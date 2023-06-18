<?php
    // CONEXIÓN CON BASE DE DATOS.
    $hostname = "localhost";
    $database = "samsung_developer";
    $username = "root";
    $password = "";
    $table_name = "alta_usuarios";

    $database_connection = new mysqli($hostname, $username, $password, $database);

    if ($database_connection->connect_error) {
        echo "Error al intentar conectar con la base de datos." . $database_connection->connect_error;
        echo '<script>
            alert("Error al intentar conectar con la base de datos.");
            window.location="/index.php";
        </script>';
    }

    // COMPROBACIÓN EN BASE DE DATOS DE SI EXISTEN REGISTROS PARA MOSTRAR EL BOTÓN DE CONSULTAR O NO.
    $info_in_database = false;
    $get_all_query = "SELECT * FROM " . $table_name;

    $all_data = $database_connection->query($get_all_query);
    
    if ($all_data && mysqli_num_rows($all_data) > 0) {
        $info_in_database = true;
    }

    function showData($all_data) {
        while ($row = $all_data->fetch_assoc()) {
            $name = $row["nombre"];
            $first_surname = $row["primerApellido"];
            $second_surname = $row["segundoApellido"];
            $username = $row["username"];
            $email = $row["email"];
            $pwd = $row["password"];
    
            $pdwNotVisible = str_repeat("*", strlen($pwd));
            
            echo "<tr>
                <td>$name</td>
                <td>$first_surname</td>
                <td>$second_surname</td>
                <td>$username</td>
                <td>$email</td>
                <td>$pdwNotVisible</td>
            </tr>";
        }
        $all_data->free();
    }
?>

<!DOCTYPE html>
<html lang="es">
	<head charset="utf-8">
        <meta charset="UTF-8">
		<title> Practica Final</title>
        <link rel="stylesheet" href="style.css">
	</head>

	<body>
        <div class="form" hidden>
            <form method="POST" action="form.php">
                <h1> Alta de usuario en plataforma </h1>

                <div class="nameDiv">
                    <label for="name">Nombre <span class="required"> (requerido) </span></label>
                    <input type="text" name="name" class="form-input" required maxlength="100">
                </div>

                <div class="firstSurnameDiv">
                    <label for="firstSurname">Primer apellido <span class="required"> (requerido) </span></label>
                    <input type="text" name="firstSurname" class="form-input" required maxlength="100">
                </div>

                <div class="secondSurnameDiv">
                    <label for="secondSurname">Segundo apellido <span class="required"> (requerido) </span></label>
                    <input type="text" name="secondSurname" class="form-input" required maxlength="100">
                </div>

                <div class="usernameDiv">
                    <label for="username">Login <span class="required"> (requerido) </span></label>
                    <input type="text" name="username" class="form-input" required maxlength="100">
                </div>

                <div class="emailDiv">
                    <label for="email">Email <span class="required"> (requerido) </span></label>
                    <input type="email" name="email" class="form-input" required maxlength="255">
                </div>

                <div class="pwdDiv">
                    <label for="pwd">Contraseña <span class="required"> (requerido) </span></label>
                    <input type="password" name="pwd" class="form-input" required minlength="4" maxlength="8">
                </div>

                <div class="confirmDiv">
                    <label for="confirmPwd">Confirmar contraseña <span class="required"> (requerido) </span></label>
                    <input type="password" name="confirmPwd" class="form-input" required minlength="4" maxlength="8">
                </div>

                <input type="submit" name="submit" class="submit" value="Darse de alta">
            </form>
            <button id="consultButton" name="consult" class="submit"
                onclick="document.getElementById('data-table').style.display='block'"
                <?php if ($info_in_database) { echo ''; } else { echo 'hidden'; } ?>>
                Consultar
            </button>
        </div>

        <div class="data-table" id='data-table' hidden>
            <h1> Usuarios registrados </h1>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Primer Apellido</th>
                    <th>Segundo Apellido</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Contraseña</th>
                </tr>
                <?php showData($all_data); ?>
            </table>
        </div>
    </body>
</html>