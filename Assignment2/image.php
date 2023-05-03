<?php
// Include EntityDAO file
require_once('./dao/EntityDAO.php');

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);

    $EntityDAO = new EntityDAO();
    $player = $EntityDAO->getPlayer($id);

    if ($player) {
        $image_data = $player->getImagePath();
        $info = getimagesizefromstring($image_data);
        header("Content-type: " . $info['mime']);

        echo $image_data;
    } else {
        header("HTTP/1.0 404 Not Found");
    }

    $EntityDAO->getMysqli()->close();
} else {
    header("HTTP/1.0 404 Not Found");
}
?>
