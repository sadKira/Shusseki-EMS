# Interface and Stress Testing Notes

## iii. Interface Testing (True in this codebase)

- What this checks
  - The app talks correctly to its dependencies and internal components.

- Interfaces to verify in this app
  - Database connections and migrations (`config/database.php`, `database/migrations/*`).
  - Cache/session stores (`config/cache.php`, `config/session.php`).
  - Queue workers and failed job handling (`config/queue.php`, `database/migrations/0001_01_01_000002_create_jobs_table.php`).
  - Mail transport (log/SMTP/failover/roundrobin) (`config/mail.php`).
  - HTTP routes, middleware, and gates (`routes/*.php`, `bootstrap/app.php`, `app/Providers/AppServiceProvider.php`).
  - Livewire components (auto-discovery, rendering) (`config/livewire.php`, `resources/views/livewire/*`).
  - Scheduler and observers (cache invalidation) (`routes/console.php`, `app/Observers/*.php`).

- Evidence in the repo that supports interface testing
  - Test setup: `phpunit.xml` configures a realistic test env (SQLite in-memory DB, array mailer, sync queue, array session).
  - Tests present under `tests/Feature` and `tests/Unit`; CI runs them on push/PR (`.github/workflows/tests.yml`).
  - `composer.json` includes a `test` script that resets config and runs the test suite.

- What to validate (examples)
  - DB: migrations run, models read/write, FKs behave (nullOnDelete for attendance logs).
  - Cache/session: set/get, invalidation by observers after create/update/delete.
  - Queue: job dispatch, retry, appearance in `failed_jobs` on error.
  - Mail: messages are sent to the array/log mailer in tests; failover config loads.
  - Routes/middleware: role/approval/account-status gates block/allow access as expected.
  - Livewire: key screens render and interact (basic actions submit, emit, update state).
  - Scheduler: console commands execute without errors and interact with Mail/DB as expected.

## iv. Stress Testing (Readiness features present; add a load tool to fully validate)

- What this checks
  - Behavior under heavy traffic/load, resource limits, and backlogs.

- Readiness features in the codebase
  - Background queues offload heavy work (email reminders); failed jobs are persisted for diagnosis.
  - Caching across computed views with targeted invalidation via observers to reduce DB load.
  - `Model::preventLazyLoading()` helps catch slow queries early in dev.
  - Streaming queries with `cursor()` for large datasets to keep memory stable in scheduled jobs.
  - Useful DB constraints and indexes (e.g., `jobs.queue` index; unique `users.email`, `users.student_id`) reduce lock contention and ensure fast lookups.

- Stress scenarios to exercise
  - High concurrent requests to protected routes (admin and user dashboards): expect low error rate, acceptable latency, correct access control under load.
  - Large email reminder batches (scheduler): expect queue growth but steady processing; minimal/zero entries in `failed_jobs`.
  - Heavy reads on event timelines and attendance logs: caching should keep response times consistent; cache churn should be bounded.
  - Session/cookie churn: session store should handle many logins/logouts with correct expiration and cookie flags.

- What’s missing to fully validate
  - No built-in load test scripts are included. Consider adding a simple k6/Artillery scenario (HTTP concurrency, ramp-up/ramp-down, and percentile latency goals) and a queue soak test (enqueue N messages, monitor throughput and failures).
