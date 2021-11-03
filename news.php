<?php 

session_start();

    if(!isset($_SESSION["session_login"])){
        header("location: login.php");
        exit;
    }


  require 'vendor/autoload.php';  
  $con = new MongoDB\Client("mongodb://localhost:27017");

    if(isset($_SESSION["session_login"])){
        $db = $con->news;

        $collection = $db->utilisateur;
        $cursor = $collection->findOne(array('login' => $_SESSION['session_login']));
        $nom=$cursor['nom'];
        $prenom=$cursor['prenom'];



        $pubs = $db->avis;
        $pub = $pubs->find();
     

    }

      $pubs = $db->avis;
      $date1=date("H:i:s");
      $date = strftime("%A, %d %B %G, ").$date1;


      
      function Reduce($titre){
          $con = new MongoDB\Client("mongodb://localhost:27017");
          $nb = $con->news->avis->findOne(array('titre' => $titre ));
          return $nb['dislike']; 
      }

      function Map($titre){
          $con = new MongoDB\Client("mongodb://localhost:27017");
          $nb = $con->news->avis->findOne(array('titre' => $titre ));
          return $nb['nblike']; 
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
<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

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
  <p>Bienvenue à la page des news <span class="w3-tag"><?php  echo $nom; ?></span></p>
</header>

<!-- Grid -->
<div class="w3-row" >
<?php 
  foreach ($pub as $pub1 ): ?>

<div class="w3-col l8 s12" >  
  <!-- Blog entry -->
<div class="w3-card-4 w3-margin w3-white">
    <div class="w3-container" >
     
      <h3><b><a href="url.php?titre2=<?php echo $pub1['titre']?>"><?php ;echo $pub1['titre'];?></a></b></h3>

      <h5><?php echo $pub1['nom']." ".$pub1['prenom'].", " ?><span class="w3-opacity"><?php echo $pub1['date'] ?></span></h5>
    </div>
 
    <div class="w3-container">
      <p><?php echo $pub1['sujet'] ?></p>
       <div class="w3-row">
        <div class="w3-col m8 s12">
         
          <p>
             &nbsp;&nbsp;&nbsp;&nbsp; <a href="like.php?titre3=<?php echo $pub1['titre'];?>" class="active"><i class="fas fa-thumbs-up"></i></a>&nbsp;&nbsp;<?=  (Map($pub1['titre'])); ?>&nbsp;&nbsp;
              <a href="dislike.php?titre3=<?php echo $pub1['titre'];?>" class="active"><i class="fas fa-thumbs-down"></i></a>&nbsp;&nbsp;<?= Reduce($pub1['titre']); ?>


          </p>
        </div>
        
 <div class="w3-col m4 w3-hide-small">

<?php    
 
        $avis = $db->avis;
        $cursor = $avis->findOne(array('titre'=>$pub1['titre']));
        //var_dump($cursor->count());
        $nb=$cursor->count();
        $total=$nb-10; 


?> 
          
          <p><span class="w3-padding-large w3-right"><b> <span class="w3-tag"><?= $total." " ?></span><a href="url.php?titre2=<?php echo $pub1['titre']?>"> Commentaires </a>&nbsp;</b> </span></p>

</div>



       
      </div>
    </div>
  </div>


  <div class="w3-row">
      <form method="post" action="">

        <div class="w3-col m8 s12">   
          &nbsp;&nbsp;&nbsp; &nbsp;
          <textarea name="commentaire"rows="2" cols="67"placeholder="Votre commentaire..." required></textarea>
        </div>
        
        <div class="w3-col m4 w3-hide-small">

          <span class="w3-padding-large w3-right"><b>
              <input type="submit" name="<?php
$searchString = " ";
$replaceString = "";
 
 
$outputString = str_replace($searchString, $replaceString, $pub1['titre']);

               echo $outputString; ?>" value="Commenter">   &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</b> 
              <span class="w3-tag"></span>
          </span>
        </div> 
      
      </form> 
        
  </div>
  <hr>

</div>
<?php   


          if(isset($_POST[$outputString])){
              


                $avis = $db->avis;
                $cursor = $avis->findOne(array('titre'=>$pub1['titre']));
                //var_dump($cursor->count());
                $nb=$cursor->count();
                $total=$nb-9;              

                $db->avis->updateOne(
                ['titre' => $pub1['titre']],
                [
                    '$set' => ['commentaire'.$total=> ([
                    'Nom'=>$nom,
                    'Prenom'=>$prenom,
                    'commentaire'=>$_POST['commentaire'],
                    'date2'=>$date
                ])]
                ]);

                
       }

endforeach; ?>


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