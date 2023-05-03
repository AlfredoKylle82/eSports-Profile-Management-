<?php
class Entity {
	private $id;
    private $PlayerName;
    private $EsportsTeam;
    private $NetWorth;
    private $BirthDate;
    private $ImagePath; 

    public function __construct ($id, $PlayerName, $EsportsTeam, $NetWorth, $BirthDate, $ImagePath) { 
        $this->id = $id;
        $this->PlayerName = $PlayerName;
        $this->EsportsTeam = $EsportsTeam;
        $this->NetWorth = $NetWorth;
        $this->BirthDate = $BirthDate;
        $this->ImagePath = $ImagePath; 
    }

    public function getPlayerName() {
        return $this->PlayerName;
    }

    public function setPlayerName($PlayerName) {
        $this->PlayerName = $PlayerName;
    }

    public function getEsportsTeam() {
        return $this->EsportsTeam;
    }

    public function setEsportsTeam($EsportsTeam) {
        $this->EsportsTeam = $EsportsTeam;
    }

    public function getNetWorth() {
        return $this->NetWorth;
    }

    public function setNetWorth($NetWorth) {
        $this->NetWorth = $NetWorth;
    }

    public function setBirthDate($BirthDate) {
        $this->BirthDate = $BirthDate;
    }

    public function getBirthDate() {
        return $this->BirthDate;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setImagePath($ImagePath) {
        $this->ImagePath = $ImagePath;
    }

    public function getImagePath() {
        return $this->ImagePath;
    }
}

?>
