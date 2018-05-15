<?php
session_start();

try {
  $database = new PDO('mysql:host=pnwd.myd.infomaniak.com;dbname=pnwd_classe2b', 'pnwd_tanguyCvgn', 'GmanG1pomCTdelicieu!');
} catch (PDOException $e) {
  echo "échec de la connexion : ". $e->getMessage();
}
$getMessages = $database->prepare('SELECT * FROM messages');
$getMessages->execute();
if(!isset($_SESSION['nbrow_old'])){
    $_SESSION['nbrow_old'] = $getMessages->rowCount();
    $_SESSION['nbrow_now'] = $getMessages->rowCount();
    
}
if (isset($_POST['sendmessage'])) {
  if(!empty($_POST['message'])){
    $messageChat = FILTER_INPUT(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $date = date("Y-m-d H:i:s");
    $insertmessage = $database->prepare('INSERT INTO messages(message,owner, date) VALUES(?,?,?)');
    $insertmessage->execute(array($messageChat, $_SESSION['userinfo']['id'], $date));
  }
  else{
    $message = "veuillez entrer qqch";
  }
}
?>
    <!DOCTYPE html>
    <!--
 * A Design by GraphBerry
 * Author: GraphBerry
 * Author URL: http://graphberry.com
 * License: http://graphberry.com/pages/license
-->
    <html lang="en">

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
        <link rel="stylesheet" href="css/mycss.css">
        <script>
            window.onresize = function() {
                fullScreen();
            };

            function hideChat() {
                document.getElementById("button-close").style.display = "none";
                document.getElementById("chat").style.display = "none";
                document.getElementById("button-open").style.display = "block";
            }

            function showChat() {
                document.getElementById("button-close").style.display = "block";
                document.getElementById("chat").style.display = "block";
                document.getElementById("button-open").style.display = "none";
            }
            
            setInterval(load_messages, 300);

            function load_messages() {
                $('#chatspace').load('refresh_chat.php');
            }
            
            function scrollBottom() {
                var objDiv = document.getElementById("chatspace");
                objDiv.scrollTop = objDiv.scrollHeight;
            }
            
            function overflowHidden() {
                corps.style.overflowY = "hidden";
                //console.log("in");
            }
            
            function overflowScroll() {
                corps.style.overflowY = "auto";
            }
        </script>
        <style>
            .navbar {
                position: sticky!important;
                top: 0 !important;
                z-index: 1000;
            }

            #chat {
                position: fixed;
                width: 500px;
                height: 450px;
                z-index: 200;
                background-color: #858585;
                float: left;
                bottom: 0px;
            }
            
            #chat-btn {
                padding: 2%;
                width: 25%;
            }

            #chat-btn,
            #button-close,
            #button-open {
                display: inline !important;
                background-color: #4CAF50 !important;
                color: white !important;
                border: 2px solid #4CAF50 !important;
                transition-duration: 0.4s;
            }

            #chat-btn:hover,
            #button-close:hover,
            #button-open:hover {
                background-color: white !important;
                color: black !important;
            }

            #button-open {
                z-index: 10;
                position: fixed !important;
                cursor: pointer;
                width: 10%;
                text-align: center;
                padding: 2px;
                bottom: 0px;
            }

            #button-close {
                float: left;
                cursor: pointer;
                width: 7%;
                padding: 2px;
                height: 34px;
                bottom: -10px;
            }
            
            corps {
                overflow-x: hidden;
            }

        </style>
    </head>

    <body onload="scrollBottom()" id="corps">
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
                            <li class="active"><a href="#home">Accueil</a></li>
                            <li><a href="#service">Services</a></li>
                            <li><a href="#portfolio">Portfolio</a></li>
                            <li><a href="#about">A propos</a></li>
                            <li><a href="#contact">Contact</a></li>

                            <?php if(isset($_SESSION['userinfo']['pseudo'])) { ?>
                            <li><a href="./stockage.php">Stockage</a></li>
                            <li><a href="./deconnexion.php">Déconnexion</a></li>
                            <li>
                                <a href="./profil.php">
                                    <?php echo $_SESSION['userinfo']['pseudo']; ?>
                                </a>
                            </li>
                            <?php } else { ?>
                            <li><a href="./inscription.php">Inscription</a></li>
                            <li><a href="./connexion.php">Connexion</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <!-- End main navigation -->
                </div>
            </div>
        </div>
        <!-- End navbar section  -->

        <button class="message-btn" id="button-open" onclick="showChat()">Open chat ↑</button>

        <div class="box">
            <div id="chat" onmouseover="overflowHidden()" onmouseleave="overflowScroll()">
                <div id="chatspace" style="height: 85%; overflow-y: scroll; margin-bottom: 2.5%; display: block; word-wrap: break-word;">
                    <ul style="list-style-type: none;">
                        <?php 
                    while ($a = $getMessages->fetch()) {
                        $_SESSION['nbrow_now'] = $getMessages->rowCount();
                        if($_SESSION['nbrow_now']!=$_SESSION['nbrow_old']){
                            $_SESSION['nbrow_old'] = $_SESSION['nbrow_now'];
                            echo "<script>scrollBottom();</script>";
                        }
                        $getOwner = $database->prepare("SELECT * from membres WHERE id_user=".$a['owner']);
                        $getOwner->execute();
                        $resultatOwner = $getOwner->fetch();

                        $ancienMessage = $database->prepare('SELECT * FROM messages WHERE id = ' . (intval($a['id']) - 1));
                        $ancienMessage->execute();
                        $ancienValue = $ancienMessage->fetch();

                        if($_SESSION['userinfo']['pseudo']==$resultatOwner['pseudo_user']) { 
                        ?>
                        <li style="color: blue; margin-bottom: 1.5%;">
                            <span style="color: white;">
                            <?php if($a['owner'] != $ancienValue['owner']) { echo $resultatOwner['pseudo_user'] . ': </br>'; } ?>
                            </span>
                            <?=$a['message']?>
                                <?php } else{ ?>
                                <li style="color: black; margin-bottom: 1.5%;">
                                    <span style="color: white;"><?php if($a['owner'] != $ancienValue['owner']) { echo $resultatOwner['pseudo_user'] . ': </br>'; } ?></span>
                                    <?=$a['message']?>
                                        <?php } ?>
                                </li>
                                <?php } ?>
                    </ul>
                </div>
				<?php if(isset($_SESSION['userinfo']['pseudo'])) { ?>
                <form method="POST" style="width: 90%; float: left; margin: 0; margin-right: 0 !important; height: 60px;">
                    <input style="width: 300px; margin: 0; margin-left: 3%; margin-bottom: 5px;" type="text" name="message" placeholder="message">
                    <button style="margin-bottom: 5px;" id="chat-btn" class="message-btn" type="submit" name="sendmessage">Envoyer</button>
                </form>
				<?php } else { ?>
				<span>Veuillez vous connecter.</span>
				<?php } ?>

                <button style="margin-top: 0.5%;" id="button-close" class="message-btn" onclick="hideChat()">\/</button>

                <?php if(isset($message)){echo "<p style='color:red'>".$message."</p>"; } ?>
            </div>
        </div>

        <!-- Start home section -->
        <div id="home">
            <!-- Start cSlider -->
            <div id="da-slider" class="da-slider">
                <div class="triangle"></div>
                <!-- mask elemet use for masking background image -->
                <div class="mask"></div>
                <!-- All slides centred in container element -->
                <div class="container">
                    <!-- Start first slide -->
                    <div class="da-slide">
                        <h2 class="fittext2">Bienvenue sur le site de la IDA/FA-P2B</h2>
                        <h4>Développement</h4>
                        <p>Nous sommes une classe de 2ème année de l'école d'informatique du CFPT. Chacun d'entre nous crée des projets que vous pourrez retrouvez ici. Notre domaine de prédiliction est le software, et le développement d'applications.</p>
                        <div class="da-img">
                            <img src="images/tools-icon.png" alt="tools-icon" width="320">
                        </div>
                    </div>
                    <!-- End first slide -->
                    <!-- Start second slide -->
                    <div class="da-slide">
                        <h2>Une classe unie</h2>
                        <h4>Esprit d'équipe</h4>
                        <p>Nous travaillons ensemble depuis plus d'un an et demi. Nous sommes donc aptes a diviser des taches complexes, et de rendre le travail plus facile pour chacun d'entre nous.</p>
                        <div class="da-img">
                            <img src="images/stockage.png" width="320" alt="stockage">
                        </div>
                    </div>
                    <!-- End second slide -->
                    <!-- Start cSlide navigation arrows -->
                    <div class="da-arrows">
                        <span class="da-arrows-prev"></span>
                        <span class="da-arrows-next"></span>
                    </div>
                    <!-- End cSlide navigation arrows -->
                </div>
            </div>
        </div>
        <!-- End home section -->

        <!-- Start services section -->
        <div class="section primary-section" id="service">
            <div class="container">
                <!-- Start title section -->
                <div class="title">
                    <h1>Que faisons nous ?</h1>
                    <!-- Section's title goes here -->
                    <p>Nous sommes étudiants en informatique en deuxième année. Nous étudions 3 domaines différents.</p>
                    <!--Simple description for section goes here. -->
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="centered service">
                            <div class="circle-border zoom-in">
                                <img class="img-circle" src="images/csharp.png" alt="C#">
                            </div>
                            <h3>C#</h3>
                            <p>Programmation orientée objet et developpement d'application.</p>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="centered service">
                            <div class="circle-border zoom-in">
                                <img class="img-circle" src="images/website-icon.png" alt="WEB" />
                            </div>
                            <h3>WEB (HTML5/CSS3/JAVASCRIPT/PHP)</h3>
                            <p>Création de site web avec/sans base de donnée.</p>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="centered service">
                            <div class="circle-border zoom-in">
                                <img class="img-circle" src="images/mysql-logo.png" alt="SQL" />
                            </div>
                            <h3>MYSQL</h3>
                            <p>Création et gestion de base de donnée.</p>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="centered service">
                            <div class="circle-border zoom-in">
                                <img class="img-circle" src="./images/web.png" alt="SQL" />
                            </div>
                            <h3>MYSQL</h3>
                            <p>Création et gestion de base de donnée.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End services section -->

        <!-- Start portfolio section -->
        <div class="section secondary-section " id="portfolio">
            <div class="triangle"></div>
            <div class="container">
                <div class=" title">
                    <h1>Projets effectués</h1>
                    <p>Voila tout nos projets fini ou pas. Pour jouer, cliquer sur jouer</p>
                </div>

                <ul id="portfolio-grid" class="thumbnails row">
                    <?php foreach(scandir('files/') as $file) { if($file != "." && $file != "..") { ?>
                    <li class="span4 mix photo">
                        <div class="thumbnail">
                            <img src="<?php echo './files/' . $file . '/logo/imgRep.jpg'; ?>" alt="project 2">
                            <h3>
                                <?php echo $file; ?>
                            </h3>
                            <p><a class="lien" href="<?php echo './files/' . $file; ?>">jouer</a></p>
                            <div class="mask"></div>
                        </div>
                    </li>
                    <?php } } ?>
                </ul>
            </div>
        </div>
        <!-- End portfolio section -->

        <!-- Start about us section -->
        <div class="section primary-section" id="about">
            <div class="triangle"></div>
            <div class="container">
                <div class="title">
                    <h1>Qui sommes nous?</h1>
                    <p>Nous sommes des élèves de deuxième années à l'école d'informatique du Petit-Lancy aka le CFPT.</p>
                </div>
                <div class="row-fluid team">
                    <div class="span4" id="first-person">
                        <div class="thumbnail">
                            <img src="images/Team1.png" alt="team 1">
                            <h3>Tanguy Cavagna</h3>
                            <ul class="social">
                                <li>
                                    <a href="">
                                        <span class="icon-facebook-circled"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <span class="icon-twitter-circled"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <span class="icon-linkedin-circled"></span>
                                    </a>
                                </li>
                            </ul>
                            <div class="mask">
                                <h2>Programmeur</h2>
                                <p>Le programmation c'est la vie.</p>
                            </div>
                        </div>
                    </div>
                    <div class="span4" id="second-person">
                        <div class="thumbnail">
                            <img src="images/Team2.png" alt="team 1">
                            <h3>John Doe</h3>
                            <ul class="social">
                                <li>
                                    <a href="">
                                        <span class="icon-facebook-circled"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <span class="icon-twitter-circled"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <span class="icon-linkedin-circled"></span>
                                    </a>
                                </li>
                            </ul>
                            <div class="mask">
                                <h2>Designer</h2>
                                <p>When you stop expecting people to be perfect, you can like them for who they are.</p>
                            </div>
                        </div>
                    </div>
                    <div class="span4" id="third-person">
                        <div class="thumbnail">
                            <img src="images/Team3.png" alt="team 1">
                            <h3>John Doe</h3>
                            <ul class="social">
                                <li>
                                    <a href="">
                                        <span class="icon-facebook-circled"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <span class="icon-twitter-circled"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <span class="icon-linkedin-circled"></span>
                                    </a>
                                </li>
                            </ul>
                            <div class="mask">
                                <h2>Photographer</h2>
                                <p>When you stop expecting people to be perfect, you can like them for who they are.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="about-text centered">
                    <h3>A propos de nous</h3>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>
                </div>
                <h3>Compétences</h3>
                <div class="row-fluid">
                    <div class="span6">
                        <ul class="skills">
                            <li>
                                <span class="bar" data-width="50%"></span>
                                <h3>Graphique design</h3>
                            </li>
                            <li>
                                <span class="bar" data-width="95%"></span>
                                <h3>Html / Css / Php</h3>
                            </li>
                            <li>
                                <span class="bar" data-width="68%"></span>
                                <h3>jQuery</h3>
                            </li>
                            <li>
                                <span class="bar" data-width="60%"></span>
                                <h3>Wordpress</h3>
                            </li>
                        </ul>
                    </div>
                    <div class="span6">
                        <div class="highlighted-box center">
                            <h1>Je sais pas quoi mettre là</h1>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, ullamcorper suscipit lobortis nisl ut aliquip consequat. I learned that we can do anything, but we can't do everything...</p>
                            <button class="button button-sp">Join Us</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End about us section -->

        <!-- Start contact section -->
        <div id="contact" class="contact">
            <div class="section secondary-section">
                <div class="container">
                    <div class="title">
                        <h1>Contact Us</h1>
                        <p>Duis mollis placerat quam, eget laoreet tellus tempor eu. Quisque dapibus in purus in dignissim.</p>
                    </div>
                </div>
                <div class="map-wrapper">
                    <div class="map-canvas" id="map-canvas">Loading map...</div>
                    <div class="container">
                        <div class="row-fluid">
                            <div class="span5 contact-form centered">
                                <h3>Say Hello</h3>
                                <div id="successSend" class="alert alert-success invisible">
                                    <strong>Well done!</strong>Your message has been sent.</div>
                                <div id="errorSend" class="alert alert-error invisible">There was an error.</div>
                                <form id="contact-form" action="php/mail.php">
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="span12" type="text" id="name" name="name" placeholder="* Your name..." />
                                            <div class="error left-align" id="err-name">Please enter name.</div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="span12" type="email" name="email" id="email" placeholder="* Your email..." />
                                            <div class="error left-align" id="err-email">Please enter valid email adress.</div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <textarea class="span12" name="comment" id="comment" placeholder="* Comments..."></textarea>
                                            <div class="error left-align" id="err-comment">Please enter your comment.</div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <button id="send-mail" class="message-btn">Send message</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="span9 center contact-info">
                        <p>CFP Technique, Chemin Gérard-de-Ternier 10, Case postale 548, 1213 Petit-Lancy</p>
                        <p class="info-mail">webmaster@classe2b.eyx.ch</p>
                        <p>Tèl. 022 388 87 28</p>
                        <p>Fax. 022 388 87 65</p>
                        <div class="title">
                            <h3>We Are Social</h3>
                        </div>
                    </div>
                    <div class="row-fluid centered">
                        <ul class="social">
                            <li>
                                <a href="">
                                    <span class="icon-facebook-circled"></span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <span class="icon-twitter-circled"></span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <span class="icon-linkedin-circled"></span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <span class="icon-pinterest-circled"></span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <span class="icon-dribbble-circled"></span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <span class="icon-gplus-circled"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End contact section -->

        <!-- Start footer section -->
        <div class="footer">
            <p>&copy; 2013 Theme by <a href="http://www.graphberry.com">GraphBerry</a>, <a href="http://goo.gl/NM84K2">Documentation</a></p>
        </div>
        <!-- End footer section -->

        <!-- Start scrollUp button -->
        <div class="scrollup">
            <a href="#">
                <i class="icon-up-open"></i>
            </a>
        </div>
        <!-- End scrollUp button -->

        <!-- Include javascript -->
        <script src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery.mixitup.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/modernizr.custom.js"></script>
        <script type="text/javascript" src="js/jquery.bxslider.js"></script>
        <script type="text/javascript" src="js/jquery.cslider.js"></script>
        <script type="text/javascript" src="js/jquery.placeholder.js"></script>
        <script type="text/javascript" src="js/jquery.inview.js"></script>

        <!-- Load google maps api and call initializeMap function defined in app.js -->
        <script async="" defer="" type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArzQSyceDAZzjX5qRvMOvfH0j5Yr59J-o&sensor=false&callback=initializeMap"></script>
        <!-- css3-mediaqueries.js for IE8 or older -->
        <!--[if lt IE 9]>
            <script src="js/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript" src="js/app.js"></script>
    </body>

    </html>
