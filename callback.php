<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

    require_once 'FB.php';

    $fb = FB::getInstance();
    
    $accessToken = $fb->getAccessToken();

    if(!$accessToken)
    {
        header('Location: login.php');
    }
    
    $_SESSION['accessToken'] = $accessToken;
    
    $_SESSION['email'] = $fb->getEmail();

    header('Location: index.php');
?>