<?php
session_start();
include('../config/modele.php');
$header = NULL;

// ----- SIGNUP -----

if ($_POST['signup'] == "signup" && $_POST['login'] != null && $_POST['mail'] != null && $_POST['passwd'] != null) {
    $login = $_POST['login'];
    $mail = $_POST['mail'];
    $passwd = hash('whirlpool', $_POST['passwd']);
    $database->query("SELECT `id` FROM camagru.users WHERE `login` = :login");
    $database->bind(':login', $login, NULL);
    $database->execute();
    if ($database->fetchAll() == NULL) {
        $database->query("INSERT INTO camagru.users (`login`, `mail`, `passwd`, `status`) 
          VALUES (\"".$login."\", \"".$mail."\", \"".$passwd."\", \"default\");");
        $database->execute();
        $_SESSION['loggued_on_user'] = $login;
        //-------Mail-------
        $subject = "Félicitations !";
        $message = "\nFélicitations, vous êtes maintenant inscrit to Camagru !\n";
        mail($mail, $subject, $message);
        //------------------
    }
    else
        echo "erreurlog";
}

// ----- SIGNIN -----

else if ($_POST['signin'] == 'signin' && $_POST['login'] != null && $_POST['passwd'] != null) {
    $login = $_POST['login'];
    $passwd = hash('whirlpool', $_POST['passwd']);
    $database->query("SELECT `passwd` FROM camagru.users WHERE `login` = :login");
    $database->bind(':login', $login, NULL);
    $database->execute();
    $array = $database->fetchAll();
    if (isset($array[0])) {
        foreach ($array as $value) {
            if ($value['passwd'] == $passwd) {
                $_SESSION['loggued_on_user'] = $login;
                exit;
            }
        }
        echo "erreurmdp";
    }
    else
        echo "erreurlog";
}

// ----- MDP UPDATE -----

elseif ($_POST['mdp'] == 'mdp' && isset($_POST['login']) && isset($_POST['oldmdp']) && isset($_POST['newmdp'])) {
    if ($_SESSION['loggued_on_user'] == $_POST['login']) {
        $user = usersinfos($_POST['login']);
        $oldpwd = hash('whirlpool', $_POST['oldmdp']);
        if ($oldpwd == $user[0]['passwd']) {
            $newpwd = hash('whirlpool', $_POST['newmdp']);
            modifiermdp($newpwd, $_POST['login']);
        }
        else echo "erreurmdp";
    }
    else
        echo "erreurlog";
}

// ----- MAIL UPDATE -----


elseif ($_POST['mail'] == 'mail' && isset($_POST['login']) && isset($_POST['oldmail']) && isset($_POST['newmail'])) {
    if ($_SESSION['loggued_on_user'] == $_POST['login']) {
        $user = usersinfos($_POST['login']);
        if ($_POST['oldmail'] == $user[0]['mail']) {
            modifiermail($_POST['newmail'], $_POST['login']);
            //-------Mail-------
            $subject = "Félicitations !";
            $message = "\nFélicitations, votre mail a bien été mis a jour!\n";
            mail($_POST['newmail'], $subject, $message);
            //------------------
        }
        else echo "erreurmail";
    }
    else
        echo "erreurlog";
}


// ----- DELETE ACCOUNT -----

else if ($_POST['delete'] == 'delete' && $_POST['login']!= null && $_POST['passwd'] != null) {
    $user = usersinfos($_POST['login']);
    if ($_SESSION['loggued_on_user'] == $_POST['login']) {
        $mdp = hash('whirlpool', $_POST['passwd']);
        if ($user[0]['passwd'] == $mdp) {
            deleteaccount($user[0]['id'], $user[0]['login']);
            $_SESSION['loggued_on_user'] = NULL;
        }
        else
            echo "erreurmdp";
    }
    else 
        echo "erreurlog";
}

// ----- FORGOT PASS -----

else if ($_POST['forgot'] == 'forgot' && isset($_POST['login']) && isset($_POST['mail'])) {
    $user = usersinfos($_POST['login']);
    if (isset($user)) {
        if ($user[0]['mail'] == $_POST['mail']) {
            $newpwd = strtoupper($_POST['login']).rand(1, 1000);
            $newpwdhash = hash('whirlpool', $newpwd);
            randompass($_POST['login'], $newpwdhash);
            //-------Mail-------
            $mail = $_POST['mail'];
            $subject = "Nouveau mot de passe !";
            $message = "\nVotre nouveau mot de passse est :\n".$newpwd."\n";
            mail($mail, $subject, $message);
            //------------------
        }
        else
            echo "erreurmail";
    }
    else 
        echo "erreurlog";
}

else if ($_GET['action'] == "deconnexion") {
     $_SESSION['loggued_on_user'] = NULL;
     header("Location: ../index.php");
}

// ---- COQUILLE -----

else {
    $_SESSION['loggued_on_user'] = NULL;
    echo "invalide";
}


?>