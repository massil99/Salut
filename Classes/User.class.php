<?php
    require_once "autoload.php";

    class User{
        private $id = '';
        private $username = '';
        private $firstname = '';
        private $lastname = '';
        private $password = '';

        public function __construct($data = null){
            if($data != null){
                $this->id = (isset($data['id']))? $data['id'] : null;
                $this->username = (isset($data['username']))? $data['username'] : null;
                $this->firstname = (isset($data['firstname']))? $data['firstname'] : null;
                $this->lastname = (isset($data['lastname']))? $data['lastname'] : null;
                $this->password = (isset($data['password']))? md5($data['password']) : null;
            }
        }

        public function getId(){
            return $this->id;
        }

        public function getUsername(){
            return $this->username;
        }

        public function getFirstname(){
            return $this->firstname;
        }

        public function getLastname(){
            return $this->lastname;
        }

        public function getPassword(){
            return $this->password;
        }

        public function __toString() {
            return  $this->id.":".
                    $this->username.":".
                    $this->firstname.":".
                    $this->lastname.":".
                    $this->password;
        }
    }