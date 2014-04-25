# Borderlands 2 item database backend

This is a php REST JSON interface for the borderland 2 items application.
The data is stored in a database (default is [MySQL] (http://www.mysql.com/)) and then retrived by using the [doctrine ORM mapper] (http://www.doctrine-project.org/projects/orm.html)
The resources are provided in a RESTful way by using the [tonic](http://www.peej.co.uk/tonic/).

## Setup
1. Make sure you have [composer](http://getcomposer.org/) installed.
2. clone the repository 
3. navigate the the directory where your clone is located
4. type in `composer install` (assuming composer is installed globally)

## Prepare database
1. Create a new database schema
2. edit `include/config.php` with the configuration for your database
3. create the database structure by executing the script `sql/create-schema.sql` in your database
4. insert master data by executing the `sql/insert-master-data.sql`
5. use the scripts within the sql folder to create the required table and fill it with some data if you like.
