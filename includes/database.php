<?php

final class ExploreGujaratStatement extends PDOStatement
{
    protected function __construct()
    {
    }

    public function bind_param(string $types, mixed &...$values): bool
    {
        foreach ($values as $index => &$value) {
            $type = $types[$index] ?? 's';
            $pdoType = $type === 'i' ? PDO::PARAM_INT : ($type === 'b' ? PDO::PARAM_LOB : PDO::PARAM_STR);
            $this->bindParam($index + 1, $value, $pdoType);
        }
        return true;
    }

    public function get_result(): self
    {
        return $this;
    }

    public function fetch_assoc(): array|false
    {
        return $this->fetch(PDO::FETCH_ASSOC);
    }

    public function fetch_row(): array|false
    {
        return $this->fetch(PDO::FETCH_NUM);
    }

    public function fetch_all(int $mode = PDO::FETCH_ASSOC): array
    {
        return $this->fetchAll($mode);
    }

    public function close(): void
    {
        $this->closeCursor();
    }
}

function explore_gujarat_database_connect(?string $databaseName = null): PDO
{
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = (int)(getenv('DB_PORT') ?: 3306);
    $username = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASSWORD');
    $password = $password === false ? '' : $password;
    $database = $databaseName ?: (getenv('DB_NAME') ?: 'explore_gujarat');
    $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";

    try {
        $connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false,
            PDO::ATTR_STATEMENT_CLASS => [ExploreGujaratStatement::class],
        ]);
        date_default_timezone_set('UTC');
        $connection->exec("SET time_zone = '+00:00'");
        return $connection;
    } catch (PDOException $exception) {
        http_response_code(500);
        error_log('WanderTrail database connection failed: ' . $exception->getMessage());
        exit('<h1>Database unavailable</h1><p>Start MySQL in WAMP and import the SQL files listed in <code>README.md</code>.</p>');
    }
}

function db_query(PDO $db, string $sql, array $parameters = []): PDOStatement
{
    $statement = $db->prepare($sql);
    foreach ($parameters as $key => $value) {
        $parameter = is_int($key) ? $key + 1 : (str_starts_with((string)$key, ':') ? (string)$key : ':' . $key);
        $type = is_int($value) ? PDO::PARAM_INT : (is_bool($value) ? PDO::PARAM_BOOL : ($value === null ? PDO::PARAM_NULL : PDO::PARAM_STR));
        $statement->bindValue($parameter, $value, $type);
    }
    $statement->execute();
    return $statement;
}

function db_all(PDO $db, string $sql, array $parameters = []): array
{
    return db_query($db, $sql, $parameters)->fetchAll(PDO::FETCH_ASSOC);
}

function db_one(PDO $db, string $sql, array $parameters = []): ?array
{
    $row = db_query($db, $sql, $parameters)->fetch(PDO::FETCH_ASSOC);
    return $row === false ? null : $row;
}

function db_value(PDO $db, string $sql, array $parameters = []): mixed
{
    return db_query($db, $sql, $parameters)->fetchColumn();
}

function db_execute(PDO $db, string $sql, array $parameters = []): bool
{
    db_query($db, $sql, $parameters);
    return true;
}

function db_fetch_array(PDOStatement $statement): array|false
{
    return $statement->fetch(PDO::FETCH_BOTH);
}

function db_num_rows(PDOStatement $statement): int
{
    return $statement->rowCount();
}

function db_error(?PDO $db = null): string
{
    return (string)(($db?->errorInfo())[2] ?? 'Database operation failed.');
}

function db_transaction(PDO $db, callable $operation): mixed
{
    $db->beginTransaction();
    try {
        $result = $operation($db);
        $db->commit();
        return $result;
    } catch (Throwable $exception) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        throw $exception;
    }
}
