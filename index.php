
<?php 

session_start();

      if(isset($_SESSION["session_login"])){
        require 'vendor/autoload.php';  
        $con = new MongoDB\Client("mongodb://localhost:27017");
        $db = $con->news;

        $collection = $db->utilisateur;
        $cursor = $collection->findOne(array('login' => $_SESSION['session_login']));
        $nom=$cursor['nom'];
        $prenom=$cursor['prenom'];

       }


 ?>





<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="utf-8">
      <title>The MB News</title>
        <link rel="shortcut icon" type="image/png" href="logo1.png">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <meta content="" name="keywords">
      <meta content="" name="description">

      <link href="favicon.ico" rel="shortcut icon">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">
      <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
      <link href="lib/animate-css/animate.min.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet">
</head>

<body>
  <div id="preloader"></div>


  <section id="hero">
    <div class="hero-container">
      <div class="wow fadeIn">
        <div class="hero-logo">
          <img class="" src="img/logo1.png" alt="Imperial">
        </div>

        <h1>Welcome <?php if (! empty($prenom)) echo $prenom; ?> to MB News</h1>
        
        <h2>On offre <span class="rotating">nouvelles infos, différents domaines, exclusivité totale</span></h2>
        <div class="actions">
          <?php  
                if(!isset($_SESSION["session_login"])){
          ?>  
            <a href="login.php" class="btn-get-started">Se connecter</a>
          <?php } 
                  else{   ?>
            <a href="news.php" class="btn-get-started">Checker les news</a>
          <?php } ?>
          <a href="Contact.php" class="btn-services">Publier news</a>
        </div>
      </div>
    </div>
  </section>


  <section id="subscribe">
    <div class="container wow fadeInUp">
      <div class="row">
        <div class="col-md-8">
          <h3 class="subscribe-title">Abonnez-vous pour recevoir les nouveautés.</h3>
          <p class="subscribe-text">Rejoignez nos +1000 abonnés et accédez aux derniers infos, reportages et bien plus encore!</p>
        </div>
        <div class="col-md-4 subscribe-btn-container">
          <a class="subscribe-btn" href="Site_News_NoSQL_MongoDB.pdf" download>Cliquez-ici pour telecharger le rapport</a>
        </div>
      </div>
    </div>
  </section>




  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
        <a href="#hero"><img src="img/logo1.png" alt="" title="" /></img></a>
 
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="#hero">Acceuil</a></li>
          <li><a href="#about">A propos de nous</a></li>
          <li><a href="news.php" >Mon fil d'actualité</a></li>
          <li class="menu-has-children"><a href="#about">Mon Profil</a>
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
                <li><a href="register.php" style="color:black;"><b>S'inscrire</b></a></li>
                <!-- <li><a href="panier.php">Mon Panier</a></li> -->
              </ul>
              <?php } ?>
          </li>
          <li><a href="Contact.php" >Publier news</a></li>
        </ul>
      </nav>

    </div>
  </header>

  <section id="about">
    <div class="container wow fadeInUp">
      <div class="row">
        <div class="col-md-12">
          <h3 class="section-title">A propos de nous</h3>
          <div class="section-title-divider"></div>
          <p class="section-description">Un site web spécialisé dans les news.</p>
        </div>
      </div>
    </div>
    <div class="container about-container wow fadeInUp">
      <div class="row">

        <div class="col-lg-6 about-img">
          <img src="img/ecomm.jpg" alt="">
        </div>

        <div class="col-md-6 about-content">
          <br></br>
          <br></br>
          <h2 class="about-title">Nous fournissons des infos en exclusivité.</h2>
          <p class="about-text">
            Il y a plus de 3 ans, on a commencé à tout faire pour réaliser notre rêve et devenir créateurs de site web. Tout d'abord commencés en tant que blogueurs sur les réseaux sociaux, on a essayé de créer notre premier blog d'infos. Ceci est notre deuxième pop-up feed avec le lancement d'une nouvelle aventure.
          </p>
        </div>
      </div>
    </div>
  </section>


  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

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
