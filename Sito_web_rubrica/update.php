<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$nome = $cognome = $indirizzo = $cell = $note = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Validate name
    $input_nome = trim($_POST["nome"]);
    $input_cognome = trim($_POST["cognome"]);
    $input_indirizzo = trim($_POST["indirizzo"]);
    $input_cell = trim($_POST["cell"]);
    $input_note = trim($_POST["note"]);

        // Prepare an update statement
        $sql = "UPDATE contatti SET nome=?, cognome=?, indirizzo=?, cell=?, note=? WHERE id=?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssisi", $param_nome, $param_cognome, $param_indirizzo, $param_cell, $param_note, $param_id);

            // Set parameters
            $param_nome = $input_nome;
            $param_cognome = $input_cognome;
            $param_indirizzo = $input_indirizzo;
            $param_cell = $input_cell;
            $param_note = $input_note;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: contatti.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }


        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM contatti WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $nome = $row["nome"];
                    $cognome = $row["cognome"];
                    $indirizzo = $row["indirizzo"];
                    $cell = $row["cell"];
                    $note = $row["note"];

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Modifica Contatto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper"><br>
      <h2>Modifica contatto</h2>
      <p>Modificare i campi e premere modifica per aggiornare il contatto.</p>
      <form class="cont_form" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

        <label>Nome:</label>
        <input type="text" name="nome"  value="<?php echo $nome; ?>"><br>

        <label>Cognome:</label>
        <input type="text" name="cognome" value="<?php echo $cognome; ?>"><br>

        <label>Indirizzo:</label>
        <input type="text" name="indirizzo" value="<?php echo $indirizzo; ?>"><br>

        <label>Cellulare:</label>
        <input type="text" name="cell" value="<?php echo $cell; ?>"><br>

        <label>Note:</label>
        <input type="text" name="note" value="<?php echo $note; ?>"><br>

        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <input type="submit" class="button1" value="Modifica"><br>
        <input type="button" class="button2" onclick="location.href='contatti.php';" value="Annulla">

      </form>

    </div>
</body>
</html>
