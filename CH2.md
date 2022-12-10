# Chapter 2 - Creating Database

## Goals

- Setup Mysql Server Using Docker
- Create Database
- Create Topics Table

## Tools

- Tools like XAMP / MAMP / WAMP
- DB: MySQL 8

### With XAMP / WAMP / MAMP

- if you use this kind tools then already have a setup Mysql Server
- with phpmyAdmin create database call suggestotron or with following code:
  ```sql
  CREATE DATABASE suggestotron;
  USE suggestotron;
  ```

### Instrutions / Setps for Docker users

- create a simple MySQL container:

```yml
docker run --name sug_db \
-e MYSQL_ROOT_PASSWORD=secret \
-e MYSQL_DATABASE=suggestron \
-e MYSQL_USER=dev \
-e MYSQL_PASSWORD=secret \
-dp 3306:3306 mysql;
```

- with this command will create automatically the DB called suggestron

### Create Table

- by using phpmyadmin, if using \*AMP app
- or any other sql IDE, even inside vs code with extension of you prefer
- create following table, with following code

  ```sql
  CREATE TABLE
            topics (
                    id INT unsigned NOT NULL AUTO_INCREMENT,
                    title VARCHAR(255) NOT NULL,
                    description TEXT NULL,
                    PRIMARY KEY (id)
            );

  ```

### Insert some data into the table

- use the follow sql code:

```sql
INSERT INTO
  topics (title, description)
VALUES
  (
    'Make Rainbow ElePHPants',
    'Create an elePHPant with rainbow fur'
  ),
  ('Make Giant Kittens', 'Like kittens, but larger'),

  ('Complete PHPBridge', 'Because I am awesome');
```

- confirm the Data insert by doing:

```sql
SELECT *
FROM topics
```

### Explanation

You have now create your first database, your first table, and your first rows of data!

We will be accessing this data via our PHP code in our application. Not only will our application be able to read it, but it will be able to create new data, edit, and delete existing data.
