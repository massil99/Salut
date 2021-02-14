<?php
    class Friendship{
        private $id;
        private $friend1;
        private $friend2;
        private $createdAt;

        public function __construct($data){
            $userd = new UserDAO;

            $this->id = (isset($data['id']))? $data['id']: null;
            $this->friend1 = (isset($data['friend1id']))? $userd->get($data['friend1id']): null;
            $this->friend2 = (isset($data['friend2id']))? $userd->get($data['friend2id']): null;
            $this->createdAt = (isset($data['createdat']))? $data['createdat']: time();
        }

        public function getId(){
            return $this->id;
        }

        public function getFriend1(){
            return $this->friend1;
        }
    
        public function getFriend2(){
            return $this->friend2;
        }

        public function getCreationDateTime(){
            return $this->createdAt;
        }
    }