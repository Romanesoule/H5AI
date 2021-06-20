<?php
include "model.php";

$directory = $_POST['id_dossier'];

$tree->display_file_list($directory);

?>
