<?php
session_start();

if(isset($_POST['upload'])) {
    $file_name = $_FILES['project']['name'];
    $file_tmp_name = $_FILES['project']['tmp_name'];
    $zip = new ZipArchive();
    
    if (isset($file_name)) {
        if (!empty($file_name)) {
            $location = 'files/';
            
            if (move_uploaded_file($file_tmp_name, $location . $file_name)) {
                echo "Uploaded !";
                
                if ($zip->open($location . $file_name) === true) {
                    $zip->extractTo($location);
                    $zip->close();
                    
                    echo "ok";
                }
                else {
                    echo "unzip fail";
                }
                
                unlink($location . $file_name);
            }
        }
        else {
            echo "Choose a file";
        }
    }
}
?>
 <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset=utf-8>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Page d'acceuil de la IDA/FA-P2B</title>
        <!-- Load Roboto font -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <!-- Load css styles -->
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/pluton.css" />
        <!--[if IE 7]>
            <link rel="stylesheet" type="text/css" href="css/pluton-ie7.css" />
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="css/jquery.cslider.css" />
        <link rel="stylesheet" type="text/css" href="css/jquery.bxslider.css" />
        <link rel="stylesheet" type="text/css" href="css/animate.css" />
        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72.png">
        <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57.png">
        <link rel="shortcut icon" href="images/ico/favicon.ico">
    </head>

    <style>
        * {
            margin: auto;
            padding: 0;
        }

        form {
            text-align: center;
        }
        
        body {
            background-color: #FECE1A;
        }
        
        #inscription {
            margin-top: 10%;
        }
        
        #inscription-btn {
            margin-top: 1%;
        }

    </style>

    <body>
        <!-- Start navbar section  -->
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <a href="#" class="brand">
                        <img src="images/logo.png" width="120" height="40" alt="Logo" />
                    
                        <!-- This is website logo -->
                    </a>
                    <!-- Navigation button, visible on small resolution -->
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <i class="icon-menu"></i>
                    </button>
                    <!-- Main navigation -->
                    <div class="nav-collapse collapse pull-right">
                        <ul class="nav" id="top-navigation">
                            <li class="active"><a href="./index.php#home">Accueil</a></li>
                            <li><a href="./index.php#service">Services</a></li>
                            <li><a href="./index.php#portfolio">Portfolio</a></li>
                            <li><a href="./index.php#about">A propos</a></li>
                            <li><a href="./index.php#contact">Contact</a></li>
                            <li><a href="./connexion.php">Connexion</a></li>
                        </ul>
                    </div>
                    <!-- End main navigation -->
                </div>
            </div>
        </div>
        <!-- End navbar section  -->


        <!-- Start stock section -->
        <div id="stockage" class="contact">
            <div class="section secondary-section">
                <div class="container">
                    <div class="title">
                        <h1>Met un fichier a disposition de tous !</h1>
                    </div>
                </div>
				<form method="post" enctype="multipart/form-data" id="contact-form">
					<div class="control-group">
                        <div class="controls">
        					<input type="file" name="project" id="project">
						</div>
                    </div>
					<div class="control-group">
                        <div class="controls">
							<button id="upload-btn" class="message-btn" type="submit" id="updload" name="upload">Mettre a disposition</button>
						</div>
                    </div>
    			</form>
            </div>
        </div>
    </body>

    </html>