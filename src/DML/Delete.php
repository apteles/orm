<?php
declare(strict_types=1);
namespace Apteles\ORM\DML;

use Apteles\ORM\DML\Traits\CriteriaAwareTrait;

class Delete extends SQLInstruction
{
    use CriteriaAwareTrait;

    public function table(string $entity): Delete
    {
        $this->setEntity($entity);
        return $this;
    }
    public function getInstruction(): string
    {
        $this->sql = "DELETE FROM {$this->entity}";

        $this->prepareCriteria();

        return $this->sql;
    }
}
