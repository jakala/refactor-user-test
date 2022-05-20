<?php
    declare(strict_types=1);

    namespace TechnicalTest\Infrastructure;

    use mysqli;

    final class MysqlConnection
    {
        private ?mysqli $connection = null;

        private function init(): mysqli
        {
            $this->connection = new mysqli(
                'mariadb-technical-test',
                'root',
                'admin',
                'technical_test'
            );

            return $this->connection;
        }

        public function select(string $SQL): array
        {
            try {
                $result = $this->init()->query($SQL)->fetch_assoc();
                $this->connection->close();
            } catch(\Exception $e) {
                $this->connection->close();
                throw $e;
            }

            return $result ?? [];
        }

        public function update(string $SQL): void
        {
            try {
                $this->init()->query($SQL);
            } catch(\Exception $e) {
                $this->connection->close();
                throw $e;
            } finally {
                $this->connection->close();
            }
        }

        public function insert(string $SQL): void
        {
            try {
                $this->init()->query($SQL);
            } catch(\Exception $e) {
                $this->connection->close();
                throw $e;
            } finally {
                $this->connection->close();
            }
        }

        public function delete(string $SQL): void
        {
            try {
                $this->init()->query($SQL);
            } catch(\Exception $e) {
                $this->connection->close();
                throw $e;
            } finally {
                $this->connection->close();
            }
        }
    }