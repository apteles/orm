<?php
declare(strict_types=1);
namespace Apteles\ORM\Connector;

use PDO;
use Apteles\ORM\Config\AbstractConfig;

abstract class AbstractConnector
{
    protected static ?PDO $conn = null;

    private function __construct()
    {
    }
    private function __clone()
    {
    }
    abstract public static function createInstance(AbstractConfig $config): PDO;
}
