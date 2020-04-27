<?php

/*
	GitHub: https://github.com/matheusjohannaraujo/data_manager
	Country: Brasil
	State: Pernambuco
	Developer: Matheus Johann Araújo
	Date: 2020-04-25
*/

// Changing "php.ini" during execution
ini_set("set_time_limit", 0);
ini_set("max_execution_time", 0);
ini_set("default_socket_timeout", 3600);
ini_set("max_input_time", 3600);
ini_set("max_input_time", 3600);
ini_set("max_input_vars", 6000);
ini_set("memory_limit", "6144M");
ini_set("post_max_size", "6144M");
ini_set("upload_max_filesize", "6144M");
ini_set("max_file_uploads", 200);

// Requesting DataManager library
require_once "DataManager.php";

// A quarter of a second ((1/4) second)
$time = 1000000 * 0.25;

// Showing results with preformatting
echo "<pre>";

echo "Criando e escrevando no arquivo de nome 'example_file_a.txt' o valor 'Test DataManager'.<br>";
// Writing a file of [name, value]
var_export(DataManager::fileWrite("example_file_a.txt", "Test DataManager"));
echo "<hr>";

// Wait for
usleep($time);

echo "Abrindo o arquivo de nome 'example_file_a.txt' para leitura.<br>";
// Reading the file of [name, additional parameter]
var_export(DataManager::fileRead("example_file_a.txt"));
echo "<hr>";

// Wait for
usleep($time);

echo "Criando um arquivo em branco de nome 'example_file_b.txt'.<br>";
// Creating a file of [name, value]
var_export(DataManager::fileCreate("example_file_b.txt"));
echo "<hr>";

// Wait for
usleep($time);

echo "Abrindo o arquivo de nome 'example_file_b.txt' e adicionando conteúdo nas linhas seguintes.<br>";
for ($i = 0; $i < 10000; $i++) { 
	// Adding in the file of [name, value, close]	
	var_export(DataManager::fileAppend("example_file_b.txt", "Linha: $i, Test DataManager\r\n", false));
}
echo "<hr>";

// Wait for
usleep($time);

echo "Fecha o arquivo de nome 'example_file_b.txt' que teve adição de conteúdo em suas linhas.<br>";
// Closes the file named 'example_file_b.txt' which has added content to its lines.
var_export(DataManager::fileAppendClose("example_file_b.txt"));
echo "<hr>";

// Wait for
usleep($time);

echo "Transforma cada linha do arquivo em uma string base64.<br>";
// Transform each line of the file into a base64 string
var_export(DataManager::fileEncodeBase64("example_file_b.txt", true));
echo "<hr>";

// Wait for
usleep($time);

echo "Transforma cada string base64 do arquivo em uma linha sem o base64.<br>";
// Transform each base64 string in the file into a line without base64.
var_export(DataManager::fileDecodeBase64("example_file_b.txt", true));
echo "<hr>";

// Wait for
usleep($time);

echo "Obtém o respectivo hash em MD5 do arquivo de nome 'example_file_a.txt'.<br>";
// Gets the MD5 hash of the file.
var_export(DataManager::fileMd5("example_file_b.txt"));
echo "<hr>";

// Wait for
usleep($time);

echo "Divide o arquivo de nome 'example_file_b.txt' em várias partes de acordo com o buffer (0.125) que foi informado.<br>";
// Divide a file into several parts, according to the buffer.
$fileSplit = DataManager::fileSplit("example_file_b.txt", 0.125);
var_export($fileSplit);
echo "<hr>";

// Wait for
usleep($time);

echo "Lista os arquivos e pastas existentes em um diretório.<br>";
// List the files and folders [from, optional detailed list, optional recursive list]
var_export(DataManager::folderScan($fileSplit, true));
echo "<hr>";

// Wait for
usleep($time);

echo "Une as partes do arquivo e gera em um só arquivo.<br>";
// Joins the parts of the file and generates a single file.
$fileJoin = DataManager::fileJoin($fileSplit);
var_export($fileJoin);
echo "<hr>";

// Wait for
usleep($time);

echo "Cria um diretório de nome 'example_dir'.<br>";
// Creating a folder of [name]
var_export(DataManager::folderCreate("example_dir"));
echo "<hr>";

// Wait for
usleep($time);

echo "Realiza a cópia do arquivo 'example_file_a.txt' para dentro da pasta 'example_dir'.<br>";
// Copy [from, to]
var_export(DataManager::copy("example_file_a.txt", "example_dir/example_file_a.txt"));
echo "<hr>";

// Wait for
usleep($time);

echo "Move o arquivo de nome 'example_file_b.txt' para dentro da pasta 'example_dir'.<br>";
// Move [from, to]
var_export(DataManager::move("example_file_b.txt", "example_dir/example_file_b.txt"));
echo "<hr>";

// Wait for
usleep($time);

echo "Exclui o arquivo de nome 'example_file_a.txt'.<br>";
// Delete [file or folder]
var_export(DataManager::delete("example_file_a.txt"));
echo "<hr>";

// Wait for
usleep($time);

echo "Exclui a pasta que contém as partes do arquivo que foi dividido.<br>";
// Delete [file or folder]
var_export(DataManager::delete($fileSplit));
echo "<hr>";

// Wait for
usleep($time);

echo "Exclui o arquivo que possui a união de todas as partes do arquivo que foi dividido.<br>";
// Delete [file or folder]
var_export(DataManager::delete($fileJoin));
echo "<hr>";

// Wait for
usleep($time);

echo "Informa o tamanho da pasta de nome 'example_dir'.<br>";
// Size [of]
var_export(DataManager::size("example_dir/"));
echo "<hr>";

// Wait for
usleep($time);

echo "Altera as permissões da pasta de nome 'example_dir'.<br>";
// Change the permission [from, to such value optional]
var_export(DataManager::perm("example_dir/", 0777));
echo "<hr>";

// Wait for
usleep($time);

echo "Cria um arquivo Zip de nome 'example_zip_file.zip'.<br>";
// Create zip from [name, [data vector], password]
var_export(DataManager::zipCreate("example_zip_file.zip", [
    "example_dir/",
    ["DEVELOPER.txt", "Matheus Johann Araújo"]
]));
echo "<hr>";

// Wait for
usleep($time);

echo "Extrai o arquivo Zip de nome 'example_zip_file.zip' para o diretório 'example_zip_file'.<br>";
// Extract from zip [from, to, optional password]
var_export(DataManager::zipExtract("example_zip_file.zip", "example_zip_file/"));
echo "<hr>";

// Wait for
usleep($time);

echo "Lista o conteúdo de um arquivo Zip.<br>";
// Lists the zip files and folders [name, optional list mode, optional password]
var_dump(DataManager::zipList("example_zip_file.zip", 3));
echo "<hr>";

// Wait for
usleep($time);

echo "Exclui a pasta de nome 'example_dir'.<br>";
// Delete [file or folder]
var_export(DataManager::delete("example_dir"));
echo "<hr>";

// Wait for
usleep($time);

echo "Exclui o arquivo de nome 'example_zip_file.zip'.<br>";
// Delete [file or folder]
var_export(DataManager::delete("example_zip_file.zip"));
echo "<hr>";

// Wait for
usleep($time);

echo "Exclui a pasta de nome 'example_zip_file'.<br>";
// Delete [file or folder]
var_export(DataManager::delete("example_zip_file"));
echo "<hr>";

?>
