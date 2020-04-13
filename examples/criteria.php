<?php
declare(strict_types=1);

use Apteles\ORM\DML\Criteria\Filter;
use Apteles\ORM\DML\Criteria\Criteria;
use Apteles\ORM\DML\Criteria\Operator;

require_once __DIR__ . '/../vendor/autoload.php';

$filter = new Filter('date', '=', '2020-06-02');

echo 'Filter by date:' . PHP_EOL . '<br>';
echo($filter->dump()). PHP_EOL . '<br>';
echo '-----------------------'. PHP_EOL . '<br>';

$criteria = new Criteria;
$criteria->add(new Filter('active', '=', true));
$criteria->add(new Filter('age', '>', 18));
$criteria->add(new Filter('created_at', '>=', '2020-06-19'));
echo($criteria->dump()). PHP_EOL . '<br>';
echo '-----------------------'. PHP_EOL . '<br>';

$criteria = new Criteria;
$criteria->add(new Filter('age', '>', 16));
$criteria->add(new Filter('age', '<', 60), Operator::OR);
echo($criteria->dump()). PHP_EOL . '<br>';
echo '-----------------------'. PHP_EOL . '<br>';

$criteria = new Criteria;
$criteria->add(new Filter('age', 'IN', [24,25,26]));
$criteria->add(new Filter('age', 'NOT IN', [10]));
echo($criteria->dump()). PHP_EOL . '<br>';
echo '-----------------------'. PHP_EOL . '<br>';

$criteria = new Criteria;
$criteria->add(new Filter('name', 'like', 'pedro%'));
$criteria->add(new Filter('name', 'like', 'maria%'), Operator::OR);
echo($criteria->dump()). PHP_EOL . '<br>';
echo '-----------------------'. PHP_EOL . '<br>';
