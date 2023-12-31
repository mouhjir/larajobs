# ![Laravel Example App](logo.png)
## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/master/installation)

Install my-project with npm

```bash
git clone https://github.com/alnahian2003/larajobs.git
```

Switch to the repo folder

```
cd larajobs
```

Install all the dependencies using composer and npm

```
composer install
```
```
npm install
```

Copy the example env file and make the required configuration changes in the .env file

```
cp .env.example .env
```

Generate a new application key

```
php artisan key:generate
```

Create a symbolic link from `public/storage` to `storage/app/public`

```
php artisan storage:link
```

Run the database migrations (Set the database connection in .env before migrating)

```
php artisan migrate
```

Start the local development server

```
php artisan serve
```

Start Vite for bundling the assets (required)

```
npm run dev
```

You can now access the server at http://localhost:8000
