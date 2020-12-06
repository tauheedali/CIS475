<?php
$debug = 0;
// Make sure only files in this directory are accessible by removing slashes
$file = str_replace('/','\/',$_GET['file']);
$file = str_replace('\\','',$file);

if ($debug) {
    echo("file=$file<br>\n");
    //  exit;
}

// If the file doesn't exist, show an error message and leave

if (file_exists($file)) {
    $basename = basename($file);
    header("Content-Type: application/octet-stream");
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"$file\"");
    //  readfile($file);
    $fh = @fopen($file,"rb");
    while(!feof($fh)) {
        print(@fread($fh, 1024*8));
        ob_flush();
        flush();
    }
    fclose($fh);
} else {
    header("HTTP/1.0 404 Not Found");
    echo("The selected file $file does not exist");
}
?>