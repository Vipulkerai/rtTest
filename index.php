<?php 

    ini_set('display_errors', 1);
    require_once 'FB.php';
    require_once 'GoogleDrive.php';
    
    if(!(isset($_SESSION['email'])))
    {
        header('Location: login.php');
    }


    $fb = FB::getInstance();
    $drive = new GoogleDrive();

    if(isset($_GET['selectedMove']))
    {
        $data = json_decode($_GET['selectedMove']);
        $drive->login();
        $photos = $fb->getPhotosByIds($data);
        $drive->move($photos);
    }
    elseif (isset($_GET['MoveAll']))
    {
        $drive->login();
        $photos = $fb->getAllPhotos();
        $drive->move($photos);
    }
    elseif (isset($_GET['MoveById'])) 
    {
        $drive->login();
        $name = $fb->getNameByID($_GET['MoveById']);
        $photos = $fb->getPhotosById($_GET['MoveById']);
        $drive->moveById($photos,$name);
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RT_Demo</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    
</head>
<body>

<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="prev" onclick="plusIndex(-1)" id="prev"><i class="fa fa-angle-left"></i></div>
    <div class="closebtn" id="close">&times;</div>
    <div class="slideshow-container">
        <div class="row">
            <div class="col-sm-6 col-md-4" id="slideshow-container">

            </div>
        </div>
    </div>
    <div class="next" onclick="plusIndex(1)" id="next"><i class="fa fa-angle-right"></i></div>
  </div>
  
  
</div>
    <header>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="logo">
                        <a class="white-text" href="index.php">Facebook</a>
                    </div>
                </div>
                <div class="col text-right">
                    <div class="logout-btn">
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="menu-bar">
                        <div class="menu">
                            <a href="#" onclick="refresh()">Refresh</a>
                            <a href="#" onclick="selectedDownload()">Download Selected</a>
                            <a href="#" onclick="downloadAll()">Download All</a>
                            <a href="#" onclick="moveSelected()">Move Selected</a>
                            <a href="https://vipulkerai.xyz/index.php?MoveAll=MoveAll">Move All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
        <div id="link"></div>
        <div id="mess"></div>
        </div>
        
        <div id="loader">
            <div class="container">
            <div class="row">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
            </div>
            </div>
        </div>

        <div id="zip-loader">
            <div class="container">
            <div class="row">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
            </div>
            </div>
        </div>

        <div id="message-container">
            <div class="container">
            <div class="row">
            <span class="message-style">Sorry !There are No Albums</span>
            </div>
            </div>
        </div>
        
        <div class="albums">
            <div class="container">
                <div class="row" id="albums">
                
                </div>
            </div>
        </div> 
    </div>

    <div class="container">
        <footer>
        &copy;2018 | Vipul Kerai
        </footer>
    </div>
    
    
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/View_Controller.js"></script>
</body>
</html>


