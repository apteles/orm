<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use Apteles\ORM\Connection;

$conn = new Connection([
  'username' => 'root',
  'password' => 'secret',
  'dbname' => 'fsphp',
  'hostname' => '127.0.0.1',
  'port' => '3306',
  'driver' => 'mysql',
  'chartset' => ''
]);

$conn->make();
