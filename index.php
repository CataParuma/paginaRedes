<?php
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create"])) {

        //si nombre, edad y cargo no están vacíos
        if (!empty($_POST["nombre"]) && !empty($_POST["edad"]) && !empty($_POST["cargo"])) {
            createStudent($_POST["nombre"], $_POST["edad"], $_POST["cargo"]);
        } else {
            //imprimir alerta
            echo "<script>alert('Nombre, edad y cargo son requeridos');</script>";
        }

    } elseif (isset($_POST["update"])) {

        //si id, nombre, edad y cargo no están vacíos
        if (!empty($_POST["id"]) && !empty($_POST["nombre"]) && !empty($_POST["edad"]) && !empty($_POST["cargo"])) {
            updateStudent($_POST["id"], $_POST["nombre"], $_POST["edad"], $_POST["cargo"]);
        } else {
            //imprimir alerta
            echo "<script>alert('ID, nombre, edad y cargo son requeridos');</script>";
        }

    } elseif (isset($_POST["delete"])) {

        //si id no está vacío
        if (!empty($_POST["id"])) {
            deleteStudent($_POST["id"]);
        } else {
            //imprimir alerta
            echo "<script>alert('ID es requerido');</script>";
        }
    }
}

$students = getStudents();
?>

<!DOCTYPE html>
<html>

<head>
    <title>CRUD</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .navbar-nav .nav-item.active .nav-link {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <i class="fa fa-cogs"></i> Administración
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">
                        <i class="fa fa-users"></i> Administrar Empleados
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fa fa-calendar"></i> Agenda actualizada
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fa fa-shopping-cart"></i> Compras
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container my-5">
        <div class="text-center mb-4">
            <h1>¡Bienvenidos!</h1>
            <p class="lead">Aquí puedes gestionar los empleados de la empresa</p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h4 class="card-title">Agregar Empleado</h4>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label>Nombre:</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Edad:</label>
                                <input type="number" name="edad" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Cargo:</label>
                                <input type="text" name="cargo" class="form-control" required>
                            </div>
                            <button type="submit" name="create" class="btn btn-success">
                                <i class="fa fa-plus"></i> Agregar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title">Actualizar Empleado</h4>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label>ID:</label>
                                <input type="number" name="id" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Nombre:</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Edad:</label>
                                <input type="number" name="edad" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Cargo:</label>
                                <input type="text" name="cargo" class="form-control" required>
                            </div>
                            <button type="submit" name="update" class="btn btn-primary">
                                <i class="fa fa-pencil"></i> Actualizar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h4 class="card-title">Eliminar Empleado</h4>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label>ID:</label>
                                <input type="number" name="id" class="form-control" required>
                            </div>
                            <button type="submit" name="delete" class="btn btn-danger">
                                <i class="fa fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-dark text-white">
                <h4 class="card-title">Lista de Empleados</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Cargo</th> <!-- Nuevo campo -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo $student["id"]; ?></td>
                                <td><?php echo $student["nombre"]; ?></td>
                                <td><?php echo $student["edad"]; ?></td>
                                <td><?php echo $student["cargo"]; ?></td> <!-- Nuevo campo -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>