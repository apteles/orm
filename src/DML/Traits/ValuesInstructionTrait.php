<?php
declare(strict_types=1);
namespace Apteles\ORM\DML\Traits;

use Exception;

trait ValuesInstructionTrait
{
    protected function prepareValues(array $values): void
    {
        if (!\property_exists($this, 'values')) {
            throw new Exception(\sprintf("Class %s must have property values", __CLASS__));
        }

        foreach ($values as $column => $value) {
            if (isset($value)) {
                $this->values[$column] = $value;
            }
            if (\is_string($value)) {
                $this->values[$column] = "'" . \addslashes($value). "'";
            }
            if (\is_bool($value)) {
                $this->values[$column] = $values ? 'TRUE' : 'FALSE';
            }
      
            if (\is_null($value)) {
                $this->values[$column] = 'NULL';
            }
        }
    }
}
