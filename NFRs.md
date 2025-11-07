# Non-Functional Requirements (Simplified)

## Performance
- Uses caching (database/Redis) and clears cache when data changes via observers.
- Prevents N+1 queries in dev; streams large queries to save memory.
- Heavy work (like emails) runs in background queues.
- Frontend assets are built with Vite for faster loading.

## Scalability
- Sessions and cache can use shared stores (DB/Redis) for multiple app instances.
- Swappable queue backends (sync/DB/Redis/SQS) with batching and failures tracked.
- Mail supports failover/round-robin delivery.
- Configuration is driven by environment variables.

## Reliability & Availability
- Queued jobs have retries and failure logs.
- Scheduled jobs handle regular tasks (e.g., reminders, token cleanup).
- Maintenance mode can be controlled centrally.

## Security
- Strong encryption (AES-256-CBC) with app key and optional key rotation.
- Secure cookie settings (HttpOnly, SameSite; Secure optional).
- Built-in CSRF protection, signed + throttled routes.
- Role-based access control via middleware and gates.

## Password Protection
- Passwords are hashed automatically (bcrypt).
- Password reset tokens stored and managed in the database.
- Password confirmation timeout is enforced.

## Data Integrity
- Database constraints and foreign keys protect relationships.
- Enums restrict valid values for roles/statuses.
- Eloquent relationships maintain consistent data access.
- Observers clear stale derived/cached data.

## Maintainability
- Code style via Pint; CI runs lint and tests.
- Tests with Pest/PHPUnit; test config uses in-memory SQLite.
- Clear folder structure with PSR-4 autoloading.
- Enums reduce magic strings and errors.

## Portability
- Supports multiple DB, cache, session, queue, and mail drivers.
- All major settings are .env driven for easy moves between environments.
- Frontend toolchain (Vite/Tailwind) is cross-platform.

## Logging & Auditability
- Centralized logging with multiple channels (file, daily, Slack, Papertrail, etc.).
- Mail can log messages in development.
- Attendance logs provide a business audit trail.
