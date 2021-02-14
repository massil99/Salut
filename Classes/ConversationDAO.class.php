<?php
    require_once "autoload.php";

    class ConversationDAO implements DAO{
        private $dbh = null;

        public function __construct(){
            $this->dbh = mysqli_connect("localhost", "root", "root", "salut");
            if($this->dbh->connect_error){
                echo "MySQLi connection error";
                exit();
            }
        }

        public function get($id){
            $sql = "SELECT * FROM conversations WHERE id=$id";        
            if($res = $this->dbh->query($sql)){
                if($row = $res->fetch_assoc()){
                    return new Conversation($row);
                }
            }

            return null;
        }

        public function insert($conv){
            $sql = "INSERT INTO conversations (friendshipid, title, createdat)
            VALUES('".$conv->getFriendshipId()
            ."', '".$conv->getTitle()
            ."', '".$conv->getCreationDateTime()."');";
            
            if($this->dbh->query($sql)){
                $sql = "SELECT * FROM conversations WHERE 
                friendshipid='".$conv->getFriendshipId()
                ."' AND title='".$conv->getTitle()
                ."' AND createdat='".$conv->getCreationDateTime()."';";

                if($res = $this->dbh->query($sql)){
                    if($row = $res->fetch_assoc()){
                        return new Conversation($row);
                    }
                }
            }
            return null;
        }

        public function delete($conv){
            $sql = "DELETE FROM conversations WHERE id=".$conv->getId().";";
            if($this->dbh->query($sql)){
                return true;
            }
            return false;
        }

        public function update($conv){
            $sql = "UPDATE TABLE conversations SET 
            friendshipid='".$conv->getFriendshipId()
            ."', title='".$conv->getTitle()
            ."', createdat='".$conv->getCreationDateTime()."' WHERE id=".$conv->getId().";";
            
            if($this->dbh->query($sql)){
                return true;
            }
            return false;
        }

        public function getAll(){
            $conversations = [];
            $sql = "SELECT * FROM conversations";        
            if($res = $this->dbh->query($sql)){
                while($row = $res->fetch_assoc()){
                    $conversations[$row['id']]= new Conversation($row);
                }
            }

            return $conversations;
        }

        public function getAllRelatedToUser($userid){
            $sql = "SELECT 
                    DISTINCT conversations.id,
                             conversations.friendshipid,
                             conversations.title,
                             conversations.createdat FROM conversations, friendship
                    WHERE   (friendship.friend1id=$userid OR
                            friendship.friend2id=$userid) AND
                            friendship.id=conversations.friendshipid;";
            $convos = [];
            if($res = $this->dbh->query($sql)){
                while($row = $res->fetch_assoc()){
                    $convos[$row["id"]] = new Conversation(($row));
                }
            }
            return $convos;
        }
    }
