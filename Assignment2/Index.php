<?php require_once('./dao/EntityDAO.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eSports players</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();   
            });
    </script>
</head>

<body> 
<div class="wrapper">
        <div class="container-fluid">
            <div class="players">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Player Details</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Player</a>
                    </div>
                    <?php
                        $EntityDAO = new EntityDAO();
                        $players = $EntityDAO->getPlayers();
                        
                        if($players){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Player Name</th>";
                                        echo "<th>Esports Team</th>";
                                        echo "<th>Networth in USD</th>";
                                        echo "<th>Player Birthdate (YYY-MM-DD)</th>";
                                        echo "<th>Activity</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                foreach($players as $player){
                                    echo "<tr>";
                                        echo "<td>" . $player->getId(). "</td>";
                                        echo "<td>" . $player->getPlayerName() . "</td>";
                                        echo "<td>" . $player->getEsportsTeam() . "</td>";
                                        echo "<td>" . $player->getNetWorth() . "</td>";
                                        echo "<td>" . $player->getBirthDate() . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $player->getId() .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $player->getId() .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $player->getId() .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            //$result->free();
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                   
                    // Close connection
                    $EntityDAO->getMysqli()->close();
                    ?>
                </div>
            </div>        
        </div>
    </div>

</body>
</html>