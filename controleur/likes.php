<?php
session_start();

require_once("../config/modele.php");

if ($_POST['action'] == "like" && $_POST['id']) {
	$user = usersinfos($_SESSION['loggued_on_user']);
    like($user[0]['id'], $_POST['id']);
    echo "like";
}

else if ($_POST['action'] == "dislike" && $_POST['id']) {
	$user = usersinfos($_SESSION['loggued_on_user']);
    dislike($user[0]['id'], $_POST['id']);
    echo "dislike";
}

else 
	echo $_POST['action'];

?>