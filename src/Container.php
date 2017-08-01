<?php
/**
 * This file is part of the subcosm-probe.
 *
 * (c)2017 Matthias Kaschubowski
 *
 * This code is licensed under the MIT license,
 * a copy of the license is stored at the project root.
 */

namespace Singularity\Container;


use Singularity\Container\Exceptions\ContainerException;
use Traversable;

/**
 * Class Container
 *
 * General purpose container implementation.
 *
 * @package Singularity\Container
 * @author Matthias Kaschubowski <nihylum@gmail.com>
 */
class Container implements ContainerInterface
{
    /**
     * holds an array of items.
     *
     * @var mixed[]
     */
    protected $items = [];

    /**
     * Container constructor.
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        foreach ( $items as $item => $value ) {
            $this->set($item, $value);
        }
    }

    /**
     * return the value of the provided item string.
     *
     * @param string $item
     * @throws ContainerException when accessing an not existing item.
     * @return mixed
     */
    public function get(string $item)
    {
        if ( ! $this->has($item) ) {
            throw new ContainerException(
                "Unknown key: {$item}"
            );
        }

        return $this->items[$item];
    }

    /**
     * checks whether the provided item string is known to the container or not.
     *
     * @param string $item
     * @return bool
     */
    public function has(string $item): bool
    {
        return array_key_exists($item, $this->items);
    }

    /**
     * sets the provided value to the provided item string.
     *
     * @param string $item
     * @param $value
     * @throws ContainerException when the provided value does not pass the validate method of this container.
     * @return void
     */
    public function set(string $item, $value): void
    {
        if ( ! $this->validate($value, $item) ) {
            throw new ContainerException(
                'Can not set invalid value of type: '.gettype($item).( is_object($value) ? '('.get_class($value).')' : '')
            );
        }
    }

    /**
     * associates the provided value to the provided item string only if not already known.
     *
     * @param string $item
     * @param $value
     * @return void
     */
    public function setIf(string $item, $value): void
    {
        if ( ! $this->has($item) ) {
            $this->set($item, $value);
        }
    }

    /**
     * removes the provided item string named item from the container.
     *
     * @param string $item
     * @return void
     */
    public function remove(string $item): void
    {
        unset($this->items[$item]);
    }

    /**
     * truncates the container.
     *
     * @return void
     */
    public function truncate(): void
    {
        $this->items = [];
    }

    /**
     * checks whether the container is empty or not.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return count($this->items) > 0;
    }

    /**
     * filters a container by the provided callable.
     *
     * @param callable $callback
     * @return ContainerInterface
     */
    public function filter(callable $callback): ContainerInterface
    {
        $filteredItems = array_filter(
            $this->items,
            $callback,
            ARRAY_FILTER_USE_BOTH
        );

        return new Container($filteredItems);
    }

    /**
     * pulls items from the current container into a new container instance.
     *
     * @param string[] ...$items
     * @return ContainerInterface
     */
    public function pull(string ... $items): ContainerInterface
    {
        $container = new Container();

        foreach ( $items as $current ) {
            if ( $this->has($current) ) {
                $container->set($current, $this->get($current));
            }
        }

        return $container;
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        yield from $this->items;
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * checks whether the provided class is serializable or not.
     *
     * @return bool
     */
    public function isSerializable(): bool
    {
        $serializableItems = array_map(
            $mapper = function($value) use (&$mapper) {
                if ( is_object($value) && $value instanceof \Serializable ) {
                    return true;
                }

                if ( is_scalar($value) ) {
                    return true;
                }

                if ( is_array($value) ) {
                    return count($value) === count(array_map($mapper, $value));
                }

                return false;
            },
            $this->items
        );

        return count($this->items) === count($serializableItems);
    }

    /**
     * validates the provided value for the provided item.
     *
     * Container limitations may be implemented while overwriting this method.
     *
     * @param $value
     * @param string $item
     * @return bool
     */
    protected function validate($value, string $item): bool
    {
        return true;
    }
}