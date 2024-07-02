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
$titulo = $conn->real_escape_string($_POST['titulo']);
$fecha_publicacion = $conn->real_escape_string($_POST['fecha_publicacion']);
$id_autor = $conn->real_escape_string($_POST['id_autor']);
$precio = $conn->real_escape_string($_POST['precio']);

// Verificar si el autor existe
$author_check_sql = "SELECT id_autor FROM autores WHERE id_autor = '$id_autor'";
$author_check_result = $conn->query($author_check_sql);

if ($author_check_result->num_rows == 0) {
    echo "Error: El autor con ID $id_autor no existe.";
} else {
    // Insertar datos en la tabla 'libros'
    $sql = "INSERT INTO libros (titulo, fecha_publicacion, id_autor, precio) VALUES ('$titulo', '$fecha_publicacion', '$id_autor', '$precio')";

    if ($conn->query($sql) === TRUE) {
        echo "Nuevo libro creado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close
?>