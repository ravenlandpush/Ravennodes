# RAVENODES DATABASE SCHEMA SETUP
# written by push

*To create the Database use dbcreate.sql like*

*mysql -u root -p somepasswordifset < dbcreate.sql or run*

*mysql -u root and type the following commands*



```CREATE DATABASE ravenstatus
CREATE DATABASE ravenstatus;
USE DATABASE ravenstatus;
CREATE TABLE `nodes` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `ip` varchar(32) NOT NULL,
  `port` int(7) NOT NULL,
  `codeversion` int(12) NOT NULL,
  `ravenrelease` varchar(48) NOT NULL,
  `timefound` int(48) NOT NULL,
  `unknown` int(12) NOT NULL,
  `block` int(20) NOT NULL,
  `rdns` varchar(254) NOT NULL,
  `city` varchar(127) NOT NULL,
  `countrycode` varchar(4) NOT NULL,
  `latitude` varchar(54) NOT NULL,
  `longitude` varchar(54) NOT NULL,
  `locality` varchar(54) NOT NULL,
  `ASnumber` varchar(12) NOT NULL,
  `ISP` varchar(254) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
```

Example Output

![https://gateway.ravenland.org/ipfs/QmYWarok4Z1au9xb9MD1dV2DmroqUfd77qtU8Z88LdqQv5](https://gateway.ravenland.org/ipfs/QmYWarok4Z1au9xb9MD1dV2DmroqUfd77qtU8Z88LdqQv5)

TODO

1. Create new field 'batch', to indicate which run the json file insert was from 'Historic' Nodes.
2. Create integration script, where explorer will automatically call the parser and insert the SQL fields (Presently to import data php makedatabase.php file.json is used). 



# USAGE

It is possible to create a script to call checknodes.php from PHP-CLI and insert jsonfile's programmatically.

```#!/bin/bash
# Author: push
# Date: 08/01/2019
# Create SQL Database of Raven Nodes Export Data

jsonfile=json/1549425135.json

    php checknodes.php "$jsonfile"
```

Alternatively you can just run the command at the CLI

```bash
php checknodes.php some/path/to/your/file.json
```

Querying the Database Fields

```mysql
MariaDB [ravenstatus]> select * from nodes;
```

Querying All Database Fields from a Specific Region

```mysql
MariaDB [ravenstatus]> select * from nodes where locality LIKE '%Europe%';
```

Querying All Database Fields from a Specific City

```mysql
MariaDB [ravenstatus]> select * from nodes where city = 'London';
```

Querying Nodes from a specific Unix Date Range

```mysql
MariaDB [ravenstatus]> select * from nodes where timefound LIKE '15494095%'
```



# DEPENDANCIES

``` bash
# CENTOS/Redhat
yum install mariadb mariadb-server

# Debian/Ubuntu
apt-get install mariadb mariadb-server
```

# MYSQL PERMISSIONS

```php
$servername = "localhost";
$username = "ravenstatus";
$password = "somesecurepasswordhere";
$dbname = "ravenstatus";
```

In the file checknodes.php you will need to configure the MYSQL  user so the script has permission to access the records. Create a MYSQL user like below, and create the DB SCHEMA by copying the below. Or using the provided database.sql file.

**Permissions:**

```mysql
MariaDB [(none)]> GRANT ALL PRIVILEGES ON ravenstatus.* to ravenstatus@localhost identified by 'changethiswithasecurepassword' ;                                                                                                     
```

**Create Database & Schema**

```mysql
MariaDB [(none)]> create database ravenstatus;
MariaDB [(none)]> CREATE TABLE `nodes` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `ip` varchar(32) NOT NULL,
  `port` int(7) NOT NULL,
  `codeversion` int(12) NOT NULL,
  `ravenrelease` varchar(48) NOT NULL,
  `timefound` int(48) NOT NULL,
  `unknown` int(12) NOT NULL,
  `block` int(20) NOT NULL,
  `rdns` varchar(254) NOT NULL,
  `city` varchar(127) NOT NULL,
  `countrycode` varchar(4) NOT NULL,
  `latitude` varchar(54) NOT NULL,
  `longitude` varchar(54) NOT NULL,
  `locality` varchar(54) NOT NULL,
  `ASnumber` varchar(12) NOT NULL,
  `ISP` varchar(254) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;


```

Once this has been done ensure that checknodes.php file has the credentials correctly set. 

Then test with the provided test data set that the importer is working correctly. You may replace json/1549425135.json with any output from Ravenodes in JSON format.

``` php 
php checknodes.php json/1549425135.json
```

A shell script is provided to get you started

```
chmod +x ./createsqlfromjson.sh
./createsqlfromjson.sh

```


