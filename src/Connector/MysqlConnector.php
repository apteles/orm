<?php
declare(strict_types=1);
namespace Apteles\ORM\Connector;

use PDO;
use Throwable;
use Apteles\ORM\Config\AbstractConfig;

final class MysqlConnector extends AbstractConnector
{
    public static function createInstance(AbstractConfig $config): PDO
    {
        if (!parent::$conn) {
            try {
                $config = $config->getConfig();
                $port = $config['port'] ?? '3306';
                parent::$conn = new PDO("mysql:host={$config['hostname']};port={$port};dbname={$config['dbname']}", $config['username'], $config['password']);

                return parent::$conn;
            } catch (Throwable $th) {
                die($th->getMessage());
            }
        }
        return parent::$conn;
    }
}
