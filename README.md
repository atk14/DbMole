DbMole
=====

[![Build Status](https://travis-ci.org/atk14/DbMole.svg?branch=master)](https://travis-ci.org/atk14/DbMole)

DbMole provides basic functionality with database (Postgresql, MySQL or Oracle).

Basic usage
-----------

At first, define the global function dbmole_connection which returns connection to the database.

At this example only one Postgresql database is considered.

    function dbmole_connection($dbmole){
      return pg_connect("dbname=testing_database host=localhost user=test password=test123");
    }

Let's use DbMole:

    $dbmole = PgMole::GetInstance();

Selecting rows:

    $rows = $dbmole->selectRows("SELECT id,title,author FROM books");
    foreach($rows as $row){
      echo $row["id"].": ".$row["title"]." (".$row["author"].")<br>";
    }

Selecting single row:

    $row = $dbmole->selectRow("SELECT id,title,author FROM books WHERE id=123");
    var_dump($row); // ["id" => "123", "title" => "Book Title", "author" => "John Doe"]

Selecting single value:

    $amount_of_books = $dbmole->selectSingleValue("SELECT COUNT(*) FROM books");
    // or better
    $amount_of_books = $dbmole->selectInt("SELECT COUNT(*) FROM books");

For selecting single values, there are also methods:

- selectValue()
- selectInt()
- selectFloat()
- selectBool()
- selectString()

Safe binding of query variables:

    $rows = $dbmole->selectRows("SELECT id,title,author FROM books WHERE UPPER(title) LIKE UPPER(:search)",[":search" => "%Goodies%"]);
    $row = $dbmole->selectRow("SELECT id,title,author FROM books WHERE id=:id",[":id" => 123]);
    $dbmole->doQuery("UPDATE books SET title=:title, author=:author WHERE id=:id",[":id" => 123,":title" => "Good Reading", ":author" => "Samantha Doe"]);

Limiting rows:

    $rows = $dbmole->selectRows("SELECT * FROM employees",[],["limit" => "10", "offset" => 0]);
    $rows = $dbmole->selectRows("SELECT * FROM employees WHERE created_at>=:date",[":date" => "2020-01-01"],["limit" => "10", "offset" => 0]);

Working in transaction:

    $dbmole->begin();

    // do something with $dbmole

    $dbmole->commit();

Working in transaction, avoiding unnecessarily database connections:

    $dbmole->begin(["execute_after_connecting" => true]);

    // do something with $dbmole and sometimes do nothig

    if($dbmole->isConnected()){
      $dbmole->commit();
    }

Installation
------------

Just use the Composer:

    composer require atk14/dbmole

Testing
-------

Install required dependencies for development:

    composer update --dev

Run tests:

    cd test
    ../vendor/bin/run_unit_tests

License
-------

DbMole is free software distributed [under the terms of the MIT license](http://www.opensource.org/licenses/mit-license)

[//]: # ( vim: set ts=2 et: )

