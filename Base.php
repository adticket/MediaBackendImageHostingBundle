<?php

//  +-----------------------------------------------------------+
//  | Copyright (c) AD ticket GmbH                              |
//  | All rights reserved.                                      |
//  +-----------------------------------------------------------+
//  | AD ticket GmbH                                            |
//  | Kaiserstraße 69                                           |
//  | D-60329 Frankfurt am Main                                 |
//  |                                                           |
//  | phone: +49 (0)69 407 662 0                                |
//  | fax:   +49 (0)69 407 662 50                               |
//  | mail:  github@adticket.de                                 |
//  | web:   www.ADticket.de                                    |
//  +-----------------------------------------------------------+
//  | This file is part of                                      |
//  | MediaBackendImageHostingBundle.                           |
//  | https://github.com/adticket/MediaBackendImageHostingBundle|
//  +-----------------------------------------------------------+
//  | This bundle is free software: you can redistribute it     |
//  | and/or modify it under the terms of the GNU General       |
//  | Public License as published by the Free Software          |
//  | Foundation, either version 3 of the License, or (at your  |
//  | option) any later version.                                |
//  |                                                           |
//  | In addition you are required to retain all author         |
//  | attributions provided in this software and attribute all  |
//  | modifications made by you clearly and in an appropriate   |
//  | way.                                                      |
//  |                                                           |
//  | This software is distributed in the hope that it will be  |
//  | useful, but WITHOUT ANY WARRANTY; without even the        |
//  | implied warranty of MERCHANTABILITY or FITNESS FOR A      |
//  | PARTICULAR PURPOSE.  See the GNU General Public License   |
//  | for more details.                                         |
//  |                                                           |
//  | You should have received a copy of the GNU General Public |
//  | License along with this software.                         |
//  | If not, see <http://www.gnu.org/licenses/>.               |
//  +-----------------------------------------------------------+

/**
 * @author Markus Tacker <m@coderbyheart.de>
 * @package AdTicket:Elvis:MediaBackendImageHostingBundle
 * @category Misc
 */

namespace Adticket\Sf2BundleOS\MediaBackendImageHostingBundle;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\DoctrineBundle\Registry;

/**
 * Basisklasse
 *
 * @author Markus Tacker <m@coderbyheart.de>
 * @package AdTicket:Elvis:MediaBackendImageHostingBundle
 * @category Misc
 */
abstract class Base implements ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @var \SplFileInfo
     */
    private $storageDir;

    /**
     * @var string
     */
    private $storageUrlPrefix;

    /**
     * Constructor
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface
     * @param string $storageDir
     * @param string $storageUrl
     */
    public function __construct(ContainerInterface $container, $storageDir, $storageUrlPrefix)
    {
        $this->setContainer($container);
        $this->storageDir = new \SplFileInfo($storageDir);
        $this->storageUrlPrefix = substr($storageUrlPrefix, -1) == '/' ? $storageUrlPrefix : $storageUrlPrefix . '/';
    }

    /**
     * Sets the Container.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container A ContainerInterface instance
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Returns the Container.
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param \Adticket\MediaBundle\Interfaces\StoredMedia $media
     * @return string
     */
    public function getMediaUrl(\Adticket\MediaBundle\Interfaces\StoredMedia $media)
    {
        return $media->getUrl();
    }

    /**
     * @param \Adticket\MediaBundle\Interfaces\ThumbnailMedia $media
     * @param int $width preferred width
     * @param int $height preferred height
     * @return string
     */
    public function getMediaThumbnailUrl(\Adticket\MediaBundle\Interfaces\ThumbnailMedia $media, $width, $height)
    {
        throw new \NotImplementedException();
    }

    /**
     * @return \SplFileInfo
     */
    public function getStorageDir()
    {
        return $this->storageDir;
    }

    /**
     * @return string
     */
    public function getStorageUrlPrefix()
    {
        return $this->storageUrlPrefix;
    }
}
