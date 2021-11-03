  <?php
      session_start();
      
      if(session_destroy())
          header("Location: login.php");
   
      
      if(isset($_GET['deconnexion']))
      { 
         if($_GET['deconnexion']==true)
         {  
            session_unset();
            header("location:login.php");
         }
      }
            
?>
