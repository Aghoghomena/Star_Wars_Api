<?php
/**
 * Created by PhpStorm.
 * User: aghogho pc
 * Date: 11/20/2019
 * Time: 10:12 AM
 */


$base_url= "https://swapi.co/api/";
$my_base_url= "http://localhost/starwars_api/api/";

$connect = mysqli_connect(
    'k9xdebw4k3zynl4u.cbetxkdyhwsb.us-east-1.rds.amazonaws.com',
    'ubf2sixm956ef6fz',
    'vqhop29urhcrczc6',
    'm320tkl3fi0wsmme',
    3306)
or trigger_error(mysqli_error(), E_USER_ERROR);

