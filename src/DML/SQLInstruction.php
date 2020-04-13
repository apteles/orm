<?php
declare(strict_types=1);
namespace Apteles\ORM\DML;

use Apteles\ORM\DML\Criteria\Criteria;

abstract class SQLInstruction
{
    protected string $sql;

    protected ?Criteria $criteria = null;

    protected string $entity;

    public function setEntity(string $entityName): void
    {
        $this->entity = $entityName;
    }

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function setCriteria(Criteria $criteria): void
    {
        $this->criteria = $criteria;
    }
    abstract public function getInstruction(): string;
}
