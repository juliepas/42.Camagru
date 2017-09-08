<?php
session_start();
require_once("../config/modele.php");

function ajouterfilter($image_file, $filter) {
    $dest = imagecreatetruecolor(640, 480);
    imagesavealpha($dest, true);
    $transbackground = imagecolorallocatealpha($dest, 0, 0, 0, 127);
    imagefill($dest, 0, 0, $transbackground);
    $url = findfilter($filter);
    $cat = imagecreatefrompng("../".$url[0]['url_filter']);
    $monimage = imagecreatefrompng("../".$image_file);
    imagecopy($dest, $monimage, 0, 0, 0, 0, 640, 480);
    $catwidth = imagesx($cat);
    $catheight = imagesy($cat);
    imagecopy($dest, $cat, 0, 0, 0, 0, $catwidth, $catheight);
    imagepng($dest, "../".$image_file);
}

if ($_POST["param1"] && $_POST['param2']) {
    $imageEncoded = $_POST["param1"];
    $imageDataExploded = explode(',', $imageEncoded);
    $imageDecoded = base64_decode($imageDataExploded[1]);
    $filename = "images/".time()."image".mt_rand().".png";
    file_put_contents("../".$filename, $imageDecoded);
    $username = $_SESSION['loggued_on_user'];
    getimage($filename, $username);
    ajouterfilter($filename, $_POST['param2']);
    echo $filename;
}

else if ($_GET['action'] == "supprimer" && isset($_GET['id'])) {
    $url = removepicture($_GET['id']);
    unlink("../".$url[0]['url_image']);
    header("Location: ../index.php?action=galerie");
}

else if ($_POST['action'] == "galerie" && $_POST['offset']) {
    $i = (int)$_POST['offset'];
    $images = afficherallimages($i);
    echo json_encode($images[0]);
}
?>