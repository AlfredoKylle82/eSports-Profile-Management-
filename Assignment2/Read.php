<?php
// Include EntityDAO file
require_once('./dao/EntityDAO.php');
$EntityDAO = new EntityDAO(); 

// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Get URL parameter
    $id =  trim($_GET["id"]);
    $player = $EntityDAO->getPlayer($id);
            
    if($player){
        // Retrieve individual field value
        $PlayerName = $player->getPlayerName();
        $EsportsTeam = $player->getEsportsTeam();
        $NetWorth = $player->getNetWorth();
        $BirthDate = $player->getBirthDate();
        $playerImageData = $player->getImagePath();
        $playerImage = $playerImageData;
    } else{
        // URL doesn't contain valid id. Redirect to error page
        header("location: error.php");
        exit();
    }
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
} 

// Close connection
$EntityDAO->getMysqli()->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        .player-image {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Player Name</label>
                        <p><b><?php echo $PlayerName; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Esports Team</label>
                        <p><b><?php echo $EsportsTeam; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Networth</label>
                        <p><b>$<?php echo $NetWorth; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>BirthDate</label>
                        <p><b><?php echo $BirthDate; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Player image</label>
                        <br>
                        <img src="<?php echo $playerImage; ?>" alt="Player image" class="player-image">
                    </div>

                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
