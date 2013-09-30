<?php

namespace Europa\Iterator;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

class InstanceIterator implements IteratorAggregate
{
  private $instances;

  public function __construct(Traversable $instances, $instanceof = null)
  {
    foreach ($instances as $instance) {
      if (!is_object($instance)) {
        throw new \UnexpectedValueException(sprintf(
          'The item at offset "%s" must be an object instance. Type of "%s" supplied.',
          $this->key(),
          gettype($instance)
        ));
      }

      if ($instanceof && !$instance instanceof $instanceof) {
        throw new \UnexpectedValueException(sprintf(
          'The instance at offset "%s" must be an instance of "%s". Instance of "%s" supplied.',
          $this->key(),
          $this->instanceof,
          get_class($instance)
        ));
      }
    }

    $this->instances = $instances;
  }

  public function getIterator()
  {
    return new ArrayIterator($this->instances);
  }
}