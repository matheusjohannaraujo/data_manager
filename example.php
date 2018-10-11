<?php

/*
	Bitbucket: https://bitbucket.org/matheusjohannaraujo/data_manager/
	Country: Brasil
	State: Pernambuco
	Developer: Matheus Johann Araújo
	Date: 2018-09-05
*/

//Changing "php.ini" during execution
ini_set("set_time_limit", 0);
ini_set("max_execution_time", 0);
ini_set("default_socket_timeout", 0);
ini_set('memory_limit', '256M');

//Requesting DataManager library
require_once "DataManager.php";

//Vector with result of the use of each method
$array = [];

//A quarter of a second ((1/4) second)
$time = 1000000 * 0.25;

//Value of test
$valueTest = "Testando LIB Sistema de arquivos";

//Creating a file of [name, value]
$array[] = DataManager::createFile("a.txt", $valueTest . " ID: " . uniqid());

//Wait for
usleep($time);

//Writing a file of [name, value]
$array[] = DataManager::writeFile("a.txt", $valueTest . " ID: " . uniqid());

//Wait for
usleep($time);

//Adding in the file of [name, value]
$array[] = DataManager::appendFile("a.txt", "\r\n" . $valueTest . " ID: " . uniqid());

//Wait for
usleep($time);

//Reading the file of [name, additional parameter]
$array[] = DataManager::readFile("a.txt");

//Wait for
usleep($time);

//Creating a folder of [name]
$array[] = DataManager::createFolder("b");

//Wait for
usleep($time);

//Copy [from, to]
$array[] = DataManager::copy("a.txt", "b/a.txt");

//Wait for
usleep($time);

//Delete [file or folder]
$array[] = DataManager::delete("a.txt");

//Wait for
usleep($time);

//Size [of]
$array[] = DataManager::size("b/");

//Wait for
usleep($time);

//Create zip from [name, [data vector], password]
$array[] = DataManager::createZip("pasta (b).zip", [
    "b/",
    ["DEVELOPER.txt", "Matheus Johann Araújo"]
]);

//Wait for
usleep($time);

//Extract from zip [from, to, optional password]
$array[] = DataManager::extractZip("pasta (b).zip", "pasta (b)/");

//Wait for
usleep($time);

//Lists the zip files and folders [name, optional list mode, optional password]
$array[] = DataManager::listZip("pasta (b).zip", 3);

//Wait for
usleep($time);

//Change the permission [from, to such value optional]
$array[] = DataManager::perm("b/", 0777);

//Wait for
usleep($time);

//List the files and folders [from, optional detailed list, optional recursive list]
$array[] = DataManager::scanFolder(".", false, true);

//Wait for
usleep($time);

//Move [from, to]
$array[] = DataManager::move("b/a.txt", "a.txt");

//Wait for
usleep($time);

//Delete [file or folder]
$array[] = DataManager::delete("b/");

//Wait for
usleep($time);

//Delete [file or folder]
$array[] = DataManager::delete("a.txt");

//Wait for
usleep($time);

//Delete [file or folder]
$array[] = DataManager::delete("pasta (b).zip");

//Wait for
usleep($time);

//Delete [file or folder]
$array[] = DataManager::delete("pasta (b)/");

//Showing results
echo "<pre>";
var_export($array);
echo "</pre>";

?>
