<?php

/*
	GitHub: https://github.com/matheusjohannaraujo
	Country: Brasil
	State: Pernambuco
	Developer: Matheus Johann Araújo
	Date: 2018-08-09
*/

class DataManager{

	const DIR_SEP = DIRECTORY_SEPARATOR;

    public static function exist($path){
        if(file_exists($path) && is_file($path)){
            return "FILE";
        }
        if(file_exists($path) && is_dir($path)){
            return "FOLDER";
        }
		return false;
	}

    public static function createFile($path, $value = "", $append = false){
		if(!self::exist($path) && (is_string($value) || is_numeric($value)) && is_bool($append)){
			return (file_put_contents($path, $value, ($append ? FILE_APPEND : false)) >= 0) ? true : false;
		}
		return false;
    }
	
    public static function writeFile($path, $write = "", $mode = "w"){
		if($mode == "w" || $mode == "w+"){
			$handle = fopen($path, $mode);
			if(is_array($write)){
				foreach($write as $key => $value){
					fwrite($handle, $value);
				}	
			}else if(is_string($write) || is_numeric($write)){
				fwrite($handle, $write);
			}				
			return fclose($handle);
		}
		return false;
    }
	
    public static function appendFile($path, $append = "", $mode = "a"){
		if(self::exist($path) && ($mode == "a" || $mode == "a+")){
			$handle = fopen($path, $mode);
			if(is_array($append)){
				foreach($append as $key => $value){
					fwrite($handle, $value);
				}	
			}else if(is_string($append) || is_numeric($append)){
				fwrite($handle, $append);
			}
			return fclose($handle);
		}
		return false;
    }
	
    public static function readFile($path, $return = 1, $mode = "r"){
		if(self::exist($path) && is_integer($return) && ($mode == "r" || $mode == "r+")){
			switch($return){
				case 1:
					$handle = fopen($path, $mode);
					$string = "";
					while($value = fgets($handle)){
						$string .= $value;
					}
					fclose($handle);
					return $string;
				case 2:
					return file_get_contents($path);
				case 3:
					return file($path);
			}
		}		
		return false;
	}

    public static function createFolder($path, $permit = 0777, $recur = true){
		if(!self::exist($path) && is_integer($permit) && is_bool($recur)){
			return mkdir($path, $permit, $recur);
		}
		return false;
    }
	
    public static function scanFolder($path, $arrayClean = false, $recursive = false){
        $array = glob($path . self::DIR_SEP . "*");    
        foreach($array as $key => $value){
            if(self::exist($value) == "FILE" && !$arrayClean){
                $array[$key] = [
                    "src" => pathinfo($value)["dirname"] . self::DIR_SEP,
                    "name" => pathinfo($value)["basename"],
					"type" => "FILE",
					"perm" => self::perm($value),
                    "size" => self::size($value),                    
                    "time" => self::time($value)
                ];
            }else if(self::exist($value) == "FOLDER"){
				if(!$arrayClean){
					$array[$key] = [
						"src" => pathinfo($value)["dirname"] . self::DIR_SEP,
						"name" => pathinfo($value)["basename"],
						"type" => "FOLDER",
						"perm" => self::perm($value),
						"size" => self::size($value),
						"time" => self::time($value)
					];
				}                
                if($recursive){
                    $array = array_merge($array, self::scanFolder($value, $arrayClean, $recursive));
                }
            }    
		}
        return $array;
	}
	
	public static function createZip($path, $array, $passZip = ""){
		$return = false;
		$zip = new ZipArchive();
		if ($zip->open($path, ZIPARCHIVE::CREATE) && is_array($array)) {
			$passStatus = false;
			if($passZip != ""){
				$passStatus = $zip->setPassword($passZip);
			}
			$fANON = function($zip, $path, $fANON, $passStatus, $dir = DIRECTORY_SEPARATOR){
				$path = realpath($path);
				if(is_dir($path)){
					$name = pathinfo($path)["basename"] . DIRECTORY_SEPARATOR;
					$array = glob($path . DIRECTORY_SEPARATOR .  "*");
					foreach($array as $key => $value){
						$zipValue = $dir . $name;
						if(file_exists($value) && is_file($value)){
							//echo "FILE: ", $value, " = ", $zipValue . pathinfo($value)["basename"], "<br>";
							$zip->addFile($value, $zipValue . pathinfo($value)["basename"]);
							if($passStatus){
								$zip->setEncryptionName($zipValue . pathinfo($value)["basename"], ZipArchive::EM_AES_256);
							}                        
						}else if(file_exists($value) && is_dir($value)){
							//echo "DIR: ", $value, " = ", $zipValue . pathinfo($value)["basename"], "<br>";
							$fANON($zip, $value, $fANON, $passStatus, $zipValue);
						}
					}
				}
			};
			foreach ($array as $key => $value) {
				if(is_array($value)){
					$zip->addFromString($value[0], $value[1]);
					if($passStatus){
						$zip->setEncryptionName($value[0], ZipArchive::EM_AES_256);
					}                
				}else if(is_string($value) && file_exists($value)){
					$fANON($zip, $value, $fANON, $passStatus);
				}
			}        
			$return = $zip->numFiles;
			$zip->close();
		}    
		return $return;
	}
	
