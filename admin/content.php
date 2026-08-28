<?php
include 'sidebar.php';
include 'header.php';
include 'config.php';

if (empty($_SESSION['cms_csrf'])) {
    $_SESSION['cms_csrf'] = bin2hex(random_bytes(32));
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = (string)($_POST['csrf_token'] ?? '');
    if (!hash_equals($_SESSION['cms_csrf'], $token)) {
        $error = 'The form expired. Please try again.';
    } else {
        $contentId = filter_input(INPUT_POST, 'content_id', FILTER_VALIDATE_INT) ?: 0;
        $pageKey = strtolower(trim((string)($_POST['page_key'] ?? '')));
        $blockKey = strtolower(trim((string)($_POST['block_key'] ?? '')));
        $title = trim((string)($_POST['title'] ?? ''));
        $content = trim((string)($_POST['content'] ?? ''));
        $imagePath = trim((string)($_POST['image_path'] ?? ''));
        $sortOrder = filter_input(INPUT_POST, 'sort_order', FILTER_VALIDATE_INT);
        $sortOrder = $sortOrder === false ? 0 : $sortOrder;
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (!preg_match('/^[a-z0-9_-]{1,80}$/', $pageKey) || !preg_match('/^[a-z0-9_-]{1,80}$/', $blockKey)) {
            $error = 'Page and block keys may contain lowercase letters, numbers, underscores and hyphens.';
        } elseif ($title === '' || $content === '') {
            $error = 'Title and content are required.';
        } elseif ($contentId > 0) {
            $statement = $con->prepare('UPDATE tbl_content_block SET page_key=?, block_key=?, title=?, content=?, image_path=?, sort_order=?, is_active=? WHERE content_id=?');
            $statement->bind_param('sssssiii', $pageKey, $blockKey, $title, $content, $imagePath, $sortOrder, $isActive, $contentId);
            $message = $statement->execute() ? 'Content updated.' : '';
            $error = $message ? '' : 'Could not update content.';
            $statement->close();
        } else {
            $statement = $con->prepare('INSERT INTO tbl_content_block (page_key, block_key, title, content, image_path, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $statement->bind_param('sssssii', $pageKey, $blockKey, $title, $content, $imagePath, $sortOrder, $isActive);
            $message = $statement->execute() ? 'Content created.' : '';
            $error = $message ? '' : 'Could not create content. The page/block key may already exist.';
            $statement->close();
        }
    }
}

$editId = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT) ?: 0;
$editing = ['content_id' => 0, 'page_key' => '', 'block_key' => '', 'title' => '', 'content' => '', 'image_path' => '', 'sort_order' => 0, 'is_active' => 1];
if ($editId) {
    $statement = $con->prepare('SELECT * FROM tbl_content_block WHERE content_id=?');
    $statement->bind_param('i', $editId);
    $statement->execute();
    $editing = $statement->get_result()->fetch_assoc() ?: $editing;
    $statement->close();
}

$blocks = $con->query('SELECT * FROM tbl_content_block ORDER BY page_key, sort_order, block_key');
?>
<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Manage Page Content</h2>
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo h($message); ?></div><?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo h($error); ?></div><?php endif; ?>
            <div class="form-grids row widget-shadow">
                <div class="form-title"><h4><?php echo $editId ? 'Edit' : 'Add'; ?> content block</h4></div>
                <div class="form-body">
                    <form method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo h($_SESSION['cms_csrf']); ?>">
                        <input type="hidden" name="content_id" value="<?php echo (int)$editing['content_id']; ?>">
                        <div class="row">
                            <div class="col-md-6 form-group"><label>Page key</label><input class="form-control"
                                                                                           name="page_key" required
                                                                                           value="<?php echo h($editing['page_key']); ?>">
                            </div>
                            <div class="col-md-6 form-group"><label>Block key</label><input class="form-control"
                                                                                            name="block_key" required
                                                                                            value="<?php echo h($editing['block_key']); ?>">
                            </div>
                        </div>
                        <div class="form-group"><label>Title</label><input class="form-control" name="title" required
                                                                           value="<?php echo h($editing['title']); ?>">
                        </div>
                        <div class="form-group"><label>Content</label><textarea class="form-control" name="content"
                                                                                rows="6"
                                                                                required><?php echo h($editing['content']); ?></textarea>
                        </div>
                        <div class="form-group"><label>Image path (optional)</label><input class="form-control"
                                                                                           name="image_path"
                                                                                           value="<?php echo h($editing['image_path']); ?>"
                                                                                           placeholder="assets/site/pic/example.jpg">
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group"><label>Sort order</label><input class="form-control"
                                                                                             type="number"
                                                                                             name="sort_order"
                                                                                             value="<?php echo (int)$editing['sort_order']; ?>">
                            </div>
                            <div class="col-md-3 form-group"><label><input type="checkbox"
                                                                           name="is_active" <?php echo $editing['is_active'] ? 'checked' : ''; ?>>
                                    Active</label></div>
                        </div>
                        <button class="btn btn-primary" type="submit">Save content</button>
                        <a class="btn btn-default" href="content.php">Clear</a>
                    </form>
                </div>
            </div>
            <div class="bs-example widget-shadow"><h4>Content blocks</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Page</th>
                            <th>Block</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Updated</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($block = $blocks->fetch_assoc()): ?>
                            <tr>
                            <td><?php echo h($block['page_key']); ?></td>
                            <td><?php echo h($block['block_key']); ?></td>
                            <td><?php echo h($block['title']); ?></td>
                            <td><?php echo $block['is_active'] ? 'Active' : 'Hidden'; ?></td>
                            <td><?php echo h($block['updated_at']); ?></td>
                            <td><a class="btn btn-xs btn-primary"
                                   href="content.php?edit=<?php echo (int)$block['content_id']; ?>">Edit</a></td>
                            </tr><?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
