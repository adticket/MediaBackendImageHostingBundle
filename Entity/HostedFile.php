<?php

//  +--------------------------------------------------+
//  | Copyright (c) Ad ticket GmbH                     |
//  | All rights reserved.                             |
//  +--------------------------------------------------+
//  | This source code is protected by international   |
//  | copyright law and may not be distributed without |
//  | written permission by                            |
//  |   AD ticket GmbH                                 |
//  |   Kaiserstraße 69                                |
//  |   D-60329 Frankfurt am Main                      |
//  |                                                  |
//  |   phone: +49 (0)69 407 662 0                     |
//  |   fax:   +49 (0)69 407 662 50                    |
//  |   mail:  info@adticket.de                        |
//  |   web:   www.ADticket.de                         |
//  +--------------------------------------------------+

/**
 * @author Markus Tacker <m@coderbyheart.de>
 * @package AdTicket:Elvis:MediaBackendFilesystemBundle
 * @category Misc
 */

namespace Adticket\Sf2BundleOS\MediaBackendImageHostingBundle\Entity;

/**
 * Repräsentiert eine gehostete Datei
 *
 * @author Markus Tacker <m@coderbyheart.de>
 * @package AdTicket:Elvis:MediaBackendFilesystemBundle
 * @category Entities
 */
class HostedFile implements \Adticket\MediaBundle\Interfaces\RemoteMedia, \Adticket\MediaBundle\Interfaces\FilesystemFile
{
    /**
     * @var string
     * @Assert\Uri()
     */
    private $url;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var int
     */
    private $filesize;

    /**
     * @var \SplFileInfo
     */
    private $file;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getFilename();
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getDisplayBasename()
    {
        return basename($this->getUrl());
    }

    /**
     * @return \Adticket\MediaBundle\Entity\InternetMediaType
     */
    public function getMediaType()
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $this->file->getPathname());
        finfo_close($finfo);
        $parts = explode('/', $mime);
        return new \Adticket\MediaBundle\Entity\InternetMediaType($parts[0], $parts[1]);
    }

    /**
     * Returns whether the media is public
     *
     * @return bool
     */
    public function isPublic()
    {
        return true;
    }

    /**
     * Anzuzeigender Dateiname mit Endung
     *
     * @return string
     */
    public function getFilename()
    {
        return basename($this->getUrl());
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return "";
    }

    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return int
     */
    public function getFilesize()
    {
        return $this->file->getSize();
    }

    /**
     * @param \SplFileInfo $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return \SplFileInfo
     */
    public function getFile()
    {
        return $this->file;
    }
}
