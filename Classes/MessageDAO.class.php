<?php
    require_once "autoload.php";

    class MessageDAO implements DAO{
        private $dbh;

        public function __construct(){
            $this->dbh = mysqli_connect("localhost", "root", "root", "salut");
            if($this->dbh->connect_error){
                echo "MySQLi connection error";
                exit();
            }
        }

        public function get(int $id){
            $sql = "SELECT * FROM messages WHERE id=$id;";
            if($res = $this->dbh->query($sql)){
                if($row = $res->fetch_assoc()){
                    return new Message($row);
                }
            }
            return null;
        }

        public function insert($message){
            $sql = "INSERT INTO messages(message, timestamp, conversationid, senderid, reciverid)
                VALUES('".$message->getMessage()
                ."', ".$message->getTimestamp()
                .", ".$message->getConversationId()
                .", ".$message->getSenderId()
                .", ".$message->getReciverId().");";
            echo $sql;
            if($this->dbh->query($sql)){
                $sql = "SELECT * FROM messages WHERE 
                    timestamp=".$message->getTimestamp()
                    ."conversationid=".$message->getConversationId().";";
                if($res = $this->dbh->query($sql)){
                    if($row = $res->fetch_assoc()){
                        return new Message($row);
                    }
                }
            }

            return null;
        }

        public function update($message){
            $sql = "UPDATE TABLE messages SET 
                    message=,'".$message->getMessage()
                ."',timestamp=".$message->getTimestamp()
                .", conversationid=".$message->getConversationId()
                .", senderid=".$message->getSenderId()
                .", reciverid=".$message->getReciverId()." WHERE id=".$message->getId().";";
            if($this->dbh->query($sql)){
                return true;
            }

            return false;
        }

        public function delete($message){
            $sql = "DELETE FROM messages WHERE id=".$message->getId().";";
            if($this->dbh->query($sql)){
                return true;
            }

            return false;
        }

        public function getAll(){
            $messages = [];
            $sql = "SELECT * FROM messages";
            if($res = $this->dbh->query($sql)){
                while($row = $res->fetch_assoc()){
                    $messages[$row['id']] =  new Message($row);
                }
            }
            return $messages;
        }

        public function getAllBefore($timestamp, $convid){
            $messages = [];
            $sql = "SELECT * FROM messages 
                    WHERE conversationid=$convid
                            AND timestamp<=$timestamp ORDER BY timestamp";
            if($res = $this->dbh->query($sql)){
                while($row = $res->fetch_assoc()){
                    $messages[$row['id']] =  new Message($row);
                }
            }
            return $messages;
        }
    }