<?php

ini_set('max_execution_time', 300);

class Download
{
    function downloadById($photos,$name)
    {
        $zip = new ZipArchive();
        
        $name = $name.".zip";

        $zip->open($name, ZipArchive::CREATE);
    
        $i=0;
        foreach($photos as $value)
        {
            $download_file = file_get_contents($value);
    
            $zip->addFromString("img".$i.".jpg",$download_file);
            $i++;
        }

        $zip->close();
        if(file_exists($name))
            return $name; 
        else
            return "false";
    }

    function downloadAll($photos)
    {
        $temp = "";
        $name = [];
        foreach($photos as $key=>$value)
        {
            foreach($value as $k=>$v)
            {   
                $i=0;
                if(is_array($v))
                {
                    foreach ($v as $ke=>$source)
                    {
                        file_put_contents($temp."/".$i.".jpg", file_get_contents($source));
                        $i++;
                    } 
                    
                }
                else
                {
                    if(!file_exists($v))
                    {
                        $oldmask = umask(0);
                        mkdir($v, 0777);
                        umask($oldmask);
                    }
                    
                    $temp = $v;
                    array_push($name,$v);
                }
            }     
    
        }
    
        $zip = new ZipArchive();
        
        $zipName = rand(1000,1000000)."_all.zip";
        
        $zip->open($zipName, ZipArchive::CREATE);
    
        foreach ($name as $k=>$v)
        {
            $dir = new DirectoryIterator($v);
    
            foreach ($dir as $fileinfo) 
            {
                if (!$fileinfo->isDot()) 
                {
                    $zip->addFile($v."/".$fileinfo->getFilename(), $v."/".$fileinfo->getFilename());
                }
            }
        }
    
        $zip->close();
    
        //$this->removeDir($name);

        if(file_exists($zipName))
                return $zipName; 
            else
                return "false";
    }

    function downloadSelected($photos)
    {
        $temp = "";
        $name = [];
        foreach($photos as $key=>$value)
        {
            foreach($value as $k=>$v)
            {   
                $i=0;
                if(is_array($v))
                {
                    foreach ($v as $ke=>$source)
                    {
                        file_put_contents($temp."/".$i.".jpg", file_get_contents($source));
                        $i++;
                    } 
                    
                }
                else
                {
                    if(!file_exists($v))
                    {
                        $oldmask = umask(0);
                        mkdir($v, 0777);
                        umask($oldmask);
                    }
                    
                    $temp = $v;
                    array_push($name,$v);
                }
            }     
    
        }
    
        $zip = new ZipArchive();
            
        $zipName = rand(1000,1000000)."_selected.zip";
        
        $zip->open($zipName, ZipArchive::CREATE);
    
        foreach ($name as $k=>$v)
        {
            $dir = new DirectoryIterator($v);
    
            foreach ($dir as $fileinfo) 
            {
                if (!$fileinfo->isDot()) 
                {
                    $zip->addFile($v."/".$fileinfo->getFilename(), $v."/".$fileinfo->getFilename());
                }
            }
        }
    
        $zip->close();
    
        //$this->removeDir($name);

        if(file_exists($zipName))
                return $zipName; 
            else
                return "false";
    }

    private function removeDir($dirname)
    {
        foreach($dirname as $key=>$value)
        {
            if (is_dir($value))
            {
                $dir_handle = opendir($value);
                
                if (!$dir_handle)
                    return false;

                while($file = readdir($dir_handle)) 
                {
                    if ($file != "." && $file != "..") 
                    {
                        if (!is_dir($value."/".$file))
                            unlink($value."/".$file);
                        else
                            delete_directory($value.'/'.$file);
                    }
                }
        
                closedir($dir_handle);
                rmdir($value);
            }
        }
    }

    
}

?>