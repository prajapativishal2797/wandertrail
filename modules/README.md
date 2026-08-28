# Feature modules

The application uses plain PHP feature modules rather than MVC.

- `shared/` owns the public header, navigation, footer and common assets.
- `home/` owns homepage data loading and the hero.
- `destinations/`, `packages/` and `hotels/` own their homepage feature blocks.
- `planner/` owns travel tools navigation.
- `newsletter/` owns the subscription interface.

Root PHP files remain stable compatibility routes. Shared routes load `header.php`
and `footer.php`, which delegate to `modules/shared`. New functionality should be
placed in the matching feature directory and composed by its route file.

Public route names describe their feature directly:

- `destinations.php` / `destination.php`
- `hotels.php` / `hotel.php`
- `packages.php` / `package.php`
- `guides.php` / `guide.php`

Header, footer, homepage cards, search results and related feature links point
directly to these routes; no duplicate compatibility controllers are required.

## Authenticated flow

Public discovery and detail pages remain canonical at the project root. The
`user/` directory contains account-only features: dashboard, saved favorites,
profile/security, bookings, payments, ratings, feedback and support forms.
Signed-in users browse the same public catalogue as guests and enter `user/`
only when an action requires their account.

## Data access

All live modules use the shared PDO connection from `includes/database.php`.
Use `db_one()`, `db_all()`, `db_value()` and `db_execute()` with parameter
arrays instead of concatenating request data into SQL. Use `db_transaction()`
when a module must save multiple related records atomically.
