# Devolon
<hr>

> Devolon is an intelligent application to help customers on finding best offers for their purchases

> The Application is wrriten on Laravel, if you are not familier with the environment please check the link below:

[Laravel Installation](https://laravel.com/docs/7.x/installation)

## Topics
- [Description](#Description)
- [How is it works](#How-is-it-works)
- [Installation guid](#Installation-Guid)

# Description
<hr>

Develon that can store all your products, define some offers and prepare a checkout list for
customers.

## How is it works ?
<hr>

### Lets imagine you have following products with special prices:

| Name | Price | Special Price| 
| :----------- | :------------: | :------------: |  
| A   |   50  | 3 for 130|
| B   |   30  | 2 for 45|
| C   |   20  | |
| D   |   15  | |



### The following table would be the sample of user checkout :

| User Items | Price Without Discount | Price With Discount | 
| :----------- | :------------: | :------------: |  
| AAA   |   150  | 130 |
| AB   |   80  | 80 |
| AABB   |   160  | 145 |
| AAABB   |   210  | 175 |

<hr>

## This system also will be able to find the "best offer" for the user

Look at this example :

| Name | Price | Special Price| 
| :----------- | :------------: | :------------: |  
| A   |   20  | 2 for 30 , 3 for 50|

| User Items | Price Without Discount | Price With Discount | 
| :----------- | :------------: | :------------: |  
| AA   |   40  | 30 |
| AAA   |   60  | 50 |

> What about if user want to take 8 of A => AAAAAAAA
<br>
> Which rule should we take to get most discount for the user ?

#### Let`s calculate with first rule ( AA = 30 ) :

AA | AA | AA | AA = 120

#### Let`s calculate with second rule ( AAA = 50 ) :

AAA | AAA | A | A = 140

#### Let`s use the combinations :

AAA | AAA | AA = 130
<br>
AAA | AA | AA | A = 130
<br>

>notice : we still can create more combinations, but the result is clear

### Result :


- [ ] AAA | AAA | A | A = 140
- [ ] AAA | AAA | AA = 130
- [x] AA | AA | AA | AA = 120

# Installation Guid

### Clone project From Git

```sh
$ mkdir devolon
$ cd devolon
$ git clone "https://github.com/mhmdnz/devolon.git" .
```

### Edit env File

To run laravel applications you have to define your system configuration for the laravel in .env file

```sh
$ mv .env.example .env
$ vim .env
```

### Install Composer Packages

```sh
$ composer install
```

### Run DB migrations

> Do not forget to create your database and give it to the .env file or you will get an Error<br>
> - If you got any error you could simply use <strong>fresh</strong> parameter<br>
> - Or if you are not familier with laravel migrations just drop and create your database again
```sh
//Create database example
//login to mysql console then use below command
$ mysql -u{enter user name here} -p{enter password here}
$ Create Database devolon
```
```sh
$ php artisan migrate --seed
```

### Run Tests

```sh
//you could run all the tests by running below command in the project root
$ phpunit
//or 
$ ./vendor/bin/phpunit
```

```sh
//you could run only one test by using this command
$ phpunit /address of the test
```
<hr>

# Docker Installation Guid

  - [Clone project from Git repository](https://github.com/mhmdnz/devolon.git)

```sh
$ mkdir devolon
$ cd devolon
$ git clone "https://github.com/mhmdnz/devolon.git" .
```

```sh
//it will bring project up and ready to use
$ docker-compose up --build -d
$ docker exec -it php sh /tmp/Prepration.sh
```
> you should be able to see : localhost:8080
## Some helpful commands

```sh
//to Run Tests
$ docker exec -it php sh /tmp/RunTests.sh

//to get fresh migration
$ docker exec -it php sh /tmp/FreshMigrations.sh

//to run composer install
$ docker exec -it php sh /tmp/ComposerInstall.sh
```
<hr>

>Notice : There is a simple Swagger documentation to explain about the APIs, you will
> also be able to send requests from that
