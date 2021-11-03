<?php 

session_start();

    if(!isset($_SESSION["session_login"])){
        header("location: index.php");
        exit;
    }
    if(isset($_SESSION["session_login"])){
        require 'vendor/autoload.php';  
        $con = new MongoDB\Client("mongodb://localhost:27017");
        $db = $con->news;

        $collection = $db->utilisateur;
        $cursor = $collection->findOne(array('login' => $_SESSION['session_login']));
        $nom=$cursor['nom'];
        $prenom=$cursor['prenom'];



        $pubs = $db->avis;
        $pub = $pubs->find();
     

       }


?>

<!DOCTYPE html>
<html>
<title>Fil d'actualité</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<style>
body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<header id="header">
        <div class="container">

          <div id="logo" class="pull-left">
            <a href="#hero"><img src="img/logo1.png" alt="" title="" /></img></a>
          </div>

          <nav id="nav-menu-container">
            <ul class="nav-menu">
              <li class="menu-active"><a href="index.php#hero">Acceuil</a></li>
              <li><a href="index.php#about">A propos de nous</a></li>
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
              <li><a href="Contact.php" >Publier news</a></li>
            </ul>
          </nav>
        </div>
      </header>

<body class="w3-light-grey" >

    

<!-- w3-content defines a container for fixed size centered content, 
and is wrapped around the whole page content, except for the footer in this example -->
<div class="w3-content" style="max-width:1400px">

<!-- Header -->
<header class="w3-container w3-center w3-padding-32"> 
  <h1><b>Mon fil d'actualité</b></h1>
</header>
  <h3 align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Commentaires</h3>
<!-- Grid -->
<div class="w3-row" >


<div class="w3-col l8 s12" >
  <!-- Blog entry -->
  <div class="w3-card-4 w3-margin w3-white">
    <?php foreach ($pub as $pub1 ): ?>
    <div class="w3-container" >
      <h3><b><?php echo $pub1['nom']." ".$pub1['prenom'] ?></b></h3>
      <h5><?php echo $pub1['titre'].", " ?><span class="w3-opacity"><?php echo $pub1['date'] ?></span></h5>
    </div>
 
    <div class="w3-container">
      <p><?php echo $pub1['sujet'] ?></p>
      <div class="w3-row">
        <div class="w3-col m8 s12">
          <p></p>
        </div>
        
        <div class="w3-col m4 w3-hide-small">
            <form method="POST" action="" >

          <span class="w3-padding-large w3-right"><b><input type="submit" name="comments" value="Commentaire">  &nbsp;</b> <span class="w3-tag"></span></span>
            
            </form> 
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <hr>

</div>
 


<!-- END GRID -->
</div><br>

<!-- END w3-content -->
</div>

<!-- Footer -->
<footer class="w3-container w3-dark-grey w3-padding-32 w3-margin-top">
  <!-- <button class="w3-button w3-black w3-disabled w3-padding-large w3-margin-bottom">Previous</button> -->
  <!-- <button class="w3-button w3-black w3-padding-large w3-margin-bottom" action="index.php">
  Revenir à l'accueil &raquo;
  </button> -->
  <form action="index.php">
    <input type="submit" class="w3-button w3-black w3-padding-large w3-margin-bottom" value="Revenir à l'accueil &raquo;" />
  </form>
</footer>

</body>
</html>