<?php

session_start();

if(!isset($_SESSION["session_login"])){
        header("location: login.php");
        exit;
}


require 'vendor/autoload.php';  
require 'functions.php';

  $con = new MongoDB\Client("mongodb://localhost:27017");  

  $db = $con->news;  
  
  $pub = $db->avis;
  $collection = $db->utilisateur;

  //date_default_timezone_set('UTC');
  //$date = date('l jS \of F Y h:i:s A');

  setlocale(LC_TIME, "fr_FR");
  $date1=date("H:i:s");
  $date = strftime("%A, %d %B %G, ").$date1;



if (isset($_REQUEST['titre'],  $_REQUEST['sujet'] )){

    $titre = $_REQUEST['titre'];
    $sujet = $_REQUEST['sujet'];
    $login = $_SESSION["session_login"];

    $cursor = $collection->findOne(array('login' => $login));
    $nom=$cursor['nom'];
    $prenom=$cursor['prenom'];
    $url="url.php?titre2=".$titre;

    $coms = $db->avis->find();
    $flags = false;

    foreach( $coms as $c){
      if($c['titre']==$titre){
          $flags=true;
          //exit();
      } 
    }

    if($flags==0){
        stockerNews($nom,$prenom,$login,$titre,$sujet,$date,$url);
        header("Location: publications.php");
    }
    else $message =  "Ce titre existe déja";
}

?>


 <!DOCTYPE html>
 
 <head>
      <meta charset="utf-8">
        <link rel="stylesheet" href="style1.css" media="screen" type="text/css" />
          <title>Publier news</title>
          <link rel="shortcut icon" type="image/png" href="logo1.png">
          <meta content="width=device-width, initial-scale=1.0" name="viewport">
          <meta content="" name="keywords">
          <meta content="" name="description">
          <link href="css/style.css" rel="stylesheet">
          <link href="favicon.ico" rel="shortcut icon">
          <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">
          <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
          <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
          <link href="lib/animate-css/animate.min.css" rel="stylesheet">
          <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>

<body>
      <header id="header">
        <div class="container">

          <div id="logo" class="pull-left">
            <a href="#hero"><img src="img/logo1.png" alt="" title="" /></img></a>
          </div>

          <nav id="nav-menu-container">
            <ul class="nav-menu">
              <li class="menu-active"><a href="index.php#hero">Acceuil</a></li>
              <li><a href="index.php#about">A propos de nous</a></li>
              <li><a href="news.php" >Mon fil d'actualité</a></li>
              <li class="menu-has-children"><a href="">Mon Profil</a>
                <?php  
                  if(isset($_SESSION["session_login"])){
                ?>  
                <ul>
                  <li><a href="publications.php">Mes publications</a></li> 
                  <li><a href="logout.php" style="color:red;"><b>Se déconnecter</b></a></li>
                </ul>
                <?php } 
                    else{   ?>  
                <ul>
                  <li><a href="login.php" style="color:green;"><b>Se connecter</b></a></li>
                  <!-- <li><a href="panier.php">Mon Panier</a></li> -->
                </ul>
                <?php } ?>
              </li>
              <!-- <li><a href="#" >Contactez nous</a></li> -->
            </ul>
          </nav>
        </div>
      </header>


      <section id="contact">
        <div class="container wow fadeInUp">
          <div class="row">
            <div class="col-md-12">
              <h3 class="section-title">Publier une News</h3>
              <div class="section-title-divider"></div>
              <p class="section-description">Laissez-vous vous exprimer!</p>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3 col-md-push-2">
              <div class="info">
                <div>
                  <i class="fa fa-map-marker"></i>
                  <p>N°107 Quartier Salam <br>80000, Agadir</p>
                </div>

                <div>
                  <i class="fa fa-envelope"></i>
                  <p>mb.news@uit.ac.ma</p>
                </div>

                <div>
                  <i class="fa fa-phone"></i>
                  <p>+212(6) 78 35 31 89</p>
                </div>

              </div>
            </div>

            <div class="col-md-5 col-md-push-2">
              <div class="form">
                <div id="sendmessage">Ton message a été envoyé, Merci!</div>
                <div id="errormessage"></div>
                <form action="" method="POST">
                  <div class="form-group">
                    <input type="text" name="titre" class="form-control" id="name" placeholder="Titre" data-rule="minlen:4" data-msg="Entrez au moins 4 caractères" required/>
                    <div class="validation"></div>
                  </div>
                  
                  <div class="form-group">
                    <textarea class="form-control" name="sujet" rows="10" data-msg="" placeholder="Ecrivez votre sujet ici ..." required></textarea>
                    <div class="validation"></div>
                  </div>
                  <div class="btn-get-started" align="center">                   
                 <input type="submit" name="publier" id="publier" value="Publier">
                 <?php if (! empty($message)) { ?>
                    <p class="errorMessage"><?php echo $message; ?></p>
                <?php } ?>

              
              </div>
                </form>
              </div>
            </div>

          </div>
        </div>
      </section> 


    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="lib/superfish/hoverIntent.js"></script>
    <script src="lib/superfish/superfish.min.js"></script>
    <script src="lib/morphext/morphext.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/stickyjs/sticky.js"></script>
    <script src="lib/easing/easing.js"></script>
    <script src="js/custom.js"></script>
    <script src="contactform/contactform.js"></script>

</body>

</html>