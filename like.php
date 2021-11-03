<?php


  require 'vendor/autoload.php';  
  $con = new MongoDB\Client("mongodb://localhost:27017");
  $db = $con->news;

  $pubs = $db->avis;
  
  session_start();


    if(!isset($_SESSION["session_login"])){
        header("location: index.php");
        exit;
    }

    if(isset($_SESSION["session_login"])){

  	   	$collection = $db->utilisateur;
        $cursor1 = $collection->findOne(array('login' => $_SESSION['session_login']));
        $nom=$cursor1['nom'];
        $prenom=$cursor1['prenom'];
}
  if(isset($_GET['titre3']) ){



        $cursor = $pubs->findOne(array('titre' => $_GET['titre3']));
        $nb=$cursor['nblike']+1;
		
		$pubs->updateOne([ 'titre' => $_GET['titre3'] ],
			[ '$set' => [ 'nblike' => $nb ]]
		);
			
       header("location: news.php");
    }

?>