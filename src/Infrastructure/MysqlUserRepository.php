<?php
    declare(strict_types=1);

    namespace TechnicalTest\Infrastructure;

    use DomainException;
    use mysqli;
    use TechnicalTest\Domain\User;

    final class MysqlUserRepository
    {
        public static function getConnection(): mysqli
        {
            return new mysqli('mariadb-technical-test', 'root', 'admin', 'technical_test');
        }

        public static function updateUser(string $name, string $phone, string $id): void
        {
            $conn = self::getConnection();
            $sql = "UPDATE user SET name='$name', phone='$phone' WHERE id='$id'";
            if (!$conn->query($sql)) {
                throw new DomainException(sprintf('User %s not updated', $id));
            }
            $conn->close();
        }

        public static function createUser(string $id, string $name, string $phone): void
        {
            $conn = self::getConnection();
            $sql = "INSERT INTO user (id, name, phone) VALUES ('$id', '$name', '$phone')";
            if (!$conn->query($sql)) {
                throw new DomainException(sprintf('User %s not created', $id));
            }
            $conn->close();
        }

        public function find(string $id): User
        {
            $conn = self::getConnection();
            $sql = "SELECT * FROM technical_test.user WHERE id = '$id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $conn->close();
                return new User($row['id'], $row['name'], $row['phone']);
            }
            $conn->close();
            throw new DomainException(sprintf('User %s not found', $id));
        }

    }