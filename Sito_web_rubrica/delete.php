<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "config.php";

    // Prepare a delete statement
    $sql = "DELETE FROM contatti WHERE id = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_POST["id"]);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: contatti.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
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
    <title>Cancellazione Contatto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
      <h2 class="mt-5 mb-3">Cancellazione contatto</h2>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
        <p>
        <?php
          require_once "config.php";
          $id = trim($_GET["id"]);
          $sql = "SELECT * FROM contatti WHERE id = $id ";

          if($result = mysqli_query($link, $sql)){
            $row = mysqli_fetch_array($result);
            echo $row['cognome']. " ";
            echo $row['nome'] . "<br>";
            echo $row['indirizzo'] . "<br>";
            echo $row['cell'] . "<br>";
            echo $row['note'] . "</td>";

          }else{
              echo "Oops! Something went wrong. Please try again later.";
          }

          // Close connection
          mysqli_close($link);


         ?>
        </p>

        <p>Sei sicuro di voler eliminare il contatto?</p>
        <p><input type="submit" value="Si" class="button2"></p>
        <p><input type="button" class="button1" value="No" onclick="location.href='contatti.php';"></p>
      </form>
    </div>
</body>
</html>
