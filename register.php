<?php
session_start();
require_once('config.php');

if (isset($_POST['submit'])) {
    if (isset($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['password']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $firstName = trim($_POST['nombre']);
        $lastName = trim($_POST['apellido']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $hashPassword = $password;
        $options = array("cost" => 4);
        $hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);
        $date = date('Y-m-d H:i:s');

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sql = 'select * from users where email = :email';
            $stmt = $pdo->prepare($sql);
            $p = ['email' => $email];
            $stmt->execute($p);

            if ($stmt->rowCount() == 0) {
                $sql = "insert into users (nombre, apellido, email, `password`, created_at,updated_at) values(:vnombre,:vapellido,:email,:pass,:created_at,:updated_at)";

                try {
                    $handle = $pdo->prepare($sql);
                    $params = [
                        ':vnombre' => $firstName,
                        ':vapellido' => $lastName,
                        ':email' => $email,
                        ':pass' => $hashPassword,
                        ':created_at' => $date,
                        ':updated_at' => $date
                    ];

                    $handle->execute($params);

                    $success = 'Usuario creado correctamente!!';
                } catch (PDOException $e) {
                    $errors[] = $e->getMessage();
                }
            } else {
                $valFirstName = $firstName;
                $valLastName = $lastName;
                $valEmail = '';
                $valPassword = $password;

                $errors[] = 'el Email ya esta registrado';
            }
        } else {
            $errors[] = "el Email no es valido";
        }
    } else {
        if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
            $errors[] = 'el nombre es requerido';
        } else {
            $valFirstName = $_POST['apellido'];
        }
        if (!isset($_POST['apellido']) || empty($_POST['apellido'])) {
            $errors[] = 'el apellido es requerido';
        } else {
            $valLastName = $_POST['apellido'];
        }

        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $errors[] = 'Email es requerido';
        } else {
            $valEmail = $_POST['email'];
        }

        if (!isset($_POST['password']) || empty($_POST['password'])) {
            $errors[] = 'el Password es requerido';
        } else {
            $valPassword = $_POST['password'];
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Page Title - SB Admin</title>

    <!-- CSS -->
    <link href="src/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="src/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="src/css/estilos.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Registrese</h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (isset($errors) && count($errors) > 0) {
                                        foreach ($errors as $error_msg) {
                                            echo '<div class="alert alert-danger">' . $error_msg . '</div>';
                                        }
                                    }

                                    if (isset($success)) {

                                        echo '<div class="alert alert-success">' . $success . '</div>';
                                    }
                                    ?>
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputFirstName">Nombre</label>
                                                    <input class="form-control py-4" name="nombre" id="inputFirstName" type="text" placeholder="Enter first name" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputLastName">Apellido</label>
                                                    <input class="form-control py-4" name="apellido" id="inputLastName" type="text" placeholder="Enter last name" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress">Email</label>
                                            <input class="form-control py-4" name="email" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Enter email address" />
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputPassword">Password</label>
                                                    <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Enter password" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputConfirmPassword">Confirme el Password</label>
                                                    <input class="form-control py-4" name="repassword" id="inputConfirmPassword" type="password" placeholder="Confirm password" />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary">Registrarse</button>

                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="login.php">¿Tener una cuenta? Ir a iniciar sesión</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2021</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="src/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <script src="src/js/scripts.js"></script>
</body>

</html>