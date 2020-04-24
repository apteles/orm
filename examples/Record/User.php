<?php
declare(strict_types=1);

use Apteles\ORM\Record;
use Apteles\ORM\Connection;
use Apteles\ORM\DML\Criteria\Filter;
use Apteles\ORM\DML\Criteria\Criteria;
use Apteles\ORM\DML\Criteria\Operator;

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

$users = new User;
$cri = new Criteria;
$cri->add(new Filter('password', '<>', ''));
$cri->setProperty('order', 'first_name');
//$cri->setProperty('limit', 1);
//$cri->add(new Filter('document', '=', ''), Operator::OR);

// \var_dump($user->count($cri));
// \var_dump($user->all($cri));

//\parse_url(PHP_URL_SCHEME);
\var_dump($_SERVER);

//die;

foreach ($users->paginate(2) as $user) {
    \var_dump($user);
}

print $users->links();
