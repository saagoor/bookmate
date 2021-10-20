# Requirements

- PHP `7.4` or Higher
- PHP Extensions - BCMath, Ctype, Fileinfo, `JSON`, `Mbstring`, `OpenSSL`, `PDO`, `Tokenizer`, `XML`


# Installation

0. Make sure the server root is `bookmate/public`
1. Create a database & user and add them in .env file on project root (also set APP_DEBUG=false).
2. Run `composer update` & `composer install --optimize-autoloader --no-dev`
3. Run `php artisan migrate:fresh`
4. Run `php artisan config:cache`
5. Run `php artisan route:cache`
6. Run `php artisan view:cache`
7. Run `php artisan storage:link`
8. Run `npm update`
9. Run `npm run production`
10. Chill out


# Model Relations

* Challenge
    * Discussion (1)
        - id
        - discussable_type
        - discussable_id
        * Comment (n)
            - id
            - user_id
            - text
            * Comment (n) (replies)
                - id
                - comment_id
                - user_id
                - text