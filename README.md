# Stack Overflow Clone

A Stack Overflow style Q&A web app built with **Laravel 8**, Blade templates and Bootstrap 4, backed by MySQL.

Features: register / login, ask / edit / delete questions, answer questions, mark a best answer, up/down-vote questions and answers, favourite questions, and database + email notifications (new reply, best answer).

> Created by **Piyush Tarwani**. as a self-training Laravel project, and shared with me with his permission. I set it up for local use, fixed bugs (auth guards, vote validation, missing storage folders, mail config) and documented the setup.

## Requirements
- PHP 8.0 or 8.1 (Laravel 8 is end-of-life and may show deprecation errors on PHP 8.2+), with extensions: mbstring, openssl, pdo_mysql, xml, ctype, json, tokenizer, fileinfo
- Composer 2
- MySQL 8 / MariaDB (XAMPP works; manage the data with phpMyAdmin at http://localhost/phpmyadmin)
- Node.js is **optional**: compiled CSS/JS is already in `public/`

## Setup
```bash
composer install
cp .env.example .env          # Windows: copy .env.example .env
php artisan key:generate
```
In phpMyAdmin create an empty database named `stackoverflow` (or change `DB_DATABASE` in `.env`), then:
```bash
php artisan migrate --seed    # --seed adds 5 demo users with questions and answers
php artisan serve
```
Open http://127.0.0.1:8000

Demo logins: any email from the `users` table (e.g. `SELECT email FROM users;`), password `password`.

### Rebuilding the frontend (optional)
```bash
npm install
npm run dev
```
On Node 17+ if you see `ERR_OSSL_EVP_UNSUPPORTED`, run `export NODE_OPTIONS=--openssl-legacy-provider` first (PowerShell: `$env:NODE_OPTIONS="--openssl-legacy-provider"`).

## Notes
- The page loads Font Awesome, Google Fonts and the Trix editor from CDNs, so an internet connection is needed for icons and the rich-text editor.
- Question and answer bodies are rendered as raw HTML. Before any public deployment, sanitise them (e.g. with `mews/purifier`).
