<?php
declare(strict_types=1);
namespace Apteles\ORM;

use PDO;
use Exception;
use Apteles\ORM\Config\DatabaseConfig;
use Apteles\ORM\Connector\MysqlConnector;

final class Connection
{
    private ?DatabaseConfig $config = null;

    private ?PDO $conn = null;

    public function __construct(array $definitons = [])
    {
        $this->definitions($definitons);
    }

    private function definitions(array $definitons): void
    {
        $this->config = new DatabaseConfig($definitons);
    }

    public function getConfig(): array
    {
        return $this->config->getConfig();
    }

    public function make(): void
    {
        switch ($this->config->driver) {
          case 'mysql':
              $this->conn = MysqlConnector::createInstance($this->config);
            break;
          default:
            throw new Exception("Driver not supported");
            break;
        }

        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConn(): PDO
    {
        return $this->conn;
    }
}
