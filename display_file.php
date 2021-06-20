<?php
include "model.php";

$path_file = $_POST['path_file'];

$tree->display_file($path_file);

?>
