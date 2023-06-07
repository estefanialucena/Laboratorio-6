<!DOCTYPE HTML>
<html>

    <head>
        <title>Samsung Desarrolladoras 2022/23 - Consulta</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <script src="js/index.js" defer></script>
        <script src="https://kit.fontawesome.com/b37653d681.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>

    <body>

        <!-- MENU -->
        <nav>
            <div class="left-items">
                <a class="item" href="index.html"><img class='logo' src="images/bejob-logo.png" alt="Logo de Bejob"></a>
            </div>
            <div class="right-items">
                <a class="item" href="registration.html">REGISTRO</a>
                <a class="item selected" href="search.php">CONSULTA</a>
                <a class="item" href="about.html">ACERCA DE</a>
            </div>
            <a class="toggle" href="#" onclick="toggle();"><i class="fas fa-bars fa-2x"></i></a>
        </nav>

        <!-- SEARCH FORM -->
        <div id="search">  
            <h1>Consulta de registros</h1>
            <?php
                // Connect to DB
                require_once("functions.php");
                $conn = connect_to_db();

                $search_query = "SELECT * FROM USUARIOS"; 
                $result = $conn->query($search_query);
                
                if ($result->num_rows > 0) {
            ?>
                    <table id="usuarios">
                        <tr>
                            <th>Nombre</th>
                            <th>Primer apellido</th>
                            <th>Segundo apellido</th>
                            <th>Email</th>
                        </tr>
                        <?php
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $row['NOMBRE'] . "</td>";
                                echo "<td>" . $row['PRIMER_APELLIDO'] . "</td>";
                                echo "<td>" . $row['SEGUNDO_APELLIDO'] . "</td>";
                                echo "<td>" . $row['EMAIL'] . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </table>
            <?php
                } else {
                    echo "No hay resultados, sé el primero en registrarte <a href='registration.html'>aquí</a>.";
                }       
                $conn->close();
            ?>
        <div>
    </body>

</html>