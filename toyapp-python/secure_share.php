<?php
$file_name = "/var/www/html/toyapp/toyapp-python/storage/input.jpg";
$N = 5;
$K = 3;
$command = '/usr/bin/python /var/www/html/toyapp/toyapp-python/toyapp.py encrypt '.$file_name.' '.$N.' '.$K;
echo $command;
echo '<br />';
#$result = #exec($command);#
$result = json_decode(passthru($command, $status), true);
echo $result. ' <br />';
var_dump($result);
?>