<?php
// Include employeeDAO file
require_once('./dao/EntityDAO.php');

 
// Define variables and initialize with empty values
$PlayerName = $EsportsTeam = $NetWorth = $BirthDate = "";
$PlayerName_err = $EsportsTeam_err = $NetWorth_err = $BirthDate_err =  "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name
    $input_name = trim($_POST["player_name"]);
    if(empty($input_name)){
        $PlayerName_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $PlayerName_err = "Please enter a valid name.";
    } else{
        $PlayerName = $input_name;
    }
    
    // Validate team
    $input_team = trim($_POST["esports_team"]);
    if (empty($input_team)) {
        $EsportsTeam_err = "Please enter an esports team.";
    } else if (strlen($input_team) > 50){
        $EsportsTeam_err = "Team name cannot exceed 50 Characters.";
    } else {
        $EsportsTeam = $input_team;
    }
    // Validate networth
    $input_networth = trim($_POST["networth"]);
    if(empty($input_networth)){
        $NetWorth_err = "Please enter the networth amount.";     
    } elseif(!ctype_digit($input_networth) || $input_networth < 1 || $input_networth > 10000000000000){
        $NetWorth_err = "Please enter a positive integer value less than 1 trillion.";
    } else{
        $NetWorth = $input_networth;
    }

    // Validate birthday
    $input_birthday = trim($_POST["birthday"]);
    $current_date = date('Y-m-d');
    if(empty($input_birthday)){
        $BirthDate_err = "Please enter the birthday.";     
    } elseif($input_birthday >= $current_date){
        $BirthDate_err = "Please enter a date in the past.";
    } else{
        $BirthDate = $input_birthday;
    }
    $playerImage = null; // initialize the $playerImage variable to null

    // Handle player image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["player_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["player_image"]["tmp_name"], $target_file)) {
        $playerImage = $target_file;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    
    // Check input errors before inserting in database
    if(empty($PlayerName_err) && empty($EsportsTeam_err) && empty($NetWorth_err) && empty($BirthDate_err) && empty($PlayerImage_err)){
        $EntityDAO = new EntityDAO();
        $player = new Entity(0, $PlayerName, $EsportsTeam, $NetWorth, $BirthDate, $playerImage);
        $addResult = $EntityDAO->addPlayer($player);
        header( "refresh:2; url=index.php" );
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';
        // Close connection
        $EntityDAO->getMysqli()->close();
    }
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add player record to the database.</p>
					
					<!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Player Name</label>
                            <input type="text" name="player_name" class="form-control <?php echo (!empty($PlayerName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $PlayerName; ?>">
                            <span class="invalid-feedback"><?php echo $PlayerName_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Esports Team</label>
                            <textarea name="esports_team" class="form-control <?php echo (!empty($EsportsTeam_err)) ? 'is-invalid' : ''; ?>"><?php echo $EsportsTeam; ?></textarea>
                            <span class="invalid-feedback"><?php echo $EsportsTeam_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Networth</label>
                            <input type="text" name="networth" class="form-control <?php echo (!empty($NetWorth_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $NetWorth; ?>">
                            <span class="invalid-feedback"><?php echo $NetWorth_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>BirthDate</label>
                            <input type="date" name="birthday" class="form-control <?php echo (!empty($BirthDate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $BirthDate; ?>">
                            <span class="invalid-feedback"><?php echo $BirthDate_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="player_image" class="form-control-file <?php echo (!empty($PlayerImage_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $PlayerImage_err;?></span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
