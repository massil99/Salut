<?php
    require_once "autoload.php";

    class FriendshipDAO implements DAO{
        private $dbh;
        
        public function __construct(){
            $configFile = file("../src/.config");
            $configInfo = [];
            foreach($configFile as $line)
				$configInfo[explode(":", $line)[0]] = trim(explode(":", $line)[1]);
 
            $this->dbh = mysqli_connect($configInfo["URL"],
                                        $configInfo["USERNAME"],
                                        $configInfo["PASSWORD"],
                                        $configInfo["DATABASE"]);
			if($this->dbh->connect_error){
                echo "MySQLi connection failed";
                exit();
            }
    
        }
    
        public function get(int $id){
            $sql = "SELECT * FROM friendship WHERE id=$id;";
            if($res = $this->dbh->query($sql)){
                if($row = $res->fetch_assoc()){
                    return new Friendship($row);
                }
            }
            return null;
        }

        public function insert($friendship){
            $sql = "INSERT INTO friendship(friend1id, friend2id, createdat)
                VALUES(".$friendship->getFriend1()->getId()
                .", ".$friendship->getFriend2()->getId()
                .", ".$friendship->getCreationDateTime().");";

            if($this->dbh->query($sql)){
                $sql = "SELECT * FROM friendship WHERE 
                        friend1id=".$friendship->getFriend1()->getId()
                    ." AND friend2id=".$friendship->getFriend2()->getId().";";
                if($res = $this->dbh->query($sql)){
                    if($row = $res->fetch_assoc()){
                        $f = new Friendship($row);
                        $data["friendshipid"] = $f->getId();
                        $data["title"] = "Conversation";
                        
                        $c = new Conversation($data);
                        
                        $cDAO = new ConversationDAO;
                        $cDAO->insert($c);
                        return $f;
                    }
                }
            }

            return null;
        }

        public function update($friendship){
            return true;
        }

        public function delete($friendship){
            $sql = "DELETE FROM friendship WHERE id=".$friendship->getId().";";
            if($this->dbh->query($sql)){
                return true;
            }

            return false;
        }

        public function getAll(){
            $friendships = [];
            $sql = "SELECT * FROM friendship";
            if($res = $this->dbh->query($sql)){
                while($row = $res->fetch_assoc()){
                    $friendship[$row['id']] =  new Friendship($row);
                }
            }
            return $friendships;
        }

        public function getFriends($user){
            $sql = "SELECT * FROM friendship WHERE
                friend1id=".$user->getId()."
                OR friend2id =".$user->getId().";";
            $friends = [];
            $userDAO = new UserDAO;
            if($res = $this->dbh->query($sql)){
                while($row = $res->fetch_assoc()){
                    $id = ($row["friend1id"] !== $user->getId())? 
                        $row["friend1id"]: $row["friend2id"];
                    $friends[$id] = $userDAO->get($id);
                }
            }
            return $friends;
        }
    }
