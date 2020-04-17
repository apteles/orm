<?php
declare(strict_types=1);
namespace Apteles\ORM;

use Exception;
use Apteles\ORM\DML\Delete;
use Apteles\ORM\DML\Insert;
use Apteles\ORM\DML\Select;
use Apteles\ORM\DML\Update;
use Apteles\Paginator\Paginator;
use Apteles\ORM\DML\Criteria\Filter;
use Psr\Container\ContainerInterface;
use Apteles\ORM\DML\Criteria\Criteria;

abstract class Record
{
    protected array $data = [];

    protected ?Paginator $paginator = null;

    protected ?ContainerInterface $container = null;

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
            if ($this->container) {
                $result->setContainer($this->container);
            }
            return $result;
        }

        return null;
    }

    public function all(?Criteria $criteria = null): array
    {
        $select = new Select;
        $select->table($this->table)
                    ->from(['*']);
        if ($criteria) {
            $select->setCriteria($criteria);
        }
        $conn = $this->getConnection();
        $conn->make();
        
        $statement = $conn->getConn()->query($select->getInstruction());
        $collection = [];
        while ($result = $statement->fetchObject(\get_class($this))) {
            if ($this->container) {
                $result->setContainer($this->container);
            }
            $collection[] = $result;
        }

        return $collection;
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

    public function count(?Criteria $criteria = null): ?int
    {
        $sql = new Select;
        $sql->table($this->table)
            ->from(['count(*) AS count']);

        if ($criteria) {
            $sql->setCriteria($criteria);
        }

        $conn = $this->getConnection();
        $conn->make();
        $result = $conn->getConn()->query($sql->getInstruction());

        if ($result) {
            return (int) $result->fetch()['count'];
        }
      
        return null;
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

    private function getDataPaginated(object $paginator): array
    {
        $cri = new Criteria;
        $cri->add(new Filter('1', '=', 1));
        $cri->setProperty('limit', $paginator->start);
        $cri->setProperty('offset', $paginator->maxPerPage);
       
        $cri->setProperty('order', '2 ASC');
      
        return $this->all($cri);
    }

    public function paginate(?int $recordsPerPage = null): array
    {
        if (!$recordsPerPage) {
            $recordsPerPage = 10;
        }

        $this->paginator = $this->getPaginator();
        $this->paginator->setTotal($this->count());
        $this->paginator->setPrefix($this->table);
        return $this->paginator->getDataWithCallable(fn ($obj) =>  $this->getDataPaginated($obj), $recordsPerPage);
    }

    public function links(): Paginator
    {
        if ($this->paginator) {
            return $this->paginator;
        }
    }
      
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    protected function getConnection(): Connection
    {
        if ($this->container) {
            if ($this->container->has(Connection::class)) {
                return $this->container->get(Connection::class);
            }
        }
       
        throw new Exception(\sprintf("Has not connection defined, please implement method %s", __METHOD__));
    }

    protected function getPaginator(): Paginator
    {
        if ($this->container) {
            if ($this->container->has(Paginator::class)) {
                return $this->container->get(Paginator::class);
            }
        }
       
        return new Paginator;
    }
}
