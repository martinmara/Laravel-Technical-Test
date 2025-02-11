Installation & Setup

1. Clone the Repository
https://github.com/martinmara/Laravel-Technical-Test.git

cd employee-timesheet

2. Install Dependencies
composer install
npm install

3. Configure Environment
Duplicate the .env.example file and rename it to .env:
cp .env.example .env

Then, update the .env file with your database credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=timesheet_db
DB_USERNAME=root
DB_PASSWORD=

4. Generate Application Key

php artisan key:generate

5. Run Migrations and Seed Database

php artisan migrate --seed

6. Start Development Server

php artisan serve

7. Run Vite for Frontend Development

npm run dev
