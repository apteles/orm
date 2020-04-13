<?php
declare(strict_types=1);

use Apteles\ORM\DML\Delete;
use Apteles\ORM\DML\Criteria\Filter;
use Apteles\ORM\DML\Criteria\Criteria;

require_once __DIR__ . '/../vendor/autoload.php';

$delete = new Delete;
$delete->table('users');

$criteria = new Criteria;
$criteria->add(new Filter('email', '=', 'foo@domain.com'));
$delete->setCriteria($criteria);

\var_dump($delete->getInstruction());
