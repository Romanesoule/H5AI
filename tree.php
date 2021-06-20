<?php
include "model.php";

echo "<h2>" . $tree->getPath() . "</h2><br>";
$tree->printTree( $tree->getFiles($fileList, $tree->getPath()));

?>