<?php 

if(isset($_GET['remove'])){
	$mask = 'home*_*';
    array_map('unlink', glob('img/test/'.$mask));
}

?>

<a href="?remove=true">Remove Image</a>