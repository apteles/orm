<?php
declare(strict_types=1);

use Apteles\ORM\DML\Criteria\Filter;

require_once __DIR__ . '/../vendor/autoload.php';

$filter = new Filter('date', '=', '2020-06-02');

echo 'Filter by date:' . PHP_EOL . '<br>';
echo($filter->dump()). PHP_EOL . '<br>';
echo '-----------------------'. PHP_EOL . '<br>';

$filter = new Filter('income', '>', 3500);
echo 'Filter by income:' . PHP_EOL . '<br>';
echo($filter->dump()). PHP_EOL . '<br>';

echo '-----------------------'. PHP_EOL . '<br>';
$filter = new Filter('genre', 'IN', ['M','F']);
echo 'Filter by genre:' . PHP_EOL . '<br>';
echo($filter->dump()). PHP_EOL . '<br>';

echo '-----------------------'. PHP_EOL . '<br>';
$filter = new Filter('contract', 'IS NOT', null);
echo 'Filter by contracts:' . PHP_EOL . '<br>';
echo($filter->dump()). PHP_EOL . '<br>';

echo '-----------------------'. PHP_EOL . '<br>';
$filter = new Filter('active', '=', true);
echo 'Filter by active:' . PHP_EOL . '<br>';
echo($filter->dump()). PHP_EOL . '<br>';
