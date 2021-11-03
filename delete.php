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

  //echo $_GET['titre3'];
  
  if(isset($_GET['titre3']) ){

        $cursor = $pubs->deleteOne(array('titre' => $_GET['titre3']));
        header("location: publications.php");
    }

?>