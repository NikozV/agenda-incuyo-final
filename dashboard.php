<?php 
    session_start();
  
    if(!$_SESSION['id']){
        header('location:login.php');
    }
 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="">
    <title>Agenda - INCuyo</title>
    <!-- CSS -->
    <link rel="stylesheet" href="src/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="src/css/estilos.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <!-- datatables CSS -->
    <link rel="stylesheet" type="text/css" href="src/DataTables/datatables.min.css" />
    <!-- <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> -->
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Agenda</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>

                <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                Redes Sociales
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Linkedin</a>
                <a class="dropdown-item" href="#">Facebook</a>
                <a class="dropdown-item" href="#">Twitter</a>
                </div>
            </li> -->

            </ul>
            <!-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="buscar" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
            </form> -->
        </div>
    </nav>

    <div class="container">

        <h1 class="text-center"> Agenda de contactos </h1>
        <div class="row">
            <div class="col-sm-12">

                <a href="#addNew" class="btn btn-primary" data-toggle="modal" style="margin-bottom: 8px;"> <span class="fa fa-plus"></span> Nuevo</a>

                <?php
                session_start();
                if (isset($_SESSION['message'])) {
                ?>
                    <div class="alert alert-dismissible alert-success" style="margin-top: 20px;">
                        <button type="button" class="close" data-dismiss="alert">
                            &times;
                        </button>
                        <?php echo $_SESSION['message']; ?>
                    </div>
                <?php
                    unset($_SESSION['message']);
                }
                ?>

                <table class="table table-bordered table-striped" id="myTable" style="margin-top:20px;">
                    <thead>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>CELULAR</th>
                        <th>CORREO</th>
                        <th>DIRECCION</th>
                        <th>ACCIONES</th>
                    <tbody>

                        <?php
                        /* Mostrar datos en la tabla */
                        include_once('conexion.php');
                        $database = new ConectarDB();
                        $db = $database->open();
                        try {
                            $sql = 'SELECT * FROM personas';
                            foreach ($db->query($sql) as $row) {
                        ?>
                                <tr>
                                    <td><?php echo $row['idPersona']; ?></td>
                                    <td><?php echo $row['Nombre']; ?></td>
                                    <td><?php echo $row['Telefono']; ?></td>
                                    <td><?php echo $row['Correo']; ?></td>
                                    <td><?php echo $row['Direccion']; ?></td>
                                    <td> <a href="#edit_<?php echo $row['idPersona']; ?>" class="btn btn-success btn-sm" data-toggle="modal"> <span class="fa fa-edit"></span> Editar </a>
                                        <a href="#delete_<?php echo $row['idPersona']; ?>" class="btn btn-danger btn-sm" data-toggle="modal"> <span class="fa fa-trash"></span> Eliminar </a>
                                    </td>
                                    <?php include('editarEliminarModal.php'); ?>
                                </tr>
                        <?php

                            }
                        } catch (PDOException $e) {
                            echo 'Error de conexion: ' . $e->getMessage();
                        }
                        $database->close();
                        ?>

                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Llamo a addModal.php -->
    <?php include('addModal.php'); ?>

</body>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="src/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
<!-- datatables JS -->
<script type="text/javascript" src="src/DataTables/datatables.min.js"></script>
<!-- <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> -->
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
<script>
    var table = $('#myTable').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
    });
</script>

</html>