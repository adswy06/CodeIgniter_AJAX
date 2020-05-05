<?php

if(isset($_POST["image"])){
	$data = $_POST["image"];
	list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);
    $data              = base64_decode($data);
    $imageName         = time().'.png';
    $path              = 'assets/img/gambar/artikel/';
    file_put_contents($path.$imageName, $data);

	echo $imageName;
}

?>