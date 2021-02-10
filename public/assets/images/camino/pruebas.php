<?php

$var = 'https://www.youtube.com/watch?v=X5f2FtR3Yfw';
$res = explode('=',$var);
//var_dump($res);
$res = $res[1];
$res = explode('&',$res);
echo $res[0];


?>
