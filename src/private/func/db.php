<?php

function getDBValue($data_id){
    try{
        $dbh = new PDO("sqlite:" . getenv('SQLITE_PATH'));
        $stmt = $dbh->prepare("SELECT * FROM `smash_data` WHERE `data_id` = :data_id");
        $stmt->bindValue(':data_id', $data_id, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;
    }catch(PDOException $e){
        error_log($e->getMessage());
        return null;
    }
}

function setDBValue($data_id, $data_content, $isInt=false){
    try{
        $dbh = new PDO("sqlite:" . getenv('SQLITE_PATH'));
        $stmt = $dbh->prepare("INSERT OR REPLACE INTO `smash_data` (`data_id`, `data_content`, `latest_update`) VALUES (:data_id, :data_content, datetime('now'))");
        $stmt->bindValue(':data_id', $data_id, PDO::PARAM_STR);
        $stmt->bindValue(':data_content', $data_content, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }catch(PDOException $e){
        error_log($e->getMessage());
        return false;
    }
}
