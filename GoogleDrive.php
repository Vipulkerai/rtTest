<?php

require_once 'vendor/autoload.php';

ini_set('max_execution_time', 300);

class GooglDrive 
{
    private $service;
    private $client;

    function login()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig('client_secret.json');
        $this->client->addScope("https://www.googleapis.com/auth/drive.file");

        if (isset($_SESSION['access_token']) && $_SESSION['access_token'])
        {
            $this->client->setAccessToken($_SESSION['access_token']);
            $this->service = new Google_Service_Drive($this->client);
        } 
        else 
        {
            $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }

    }

    function move($photos)
    {
        $foldername = 'facebook_'.$_SESSION['email'].'_albums';
        $fileMetadata = new Google_Service_Drive_DriveFile(array(
            'name' => $foldername,
            'mimeType' => 'application/vnd.google-apps.folder'));

        $file = $this->service->files->create($fileMetadata, array(
            'fields' => 'id'));

        $folderId = $file->id;
        $temp = "";
        foreach($photos as $key=>$value)
        {
            foreach($value as $k=>$v)
            {   
                $i=0;
                if(is_array($v))
                {
                    foreach ($v as $ke=>$source)
                    {
                        $fileData = new Google_Service_Drive_DriveFile(array(
                            'name' => $i.'jpg',
                            'parents' => array($temp)
                        ));
                        $content = file_get_contents($source);
                        $file = $this->service->files->create($fileData, array(
                            'data' => $content,
                            'mimeType' => 'image/jpeg',
                            'uploadType' => 'multipart',
                            'fields' => 'id'));
                        $i++;
                    } 
                        
                }
                else
                {
                    $fileMetaData = new Google_Service_Drive_DriveFile(array(
                        'name' => $v,
                        'parents' => array($folderId),
                        'mimeType' => 'application/vnd.google-apps.folder'));
                    
                    $subFolderFile = $this->service->files->create($fileMetaData, array(
                        'fields' => 'id'));
                    
                    $temp = $subFolderFile->id;
                }
            }     
        
        }

        return $folderId;
        
    }

    public function moveById($photos,$name)
    {
        $foldername = 'facebook_'.$_SESSION['email'].'_albums';
        $fileMetadata = new Google_Service_Drive_DriveFile(array(
            'name' => $foldername,
            'mimeType' => 'application/vnd.google-apps.folder'));

        $file = $this->service->files->create($fileMetadata, array(
            'fields' => 'id'));

        $folderId = $file->id;

        $fileMetaData = new Google_Service_Drive_DriveFile(array(
            'name' => $name,
            'parents' => array($folderId),
            'mimeType' => 'application/vnd.google-apps.folder'));
        
        $subFolderFile = $this->service->files->create($fileMetaData, array(
            'fields' => 'id'));

        $i=0;
        foreach($photos as $key=>$value)
        {
            $fileData = new Google_Service_Drive_DriveFile(array(
                'name' => $i.'jpg',
                'parents' => array($subFolderFile->id)
            ));
            $content = file_get_contents($value);
            $file = $this->service->files->create($fileData, array(
                'data' => $content,
                'mimeType' => 'image/jpeg',
                'uploadType' => 'multipart',
                'fields' => 'id'));
            $i++;
        }

    }

}

?>