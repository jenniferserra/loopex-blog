<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login/Registrera</title>
    <link rel="stylesheet" href="normalize.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <link rel="stylesheet" href="style/css/style.css">




  </head>

  <body class="login">
  <!-- Om användaren loggar in med fel uppgifter blir man varse om detta -->
    <?php
      if(isset($_GET['error'])) {
        ?>
        <div class="alert alert-danger" role="alert">Fel användarnamn eller lösenord</div>
    <?php
      }

      include "functions/functions.php";

      // TODO, någon liknande if sats som denna, för att:
      // om användaren är inloggad och hamnar på login.php ska
      // användaren hamna på dashboard istället
      //
      // if (!empty($_SESSION['user_id'])) {
      //   header("Location: dashboard.php");
      // }
      ?>
  <div class="loginbox col-sm-12 col-xs-12">
    <div class="container form">
      <form method="POST" action="logincheck.php" class="form-center login-form">
        <h2 class="form-center-heading login">Logga in</h2>
        <label for="inputEmail" class="sr-only">E-post</label>
        <input type="email" id="inputEmail" class="form-control" name="email" placeholder="E-post" required autofocus>
        <label for="inputPassword" class="sr-only">Lösenord</label>
        <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Lösenord" required>
        <!-- <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Kom ihåg mig
          </label>
        </div> -->
        <input name="login" class="btn login-button btn-lg btn-primary btn-block" type="submit" value="Logga in">
      </form>
    </div>

    <!-- DEN HÄR KODEN SKA BORT OCH ISTÄLLET IN I SUPERUSER ADMIN-SIDAN -->
    <div class="container">

      <form method="POST" class="form-horizontal form-center">
      <h2 class="form-center-heading">Registrera</h2>
        <div class="form-group">
        <input type="text" name="firstname" placeholder="Förnamn" class="form-control" required>
        </div>
        <div class="form-group">
        <input type="text" name="lastname" placeholder="Efternamn" class="form-control" required>
        </div>
        <div class="form-group">
        <input type="email" name="email" placeholder="E-post" class="form-control" required>
        </div>
        <div class="form-group">
        <input type="password" name="password" placeholder="*******" class="form-control" required>
        </div>
        <!-- TO DO: lägg till profilbild här -->
        <input name="register" class="btn btn-lg btn-primary btn-block" type="submit" value="Registrera">
      </form>
      <?php regUser();

      ?>

    </div>
  </div>

  </body>
</html>
