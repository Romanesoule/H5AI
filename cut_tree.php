<?php
include "model.php";

echo "<h2>" . $tree->getPath() . "</h2><br>";
$tree->printCutTree( $tree->getFiles($fileList, $tree->getPath()));

?>