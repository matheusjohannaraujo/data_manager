<?php

/*
	GitHub: https://github.com/matheusjohannaraujo/data_manager
	Country: Brasil
	State: Pernambuco
	Developer: Matheus Johann Araujo
	Date: 2022-04-01
*/

// Altera o "php.ini" em memória durante a execução
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

// Solicitando a inclusão da biblioteca DataManager
require_once "DataManager.php";

// Incluindo Namespace
use Lib\DataManager;

// 1/4 - Um quarto de segundo
$time = 1000000 * 0.25;

// Mostrando resultados com pré-formatação
echo "<pre>";

echo "Criando e escrevando no arquivo de nome 'example_file_a.txt' o valor 'Test DataManager'.<br>";
var_export(DataManager::fileCreate("example_file_a.txt", "Test DataManager"));
echo "<hr>";

usleep($time);

echo "Abrindo o arquivo de nome 'example_file_a.txt' para leitura.<br>";
var_export(DataManager::fileRead("example_file_a.txt"));
echo "<hr>";

usleep($time);

echo "Criando um arquivo em branco de nome 'example_file_b.txt'.<br>";
var_export(DataManager::fileWrite("example_file_b.txt", ""));
echo "<hr>";

usleep($time);

echo "Abrindo o arquivo de nome 'example_file_b.txt' e adicionando conteúdo nas linhas seguintes.<br>";
$result = true;
for ($i = 0; $i < 10000; $i++) { 
	$result = $result && DataManager::fileAppend("example_file_b.txt", "Linha: $i, Test DataManager\r\n", false);
}
var_export($result);
echo "<hr>";

usleep($time);

echo "Fecha o arquivo de nome 'example_file_b.txt' que teve adição de conteúdo em suas linhas.<br>";
var_export(DataManager::fileAppendClose("example_file_b.txt"));
echo "<hr>";

usleep($time);

echo "Transforma cada linha do arquivo em uma string base64.<br>";
var_export(DataManager::fileEncodeBase64("example_file_b.txt", true));
echo "<hr>";

usleep($time);

echo "Transforma cada string base64 do arquivo em uma linha sem o base64.<br>";
var_export(DataManager::fileDecodeBase64("example_file_b.txt", true));
echo "<hr>";

usleep($time);

echo "Obtém o respectivo hash em MD5 do arquivo de nome 'example_file_a.txt'.<br>";
var_export(DataManager::fileMd5("example_file_b.txt"));
echo "<hr>";

usleep($time);

echo "Divide o arquivo de nome 'example_file_b.txt' em várias partes de acordo com o buffer (0.125) que foi informado.<br>";
$fileSplit = DataManager::fileSplit("example_file_b.txt", 0.125);
var_export($fileSplit);
echo "<hr>";

usleep($time);
DataManager::delete("example_file_b.txt");

usleep($time);

echo "Lista os arquivos e pastas existentes em um diretório.<br>";
var_export(DataManager::folderScan($fileSplit, true));
echo "<hr>";

usleep($time);

echo "Une as partes do arquivo e gera em um só arquivo.<br>";
$fileJoin = DataManager::fileJoin($fileSplit);
var_export($fileJoin);
echo "<hr>";

usleep($time);

echo "Cria um diretório de nome 'example_dir'.<br>";
var_export(DataManager::folderCreate("example_dir"));
echo "<hr>";

usleep($time);

echo "Realiza a cópia do arquivo 'example_file_a.txt' para dentro da pasta 'example_dir'.<br>";
var_export(DataManager::copy("example_file_a.txt", "example_dir/example_file_a.txt"));
echo "<hr>";

usleep($time);

echo "Move o arquivo de nome 'example_file_b.txt' para dentro da pasta 'example_dir'.<br>";
var_export(DataManager::move("example_file_b.txt", "example_dir/example_file_b.txt"));
echo "<hr>";

usleep($time);

echo "Exclui o arquivo de nome 'example_file_a.txt'.<br>";
var_export(DataManager::delete("example_file_a.txt"));
echo "<hr>";

usleep($time);

echo "Exclui a pasta que contém as partes do arquivo que foi dividido.<br>";
var_export(DataManager::delete($fileSplit));
echo "<hr>";

usleep($time);

echo "Informa o tamanho da pasta de nome 'example_dir'.<br>";
var_export(DataManager::size("example_dir/"));
echo "<hr>";

usleep($time);

echo "Altera as permissões da pasta de nome 'example_dir'.<br>";
var_export(DataManager::perm("example_dir/", 0777));
echo "<hr>";

usleep($time);

echo "Cria um arquivo Zip de nome 'example_zip_file.zip'.<br>";
var_export(DataManager::zipCreate("example_zip_file.zip", [
    "example_dir/",
    ["DEVELOPER.txt", "Matheus Johann Araújo"]
]));
echo "<hr>";

usleep($time);

echo "Extrai o arquivo Zip de nome 'example_zip_file.zip' para o diretório 'example_zip_file'.<br>";
var_export(DataManager::zipExtract("example_zip_file.zip", "example_zip_file/"));
echo "<hr>";

usleep($time);

echo "Lista o conteúdo de um arquivo Zip.<br>";
var_dump(DataManager::zipList("example_zip_file.zip", 3));
echo "<hr>";

usleep($time);

echo "Exclui a pasta de nome 'example_dir'.<br>";
var_export(DataManager::delete("example_dir"));
echo "<hr>";

usleep($time);

echo "Exclui o arquivo de nome 'example_zip_file.zip'.<br>";
var_export(DataManager::delete("example_zip_file.zip"));
echo "<hr>";

usleep($time);

echo "Exclui a pasta de nome 'example_zip_file'.<br>";
var_export(DataManager::delete("example_zip_file"));
echo "<hr>";
