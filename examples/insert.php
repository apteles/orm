<?php
declare(strict_types=1);

use Apteles\ORM\DML\Insert;

require_once __DIR__ . '/../vendor/autoload.php';

$insert = new Insert;
$insert->into('users')->values([
  'first_name' => 'Foo',
  'last_name' => 'Bar',
  'age' => 30,
  'updated_at' => null,
  'created_at' => '2020-09-19',
]);

\var_dump($insert->getInstruction());
