<?php
header("Content-type: text/html; charset=utf-8");
$conn= oci_connect('test1', '123456', 'test');
var_dump($conn) ;
