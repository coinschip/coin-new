# MarketCoin

Financial index for cryptocurrency with various data and user added index, this website is built with several open source framework & assets:

- [Laravel](https://laravel.com/)
- [InertiaJS](https://inertiajs.com/)
- [VueJS](https://vuejs.org/)
- [TailwindCSS](https://tailwindcss.com/)
- [Laravel Mix](https://github.com/laravel-mix/laravel-mix)
- [Heroicons](https://heroicons.com/)

## Deployment

Copy `.env.example` to `.env` and configure to your need, then follow the following lines to deploy.

```bash
# Install Dependencies

composer install

npm install

# Setup

php artisan key:generate

php artisan migrate

# Development Preview

php artisan ser

npm run watch --hot

```
