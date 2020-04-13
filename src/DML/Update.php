<?php
declare(strict_types=1);
namespace Apteles\ORM\DML;

use Apteles\ORM\DML\Traits\CriteriaAwareTrait;
use Apteles\ORM\DML\Traits\ValuesInstructionTrait;

class Update extends SQLInstruction
{
    use ValuesInstructionTrait, CriteriaAwareTrait;

    private array $values = [];

    public function table(string $entity): Update
    {
        $this->setEntity($entity);
        return $this;
    }

    public function values(array $values): Update
    {
        $this->prepareValues($values);
        return $this;
    }

    public function getInstruction(): string
    {
        $this->sql = "UPDATE {$this->entity}";
        $set = [];

        foreach ($this->values as $column => $value) {
            $set[] = "{$column} = {$value}";
        }

        $this->sql .= ' SET ' . \implode(', ', $set);

        $this->prepareCriteria();

        return $this->sql;
    }
}
