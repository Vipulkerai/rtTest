<?php

class JSONhandler
{
    function saveAlbumIntoJSON($data)
    {
        $jsonData = json_encode($data);
        file_put_contents('assets/json/albums.json', $jsonData);
    }

    function getAllData()
    {
        $str = file_get_contents('assets/json/albums.json');
        $json = json_decode($str, true);

        return $json;
    }

    function getAlbums()
    {
        $str = file_get_contents('assets/json/albums.json');
        $json = json_decode($str, true);

        $albums = [];
        $ids = [];
        $sources = [];

        foreach($json as $k=>$v)
        {
            foreach ($v as $key=>$value)
            {
                if($key == "id")
                {
                    array_push($ids,$value);
                }

                if($key == "count" && $value=='0')
                {
                    array_pop($ids);
                }

                if(is_array($value))
                {
                    foreach($value as $kk=>$vv)
                    {
                        foreach ($vv as $kkk=>$vvv) 
                        {
                            if(is_array($vvv))
                            foreach ($vvv as $kkkk=>$vvvv) 
                            {
                                if(is_array($vvvv))
                                foreach ($vvvv as $kkkkk=>$vvvvv) 
                                {
                                    foreach ($vvvvv as $source=>$source_value) 
                                    {
                                        array_push($sources,$source_value);
                                    
                                    }
                                    break;
                                }
                            }
                            break;
                        }
                    }
                }
                    
            }   
        }

        for($i=0;$i<count($ids);$i++)
        {
            $albums[$ids[$i]] = $sources[$i];
        }

        return $albums;
    }

    function getByIDs($ids)
    {
        $str = file_get_contents('assets/json/albums.json');
        $json = json_decode($str, true);

        $album_ids = [];
        $albums = [];
        $count = [];
        $sources = [];
            
        foreach ($json as $key=>$value) 
        {
            foreach ($value as $k => $v) 
            {
                if($k=="id")
                {
                    array_push($album_ids,$v);
                }

                if ($k=="name") {
                    $temp[$k]=$v;
                    array_push($albums, $temp);
                }
        
                if ($k=="count" && $v=="0") {
                    array_pop($albums);
                    array_pop($album_ids);
                }
                    
                if ($k=="count" && $v>0) {
                    array_push($count, $v);
                }

                if (is_array($v)) {
                    foreach ($v as $kk=>$vv) {
                        if (is_array($vv)) {
                            foreach ($vv as $kkk=>$vvv) {
                                if (is_array($vvv)) {
                                    foreach ($vvv as $kkkk=>$vvvv) {
                                        if (is_array($vvvv)) {
                                            foreach ($vvvv as $kkkkk=>$vvvvv) {
                                                foreach ($vvvvv as $kkkkkk=>$source) {
                                                    array_push($sources, $source);
                                                }
                                                break;
                                            }
                                        }
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
            
            
        $sources = array_reverse($sources);
        $j=0;
        foreach ($count as $k=>$v) {
            $s = [];
            for ($i=0;$i<$v;$i++) {
                $temp = array_pop($sources);
                array_push($s, $temp);
            }
            array_push($albums[$j], $s);
            $j++;
        }

        $albums_temp = [];
        for($k=0;$k<count($ids);$k++)
        {
            for($l=0;$l<count($album_ids);$l++)
            {
                if($ids[$k]==$album_ids[$l])
                {
                    
                    array_push($albums_temp,$albums[$l]);
                }
            }
                
        }
        return $albums_temp;
    }


    function getById($id)
    {
        $str = file_get_contents('assets/json/albums.json');
        $json = json_decode($str, true);
        $sources = [];

        foreach ($json as $key => $value) 
        {
            foreach($value as $k=>$v)
            {
                if($k=="id" && $v==$id)
                {
                    foreach($value['photos']['data'] as $kk=>$vv)
                    {
                        foreach($vv as $kkk=>$vvv)
                        {
                            foreach($vvv as $kkkk=>$vvvv)
                            {
                                foreach($vvvv as $kkkkk=>$source)
                                {
                                    array_push($sources,$source);
                                }
                                break; 
                            }
                            break;
                        }   
                    }
                }
            }
        }

    return $sources;

    }

    function getAllPhotos()
    {
        $str = file_get_contents('assets/json/albums.json');
        $json = json_decode($str, true);

        $albums = [];
        $count = [];
        $sources = [];

        foreach($json as $key=>$value)
        {
            foreach ($value as $k => $v) 
            {
                if($k=="name")
                {
                    $temp[$k]=$v;
                    array_push($albums,$temp);
                }
                if($k=="count" && $v=="0")
                {
                    array_pop($albums);
                }
                if($k=="count" && $v>0)
                {     
                    array_push($count,$v);                  
                }

                if(is_array($v))
                foreach($v as $kk=>$vv)
                {
                    if(is_array($vv))
                    foreach($vv as $kkk=>$vvv)
                    {
                        if(is_array($vvv))
                        foreach($vvv as $kkkk=>$vvvv)
                        {
                            if(is_array($vvvv))
                            foreach($vvvv as $kkkkk=>$vvvvv)
                            {
                                foreach($vvvvv as $kkkkkk=>$source)
                                {
                                    
                                    array_push($sources,$source);
                                
                                }
                                break;
                            }
                            break;  
                        }
                    }
                    
                }
            }
        }
        
        $sources = array_reverse($sources);
        $j=0;
        foreach($count as $k=>$v)
        {
            $s = [];
            for($i=0;$i<$v;$i++)
            {
                $temp = array_pop($sources);
                array_push($s,$temp);
            }
            array_push($albums[$j],$s);
            $j++;
        }

        return $albums;
    }

    public function getNameByID($album_id)
    {
        $str = file_get_contents('assets/json/albums.json');
        $json = json_decode($str, true);

        $name = '';

        foreach($json as $key=>$value)
        {
            if($value['id']==$album_id)
            {
                $name = $value['name'];
            }
        }

        return $name;
    }

}

?>