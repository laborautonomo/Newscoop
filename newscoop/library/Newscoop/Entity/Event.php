<?php
/**
 * @package Newscoop
 * @copyright 2012 Sourcefabric o.p.s.
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Newscoop\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Events")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @var int
     */
    private $id;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", name="Name")
     * @var int
     */
    private $name;

    /**
     * @ORM\Column(type="string", name="Notify")
     * @var int
     */
    private $notify;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Newscoop\Entity\Language")
     * @ORM\JoinColumn(name="IdLanguage", referencedColumnName="Id")
     * @var Newscoop\Entity\Language
     */
    private $language;

    public function getName() {
        return $this->name;
    }
}
