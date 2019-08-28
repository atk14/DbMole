<?php
define("TEST",true);
define("SENDMAIL_DO_NOT_SEND_MAILS",true);

require(__DIR__."/connections_and_handler.php");
class tc_super_base extends PHPUnit\Framework\TestCase {}

// === Creating testing table in postgresql
$pg = PgMole::GetInstance();
$pg->doQuery(file_get_contents(__DIR__."/structures.postgresql.sql"));

// === Creating testing table in mysql
$my = MysqlMole::GetInstance();
$script = file_get_contents(__DIR__."/structures.mysql.sql");
// dropping table
preg_match('/\n(DROP TABLE.*?);/s',$script,$matches);
$my->doQuery($matches[1]);
// creating table
preg_match('/\n(CREATE TABLE.*?);/s',$script,$matches);
$my->doQuery($matches[1]);
