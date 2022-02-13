# User Management

User management describes the ability for administrators to manage user access to various IT resources like systems, devices, applications, storage systems, networks, SaaS services, and more. ... User management enables admins to control user access and on-board and off-board users to and from IT resources.

## Installation

Windows:

```sh
to be editted
```

OS & Linux:

```sh
to be editted
```

## Development setup

Follow these steps to install the system for development purposes:

1. Make a clone or copy of the repository.

2. Run this command to the terminal of the cloned or forked repository:
	```sh
	composer install
	```
	
3. Make a ``.env`` file using the ``.env.example`` and change your local configuration for DB, APP_URL, and DOMAIN.

4. Create a database with the name you specified in ``.env`` file and use ``utf8mb4_unicode_ci`` collation.collation.

5. Run the optimize command:
	```sh
	php artisan optimize
	```

6. Generate app key:
	```sh
	php artisan key:generate
	```

7. Run the migrations:
	```sh
	php artisan migrate
	```

8. Run the laravel passport:
	```sh
	php artisan passport:install
	```
		
9. Run the laravel project:
	```sh
	php artisan serve
	```

10. Start the development.