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

/**
 * Interface ContainerInterface
 *
 * defines the general container interface.
 *
 * @package Singularity\Container
 * @author Matthias Kaschubowski <nihylum@gmail.com>
 */
interface ContainerInterface extends \Countable, \IteratorAggregate, SerializationInterface
{
    /**
     * return the value of the provided item string.
     *
     * @param string $item
     * @return mixed
     */
    public function get(string $item);

    /**
     * checks whether the provided item string is known to the container or not.
     *
     * @param string $item
     * @return bool
     */
    public function has(string $item): bool;

    /**
     * sets the provided value to the provided item string.
     *
     * @param string $item
     * @param $value
     * @return void
     */
    public function set(string $item, $value): void;

    /**
     * associates the provided value to the provided item string only if not already known.
     *
     * @param string $item
     * @param $value
     * @return void
     */
    public function setIf(string $item, $value): void;

    /**
     * removes the provided item string named item from the container.
     *
     * @param string $item
     * @return void
     */
    public function remove(string $item): void;

    /**
     * truncates the container.
     *
     * @return void
     */
    public function truncate(): void;

    /**
     * checks whether the container is empty or not.
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * filters a container by the provided callable.
     *
     * @param callable $callback
     * @return ContainerInterface
     */
    public function filter(callable $callback): ContainerInterface;

    /**
     * pulls items from the current container into a new container instance.
     *
     * @param string[] ...$items
     * @return ContainerInterface
     */
    public function pull(string ... $items): ContainerInterface;
}