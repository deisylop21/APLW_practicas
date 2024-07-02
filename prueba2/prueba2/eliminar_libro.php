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

// Obtener el ID del libro del formulario
$id_libro = $conn->real_escape_string($_POST['id_libro']);

// Verificar si el libro existe
$book_check_sql = $conn->prepare("SELECT id_libro FROM libros WHERE id_libro = ?");
$book_check_sql->bind_param("i", $id_libro);
$book_check_sql->execute();
$book_check_result = $book_check_sql->get_result();

if ($book_check_result->num_rows == 0) {
    echo "Error: El libro con ID $id_libro no existe.";
} else {
    // Eliminar el libro
    $delete_sql = $conn->prepare("DELETE FROM libros WHERE id_libro = ?");
    $delete_sql->bind_param("i", $id_libro);

    if ($delete_sql->execute() === TRUE) {
        echo "Libro eliminado exitosamente.";
    } else {
        echo "Error: " . $delete_sql->error;
    }
}

$conn->close();
?>
