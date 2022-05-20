<?php
    declare(strict_types=1);

    namespace TechnicalTest\Infrastructure;

    use TechnicalTest\Domain\User;

    final class MysqlUserRepository
    {
        protected const QUERY_FIND = "SELECT * FROM technical_test.user WHERE id = '%s'";
        protected const QUERY_SAVE = "UPDATE user SET name='%s', phone='%s' WHERE id='%s'";
        protected const QUERY_CREATE = "INSERT INTO user (id, name, phone) VALUES ('%s', '%s', '%s')";
        protected const QUERY_EMPTY = "DELETE FROM user";

        private $connection;

        public function __construct()
        {
            $this->connection = new MysqlConnection();
        }

        public function find(string $id): User
        {
            $sql = sprintf(self::QUERY_FIND, $id);
            try {
                $result = $this->connection->select($sql);
                if(empty($result)) {
                    throw new UserNotFound($id);
                }
                return $this->createUser($result);
            } catch(\Exception $e) {
                throw new UserNotFound($id);
            }
        }

        public function save(User $user): void
        {
            $insert = sprintf(self::QUERY_CREATE, $user->getId(), $user->getName(), $user->getPhone());
            $update = sprintf(self::QUERY_SAVE,  $user->getName(), $user->getPhone(),$user->getId());
            try {
                $this->find($user->getId());
                $this->connection->update($update);
            } catch(UserNotFound $e) {
                $this->connection->insert($insert);
            } catch(\Exception $e) {
                throw new UserNotSave($user->getId());
            }
        }

        public function emptyUsers(): void
        {
            $empty = self::QUERY_EMPTY;
            try {
                $this->connection->delete($empty);
            } catch(\Exception $e) {
                throw new \DomainException("cannot empty Users");
            }

        }

        private function createUser(array $row): User
        {
            return new User($row['id'], $row['name'], $row['phone']);
        }
    }