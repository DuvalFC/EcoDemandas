<?php
session_start();
include("bd.php");
$sql='DELETE FROM publicacion WHERE id = :id';
$records = $conn->prepare($sql);
$records->bindParam(':id', $_GET['id']);
if ($records->execute()) {
    header("Location: /EcoDemandas/index.php?op=1");
}