<?php
declare(strict_types=1);

use Apteles\ORM\DML\Update;
use Apteles\ORM\DML\Criteria\Filter;

require_once __DIR__ . '/../vendor/autoload.php';

$update = new Update;
$update->table('users')->values([
  'first_name' => 'Foo',
  'last_name' => 'Bar',
]);
$update->setCriteria(new Filter('id', '=', 555));

\var_dump($update->getInstruction());
