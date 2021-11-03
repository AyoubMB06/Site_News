<!DOCTYPE html>

<html>
    <head>
       <meta charset="utf-8">
        <link rel="stylesheet" href="style1.css" media="screen" type="text/css" />
          <title>Login</title>
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
              <!-- <li><a href="news.php" >Mon fil d'actualité</a></li> -->
              <!-- <li><a href="Contact.php" >Publier news</a></li> -->
              <li><a href="register.php" style="color:green;"><b>S'inscrire</b></a>
            </ul>
          </nav>
        </div>
    </header>




<body>

<?php



session_start();

    require 'vendor/autoload.php';  

    if(isset($_SESSION["session_login"])){
        header("location: index.php");
        exit;
    }

    if (isset($_POST['email'])){

          // Creating Connection  
          $con = new MongoDB\Client("mongodb://localhost:27017");  

          // Creating Database  
          $db = $con->news;  

          $collection = $db->utilisateur;

          $email = $_POST["email"];
          $password = $_POST["password"];

          $record = $collection->findOne( [ 'login' =>$email ,'mdp' =>$password ] );  
                  if($record){
                       $_SESSION["session_login"] = $email;
                      header("Location: index.php");
                  }
                  else{
                    $message="Le nom d'utilisateur ou le mot de passe est incorrect.";
                  }

    }
    


  


?>

      <div id="container">
            <p align="center" style="color:#FFEFD5"; class="glitch"><FONT size="5pt" backgrou>Bienvenue à MB News</FONT></p>
            
            <form method="POST" action="" name="login">
                
                <label><b>E-mail</b></label>
                <input type="text" placeholder="Entrez l'adresse e-mail" name="email" required>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrez le mot de passe" name="password" required>

                <input type="submit" id='submit' value='LOGIN' name="submit" >
                <h6 align="center">Vous n'êtes pas encore enregistrés? <a href="register.php">Inscrivez-vous</a>. </h6>

                <?php if (! empty($message)) { ?>
                    <p class="errorMessage"><?php echo $message; ?></p>
                <?php } ?>

            </form>
        </div>

</body>
</html>