# Non-Functional Requirements (Detailed)

Below is what the codebase currently implements for each non-functional requirement, with file references.

## Performance
- Application caching with centralized stores and namespaced keys; default store is database with optional Redis/Memcached/DynamoDB backends configured in `config/cache.php`. Cache invalidation is proactively handled via model observers (`app/Observers/*.php`).
- N+1 protection: `Model::preventLazyLoading()` is enabled in `app/Providers/AppServiceProvider.php` to catch inefficient lazy loading during development.
- Streaming queries where appropriate: the scheduled email reminder job uses `cursor()` to avoid memory blowup (`routes/console.php`).
- Queued work offloads heavy tasks (emails) from the request path using Laravel queues (`config/queue.php`, `routes/console.php`).
- Frontend assets compiled with Vite for efficient client delivery (`package.json`, `vite.config.js`).
- Useful DB indexes/constraints for hot paths (e.g., `jobs.queue` index, `users.email`/`student_id` unique, `sessions.last_activity` indexed) in `database/migrations/*`.

## Scalability
- Horizontal scaling–friendly state: sessions (`config/session.php`) and cache (`config/cache.php`) default to database stores, with first-class Redis support (`config/database.php`), so multiple app instances can share state.
- Queue backends are swappable (sync/database/redis/sqs) with failure handling and batching (`config/queue.php`, `database/migrations/0001_01_01_000002_create_jobs_table.php`).
- Mail transport supports failover and round-robin strategies (`config/mail.php`) for scaling outbound email.
- Environment-driven configuration throughout (`.env.example`, config files) supports running in varied infra setups.

## Reliability & Availability
- Job durability: failed jobs table and configuration present (`config/queue.php` failed driver `database-uuids`, `failed_jobs` migration).
- Scheduled housekeeping and business jobs using the scheduler (`routes/console.php`), including periodic clearing of expired password reset tokens and queued email reminders.
- Maintenance mode supports centralized driver configuration for multi-instance control (`config/app.php` maintenance driver).
- Email transport supports failover to alternate mailers (`config/mail.php`).

## Security
- Strong app encryption defaults (`config/app.php` uses AES-256-CBC and `APP_KEY`, supports key rotation via `previous_keys`).
- Web security defaults (HTTP-only, SameSite cookies, optional secure cookies) configured in `config/session.php`.
- CSRF, auth, and signed routes enforced by Laravel’s middleware; e.g., email verification route uses `signed` and `throttle:6,1` (`routes/auth.php`).
- Access control: route-level RBAC via custom middlewares and policies/gates (`bootstrap/app.php` middleware aliases; gates in `app/Providers/AppServiceProvider.php`).
- Environment-first secrets and credentials via `.env.example`; no hardcoded secrets detected.

## Password Protection
- Password hashing is enforced via Eloquent casts: `'password' => 'hashed'` in `app/Models/User.php` (bcrypt by default), with configurable cost (`BCRYPT_ROUNDS` in `.env.example`).
- Password reset flow and token storage configured (`config/auth.php`, `database/migrations/0001_01_01_000000_create_users_table.php` tokens table).
- Password confirmation timeout configured (`config/auth.php` `password_timeout`).

## Data Integrity
- Referential integrity and constraints: foreign keys with `constrained()->nullOnDelete()` for attendance logs; unique keys on critical identifiers (`database/migrations/*`).
- Enumerated domain values stored at DB and PHP levels (`users.role/status/account_status`, `events.status`, `event_attendance_logs.attendance_status`) to prevent invalid state.
- Eloquent relations defined for data consistency and safer querying (`app/Models/*.php`).
- Observers invalidate dependent aggregates to prevent stale derived data (`app/Observers/*.php`).

## Maintainability
- Automated code style enforcement via Laravel Pint and CI job (`.github/workflows/lint.yml`).
- Automated tests with Pest and CI workflow (`.github/workflows/tests.yml`, `phpunit.xml`); composer script `test` clears config and runs tests.
- Clear modular structure (models, observers, middleware, routes, configs) with PSR-4 autoload (`composer.json`).
- Use of PHP enums for clarity of roles/statuses reduces “magic strings”.

## Portability
- Multiple first-party DB drivers supported and configured by env (`config/database.php` for sqlite/mysql/pgsql/sqlsrv`).
- Pluggable cache, session, queue, and mail transports via env files (`.env.example`, `config/*`).
- Optional Redis via `predis/predis` in `composer.json`; app remains functional with database-backed stores by default.
- Frontend toolchain (Vite/Tailwind) is cross-platform (`package.json`).

## Logging & Auditability
- Centralized, configurable logging with Monolog: `stack`, `single`, `daily`, `slack`, `papertrail`, `stderr`, `syslog` channels (`config/logging.php`), including deprecation logging controls.
- Mail driver can log outbound messages (`config/mail.php` default `MAIL_MAILER=log` in development).
- Business-level audit trail captured via `event_attendance_logs` model/table and relationships (`app/Models/EventAttendanceLog.php`, migration), with observers ensuring cached aggregates reflect actual logs.
