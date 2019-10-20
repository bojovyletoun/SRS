<?php

declare(strict_types=1);

namespace App\Model\CMS\Content;

use Doctrine\ORM\Mapping as ORM;
use Nette\Application\UI\Form;

/**
 * DTO obsahu s HTML.
 *
 * @author Jan Staněk <jan.stanek@skaut.cz>
 */
class HtmlContentDTO extends ContentDTO
{
    /**
     * Text.
     * @var string
     */
    protected $text;


    /**
     * HtmlContent constructor.
     * @param string $type
     * @param string $heading
     * @param string $text
     */
    public function __construct(string $type, string $heading, ?string $text)
    {
        parent::__construct($type, $heading);
        $this->text = $text;
    }

    public function getText() : ?string
    {
        return $this->text;
    }
}
