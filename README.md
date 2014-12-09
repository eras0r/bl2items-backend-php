# Borderlands 2 items database backend

[![PHP Dependency Status](https://www.versioneye.com/user/projects/5453bcf922b4fbef21000116/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5453bcf922b4fbef21000116)
[![Stories in Ready](https://badge.waffle.io/eras0r/bl2items-backend.png?label=ready&title=Ready)](https://waffle.io/eras0r/bl2items-backend)

This is a php REST JSON interface for the borderlands 2 items application.
The data is stored in a database (default is [MySQL] (http://www.mysql.com/)) and then retrived by using the [doctrine ORM mapper] (http://www.doctrine-project.org/projects/orm.html)
The resources are provided in a RESTful way by using  [Spore](https://github.com/dannykopping/spore).

## Prerequisites
Make sure you have [composer](http://getcomposer.org/) installed globally.

## Setup
clone the repository:
```
git clone https://github.com/eras0r/bl2items-backend
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

## Initial credentials
By invoking the insert-master-data.sql script the following admin user (with all roles) will be created automatically:

| Username | Password   |
| -------- |:---------: |
| admin    | bl2        |