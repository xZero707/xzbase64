<?PHP

function init_download($file) {
    if ($fd = fopen($file, "r")) {
        $fsize = filesize($file);
        $path_parts = pathinfo($file);
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"" . $path_parts["basename"] . "\"");
        header("Content-length: $fsize");
        header("Cache-control: private");
        while (!feof($fd)) {
            echo fread($fd, 2048);
        }
    } else {
        return false;
    }
    fclose($fd);
}


function response($array, $exit = true){
   if(is_array($array)){
      echo base64_encode(serialize($array));
      if($exit)
      exit;
   }
   return false;
}
