<?php

	namespace App\User;

	class User {

		protected $firstName, $lastName, $email;

		public function setFirstName($firstName): User
		{
			$this->firstName = $firstName;

			return $this;
		}

		public function setLastName($lastName): User
		{
			$this->lastName = $lastName;

			return $this;
		}
		public function setEmail($email): User
		{
			$this->email = $email;

			return $this;
		}

		public function __toString() {
			return $this->email;
		}
	}