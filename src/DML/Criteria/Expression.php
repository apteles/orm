<?php
declare(strict_types=1);
namespace Apteles\ORM\DML\Criteria;

abstract class Expression
{
    abstract public function dump(): string;
}
