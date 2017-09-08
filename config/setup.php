<?php
require_once("database.php");
$database = new myDb();

    if ($database) {
        //------CREATE DB USER-------
        $database->query("CREATE TABLE IF NOT EXISTS camagru.users (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `login` VARCHAR(255) NOT NULL,
            `mail` VARCHAR(255) NOT NULL,
            `passwd` VARCHAR(255) NOT NULL,
            `status` ENUM('admin', 'default') NOT NULL
            );");
        $database->execute();
        $adminpass = hash('whirlpool', 'admin');
        $database->query("SELECT `login` FROM camagru.users WHERE `status` = 'admin';");
        $database->execute();
        if ($database->fetchAll() == NULL) {
            $database->query("INSERT INTO camagru.users (`login`, `mail`, `passwd`) 
              VALUES (\"admin\", \"admin@admin.com\", \"".$adminpass."\");");
            $database->execute();
        }
        //------------------------------
        
        //-------CREATE DB FILTERS-------
        $database->query("CREATE TABLE IF NOT EXISTS camagru.filters (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `url_filter` TEXT NOT NULL
            );");
        $database->execute();
        $database->query("SELECT * FROM camagru.filters");
        $database->execute();
        if ($database->fetchAll() == NULL) {
           $database->query("INSERT INTO camagru.filters (`url_filter`)
                VALUES 
                    (\"filters/cat.png\"),
                    (\"filters/minions.png\"),
                    (\"filters/luigi.png\"),
                    (\"filters/scrat.png\"),
                    (\"filters/homer.png\");");
            $database->execute();
        }
        //------------------------------
        
        //-------CREATE DB IMAGES-------
        $database->query("CREATE TABLE IF NOT EXISTS camagru.images (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `url_image` TEXT NOT NULL,
            `name_user` VARCHAR(255) NOT NULL,
            `creation_date` TIMESTAMP NOT NULL
            );");
        $database->execute();
        //------------------------------
        
        //-------CREATE DB COMMENTS -------
        $database->query("CREATE TABLE IF NOT EXISTS camagru.comments (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `commentaire` TEXT NOT NULL,
            `id_image` INT NOT NULL,
            `user_name` VARCHAR(255),
            `creation_date` TIMESTAMP NOT NULL
            );");
        $database->execute();
        
        //-------CREATE DB LIKES -------
        $database->query("CREATE TABLE IF NOT EXISTS camagru.likes (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `id_user` INT NOT NULL,
            `id_image` INT NOT NULL
            );");
        $database->execute();
    }