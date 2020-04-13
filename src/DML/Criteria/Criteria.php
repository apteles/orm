<?php
declare(strict_types=1);
namespace Apteles\ORM\DML\Criteria;

class Criteria extends Expression
{
    private array $expressions = [];

    private array $operators = [];

    private array $properties = [];

    public function add(Expression $expression, $operator = Operator::AND): void
    {
        if (empty($this->expressions)) {
            $operator = '';
        }

        $this->expressions[] = $expression;
        $this->operators[] = $operator;
    }

    public function dump(): string
    {
        if (!empty($this->expressions)) {
            $operator = '';
            $result = '';
            foreach ($this->expressions as $key => $expression) {
                $operator = $this->operators[$key];
                $result .= $operator . ' '. $expression->dump() . ' ';
            }

            return "(". \trim($result) .")";
        }
    }

    public function setProperty(string $property, $value): void
    {
        $this->properties[$property] = $value;
    }

    public function getProperty(string $property): ?string
    {
        if (isset($this->properties[$property])) {
            return (string) $this->properties[$property];
        }
        return null;
    }
}
