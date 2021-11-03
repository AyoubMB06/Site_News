<?php


  require 'vendor/autoload.php';  
  $con = new MongoDB\Client("mongodb://localhost:27017");
  $db = $con->news;

  $pubs = $db->avis;


  if(isset($_GET['titre3']) ){

        $cursor = $pubs->findOne(array('titre' => $_GET['titre3']));
        $nb=$cursor['dislike']+1;
		
		$pubs->updateOne([ 'titre' => $_GET['titre3'] ],
			[ '$set' => [ 'dislike' => $nb ]]);

		$_SESSION['dislike'] = $nb;
        header("location: news.php");
    }

?>