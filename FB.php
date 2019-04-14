<?php

require_once "vendor/autoload.php";
require_once "JSONhandler.php";

session_start();

class FB
{
    private $FB;
    private $helper;
    private static $instance;
    private $accessToken;
 
    private function __construct()
    {
        $this->FB = new \Facebook\Facebook([
        'app_id' => '2220856681523974',
        'app_secret' => '6e478af13e253ed60f10e118af59a289',
        'default_graph_version' => 'v3.1']);

        $this->helper = $this->FB->getRedirectLoginHelper();
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new FB();
        }
        return self::$instance;
    }
    
    //create login url for facebook login
    function login()
    {
        $callback_URL = "https://vipulkerai.xyz/callback.php";
        $permissions = ['email','user_photos','user_likes'];
        $login_URL = $this->helper->getLoginUrl($callback_URL,$permissions);
        
        return $login_URL;
    }

    function getEmail()
    {
        $response = $this->FB->get("me?fields=email",$_SESSION['accessToken']);
        $response =  $response->getGraphNode()->asArray();
        return $response['email'];
    }

    //get accessToken from facebook
    function getAccessToken()
    {
        try
        {
            $accessToken = $this->helper->getAccessToken();

            if(!$accessToken->isLongLived())
            {
                $oAuth2Client = $this->FB->getOAuth2Client();
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
                
            }
        
            return $accessToken;
        }
        catch(\Facebook\Exception\FacebookSDKException $e)
        {
            echo "Exception : " . $e-getMessage();
        }
    }

    //get albums from facebook
    function getAlbums()
    {
        $albums = [];
        $url = "https://graph.facebook.com/v3.1/me?fields=albums%7Bid%2Cname%2Ccount%2Cphotos%7Bimages%7Bsource%7D%7D%7D&access_token=".$_SESSION['accessToken'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $results = curl_exec($ch);
        
        $resultArray = json_decode($results, true);
    
        for ($i=0;$i<count($resultArray['albums']['data']);$i++) 
        {
            array_push($albums,$resultArray['albums']['data'][$i]);
        }

        if (array_key_exists('next',$resultArray['albums']['paging'])) 
        {
            $this->getAlbumsNext($albums,$resultArray['albums']['paging']['next']);
        }

        $json = new JSONhandler();
        $json->saveAlbumIntoJSON($albums);  
        
        return $json->getAlbums();
        
        
    }

    //get next album page from facebook
    private function getAlbumsNext(&$albums,$albumsNextLink)
	{
        $url=$albumsNextLink;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $results = curl_exec($ch);
        
        $resultArray = json_decode($results, true);
      
        for ($i=0;$i<count($resultArray['data']);$i++) 
        {
            array_push($albums, $resultArray['data'][$i]);
        }
       
        if (array_key_exists('next',$resultArray['paging'])) 
        {
            $this->getAlbumsNext($albums,$resultArray['paging']['next']);
        }


    }

    //get next photos page from facebook
    public function getNextPhotos()
    {
        $j = new JSONhandler();
        $json = $j->getAllData();

        $i=-1;
        $images = [] ;
        foreach($json as $key=>$value)
        {
            $i++;

            if(array_key_exists('photos',$value) && array_key_exists('next',$value['photos']['paging']))
            {
                $this->getNextImages($images,$value['photos']['paging']['next']);

                unset($json[$i]['photos']['paging']['next']);

                foreach($images as $ke=>$val)
                {
                    array_push($json[$i]['photos']['data'],$val);
                }
            }
                
        }

        $j->saveAlbumIntoJSON($json);
    }

    //get next photos page helper
    private function getNextImages(&$images,$link)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $results = curl_exec($ch);
            
        $resultArray = json_decode($results, true);
        
        for ($i=0;$i<count($resultArray['data']);$i++) 
        {
            array_push($images,$resultArray['data'][$i]);
        }
        
        if (array_key_exists('next',$resultArray['paging'])) 
        {
            $this->getNextImages($images,$resultArray['paging']['next']);
        }
    }

    //get photo by album_ids from JSON file
    public function getPhotosByIds($album_id)
    {
        $json = new JSONhandler();
        
        return $json->getByIDs($album_id);   
        
    }

    //get all photos from JSON file
    public function getAllPhotos()
    {
        $json = new JSONhandler();
        return $json->getAllPhotos();
    }

    //get photo by album_id from JSON file
    public function getPhotosById($album_id)
    {
        $json = new JSONhandler();
        
        return $json->getByID($album_id);   
        
    }
    
    //get name of album by id
    public function getNameByID($id)
    {
        $json = new JSONhandler();
        
        return $json->getNameByID($id); 
    }
    
}


?>