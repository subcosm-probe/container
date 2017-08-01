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
 * Interface SerializationInterface
 *
 * defines the serialization checkup interface.
 *
 * @package Singularity\Container
 * @author Matthias Kaschubowski <nihylum@gmail.com>
 */
interface SerializationInterface
{
    /**
     * checks whether the provided class is serializable or not.
     *
     * @return bool
     */
    public function isSerializable(): bool;
}