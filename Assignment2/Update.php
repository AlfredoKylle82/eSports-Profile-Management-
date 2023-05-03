<?php
// Include employeeDAO file
require_once('./dao/EntityDAO.php');

// Define variables and initialize with empty values
$PlayerName = $EsportsTeam = $NetWorth = $BirthDate = $ImagePath = "";
$PlayerName_err = $EsportsTeam_err = $NetWorth_err = $BirthDate_err = $ImagePath_err = "";
$EntityDAO = new EntityDAO();

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate name
    $input_name = trim($_POST["player_name"]);
    if (empty($input_name)) {
        $PlayerName_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $PlayerName_err = "Please enter a valid name.";
    } else {
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
    $input_networth = trim($_POST["net_worth"]);
    if(empty($input_networth)){
        $NetWorth_err = "Please enter the networth amount.";     
    } elseif(!ctype_digit($input_networth) || $input_networth < 1 || $input_networth > 10000000000000){
        $NetWorth_err = "Please enter a positive integer value less than 1 trillion.";
    } else{
        $NetWorth = $input_networth;
    }


    // Validate birthdate
    $input_birthday = trim($_POST["birthdate"]);
    $current_date = date('Y-m-d');
    if(empty($input_birthday)){
        $BirthDate_err = "Please enter the birthday.";     
    } elseif($input_birthday >= $current_date){
        $BirthDate_err = "Please enter a date in the past.";
    } else{
        $BirthDate = $input_birthday;
    }

    $player = $EntityDAO->getPlayer($id);
    // Validate image
if (is_uploaded_file($_FILES['image']['tmp_name'])) {
    $target_dir = "uploads/";
    $image_name = basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    
    
    // Generate a unique filename using a timestamp
    $unique_name = time() . "_" . $image_name;
    $target_file = $target_dir . $unique_name;
    $uploadOk = 1;

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    // Check file size and increase the limit if necessary
    $max_file_size = 5000000; // 5MB
    if ($_FILES["image"]["size"] > $max_file_size) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $ImagePath = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    $ImagePath = $player->getImagePath();
}

    // Check input errors before inserting in database
    if (empty($PlayerName_err) && empty($EsportsTeam_err) && empty($NetWorth_err) && empty($BirthDate_err) && empty($ImagePath_err)) {
        $EntityDAO = new EntityDAO();
        $player = new Entity($id, $PlayerName, $EsportsTeam, $NetWorth, $BirthDate, $ImagePath);
        $updateResult = $EntityDAO->updatePlayer($player);

        header("refresh:2; url=index.php");
        echo '<br><h6 style="text-align:center">' . $updateResult . '</h6>';
        // Close connection
        $EntityDAO->getMysqli()->close();

    }


} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id =  trim($_GET["id"]);
        $player = $EntityDAO->getPlayer($id);
        if($player){
            // Retrieve individual field value
            $PlayerName = $player->getPlayerName();
            $EsportsTeam = $player->getEsportsTeam();
            $NetWorth = $player->getNetWorth();
            $BirthDate = $player->getBirthDate();
            $ImagePath = $player->getImagePath();

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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Player Name</label>
                            <input type="text" name="player_name" class="form-control <?php echo (!empty($PlayerName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $PlayerName; ?>">
                            <span class="invalid-feedback"><?php echo $PlayerName_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Esports team</label>
                            <textarea name="esports_team" class="form-control <?php echo (!empty($EsportsTeam_err)) ? 'is-invalid' : ''; ?>"><?php echo $EsportsTeam; ?></textarea>
                            <span class="invalid-feedback"><?php echo $EsportsTeam_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>NetWorth</label>
                            <input type="text" name="net_worth" class="form-control <?php echo (!empty($NetWorth_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $NetWorth; ?>">
                            <span class="invalid-feedback"><?php echo $NetWorth_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>BirthDate</label>
                            <input type="date" name="birthdate" class="form-control <?php echo (!empty($BirthDate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $BirthDate; ?>">
                            <span class="invalid-feedback"><?php echo $BirthDate_err;?></span>
                        </div>
                        <div>
                            <label>Image</label>
                            <br>
                            <input type="file" name="image" class="<?php echo (!empty($ImagePath_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $ImagePath_err;?></span>
                        </div>
                        <br>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>