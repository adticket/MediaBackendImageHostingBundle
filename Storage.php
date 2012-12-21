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
 * @package AdTicket:Elvis:MediaBackendImageHostingBundle
 * @category Misc
 */

namespace Adticket\MediaBackendImageHostingBundle;

use Adticket\MediaBundle\Interfaces\NewMedia;
use Adticket\MediaBundle\Entity\InternetMediaType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Kümmert sich um das speichern von Dateien
 *
 * @author Markus Tacker <m@coderbyheart.de>
 * @package AdTicket:Elvis:MediaBackendImageHostingBundle
 * @category Misc
 */
class Storage extends Base implements \Adticket\MediaBundle\Interfaces\Feature\Hosting
{
    /**
     * Gibt ein Array mit akzeptierten Mime-Typen zurück
     *
     * @return \Adticket\MediaBundle\Entity\InternetMediaType[]
     */
    public function getAcceptedMediaTypes()
    {
        return array(
            new InternetMediaType(InternetMediaType::TYPE_IMAGE, 'gif', 'gif'),
            new InternetMediaType(InternetMediaType::TYPE_IMAGE, 'jpeg', 'jpg'),
            new InternetMediaType(InternetMediaType::TYPE_IMAGE, 'png', 'png'),
        );
    }

    /**
     * Fügt ein neues Medium hinzu
     *
     * @param \Adticket\MediaBundle\Interfaces\NewMedia $file
     * @return \Adticket\MediaBundle\Interfaces\StoredMedia
     */
    public function store(NewMedia $file)
    {
        $hash = $file->getHash();
        $retrieval = $this->getContainer()->get('adticket.mediabackendimagehosting.retrieval');
        if ($media = $retrieval->retrieve($hash)) return $media; // Already in storage
        $uploadDir = $this->getStorageDir();
        $target = $uploadDir . DIRECTORY_SEPARATOR . $hash;
        $source = $file->getFile()->getPathname();

        if (!is_dir($uploadDir)) throw new FileException(sprintf('Not a directory: %s', $uploadDir));
        if (!is_writable($uploadDir)) throw new FileException(sprintf('Not writeable: %s', $uploadDir));
        if (!@copy($source, $target)) {
            throw new FileException(sprintf('Failed to copy %s to %s. Reason: %s', $source, $target, error_get_last()));
        }
        return $retrieval->retrieve($hash);
    }
}
