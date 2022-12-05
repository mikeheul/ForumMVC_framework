<?php

namespace Model\Entities;

use App\Entity;

final class User extends Entity
{
        private int $id;
        private string $nickname;
        private string $email;
        private string $password;
        private \DateTime $creationDate;
        private string $role;
        private bool $status;

        public function __construct($data)
        {
                $this->hydrate($data);
        }

        /**
         * Get the value of id
         */
        public function getId(): int
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }



        /**
         * Get the value of nickname
         */
        public function getNickname(): string
        {
                return $this->nickname;
        }

        /**
         * Set the value of nickname
         *
         * @return  self
         */
        public function setNickname($nickname)
        {
                $this->nickname = $nickname;

                return $this;
        }

        /**
         * Get the value of email
         */
        public function getEmail(): string
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of password
         */
        public function getPassword(): string
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        /**
         * Get the value of creationDate
         */
        public function getCreationDate(): \DateTime
        {
                return $this->creationDate;
        }

        /**
         * Set the value of creationDate
         *
         * @return  self
         */
        public function setCreationDate($creationDate)
        {
                $this->creationDate = new \DateTime($creationDate);

                return $this;
        }

        /**
         * Get the value of role
         */
        public function getRole(): string
        {
                return $this->role;
        }

        /**
         * Set the value of role
         *
         * @return  self
         */
        public function setRole($role)
        {
                $this->role = $role;

                return $this;
        }

        /**
         * Get the value of status
         */
        public function getStatus(): bool
        {
                return $this->status;
        }

        /**
         * Set the value of status
         *
         * @return  self
         */
        public function setStatus($status)
        {
                $this->status = $status;

                return $this;
        }

        public function hasRole($role): bool
        {
                $result = $this->role == $role;
                return $result;
        }

        public function __toString()
        {
                return $this->nickname;
        }
}
