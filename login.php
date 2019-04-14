<?php
    
    require_once 'FB.php';

    if(isset($_SESSION["email"]))
    {
        header('Location: index.php');
    }

    $fb = FB::getInstance();
    $login_URL = $fb->login();
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RT_task</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="logo">
                        <a class="white-text" href="index.php">Facebook</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <div class="container">
        <div class="row d-flex justify-content-between align-items-stretch pt-5">

            <div style="" class="col-sm-6 col-md-6">
                <div class="main">
                    <h1 class="title">Welcome to <span class="welcome_title">Facebook</span></h1>
                    <p class="sub-title" >Download your all facebook album photos in one .zip file</p> 
                    <p class="sub-title" >Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem dolores numquam expedita consequatur quasi ullam aliquam eligendi incidunt sunt. Facere doloremque similique, incidunt recusandae alias id commodi eaque aperiam nemo?</p>
                    <p class="sub-title" >Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem dolores numquam expedita consequatur quasi ullam aliquam eligendi incidunt sunt. Facere doloremque similique, incidunt recusandae alias id commodi eaque aperiam nemo?</p>
                    <div class="login-btn">
                        <a href="<?php echo $login_URL?>" target="_self">Login with facebook</a>
                    </div>
                </div>
            </div>
            <div style="" class="col-sm-6 col-md-6">
                <div class="main main_two">
                    <p class="sub-title" >Lorem ipsum dolor sit amet consectetur adipisicing elit Dolorem dolores.</p> 
                    <p class="sub-title" >Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem dolores numquam expedita consequatur quasi ullam aliquam eligendi incidunt sunt. Facere doloremque similique, incidunt recusandae alias id commodi eaque aperiam nemo?</p>
                    <p class="sub-title" >Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem dolores numquam expedita consequatur quasi ullam aliquam eligendi incidunt sunt. Facere doloremque similique, incidunt recusandae alias id commodi eaque aperiam nemo?</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

