<?php
declare(strict_types=1);
namespace Apteles\ORM\Config;

class DatabaseConfig extends AbstractConfig
{
    protected array $definitionsRequired = [
    'username',
    'password',
    'dbname',
    'hostname',
    'port',
    'driver',
    'chartset'
  ];

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->init();
    }

    private function init(): void
    {
        $this->validateDefinitionsRequired();
    }

    public function getConfig(): array
    {
        return $this->data;
    }
}
