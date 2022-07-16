# About
**Get Users list from CSV, show them in front usinag caching (Redis)**

# Table of Contents

| No. | Title                                         |
|-----|-----------------------------------------------|
| 1   | [Todos](#task-implemented)                    |
| 2   | [Installation](#installation)                 |
| 3   | [Upload data from CSV](#upload-data-from-CSV) |
| 4   | [Run Project](#run-project)                   |
| 5   | [Unit Test](#unit-test)                       |
| 6   | [Postman](#postman)                           |



# Task Implemented
1. Upload data from CSV to PostgreSQL DB
2. Show user's list
3. Design the database schema so that queries to PostgreSQL would not take longer than 250ms
4. Apply filtering based on: User's birth year & month
5. Use redis to cache data for 60 seconds
    1. At first fetch whole data from DB
    2. Then apply pagination on that (custom pagination)
6. Fetch data from DB if it is not available in Redis cache
7. Redis cache will invalid if: Any filter parameter is changed
8. If page is refreshed, then check any filter parameter is used before. If found, use those to call API
9. Pagination limit (how many users will show per page) can be set from front. Default is 20


# Installation
- For implementation used: **Laravel**, **Vue.js**, **PostgreSQL** and **Redis** (_phpredis_)
- Laravel version `^8.0` is used. So, respective PHP version is pre-required to install
- After git clone, copy `env.example` and paste as `.env`
- Update **DB_PASSWORD** in `.env` file. **Provide your own DB password**
- You need redis installed and running in your system
- Install composer packages: run `composer install`
- Install npm packages: run `npm install`
- Key generate: `php artisan key:generate`
- Create the respective table: **sender_db**. Then migrate: `php artisan migrate`
  - If you use any other table name, update that in the `.env` file

# Upload data from CSV
- CSV file is provided here named `test-data.csv` This path is used in `.env` to upload data to DB.
- Run command to upload data from CSV file to DB: `php artisan upload:csvtodb`

# Run Project
- Run server: `php artisan serve`
- Run Vue: `npm run hot`

By default, it is run under `http://localhost:8000/` URL. If any part of the URL is changed, update 
- MIX_BASE_URL
- MIX_API_BASE_URL

in the `.env` file accordingly

# Unit Test
- Run Tests: `php artisan test`
  - for windows, to avoid warning of TTY mode, run: `php artisan test --without-tty`
- Check the test file in `tests/Unit/UserListTest.php`

# Postman
- **Postman API collection** is provided here: `Email Sender.postman_collection.json`
**For environment Variable**,
- Set **BASE_URL** like, `http://localhost:port/api` 