	public static function extractZip($pathZip, $pathExtract, $passZip = ""){
		$return = false;
		$zip = new ZipArchive();
		if($zip->open($pathZip)){
			if($passZip != ""){
				$zip->setPassword($passZip);
			}
			$return = $zip->extractTo($pathExtract);
			$zip->close();
		}
		return $return;
	}

	public static function perm($path, $permit = false){
		if(self::exist($path) && !$permit){
			return substr(sprintf('%o', fileperms($path)), -4);
		}else if(self::exist($path) && is_numeric($permit)){
			return chmod($path, $permit);
		}
		return false;
	}

    public static function copy($path, $newPath){
		if(self::exist($path) == "FILE"){
			return copy($path, $newPath);
		}else if(self::exist($path) == "FOLDER"){
			if(!self::exist($newPath)){
				self::createFolder($newPath);
			}
			$array = self::scanFolder($path, true, true);
			foreach ($array as $key => $value) {
				if(self::exist($value) == "FOLDER"){
					self::createFolder(str_replace($path, $newPath, $value));
				}else if(self::exist($value) == "FILE"){
					copy($value, str_replace($path, $newPath, $value));
				}
			}
			return true;
		}
		return false;
	}

    public static function move($path, $newPath){
		if(self::exist($path) == "FILE"){
            if(copy($path, $newPath))
                return unlink($path);
        }else if(self::exist($path) == "FOLDER"){
			if(!self::exist($newPath)){
				self::createFolder($newPath);
			}
			$array = self::scanFolder($path, true, true);
			foreach ($array as $key => $value) {
				if(self::exist($value) == "FOLDER"){
					self::createFolder(str_replace($path, $newPath, $value));
				}else if(self::exist($value) == "FILE"){
					copy($value, str_replace($path, $newPath, $value));
				}
			}
			return self::delete($path);
		}
		return false;
    }
	
    public static function time($path){
		if(self::exist($path)){
			return date("d/m/Y H:i:s", filectime($path));
		}
		return false;
    }
	
	public static function size($path){
		$bytes = 0;
        if(self::exist($path) == "FOLDER"){
			$array = self::scanFolder($path, true, true);
			for ($i = count($array) - 1, $j = 0; $i >= $j; $i--) {
				if(self::exist($array[$i]) == "FILE"){
					$bytes += filesize($array[$i]);
				}
				unset($array[$i]);
			}
        }else if(self::exist($path) == "FILE"){
            $bytes = filesize($path);
        }
        if($bytes >= 1073741824){
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }else if($bytes >= 1048576){
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }else if($bytes >= 1024){
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }else if($bytes > 1){
            $bytes = $bytes . ' bytes';
        }else if ($bytes == 1){
            $bytes = $bytes . ' byte';
        }else{
            $bytes = '0 bytes';
        }
        return $bytes;
	}

    public static function rename($path, $newPath){
		if(self::exist($path) && !self::exist($newPath)){
			return rename($path, $newPath);
		}
		return false;
    }
	
    public static function delete($path){
		if(self::exist($path) == "FILE"){
			return unlink($path);
		}else if(self::exist($path) == "FOLDER"){
			$array = self::scanFolder($path, true, true);
			for ($i = count($array) - 1, $j = 0, $value = null; $i >= $j; $i--) {
				$value = $array[$i];
				//print_r($value);
				if(self::exist($value) == "FILE"){
					unlink($value);
				}else if(self::exist($value) == "FOLDER"){
					rmdir($value);
				}
			}
			return rmdir($path);
		}
		return false;
	}
   
}
