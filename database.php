<?php
$mysqli = new mysqli('localhost', 'root', 'pass', 'base de datos');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Create
function createStudent($nombre, $edad, $cargo) {
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO alumnos (nombre, edad, cargo) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nombre, $edad, $cargo);
    $stmt->execute();
    $stmt->close();
}

// Read
function getStudents() {
    global $mysqli;
    $result = $mysqli->query("SELECT id, nombre, edad, cargo FROM alumnos");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getStudent($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT id, nombre, edad, cargo FROM alumnos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Update
function updateStudent($id, $nombre, $edad, $cargo) {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE alumnos SET nombre = ?, edad = ?, cargo = ? WHERE id = ?");
    $stmt->bind_param("sisi", $nombre, $edad, $cargo, $id);
    $stmt->execute();
    $stmt->close();
}

// Delete
function deleteStudent($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM alumnos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
?>
