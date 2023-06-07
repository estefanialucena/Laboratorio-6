<!DOCTYPE HTML>
<html>

    <head>
        <title>Samsung Desarrolladoras 2022/23 - Registro</title>
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
                <a class="item selected" href="registration.html">REGISTRO</a>
                <a class="item" href="search.php">CONSULTA</a>
                <a class="item" href="about.html">ACERCA DE</a>
            </div>
            <a class="toggle" href="#" onclick="toggle();"><i class="fas fa-bars fa-2x"></i></a>
        </nav>

        <?php

            if($_POST){
                
                // Connect to DB
                require_once("functions.php");
                $conn = connect_to_db();

                // Get data from form
                $name = trim($_POST["name"]);
                $first_surname = trim($_POST["first-surname"]);
                $second_surname = trim($_POST["second-surname"]);
                $email = trim($_POST["email"]);

                // Check if user has already registered
                $sql_complete_name_query = "SELECT * FROM USUARIOS 
                                            WHERE NOMBRE='$name' 
                                            AND PRIMER_APELLIDO='$first_surname'
                                            AND SEGUNDO_APELLIDO='$second_surname'";
                $complete_name_duplicates = $conn->query($sql_complete_name_query);
                if ($complete_name_duplicates->num_rows > 0) {
                    echo "<div class='registration-error'>";
                    echo "ERROR: Este nombre completo ya se encuentra registrado en nuestra base de datos. ";
                    echo "Será redirigido al formulario en 5 segundos.";
                    echo "</div>";
                    header("refresh:5;url=registration.html" );
                    exit;
                }

                // Check if user e-mail already exists
                $sql_email_query = "SELECT * FROM USUARIOS 
                                    WHERE EMAIL='$email'";
                $email_duplicates = $conn->query($sql_email_query);
                if ($email_duplicates->num_rows > 0) {
                    echo "<div class='registration-error'>";
                    echo "ERROR: Este e-mail ya se encuentra registrado en nuestra base de datos. ";
                    echo "Será redirigido al formulario en 5 segundos.";
                    echo "</div>";
                    header("refresh:5;url=registration.html" );
                    exit;
                }

                // Insert data into DB
                try {
                    $sql_insert = "INSERT INTO USUARIOS (NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO, EMAIL) 
                                   VALUES ('$name', '$first_surname', '$second_surname', '$email')";

                    // Successful insert
                    if ($conn->query($sql_insert) === TRUE) {
                        echo "<div class='registration-success'>";
                        echo "Registro completado con éxito.";
                        echo '<div><input class="search-button" type="button" value="CONSULTA" onclick="location.href=\'search.php\'"></div>';
                        echo "</div>";
                    } 
                } catch (mysqli_sql_exception $e) {
                    // Show error in Spanish if variable exceeds the maximum number of characters (30)
                    if (str_contains($e, "Data too long for column")) {
                        $long_var = explode(" ", $e)[6];
                        echo "<div class='registration-error'>";
                        echo "ERROR: Se ha sobrepasado el número máximo de carácteres (30) en el campo " . $long_var . ". ";
                        echo "Será redirigido al formulario en 5 segundos.";
                        echo "</div>";
                        header("refresh:5;url=registration.html" );
                    
                    // Show other errors
                    } else {
                        echo "<div class='registration-error'>";
                        echo "No se han podido registrar los datos. ";
                        echo "ERROR: " . $e;
                        echo "</div>";
                    }
                    exit;
                }

                $conn->close();
            }

        ?>

    </body>

</html>