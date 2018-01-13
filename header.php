<?php




$url = "https://get.google.com/albumarchive/pwaf/116749500979671626219/album/5770840404407401281";

$headers = get_headers($url,1);




echo $headers['Location'];


?>
