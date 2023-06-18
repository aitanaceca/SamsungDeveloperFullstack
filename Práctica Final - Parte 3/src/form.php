<?php
    //¡¡IMPORTANTE!!: COPIAR EN HTDOCS SOLAMENTE LA CARPETA SRC DEL PROYECTO PARA QUE LAS REDIRECCIONES FUNCIONEN.
    
    //EJECUTAR ARCHIVO SQL ANTES DE PROBAR EL FORMULARIO.
    include 'index.php';

    if ($_POST) {
        // REGIÓN PARA OBTENER LOS CAMPOS DEL FORMULARIO.
        $name = $_POST['name'];
        $first_surname = $_POST['firstSurname'];
        $second_surname = $_POST['secondSurname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];
        $confirm_pwd = $_POST['confirmPwd'];
    

        // REGIÓN DE VALIDACIÓN DE CAMPOS.
        function setEmptyAlert($inputField)
        {
            echo '<script>
                alert("El campo ' . $inputField . ' no puede estar vacío.");
                window.location = "/src/index.php";
            </script>';
            die();
        }

        if (empty($name) || trim($name) === "") {
            setEmptyAlert("Nombre");
        }

        if (empty($first_surname) ||  trim($first_surname) === "") {
            setEmptyAlert("Primer apellido");
        }

        if (empty($second_surname) || trim($second_surname) === "") {
            setEmptyAlert("Segundo apellido");
        }

        if (empty($username) ||  trim($username) === "") {
            setEmptyAlert("Login");
        }

        if (empty($email) || trim($email) === "") {
            setEmptyAlert("Email");
        }

        $emailRegex = "/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/";

        if (!preg_match($emailRegex, $email)) {
            echo '<script>
                alert("El email no tiene el formato adecuado.");
                window.location = "/src/index.php";
            </script>';
            die();
        }


        if (empty($pwd) || trim($pwd) === "") {
            setEmptyAlert("Contraseña");
        }

        if (empty($confirm_pwd) || trim($confirm_pwd) === "") {
            setEmptyAlert("Confirmar contraseña");
        }

        if (strlen($pwd) < 4 || strlen($pwd) > 8) {
            echo '<script>
                alert("La contraseña tiene que tener entre 4 y 8 caracteres");
                window.location = "/src/index.php";
            </script>';
            die();
        }

        if ($pwd !== $confirm_pwd) {
            echo '<script>
                alert("Las contraseñas no coinciden.");
                window.location = "/src/index.php";
            </script>';
            die();
        }


        // COMPROBACIÓN EN BASE DE DATOS DE QUE EL EMAIL INTRODUCIDO NO EXISTA.
        $check_email_query = "SELECT * FROM " . $table_name . " WHERE email LIKE '" . $email . "';";

        $result = $database_connection->query($check_email_query);
        
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row) {
                $prueba = $row['email'];
                echo '<script>
                    alert("Email registrado anteriormente.");
                    window.location = "/src/index.php";
                </script>';
                die();
            }
            $result->free();
        }


        // SI EL EMAIL NO EXISTE EN LA BASE DE DATOS, SE INSERTA LA INFORMACIÓN DEL REGISTRO.
        $insert_query = "INSERT INTO " . $table_name . " (nombre, primerapellido, segundoapellido, username, email, password)
            VALUES ('$name', '$first_surname', '$second_surname', '$username', '$email', '$pwd')";
        
        if ($database_connection->query($insert_query) === true) {
            echo "Registro completado con éxito.";
            echo '<script>
                alert("Registro completado.");
                window.location = "/src/index.php";
            </script>';
        } else {
            echo "Error: " . $insert_query . "<br>" . $database_connection->error;
            echo '<script>
                alert("Error al crear el registro.");
                window.location = "/src/index.php";
            </script>';
            die();
        }

        $database_connection->close();
    }
?>