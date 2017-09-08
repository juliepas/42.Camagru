<?php
include("setup.php");
// ----- FILTERS -----

function getfilters() {
    $database = new myDb();
    if ($database) {
        $database->query("SELECT * FROM camagru.filters");
        $database->execute();
        $allfilters = $database->fetchAll();
        return $allfilters;
    }
}

function findfilter($id_filter) {
    $database = new myDb();
    if ($database) {
        $database->query("SELECT * FROM camagru.filters WHERE `id` = :image");
        $database->bind(':image', $id_filter, NULL);
        $database->execute();
        $filter = $database->fetchAll();
        return $filter;
    }
}

// ----- IMAGES -----

function getimage($filename, $username) {
    $database = new myDb();
    if ($database) {
        $database->query("INSERT INTO camagru.images (`url_image`, `name_user`)
          VALUES (:file, :username);");
        $database->bind(':file', $filename, NULL);
        $database->bind(':username', $username, NULL);
        $database->execute();
    }
}
    
function afficherallimages() {
    $database = new myDb();
    if ($database) {
        $database->query("SELECT * FROM camagru.images ORDER BY `creation_date` DESC");
        $database->execute();
        $allimages = $database->fetchAll();
        return $allimages;
    }
}

function lastimages($user) {
    $database = new myDb();
    if ($database) {
        $database->query("SELECT * FROM camagru.images WHERE `name_user` = :username ORDER BY `creation_date` DESC");
        $database->bind(':username', $user, NULL);
        $database->execute();
        $images = $database->fetchAll();
        return $images;
    }
}

function findpicture($id_image) {
    $database = new myDb();
    if ($database) {
        $database->query("SELECT * FROM camagru.images WHERE `id` = :image");
        $database->bind(':image', $id_image, NULL);
        $database->execute();
        $image = $database->fetchAll();
        return $image;
    }
}

function removepicture($id_image) {
    removecomments($id_image);
    removelikes($id_image);
    $database = new myDb();
    if ($database) {
        $database->query("SELECT `url_image` FROM camagru.images WHERE `id` = :image");
        $database->bind(':image', $id_image, NULL);
        $database->execute();
        $url = $database->fetchAll();
        $database->query("DELETE FROM camagru.images WHERE `id` = :image");
        $database->bind(':image', $id_image, NULL);
        $database->execute();
        return $url;
    }
}

function nbpictures($username) {
    $database = new myDb();
    if ($database) {
        $database->query("SELECT COUNT(*) FROM camagru.images WHERE `name_user` = :user GROUP BY `name_user`");
        $database->bind(":user", $username, NULL);
        $database->execute();
        $nbpictures = $database->fetchAll();
        return $nbpictures;
    }
}


// ----- COMMENTAIRES -----

function ajoutercomment($comment, $idimage, $username) {
    $database = new myDb();
    if ($database) {
        $database->query("INSERT INTO camagru.comments (`commentaire`, `id_image`, `user_name`)
        VALUES (:comment, :idimage, :username);");
        $database->bind(':comment', $comment, NULL);
        $database->bind(':idimage', $idimage, NULL);
        $database->bind(':username', $username, NULL);
        $database->execute();
    }
}

function findcomments($id_image) {
    $database = new myDb();
    if ($database) {
        $database->query("SELECT * FROM camagru.comments WHERE `id_image` = :image");
        $database->bind(':image', $id_image, NULL);
        $database->execute();
        $comments = $database->fetchAll();
        return $comments;
    }
}

function nbcomments($id_image) {
    $database = new myDb();
    if ($database) {
        $database->query("SELECT COUNT(*) FROM camagru.comments WHERE `id_image` = :image GROUP BY `id_image`");
        $database->bind(":image", $id_image, NULL);
        $database->execute();
        $nbcomments = $database->fetchAll();
        return $nbcomments;
    }
}

function removecomments($id_image) {
    $database = new myDb();
    if ($database) {
        $database->query("DELETE FROM camagru.comments WHERE `id_image` = :image");
        $database->bind(':image', $id_image, NULL);
        $database->execute();
    }
}

function removeuserscomments($username) {
    $database = new myDb();
    if ($database) {
        $database->query("DELETE FROM camagru.comments WHERE `user_name` = :user");
        $database->bind(':user', $username, NULL);
        $database->execute();
    }
}


// ----- LIKES -----

function like($id_user, $id_image) {
    $database = new myDb();
    if ($database) {
        $database->query("INSERT INTO camagru.likes (`id_user`, `id_image`)
            VALUES (:user, :image);");
        $database->bind(':user', $id_user, NULL);
        $database->bind(':image', $id_image, NULL);
        $database->execute();
    }
}

function dislike($id_user, $id_image) {
    $database = new myDb();
    if ($database) {
        $database->query("DELETE FROM camagru.likes WHERE `id_user` = :user AND `id_image` = :image");
        $database->bind(':user', $id_user, NULL);
        $database->bind(':image', $id_image, NULL);
        $database->execute();
    }
}

function nblikes($id_image) { 
    $database = new myDb();
    if ($database) {
        $database->query("SELECT COUNT(*) FROM camagru.likes WHERE `id_image` = :image GROUP BY `id_image`");
        $database->bind(':image', $id_image, NULL);
        $database->execute();
        $nblikes = $database->fetchAll();
        return $nblikes;
    }
}

function removelikes($id_image) {
    $database = new myDb();
    if ($database) {
        $database->query("DELETE FROM camagru.likes WHERE `id_image` = :image");
        $database->bind(':image', $id_image, NULL);
        $database->execute();
    }
}

function removeuserslikes($id_user) {
    $database = new myDb();
    if ($database) {
        $database->query("DELETE FROM camagru.likes WHERE `id_user` = :user");
        $database->bind(':user', $id_user, NULL);
        $database->execute();
    }
}

function wholikeswhat($id_image, $id_user) {
    $database = new myDb();
    if ($database) {
        $database->query("SELECT * FROM camagru.likes WHERE `id_image` = :image AND `id_user` = :user");
        $database->bind(':image', $id_image, NULL);
        $database->bind(':user', $id_user, NULL);
        $database->execute();
        $jelike = $database->fetchAll();
        if (isset($jelike[0]))
            return true;
        else
            return false;
    }
}

// ----- MON COMPTE -----

function usersinfos($username) {
    $database = new myDb();
    if ($database) {
        $database->query("SELECT * FROM camagru.users WHERE `login` = :user");
        $database->bind(':user', $username, NULL);
        $database->execute();
        $user = $database->fetchAll();
        return $user;
    }
}

function modifiermdp($newmdp, $username) {
    $database = new myDb();
    if ($database) {
        $database->query("UPDATE camagru.users SET `passwd` = :pwd WHERE `login` = :log");
        $database->bind(':pwd', $newmdp, NULL);
        $database->bind(':log', $username, NULL);
        $database->execute();
    }
}

function modifiermail($newmail, $username) {
    $database = new myDb();
    if ($database) {
        $database->query("UPDATE camagru.users SET `mail` = :email WHERE `login` = :log");
        $database->bind(':email', $newmail, NULL);
        $database->bind(':log', $username, NULL);
        $database->execute();
    }
}

function deleteaccount($id_user, $username) {
    removeuserslikes($id_user);
    removeuserscomments($username);
    $database = new myDb();
    if ($database) {
        $database->query("SELECT * FROM camagru.images WHERE `name_user` = :user");
        $database->bind(':user', $username, NULL);
        $database->execute();
        $pictures = $database->fetchAll();
        foreach ($pictures as $value) {
          $url = removepicture($value['id']);
          unlink("../".$url[0]['url_image']);
        }
        $database->query("DELETE FROM camagru.users WHERE `id` = :userid");
        $database->bind(':userid', $id_user, NULL);
        $database->execute();
    }
}

function randompass($user_name, $passrand) {
    $database = new myDb();
    if ($database) {
        $database->query("UPDATE camagru.users SET `passwd` = :pass WHERE `login` = :username");
        $database->bind(':pass', $passrand, NULL);
        $database->bind(':username', $user_name, NULL);
        $database->execute();
    }
}

function getusermail($id_image) {
    $database = new myDb();
    if ($database) {
        $database->query("SELECT * FROM camagru.images WHERE `id` = :idimg");
        $database->bind(':idimg', $id_image, NULL);
        $database->execute();
        $user = $database->fetchAll();
        $database->query("SELECT * FROM camagru.users WHERE `login` = :username");
        $database->bind(':username', $user[0][name_user]);
        $database->execute();
        $mail = $database->fetchAll();
        return $mail[0][mail];
    }
}



?>