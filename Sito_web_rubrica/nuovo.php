<?php
  // Include config file
  require_once "config.php";

  // Define variables and initialize with empty values
  $nome = $cognome = $indirizzo = $cell = $note = "";

  // Processing form data when form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST"){

      $nome = trim($_POST["nome"]);
      $cognome = trim($_POST["cognome"]);
      $indirizzo = trim($_POST["indirizzo"]);
      $cell = trim($_POST["cell"]);
      $note = trim($_POST["note"]);


      $sql = "INSERT INTO contatti (id, nome, cognome, indirizzo, cell, note) VALUES (null, ?, ?, ?, ?, ?)";

      if($stmt = mysqli_prepare($link, $sql)){
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "sssis", $param_nome, $param_cognome, $param_indirizzo, $param_cell, $param_note);

          // Set parameters
          $param_nome = $nome;
          $param_cognome = $cognome;
          $param_indirizzo = $indirizzo;
          $param_cell = $cell;
          $param_note = $note;

          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
              // Records created successfully. Redirect to landing page
              header("location: index.php");
              exit();
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
      }

      // Close statement
      mysqli_stmt_close($stmt);


    // Close connection
    mysqli_close($link);
  }
?>


<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Aggiungi Contatto</title>
    <link rel="stylesheet" href="style.css?ts=<?=time()?>&quot">
  </head>
  <body>
    <div class="container">
      <img src="img/logo.png" alt="Immagine del logo" class="logo" onclick="location.href='index.php';">
      <div class="cont_button">
        <h2>Aggiungi nuovo contatto</h2>

        <form  class="cont_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <input type="text" name="nome" placeholder="Nome" value="<?php echo $nome; ?>">
            <input type="text" name="cognome" placeholder="Cognome" value="<?php echo $cognome; ?>">
            <input type="text" name="indirizzo" placeholder="Indirizzo" value="<?php echo $indirizzo; ?>">
            <input type="text" name="cell" placeholder="Cellulare" value="<?php echo $cell; ?>">
            <input type="text" name="note" placeholder="Note" value="<?php echo $note; ?>">
            <input class="button1" type="submit" value="Aggiungi">
            <input class="button2" type="button" onclick="location.href='index.php';" value="Annulla">

        </form>

      </div>
    </div>

  </body>
</html>
