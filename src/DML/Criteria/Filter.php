<?php
declare(strict_types=1);
namespace Apteles\ORM\DML\Criteria;

final class Filter extends Expression
{
    private string $variable;

    private string $operator;

    private $value;
    
    public function __construct(string $variable, string $operator, $value)
    {
        $this->variable = $variable;
        $this->operator = $operator;
        $this->value = $this->transform($value);
    }

    public function transform($value): string
    {
        if (\is_array($value)) {
            return $this->prepareArrayValue($value);
        }
        if (\is_string($value)) {
            return $this->prepareStringValue($value);
        }
        if (\is_null($value)) {
            return 'NULL';
        }
        if (\is_bool($value)) {
            return $this->prepareBoolValue($value);
        }
        return (string) $value;
    }

    public function prepareArrayValue(array $value): string
    {
        $result = [];

        foreach ($value as $x) {
            if (\is_integer($x)) {
                $result[] = $x;
            } elseif (\is_string($x)) {
                $result[] = $this->prepareStringValue($x);
            }
        }

        return '(' . \implode(',', $result) . ')';
    }

    public function prepareStringValue(string $value): string
    {
        return "'{$value}'";
    }
    public function prepareBoolValue(bool $value): string
    {
        return $value ? 'TRUE' : 'FALSE';
    }

    public function dump(): string
    {
        return "{$this->variable} {$this->operator} {$this->value}";
    }
}
