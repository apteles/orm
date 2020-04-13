<?php
declare(strict_types=1);
namespace Apteles\ORM\DML;

use Exception;
use Apteles\ORM\DML\Criteria\Criteria;
use Apteles\ORM\DML\Traits\ValuesInstructionTrait;

class Insert extends SQLInstruction
{
    use ValuesInstructionTrait;
   
    private array $values = [];
    
    public function into(string $entity): Insert
    {
        $this->setEntity($entity);
        return $this;
    }

    public function values(array $values): void
    {
        $this->prepareValues($values);
    }

    public function setCriteria(Criteria $criteria): void
    {
        throw new Exception(\sprintf("Method %s cannot be called in class %s", __METHOD__, __CLASS__));
    }
    public function getInstruction(): string
    {
        $this->sql = "INSERT INTO {$this->entity} (";
        $columns = \implode(', ', \array_keys($this->values));
        $values = \implode(', ', \array_values($this->values));
        $this->sql .= $columns . ')';
        $this->sql .= " VALUES({$values})";

        return $this->sql;
    }
}
