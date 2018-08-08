<?php

/*
	GitHub: https://github.com/matheusjohannaraujo
	Country: Brasil
	State: Pernambuco
	Developer: Matheus Johann Araújo
	Date: 2018-08-07
*/

//Changing "php.ini" during execution
ini_set('max_execution_time', 0);
ini_set('memory_limit', '256M');

//Example of using the SystemFilesPHP library
require_once "SystemFilesPHP.php"; //Requesting SystemFilesPHP library

//Vector with result of the use of each method
$array = [];

//A quarter of a second ((1/4) second)
$time = 1000000 * 0.25;

//Value of test
$valueTest = "Testando LIB Sistema de arquivos";

//Creating a file of [name, value]
$array[] = SystemFilesPHP::createFile("a.txt", $valueTest . " ID: " . uniqid());

//Wait for
usleep($time);

//Writing a file of [name, value]
$array[] = SystemFilesPHP::writeFile("a.txt", $valueTest . " ID: " . uniqid());

//Wait for
usleep($time);

//Adding in the file of [name, value]
$array[] = SystemFilesPHP::appendFile("a.txt", "\r\n" . $valueTest . " ID: " . uniqid());

//Wait for
usleep($time);

//Reading the file of [name, additional parameter]
$array[] = SystemFilesPHP::readFile("a.txt");

//Wait for
usleep($time);

//Creating a folder of [name]
$array[] = SystemFilesPHP::createFolder("b");

//Wait for
usleep($time);

//Copy [from, to]
$array[] = SystemFilesPHP::copy("a.txt", "b/a.txt");

//Wait for
usleep($time);

//Delete [file or folder]
$array[] = SystemFilesPHP::delete("a.txt");

//Wait for
usleep($time);

//Size [of]
$array[] = SystemFilesPHP::size("b/");

//Wait for
usleep($time);

//Create zip from [name, [data vector], password]
$array[] = SystemFilesPHP::createZip("pasta (b).zip", [
    "b/",
    ["DEVELOPER.txt", "Matheus Johann Araújo"]
], 123);

//Wait for
usleep($time);

//Extract from zip [from, to, optional password]
$array[] = SystemFilesPHP::extractZip("pasta (b).zip", "pasta (b)/", 123);

//Wait for
usleep($time);

//Change the permission [from, to such value optional]
$array[] = SystemFilesPHP::perm("b/", 0777);

//Wait for
usleep($time);

//List the files and folders [from, optional detailed list, optional recursive list]
$array[] = SystemFilesPHP::scanFolder(".", false, true);

//Wait for
usleep($time);

//Move [from, to]
$array[] = SystemFilesPHP::move("b/a.txt", "a.txt");

//Wait for
usleep($time);

//Delete [file or folder]
$array[] = SystemFilesPHP::delete("b/");

//Wait for
usleep($time);

//Delete [file or folder]
$array[] = SystemFilesPHP::delete("a.txt");

//Wait for
usleep($time);

//Delete [file or folder]
$array[] = SystemFilesPHP::delete("pasta (b).zip");

//Wait for
usleep($time);

//Delete [file or folder]
$array[] = SystemFilesPHP::delete("pasta (b)/");

//Showing results
echo "<pre>";
var_export($array);
echo "</pre>";

?>