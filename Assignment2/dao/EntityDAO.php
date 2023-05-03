<?php
require_once('AbstractDAO.php');
require_once('./entity/Entity.php');

class EntityDAO extends AbstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }  
    
    public function getPlayer($playerId){
        $query = 'SELECT * FROM esports WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $playerId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $player = new Entity($temp['id'],$temp['PlayerName'], $temp['EsportsTeam'], $temp['NetWorth'], $temp['BirthDate'], $temp['ImagePath']);
            $result->free();
            return $player;
        }
        $result->free();
        return false;
    }
    
    public function getPlayers() {
        // The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM esports');

        // Check if the result is not a boolean false value
        if($result !== false) {
            $players = Array();

            if($result->num_rows >= 1){
                while($row = $result->fetch_assoc()){
                    $player = new Entity($row['id'], $row['PlayerName'], $row['EsportsTeam'], $row['NetWorth'], $row['BirthDate'], $row['ImagePath']);
                    $players[] = $player;
                }
                $result->free();
                return $players;
            }

            return false;
        } else {
            // Print the error message and return false
            echo "Error in SQL query: " . $this->mysqli->error;
            return false;
        }
    }
    
    
    
    public function addPlayer($player){
        if(!$this->mysqli->connect_errno){
            $query = 'INSERT INTO esports (PlayerName, EsportsTeam, NetWorth, BirthDate, ImagePath) VALUES (?,?,?,?,?)';
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $PlayerName = $player->getPlayerName();
                    $EsportsTeam = $player->getEsportsTeam();
                    $NetWorth = $player->getNetWorth();
                    $BirthDate = $player->getBirthDate();
                    $ImagePath = $player->getImagePath();
    
                    $stmt->bind_param('ssiss',
                        $PlayerName,
                        $EsportsTeam,
                        $NetWorth,
                        $BirthDate,
                        $ImagePath
                    );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $player->getPlayerName() . ' added successfully!';
                    } 
            }
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   
    public function updatePlayer($player){

        if(!$this->mysqli->connect_errno){
            $query = "UPDATE esports SET PlayerName=?, EsportsTeam=?, NetWorth=?, BirthDate=?, ImagePath=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $PlayerName = $player->getPlayerName();
                    $EsportsTeam = $player->getEsportsTeam();
                    $NetWorth = $player->getNetWorth();
                    $BirthDate = $player->getBirthDate();
                    $ImagePath = $player->getImagePath();
                    $id = $player->getId();
    
                    $stmt->bind_param('ssissi',
                        $PlayerName,
                        $EsportsTeam,
                        $NetWorth,
                        $BirthDate,
                        $ImagePath,
                        $id
                    );    
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $player->getPlayerName() . ' updated successfully!';
                    } 
            }
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
    
        }else {
            return 'Could not connect to Database.';
        }
    }
    

    public function deletePlayer($playerId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM esports WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $playerId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>