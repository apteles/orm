<?php
declare(strict_types=1);

use Apteles\ORM\DML\Select;
use Apteles\ORM\DML\Criteria\Filter;
use Apteles\ORM\DML\Criteria\Criteria;
use Apteles\ORM\DML\Criteria\Operator;

require_once __DIR__ . '/../vendor/autoload.php';

$select = new Select;
$select->table('users')->from(['*']);
$criteria = new Criteria;
$criteria->add(new Filter('id', '>', 20));
$criteria->add(new Filter('age', '<', 18), Operator::OR);
$criteria->setProperty('order', 'id');
$criteria->setProperty('offset', 20);
$criteria->setProperty('limit', 0);

$select->setCriteria($criteria);

\var_dump($select->getInstruction());
