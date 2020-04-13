<?php
declare(strict_types=1);
namespace Apteles\ORM\DML\Traits;

trait CriteriaAwareTrait
{
    private function prepareCriteria(): void
    {
        if ($this->criteria) {
            $expression = $this->criteria->dump();
      
            if ($expression) {
                $this->sql .= ' WHERE ' . $expression;
            }

            $order = $this->criteria->getProperty('order');
            $limit = $this->criteria->getProperty('limit');
            $offset = $this->criteria->getProperty('offset');
            if ($order) {
                $this->sql .= ' ORDER BY ' . $order;
            }
            if (\is_scalar($limit)) {
                $this->sql .= ' LIMIT ' . $limit;
            }
            if (\is_scalar($offset)) {
                $this->sql .= ' OFFSET ' . $offset;
            }
        }
    }
}
