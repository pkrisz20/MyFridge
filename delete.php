<?php
    require_once "dbconfig.php";
    $sql = "DELETE FROM comments_and_ratings WHERE id = :id";
    $delete = $pdo -> prepare($sql);
    $delete -> bindValue(":id", array_key_first($_POST), PDO::PARAM_STR);
    $delete -> execute();
    $string = "location: details.php?id=" .$_GET["id"];
    header($string, TRUE, 302);
?>