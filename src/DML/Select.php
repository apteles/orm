<?php
declare(strict_types=1);
namespace Apteles\ORM\DML;

use Apteles\ORM\DML\Traits\CriteriaAwareTrait;

class Select extends SQLInstruction
{
    use CriteriaAwareTrait;
    private array $columns = [];

    public function table(string $entity): Select
    {
        $this->setEntity($entity);
        return $this;
    }

    public function from(array $columns): Select
    {
        $this->columns = $columns;
        return $this;
    }

    public function getInstruction(): string
    {
        $this->sql = "SELECT ";
        $this->sql .= \implode(', ', $this->columns);
        $this->sql .= ' FROM ' . $this->entity;
        
        $this->prepareCriteria();

        return $this->sql;
    }
}
