<?php

namespace App\Model\CMS\Content;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="application_content")
 */
class ApplicationContent extends Content
{
    protected $type = Content::APPLICATION;
}