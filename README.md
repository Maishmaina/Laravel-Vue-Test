<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel Vue/Nuxt js install and configuration
Clone project

    git clone https://github.com/Maishmaina/Laravel-Vue-Test.git
 navigate to project folder
 
    cd Laravel-Vue-Test

Install dependencies 
   
    composer install

    npm install

Copy or create .env file and configure

    cp .env.example .env  

set config details below

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=YOUR DB
    DB_USERNAME=DB USER
    DB_PASSWORD= PASSWORD

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=465
    MAIL_USERNAME=YOUR EMAIL
    MAIL_PASSWORD=YOUR PASSWORD
    MAIL_ENCRYPTION=ssl
    MAIL_FROM_ADDRESS=
    MAIL_FROM_NAME=
Run server

    php artisan serve   

    npm run dev

Generate application key

    php artisan key:generate
Setup DB and migrate tables run seed to add data

    php artisan migrate
    php artisan db:seed


Admin link for local dev server

    http://localhost:8000/admin/home/admin_login
    from the db:seed
    admin account is created
    username: admin@gmail.com
    password: P@ssw0rd
    
User account creation links are.

    http://localhost:8000/user/register
    http://localhost:8000/user/login
    


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
