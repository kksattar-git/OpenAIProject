

## Project Setup
1. Clone the repository.
2. Run `composer install`.
3. Set up the `.env` file with your `OPENAI_API_KEY`.
4. Run migrations: `php artisan migrate`.
5. Serve the project: `php artisan serve`.
6. Run tests: `php artisan test`.


# make sure mod_rewrite is enabled in the configurations

# if the mod_rewrite is not enabled then call the links directly as below
1. /OpenAIProject/public/index.php/summarize
2.  /OpenAIProject/public/index.php/history