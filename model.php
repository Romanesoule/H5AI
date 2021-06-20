<?php
class H5AI {

    private $_tree;
    private $_path;

    public function __construct($path) {
        $this->_tree = [];
        $this->_path = $path;
    }

    public function getTree() {
        return $this->_tree;
    }
    public function getPath() {
        return $this->_path;
    }

    public function getFiles($fileList, $directory) {

        foreach (scandir($directory) as $value) {

            if (substr($value , 0, 1) != ".") {

                if (is_file($directory . "/" . $value)) {
                    $fileList[] = $directory . "/" .$value;
                } else if (is_dir($directory . "/" . $value)) {
                    $tab = [];
                    $fileList[$directory . "/" .$value] = $this->getFiles( $tab , $directory . "/" . $value );
                } else {
                    echo "le fichier n'existe pas ou est invalide" . "\n";
                }
            }
        }
        return $fileList;
    }

    public function list_files($filelist) {

        foreach ($filelist as $value)   {

            if (is_array($value))   {
                $value = $this->list_files($value);
            } else {
                echo $value . "*" ;
            }
        }
    }

    public function display_file($path_file) {
         echo '<table><thead>
        <tr>
        <th id="nom" scope="col">Nom</th>
        <th id="chemin" scope="col">Chemin</th>
        <th id="modif" scope="col">Dernière modification</th>
        <th id="taille" scope="col">Taille</th>
        </tr></thead><tbody><tr><td>';
                
        if (substr($path_file, -3) == "css") {
            echo '<i class="color fab fa-css3-alt"></i>';
        } else if (substr($path_file, -3) == "php") {
            echo '<i class="color fab fa-php"></i>';
        } else if (substr($path_file, -2) == "js") {
            echo '<i class="color fab fa-js-square"></i>';
        } else if (substr($path_file, -4) == "html") {
            echo '<i class="color fab fa-html5"></i>';
        } else if ((substr($path_file, -3) == "png" ) || (substr($path_file, -3) == "jpg") || (substr($path_file, -4) == "jpeg")) {
            echo '<i class="color far fa-file-image"></i>';
        } else if ((substr($path_file, -3) == "mp4" ) || (substr($path_file, -3) == "ogg") || (substr($path_file, -4) == "webm")) {
            echo '<i class="color far fa-file-video"></i>';
        } else if (substr($path_file, -3) == "pdf") {
            echo '<i class="color far fa-file-pdf"></i>';
        }
        echo '<strong  class="content" id="'. $path_file .'">' . substr($path_file , strrpos("$path_file","/") +1) . '</strong>';
        
        if (substr($path_file, -4) == "html") {
            echo '<a id="page" href="'. $path_file.'">Voir la page</a>';
        }

            echo '</td>
            <td>' . $path_file . '</td>
            <td>' . date("F d Y H:i:s.", filemtime($path_file)) . '</td>
            <td>' .filesize($path_file) . 'b </td></tbody></table>' ;

    }

    public function printCutTree($_tree)    {
       
        foreach ($_tree as $key => $value)   {

            if (is_array($value))   {
                
                echo '<ul><p class="dossier" id="' . $key . '"0><i class="color fas fa-folder"></i> '.substr($key , strrpos("$key","/") +1). "</p><br>";
                $value = $this->printCutTree($value);
            } 
            
        }
        echo "</ul>";
    }

    public function printTree($_tree)    {
       
        foreach ($_tree as $key => $value)   {

            if (is_array($value))   {
                
                echo '<ul><p class="dossier" id="' . $key . '"0><i class="color fas fa-folder"></i> '.substr($key , strrpos("$key","/") +1). "</p><br>";
                $value = $this->printTree($value);
            } else {
                echo '<li id="'. $value .'"><i class="fas fa-chevron-right"></i><a>' . substr($value , strrpos("$value","/") +1) . '</a></li><br>';
            }
        }
        echo "</ul>";
    }

    public function display_file_list($directory) {
        echo '<table><thead>
                <tr>
                <th id="nom" scope="col">Nom</th>
                <th id="chemin" scope="col">Chemin</th>
                <th id="modif" scope="col">Dernière modification</th>
                <th id="taille" scope="col">Taille</th>
                </tr></thead><tbody>';
 
        foreach (scandir($directory) as $value) {

            if (substr($value , 0, 1) != ".") {

                if (is_dir($directory . "/" . $value)) {
                    echo '<tr><td class="dossier"><i class="color fas fa-folder"></i> '.$value. "</td></tr>";

                } else {
                    echo '<tr><td>';
                
                    if (substr($value, -3) == "css") {
                        echo '<i class="color fab fa-css3-alt"></i>';
                    } else if (substr($value, -3) == "php") {
                        echo '<i class="color fab fa-php"></i>';
                    } else if (substr($value, -2) == "js") {
                        echo '<i class="color fab fa-js-square"></i>';
                    } else if (substr($value, -4) == "html") {
                        echo '<i class="color fab fa-html5"></i>';
                    } else if ((substr($value, -3) == "png" ) || (substr($value, -3) == "jpg") || (substr($value, -4) == "jpeg")) {
                        echo '<i class="color far fa-file-image"></i>';
                    } else if ((substr($value, -3) == "mp4" ) || (substr($value, -3) == "ogg") || (substr($value, -4) == "webm")) {
                        echo '<i class="color far fa-file-video"></i>';
                    } else if (substr($value, -3) == "pdf") {
                        echo '<i class="color far fa-file-pdf"></i>';
                    }
                    echo '<strong  class="content" id="'. $directory . '/' .$value .'">' . $value . '</strong>';
                    if (substr($value, -4) == "html") {
                        echo '<a id="page" href="'. $directory . '/' .$value .'">Voir la page</a>';
                    }
                    echo '</td>
                    <td>' . $directory . '/' .$value . '</td>
                    <td>' . date("F d Y H:i:s.", filemtime($directory . '/' .$value)) . '</td>
                    <td>' .filesize($directory . '/' .$value) . 'b </td>' ;

                } 
            }
        }
        echo '</tbody></table>';
    }

    public function get_content($file) {
        if ((substr($file, -3) == "png" ) || (substr($file, -3) == "jpg") || (substr($file, -4) == "jpeg")) {
            echo '<img class="previsual" src="'. $file .'">';
        } else if ((substr($file, -3) == "mp4" ) || (substr($file, -3) == "ogg") || (substr($file, -4) == "webm")) {
            echo '<video width="800" height="500" controls src="' . $file . '"></video>';
        } else if ((substr($file, -3) == "pdf" )) {
            echo '<embed src="' . $file . '" width=800 height=500 type="application/pdf"/>';
        } else {
            echo nl2br(htmlentities(file_get_contents($file)));
        }
        
    }

}
//realpath("Nom du fichier dans le dossier courant")
$tree = new H5AI("twitter");
$fileList = [];

?>