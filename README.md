# School Management
> A web-based school management system that covers admission to graduation.

A web-based school management system for colleges and universities. It contains modules from applicant admission to student graduation. To be specific, here are the modules included in this project:

* Admission Module
* System Managment
* Enrollment Module
* Grading System Module
* Faculty Evaluation
* Security Management

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

3. Install the npm libraries:
	```sh
	npm install
	```
	
4. Make a ``.env`` file using the ``.env.example`` and change your local configuration for DB, APP_URL, and DOMAIN.

5. Create a database with the name you specified in ``.env`` file and use ``utf8mb4_unicode_ci`` collation.collation.

6. Run the migrations:
	```sh
	php artisan migrate:fresh
	```
	
7. Run the default tables' data:
	```sh
	php artisan db:seed --class=CoreDatabaseSeeder
	```

8. Generate app key
	```sh
	php artisan key:generate
	```
		
9. Run the laravel project:
	```sh
	php artisan serve
	```

9. Compile the project views:
	```sh
	npm run dev
	or
	npm run watch
	```

10. Start the development and Happy Coding!

## Testing Data

Run this command to add test data on the system:
```sh
php artisan db:seed --class=TestDatabaseSeeder
```

## Code of Conduct

It contains the coding standards of the project and expectations on how to interact with others using git. See ``CODE OF CONDUCT`` for more information.

[https://github.com/mamangss/sms/CODE_OF_CONDUCT.md](/CODE_OF_CONDUCT.md) 

## Release History

* 0.0.1
	* Work in progress

## Meta

* Andre S. Laurio - [Hyperstorm321](https://github.com/Hyperstorm321) - ict.alaurio@gmail.com
* Joshua A. Mamangun – [mamangss](https://github.com/mamangss) - mamangunjoshua@gmail.com

Distributed under the [] license. See ``LICENSE`` for more information.

[https://github.com/mamangss/sms](https://github.com/mamangss/sms)

## Contributing

1. Fork it (<https://github.com/mamangss/sms/fork>)
2. Create your feature branch (`git checkout -b feature/foo-bar`)
3. Commit your changes (`git commit -am 'Add some foo-bar'`)
4. Push to the branch (`git push origin feature/foo-bar`)
5. Create a new Pull Request
