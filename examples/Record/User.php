<?php
declare(strict_types=1);

use Apteles\ORM\Record;
use Apteles\ORM\Connection;
use Apteles\ORM\DML\Criteria\Filter;
use Apteles\ORM\DML\Criteria\Criteria;

require_once __DIR__ . '/../../vendor/autoload.php';


class User extends Record
{
    protected $table = 'users';

    public function getConnection(): Connection
    {
        return new Connection([
        'username' => 'root',
        'password' => 'secret',
        'dbname' => 'fsphp',
        'hostname' => '127.0.0.1',
        'port' => '3306',
        'driver' => 'mysql',
        'chartset' => ''
      ]);
    }
}

$user = User::find(1);
$cri = new Criteria;
$cri->add(new Filter('status', '<>', 'confirmed'));

$count = $user->count($cri);
\var_dump($count);
