# Borderlands 2 item database backend

This is a php REST JSON interface for the borderland 2 items application.
The data is stored in a database (default is [MySQL] (http://www.mysql.com/)) and then retrived by using the [doctrine ORM mapper] (http://www.doctrine-project.org/projects/orm.html)
The resources are provided in a RESTful way by using the [tonic](http://www.peej.co.uk/tonic/).

## Prerequisites
Make sure you have [composer](http://getcomposer.org/) installed globally.

## Setup
clone the repository:
```
git clone https://github.com/eras0r/bl2items-frontend
```
navigate the the directory where your clone is located and type in 
```
composer install
```

## Prepare database
1. Create a new database schema
2. edit `include/config.php` with the configuration for your database
3. create the database structure by executing the script `sql/create-schema.sql` in your database
4. insert master data by executing the `sql/insert-master-data.sql`
