<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblo";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener datos del formulario
$id_autor = $conn->real_escape_string($_POST['id_autor']);
$nombre = $conn->real_escape_string($_POST['nombre']);
$apellido = $conn->real_escape_string($_POST['apellido']);
$fecha_nacimiento = $conn->real_escape_string($_POST['fecha_nacimiento']);

// Verificar si el autor existe
$author_check_sql = $conn->prepare("SELECT id_autor FROM autores WHERE id_autor = ?");
$author_check_sql->bind_param("i", $id_autor);
$author_check_sql->execute();
$author_check_result = $author_check_sql->get_result();

if ($author_check_result->num_rows == 0) {
    echo "Error: El autor con ID $id_autor no existe.";
} else {
    // Actualizar datos del autor
    $update_sql = $conn->prepare("UPDATE autores SET nombre = ?, apellido = ?, fecha_nacimiento = ? WHERE id_autor = ?");
    $update_sql->bind_param("sssi", $nombre, $apellido, $fecha_nacimiento, $id_autor);

    if ($update_sql->execute() === TRUE) {
        echo "Autor actualizado exitosamente.";
    } else {
        echo "Error: " . $update_sql->error;
    }
}

$conn->close();
?>
