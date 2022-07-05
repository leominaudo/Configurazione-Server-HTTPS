<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Contatti</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="container">
      <img src="img/logo.png" alt="Immagine del logo" class="logo" onclick="location.href='index.php';">
      <div class="cont_button">
        <div class="head_con">

          <form action="search.php" method="post">
            <input type="text" name="search" id="search_bar" style="float:left">
            <button type="submit" id="search_submit">
              <img src="img/search.png" />
            </button>
          </form>

          <a href="nuovo.php" title="Aggiungi" ><img src="img/add.png" ></a>
        </div>
          <?php
          require_once "config.php";

          $sql = "SELECT * FROM contatti ORDER BY cognome";

          if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table >';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Cognome</th>";
                                        echo "<th>Nome</th>";
                                        echo "<th>Indirizzo</th>";
                                        echo "<th>Cellulare</th>";
                                        echo "<th>Note</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['cognome'] . "</td>";
                                        echo "<td>" . $row['nome'] . "</td>";
                                        echo "<td>" . $row['indirizzo'] . "</td>";
                                        echo "<td>" . $row['cell'] . "</td>";
                                        echo "<td>" . $row['note'] . "</td>";
                                        echo "<td class=\"icon\">";
                                          echo '<a href="update.php?id='. $row['id'] .'" title="Modifica" ><img src="img/update.png" class="image_icon" style="float:left"></a>';
                                          echo '<a href="delete.php?id='.$row['id'].'" title="Elimina" ><img src="img/delete.png" class="image_icon" style="float:right"></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";

                            mysqli_free_result($result);
                        } else{
                            echo '<div><em>Non ci sono contatti.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close connection
                    mysqli_close($link);

          ?>

      </div>
    </div>

  </body>
</html>
