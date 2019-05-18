<?php

	namespace App;

	class User {

		protected $firstName, $lastName, $email;

		public function setFirstName(string $firstName): User
		{
			$this->firstName = $firstName;

			return $this;
		}

		public function setLastName(string $lastName): User
		{
			$this->lastName = $lastName;

			return $this;
		}
		public function setEmail(string $email): User
		{
			$this->email = $email;

			return $this;
		}

		public function __toString() {
			return sprintf("%s %s<%s>", $this->firstName, $this->lastName, $this->email);
		}
	}