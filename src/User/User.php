<?php

namespace TechnicalTest\User;

use DomainException;
use mysqli;

class User
{
    private string $id;
    private string $name;
    private string $phone;

    public function __construct(string $id, string $name, string $phone)
    {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
    }

    public static function save(string $id, string $name, string $phone): void
    {
        try {
            self::find($id);
            self::updateUser($name, $phone, $id);
        } catch (DomainException $e) {
            self::createUser($id, $name, $phone);
        }
    }

    public static function find(string $id): User
    {
        $conn = self::getConnection();
        $sql = "SELECT * FROM technical_test.user WHERE id = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $conn->close();
            return new self($row['id'], $row['name'], $row['phone']);
        }
        $conn->close();
        throw new DomainException(sprintf('User %s not found', $id));
    }

    /**
     * @return mysqli
     */
    public static function getConnection(): mysqli
    {
        return new mysqli('mariadb-technical-test', 'root', 'admin', 'technical_test');
    }

    /**
     * @param string $name
     * @param string $phone
     * @param string $id
     * @return array
     */
    public static function updateUser(string $name, string $phone, string $id): void
    {
        $conn = self::getConnection();
        $sql = "UPDATE user SET name='$name', phone='$phone' WHERE id='$id'";
        if (!$conn->query($sql)) {
            throw new DomainException(sprintf('User %s not updated', $id));
        }
        $conn->close();
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $phone
     * @return void
     */
    public static function createUser(string $id, string $name, string $phone): void
    {
        $conn = self::getConnection();
        $sql = "INSERT INTO user (id, name, phone) VALUES ('$id', '$name', '$phone')";
        if (!$conn->query($sql)) {
            throw new DomainException(sprintf('User %s not created', $id));
        }
        $conn->close();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}