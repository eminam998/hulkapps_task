
# HulkApps task

This my mini project for a HulkApps junior PHP Developer test. My project contains user authentification (register, login, logout, user profile, refresh token) with jwt token. Also, user can have one of two roles: admin or user. Admin can create, view, edit and delete movies and genres. User can view all movies, search and filter through them and add or remove them from favorites. This is only the backend portion and can be implemented with any frontend framework of your choice.





## Set up the project


After you've cloned the project to your machine, these are the steps that you have to follow:

### Create an .env file
You can either just copy .env.example or if you're on Linux based sistem, run:
```bash
  cp .env.example .env
```

This will copy the .env file for you

### Run composer.install

Run a command:

```bash
  composer install
```
inside the projects folder.
### Set up the database

In your .env file, you need to change these fields according to your setup:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hulkapps_task
DB_USERNAME=root
DB_PASSWORD=
```
After that, you're supposed to run these commands:
```bash
  php artisan migrate
  php artisan db:seed
```
The first command will migrate all the project tables to your database, the second command will fill your tables with fake data.

### Make an admin
Admin is a special type of user. It is created using the commad:
```bash
  php artisan make:admin
```

Here you will need to fill in the name, email and password.

### Generating the application key, jwt key and running the application

For your application to work you need to run these two commands:
```bash
  php artisan key:generate
  php artisan jwt:secret
```

This will create all the necessary keys. After that, all you need to do is run:
```bash
  php artisan serve
```

And your application will start running on a local server.


## Testing

Application was tested throug Postman API. The json with postman collection is located in the root folder of the project. Feel free to import it and test the routes.
## Additional comments

Since this is a small project, it is not perfect, so it can be upgraded/modified. The changes I would make if this was a bigger project would be:


- Changing the roles system: since this is a small project, for roles was used only a string with the word 'admin' or 'user'. I would implement a more complex roles/permission system (This can be done with some laravel packages, such as laratrust or completely custom),
- Work on code redundacy: validation of request could be handled differently, however I went with the most basic approach since I didn't have much luck with testing more complex ways through Postman,
- Creating a frontend: It would be nice for this application to have a frontend.


If you have any additional questions, feel free to contact me through my email: eminamidzic998@gmail.com
