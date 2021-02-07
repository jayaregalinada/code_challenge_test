<?php

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repositories\CustomerRepository")
 * @ORM\Table(name="customers")
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", name="first_name")
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", name="last_name")
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string")
     */
    protected $username;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $gender;

    /**
     * @ORM\Column(type="string")
     */
    protected $country;

    /**
     * @ORM\Column(type="string")
     */
    protected $city;

    /**
     * @ORM\Column (type="string")
     */
    protected $phone;

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail() : ?string
    {
        return $this->email;
    }

    public function setEmail($email) : Customer
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName() : ?string
    {
        return $this->firstName;
    }

    public function setFirstName($firstName) : Customer
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName() : ?string
    {
        return $this->lastName;
    }

    public function setLastName($lastName) : Customer
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName() : string
    {
        return implode(' ', [$this->getFirstName(), $this->getLastName()]);
    }

    public function getUsername() : ?string
    {
        return $this->username;
    }

    public function setUsername($username) : Customer
    {
        $this->username = $username;

        return $this;
    }

    public function getGender() : ?int
    {
        return $this->gender;
    }

    public function setGender($gender) : Customer
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCountry() : ?string
    {
        return $this->country;
    }

    public function setCountry($country) : Customer
    {
        $this->country = $country;

        return $this;
    }

    public function getCity() : ?string
    {
        return $this->city;
    }

    public function setCity($city) : Customer
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone() : ?string
    {
        return $this->phone;
    }

    public function setPhone($phone) : Customer
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPassword() : ?string
    {
        return $this->password;
    }

    public function setPassword($password) : Customer
    {
        $this->password = $password;

        return $this;
    }
}
