<?php  

session_start();
      require 'vendor/autoload.php';  
    
    // Creating Connection  
    $con = new MongoDB\Client("mongodb://localhost:27017");  

    // Creating Database  
    $db = $con->news;  

    $collection = $db->utilisateur;

    if(isset($_SESSION["session_login"])){
        header("location: index.php");
        exit;
    }


 if(isset($_REQUEST['email'], $_REQUEST['password'], $_REQUEST['nom'], $_REQUEST['prenom'])){

    $email = $_REQUEST['email']; 
    $password = $_REQUEST['password'];
    $nom = $_REQUEST['nom'];
    $prenom = $_REQUEST['prenom'];
    

    function verifEmail($email){
        if (preg_match('/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/im',$email)) 
            return true;
        else 
            return false;
    }
    
    function verifPassword($password){
         if(preg_match("/.{8,}/im", $password)){
            if(preg_match("/[A-Z]+/im", $password)){
                    if(preg_match("/[0-9]+/im", $password)){
                        return true;
                        }
                    }
                }
                return false;
    }



    if(verifEmail($email) && verifPassword($password)){

        $checkEmail = $collection->findOne( ['login' =>$email] ); 
        

        if($checkEmail){
              $verifEmail_already="Adresse e-mail déjà utilisée.";         
        }
        else{
            $collection->insertOne( ['nom'=>$nom, 'prenom'=>$prenom, 'login'=>$email, 'mdp'=>$password] );
            $_SESSION["session_login"] = $email;
            header("location: index.php");
        }

    }else{
        if(verifEmail($email))
            $verifPassword_message="Veuillez entrer un mot de passe valide, avec au moins 8 caractères, une lettre en majuscule et un chiffre";
        else
             $verifEmail_message="Veuillez entrer une adresse e-mail valide.";
    }
    
}


?>

<!DOCTYPE html>
<html>
    <head>
       <meta charset="utf-8">
        <link rel="stylesheet" href="style1.css" media="screen" type="text/css" />
          <title>Inscription</title>
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
            <style>
              body{
                      background-image: url(img/wallpaper1.jpg);
                  }
            </style>
    </head>
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
              <li><a href="Contact.php">Publier news</a></li>
              <li><a href="login.php" style="color:green;"><b>Se connecter</b></a>
            </ul>
          </nav>
        </div>
    </header>
 
<body>
        
      <div id="container">
            
                <p align="center" style="color:#FFEFD5"; class="glitch"><FONT size="5pt" backgrou>Bienvenue à MB News</FONT></p>   
                <form action="register.php#container" method="POST">
                
                <label><b>Adresse e-mail</b></label>
                <input type="text" placeholder="Entrez le nom d'utilisateur" name="email" required>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrez le mot de passe" name="password" required>

                <label><b>Nom</b></label>
                <input type="text" placeholder="Entrez votre nom" name="nom" required>

                <label><b>Prénom</b></label>
                <input type="text" placeholder="Entrez votre prénom" name="prenom" required>

                <input type="submit" id='submit' value='Inscription' name="submit">
                <h6 align="center">Déjà inscrit? <a href="login.php">Connectez-vous ici</a>.</h6>
                
                <?php if (! empty($verifEmail_message)) { ?>
                    <p class="errorMessage"><?php echo $verifEmail_message; ?></p>
                <?php }elseif(! empty($verifPassword_message)) { ?>
                    <p class="errorMessage"><?php echo $verifPassword_message; ?></p>
                <?php } ?>
                <?php if (! empty($verifEmail_already)) { ?>
                    <p class="errorMessage"><?php echo $verifEmail_already; ?></p>
                <?php } ?>

            </form>
        </div>
    </body>
</html>