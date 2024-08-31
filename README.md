

## ASTUDIO Demo Application

- created CRUD for Users, Projects and Timesheets
- created Unit Tests for all basic API requests
- created default seeders and DB migration
- [created Postman collection](https://github.com/SmileyThane/astudio-demo-app/postman-collection.json)

Please, check postman collection to see all API routes and parameters

Installation and Run:

```
1) run composer install & configure .env file
2) execute DB
2.1) Laravel style
2.1.1) php artisan migrate
2.1.2) php artisan db:seed
2.1.3) (optional) php artisan db:seed --clas==TestDataSeeder
2.2) or execute DB backup
3) run php artisan key:generate
4) run php artisan serve
```

### First(system) user:

```
email: first_user@mail.com

password: Qwerty!23456
```

#### Next improvements:

- change routes to RESTFull standard
- add more code documentation 

