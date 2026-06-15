# SignalPilot V3

AI-assisted stock opportunity scanner for PHP 8.2 using Bootstrap 5, jQuery, JSON file storage, PHPMailer, and the OpenAI API. Version 1 is paper trading only and requires human approval from opportunity emails before creating orders/trades.

## Install

1. Run `composer install` to install PHPMailer.
2. Visit `/signalpilot/install.php` once. It creates storage folders, JSON files, an admin account, default settings, default strategies, and `storage/install.lock` to disable itself.
3. Point the web root at `public/` or route `/signalpilot` to `public/index.php`.

Default admin seed: `admin@example.com` / `changeme` (authentication scaffolding is stored in JSON and should be hardened before production exposure).

## Cron

```bash
php cron/scan.php
php cron/send_email_queue.php
```

Schedule `cron/scan.php` at the configured interval. It scans enabled watchlist symbols, evaluates AI/fallback decisions, creates opportunities above threshold, queues email alerts, and backs up JSON files.

## Storage

All application data is JSON in `storage/data/`. Backups are written to `storage/backups/`. There is no SQL, no PDO, and no database dependency.

## Architecture

Contracts live in `src/Contracts`: `BrokerInterface`, `MarketDataProviderInterface`, `AIProviderInterface`, and `StorageProviderInterface`. Current implementations include `PaperBroker`, `OpenAIProvider`, and `JsonStorageProvider`. Future broker placeholders are included for Alpaca, Interactive Brokers, Tradier, and Webull.
