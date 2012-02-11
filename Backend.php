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

use Adticket\MediaBundle\Interfaces\NewMedia;
use Adticket\MediaBundle\Entity\InternetMediaType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Dateisystem-Backend
 *
 * @author Markus Tacker <m@coderbyheart.de>
 * @package AdTicket:Elvis:MediaBackendImageHostingBundle
 * @category Misc
 */
class Backend implements \Adticket\MediaBundle\Interfaces\Backend, \Adticket\MediaBundle\Interfaces\Feature\Retrieval, \Adticket\MediaBundle\Interfaces\Feature\Hosting, ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * Constructor
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
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
     * @return string
     */
    public function getVersion()
    {
        return '0.1';
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'http://elvis.adticket.de/';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Image hosting backend';
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'Medienbackend, in dem Bilder veröffentlicht werden können.';
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return 'Markus Tacker <m@coderbyheart.de>';
    }

    /**
     * Lädt ein Medium
     *
     * @param string $hash
     * @return \Adticket\MediaBundle\Interfaces\StoredMedia
     */
    public function retrieve($hash)
    {
        return $this->getContainer()->get('adticket.mediabackendimagehosting.retrieval')->retrieve($hash);
    }

    /**
     * @param \Adticket\MediaBundle\Interfaces\StoredMedia $media
     * @return string
     */
    public function getMediaUrl(\Adticket\MediaBundle\Interfaces\StoredMedia $media)
    {
        return $this->getContainer()->get('adticket.mediabackendimagehosting.retrieval')->getMediaUrl($media);
    }

    /**
     * @param \Adticket\MediaBundle\Interfaces\ThumbnailMedia $media
     * @param int $width preferred width
     * @param int $height preferred height
     * @return string
     */
    public function getMediaThumbnailUrl(\Adticket\MediaBundle\Interfaces\ThumbnailMedia $media, $width, $height)
    {
        return $this->getContainer()->get('adticket.mediabackendimagehosting.retrieval')->getMediaUrl($media);
    }

    /**
     * Fügt ein neues Medium hinzu
     *
     * @param \Adticket\MediaBundle\Interfaces\NewMedia $file
     * @return string Hash des Mediums
     */
    function store(NewMedia $file)
    {
        return $this->getContainer()->get('adticket.mediabackendimagehosting.storage')->store($file);
    }

    /**
     * Gibt ein Array mit akzeptierten Mime-Typen zurück
     *
     * @return String[]
     */
    function getAcceptedMediaTypes()
    {
        return $this->getContainer()->get('adticket.mediabackendimagehosting.storage')->getAcceptedMediaTypes();
    }
}
