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
 * Interface SerializableContainerInterface
 *
 * defines the serializable container interface.
 *
 * @package Singularity\Container
 * @author Matthias Kaschubowski <nihylum@gmail.com>
 */
interface SerializableContainerInterface extends ContainerInterface, \Serializable
{

}