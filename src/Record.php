<?php
declare(strict_types=1);
namespace Apteles\ORM;

use Apteles\ORM\DML\Delete;
use Apteles\ORM\DML\Insert;
use Apteles\ORM\DML\Select;
use Apteles\ORM\DML\Update;
use Apteles\ORM\DML\Criteria\Filter;
use Apteles\ORM\DML\Criteria\Criteria;

abstract class Record
{
    protected array $data = [];

    public function __construct(?int $id = null)
    {
        if ($id) {
            $object = $this->load($id);
            if ($object) {
                $this->fromArray($object->toArray());
            }
        }
    }

    public function __set($prop, $value): void
    {
        if ($value === null) {
            unset($this->data[$prop]);
        } else {
            $this->data[$prop] = $value;
        }
    }

    public function __get($prop)
    {
        if (isset($this->data[$prop])) {
            return $this->data[$prop];
        }
    }

    public function __isset($prop)
    {
        return isset($this->data[$prop]);
    }

    public function __clone()
    {
        unset($this->data['id']);
    }
  
    public function load(int $id): ?Record
    {
        $select = new Select;
        $criteria = new Criteria;
        $criteria->add(new Filter('id', '=', $id));
        $select->table($this->table)
                    ->from(['*'])
                        ->setCriteria($criteria);


        $conn = $this->getConnection();
        $conn->make();
        $statement = $conn->getConn()->query($select->getInstruction());
        
        if ($result = $statement->fetchObject(\get_class($this))) {
            return $result;
        }

        return null;
    }

    public function fromArray(array $data): void
    {
        $this->data = $data;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function delete(?int $id = null): ?int
    {
        $id = $id ?? $this->data['id'];

        $criteria = new Criteria;
        $criteria->add(new Filter('id', '=', $id));

        $sql = new Delete;
        $sql->table($this->table);
        $sql->setCriteria($criteria);

        $conn = $this->getConnection();
        $conn->make();

        return $conn->getConn()->exec($sql->getInstruction());
    }

    public function store(): ?int
    {
        if (empty($this->data['id']) or (!$this->load((int)$this->data['id']))) {
            if (empty($this->data['id'])) {
                $this->data['id'] = $this->getLast() + 1;
            }

            $sql = new Insert;
            $sql->into($this->table)
                ->values($this->data);
        } else {
            $data = $this->data;
            unset($data['id']);

            $criteria = new Criteria;
            $criteria->add(new Filter('id', '=', $this->data['id']));
            $sql = new Update;
            $sql->table($this->table)
                ->values($data)
                ->setCriteria($criteria);
        }

        $conn = $this->getConnection();
        $conn->make();
        
        return $conn->getConn()->exec($sql->getInstruction());
    }

    private function getLast(): ?int
    {
        $select = new Select;
        $select->table($this->table)
                    ->from(['MAX(id)']);

        $conn = $this->getConnection();
        $conn->make();
        $statement = $conn->getConn()->query($select->getInstruction());

        if ($result = $statement->fetch()) {
            return (int) $result[0];
        }
    }

    public static function find(int $id): Record
    {
        $class = \get_called_class();

        return (new $class)->load($id);
    }
  
    abstract protected function getConnection(): Connection;
}
