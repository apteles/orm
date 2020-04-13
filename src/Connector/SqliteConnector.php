<?php
declare(strict_types=1);
namespace Apteles\ORM\Connector;

use PDO;
use Throwable;
use Apteles\ORM\Config\AbstractConfig;

final class SqliteConnector extends AbstractConnector
{
    public static function createInstance(AbstractConfig $config): PDO
    {
        if (!parent::$conn) {
            try {
                $config = $config->getConfig();
            
                parent::$conn = new PDO("sqlite:{$config['name']}");
                parent::$conn->query('PRAGMA foreign_keys = ON');
                
                return parent::$conn;
            } catch (Throwable $th) {
                die($th->getMessage());
            }
        }

        return parent::$conn;
    }
}
