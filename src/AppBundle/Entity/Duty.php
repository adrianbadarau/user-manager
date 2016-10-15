<?php
/**
 * Created by PhpStorm.
 * User: adrianbadarau
 * Date: 15/10/2016
 * Time: 11:44
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="duties")
 */
class Duty
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $label;
}