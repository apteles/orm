<?php
declare(strict_types=1);
namespace Apteles\ORM\Config;

use Apteles\ORM\Config\Exceptions\InvalidDefinitionsException;

abstract class AbstractConfig
{
    protected array $definitionsRequired = [];

    protected array $data = [];

    public function __construct(array $config)
    {
        $this->data = $config;
    }

    public function __get(string $key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
    }

    public function __set(string $key, $value): void
    {
        if (!isset($this->data[$key])) {
            $this->data[$key] = $value;
        }
    }

    public function __isset(string $key): bool
    {
        return isset($this->data[$key]);
    }

    protected function validateDefinitionsRequired(): void
    {
        if ($this->hasData()) {
            foreach (\array_values($this->definitionsRequired) as $definition) {
                $isValid = \in_array($definition, \array_keys($this->data), true);
                if (!$isValid) {
                    throw new InvalidDefinitionsException(\sprintf("Definition %s is required", $definition));
                }
            }
        }
    }

    private function hasData(): bool
    {
        return !empty($this->data);
    }

    abstract public function getConfig(): array;
}
