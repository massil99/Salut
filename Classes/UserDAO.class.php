<?php
    require_once "autoload.php";

    class UserDAO implements DAO{
        private $dbh = null;
        
        public function __construct(){
            $configFile = file("../Salut/.config");
            $configInfo = []; 
            foreach($configFile as $line)
                $configInfo[explode(":", $line)[0]] = trim(explode(":", $line)[1]);
 
            $this->dbh = mysqli_connect($configInfo["URL"],
                                        $configInfo["USERNAME"],
                                        $configInfo["PASSWORD"],
                                        $configInfo["DATABASE"]);
        
			if($this->dbh->connect_error){
                echo "MySQLi connection error";
                exit();
            }
        }

        public function connect(string $username, string $password){
            $sql = "SELECT * FROM users WHERE username='".mysqli_real_escape_string($this->dbh, $username)
            ."' AND password='".$password."';";
            
            if($res = $this->dbh->query($sql)){
                if($res->num_rows > 0){
                    if($row = $res->fetch_assoc()){
                        return new User($row);
                    }
                }
            }
            return null;  
        }

        public function get(int $id){
            $sql = "SELECT * FROM users WHERE id=$id";
        
            if($res = $this->dbh->query($sql)){
                if($res->num_rows > 0){
                    if($row = $res->fetch_assoc()){
                        return new User($row);
                    }
                }
            }
            return null;
        }

        public function insert($user){
            $sql = "INSERT INTO users(username, firstname, lastname, password)
                VALUES('".mysqli_real_escape_string($this->dbh, $user->getUsername()).
                "','".mysqli_real_escape_string($this->dbh, $user->getFirstname()).
                "','".mysqli_real_escape_string($this->dbh,$user->getLastname()).
                "','".$user->getPassword()."');";
            
            echo $sql;
            if($this->dbh->query($sql)){
                $sql = "SELECT * FROM users WHERE username='".$user->getUsername()."';";
                if($res = $this->dbh->query($sql)){
                    if($res->num_rows > 0){
                        if($row = $res->fetch_assoc()){
                            return new User($row);
                        }
                    }
                }
            }

            return null;
        }

        public function delete($user){
            $sql = "DELETE FROM users WHERE id=".$user->getId();
            
            if($this->dbh->query($sql)){
                return true;
            }else{
                return false;
            }
        }

        public function update($user){
            $sql = "UPDATE TABLE users SET username='".$user->getUsername()
            ."', firstname='".$user->getFirstname()
            ."', lastname='".$user->getLastname()
            ."', password='".$user->getPassword()."' WHERE id=".$user->getId().";";
            
            if($this->dbh->query($sql)){
                return true;
            }else{
                return false;
            }
        }

        public function getAll(){
            $sql = "SELECT * FROM users;";
            $users = [];
            if($res = $this->dbh->query($sql)){
                while($row = $res->fetch_assoc()){
                    $users[$row['id']] = new User($row);
                }
            }
            return $users;
        }

        public function getLike($username){
            $sql = "SELECT * FROM users WHERE username LIKE('%".
            mysqli_real_escape_string($this->dbh, $username)."%');";
            $users = [];
            if($res = $this->dbh->query($sql)){
                while($row = $res->fetch_assoc()){
                    $users[$row['id']] = new User($row);
                }
            }
            return $users;
        }
    }
