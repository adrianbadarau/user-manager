<?php
/**
 * Created by PhpStorm.
 * User: adrianbadarau
 * Date: 15/10/2016
 * Time: 11:23
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="employees")
 */
class Employee
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
    private $email;
    /**
     * @ORM\Column(type="string")
     */
    private $firstName;
    /**
     * @ORM\Column(type="string")
     */
    private $lastName;
    /**
     * @ORM\Column(type="text")
     */
    private $picture;
    /**
     * @ORM\Column(type="boolean")
     */
    private $gender;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $supervisor_id;
    /**
     * @ORM\ManyToOne(targetEntity="Employee")
     * @ORM\JoinColumn(name="supervisor_id", referencedColumnName="id",nullable=true)
     */
    private $supervisor;
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Duty",inversedBy="employees")
     * @ORM\JoinTable(name="employees_duties")
     */
    private $duties;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLogin;

    public function __construct()
    {
        $this->duties = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getSupervisorId()
    {
        return $this->supervisor_id;
    }

    /**
     * @param mixed $supervisor_id
     */
    public function setSupervisorId($supervisor_id)
    {
        $this->supervisor_id = $supervisor_id;
    }

    /**
     * @return mixed
     */
    public function getSupervisor()
    {
        return $this->supervisor;
    }

    /**
     * @param mixed $supervisor
     */
    public function setSupervisor($supervisor)
    {
        $this->supervisor = $supervisor;
    }

    /**
     * @return mixed
     */
    public function getDuties()
    {
        return $this->duties;
    }

    /**
     * @param mixed $duties
     */
    public function setDuties($duties)
    {
        $this->duties = $duties;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param mixed $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }




}