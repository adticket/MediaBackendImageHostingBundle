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

namespace Adticket\Sf2BundleOS\MediaBackendImageHostingBundle;

use Adticket\MediaBundle\Interfaces\NewMedia;
use Adticket\MediaBundle\Entity\InternetMediaType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Kümmert sich um das speichern von Dateien
 *
 * @author Markus Tacker <m@coderbyheart.de>
 * @package AdTicket:Elvis:MediaBackendFilesystemBundle
 * @category Misc
 */
class Retrieval extends Base implements \Adticket\MediaBundle\Interfaces\Feature\Retrieval, \Adticket\MediaBundle\Interfaces\Feature\Open
{
    /**
     * Lädt ein Medium
     *
     * @param string $hash
     * @return \Adticket\MediaBundle\Interfaces\StoredMedia|null
     */
    public function retrieve($hash)
    {
        $target = $this->getStorageDir() . DIRECTORY_SEPARATOR . $hash;
        $file = new \SplFileInfo($target);
        if (!$file->isReadable()) return null;
        $media = new Entity\HostedFile();
        $media->setFile($file);
        $media->setHash($hash);
        $media->setUrl($this->getStorageUrlPrefix() . $hash);
        return $media;
    }

    /**
     * Öffnet ein Medium
     *
     * @param string $hash
     * @return \Adticket\MediaBundle\Interfaces\FilesystemFile
     */
    public function open($hash)
    {
        return $this->retrieve($hash);
    }
}
