<?php

namespace App\Entity;

class User
{
    const GENDER_MALE = 'male';

    const GENDER_FEMALE = 'female';

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $gender;

    /** @var int */
    private $age;

    /** @var string */
    private $address;

    /**
     * User constructor.
     * @param string $name
     * @param string $gender
     * @param int $age
     * @param string $address
     */
    public function __construct(string $name, string $gender, int $age, string $address)
    {
        $this->setName($name);
        $this->setGender($gender);
        $this->setAge($age);
        $this->setAddress($address);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender)
    {
        if (!\in_array($gender, [self::GENDER_FEMALE, self::GENDER_MALE], true)) {
            throw new \DomainException('Gender not valid for User Entity');
        }
        $this->gender = $gender;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age)
    {
        if ($age < 0 || $age > 150) {
            throw new \DomainException('Age not valid for User Entity');
        }
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public static function toArray(User $user): array
    {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'gender' => $user->getGender(),
            'age' => $user->getAge(),
            'address' => $user->getAddress(),
        ];
    }
}