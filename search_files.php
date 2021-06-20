<?php
include "model.php";

$tree->list_files($tree->getFiles($fileList, $tree->getPath()));

?>