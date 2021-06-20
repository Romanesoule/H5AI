<?php
include "model.php";

$file = $_POST['file'];

$tree->get_content($file);

?>
