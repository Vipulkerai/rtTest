<?php

require_once 'FB.php';
require_once 'Download.php';
require_once 'GoogleDrive.php';

if(!(isset($_SESSION["email"])))
{
    header('Location: login.php');
}

$fb = FB::getInstance();
$download = new Download();


if(isset($_GET['albumbId']))
{
    $photos = $fb->getPhotosById($_GET['albumbId']);
    $data['photos'] = $photos;
    echo json_encode($data);
}
elseif (isset($_GET['albums'])) 
{
    $albums = $fb->getAlbums();
    $data = $albums;
    echo json_encode($data);
}
elseif(isset($_GET['downloadById']))
{
    $name = $fb->getNameByID($_GET['downloadById']);
    $photos = $fb->getPhotosById($_GET['downloadById']);

    $data = $download->downloadById($photos,$name);
    $zip_name = $data;
    if(!(empty($data)))
    {
        rename($data,"download/".$data);
    }
    
    echo $zip_name;
    
}
elseif(isset($_GET['downloadAll']))
{
    $photos = $fb->getAllPhotos();

    $data = $download->downloadAll($photos);

    $zip_name = $data;

    if(!(empty($data)))
    {
        rename($data,"download/".$data);
    }

    echo $zip_name;

}
elseif(isset($_GET['selectedDownload']))
{ 
    $photos = $fb->getPhotosByIds($_GET['selectedDownload']);
    $data = $download->downloadSelected($photos);

    $zip_name = $data;

    if(!(empty($data)))
    {
        rename($data,"download/".$data);
    }

    echo $zip_name;
}
elseif (isset($_GET['downloadZip'])) 
{
   echo "download/".$_GET['downloadZip'];
}
elseif(isset($_GET['selectedMove']))
{
    $drive = new GooglDrive();
    $drive->login();
    $photos = $fb->getPhotosByIds($_GET['selectedMove']);
    $drive->move($photos);
}
elseif (isset($_GET['MoveAll']))
{
    $drive = new GooglDrive();
    $drive->login();
    $photos = $fb->getAllPhotos();
    $drive->move($photos);
}
elseif (isset($_GET['MoveById'])) 
{
    $drive = new GooglDrive();
    $drive->login();
    $name = $fb->getNameByID($_GET['MoveById']);
    $photos = $fb->getPhotosById($_GET['MoveById']);
    $drive->moveById($photos,$name);
}
elseif(isset($_GET['nextPhotos']))
{
    $fb->getNextPhotos();
}

?>