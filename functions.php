<?php 
function Map($titre){
          $con = new MongoDB\Client("mongodb://localhost:27017");
          $nb = $con->news->avis->findOne(array('titre' => $titre ));
          return $nb['nblike']; 
}

function stockerNews($nom,$prenom,$login,$titre,$sujet,$date,$url){
      $con = new MongoDB\Client("mongodb://localhost:27017");  
      $db = $con->news;  
      
      $db->avis->insertOne( ['nom'=>$nom,'prenom' => $prenom, 'email'=>$login,'titre'=>$titre, 'sujet'=>$sujet,'date'=>$date, 'url'=>$url,'nblike'=>0,'dislike'=>0 ]);
}

function Reduce($titre){
          $con = new MongoDB\Client("mongodb://localhost:27017");
          $nb = $con->news->avis->findOne(array('titre' => $titre ));
          return $nb['dislike']; 
}

function ScoreLikes($titre){
		return Map($titre)-Reduce($titre);        
}

function AfficherNews($login){
	  $con = new MongoDB\Client("mongodb://localhost:27017");
        $db = $con->news;

        $collection = $db->avis;
        $cursor = $collection->find(array('email' => $_SESSION['session_login']));

  		foreach ($cursor as $c ){
  			return $c['titre'];
  		}
}
?>