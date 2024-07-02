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

// Obtener el ID del autor del formulario
$id_autor = $conn->real_escape_string($_POST['id_autor']);

// Verificar si el autor existe y si tiene libros asociados
$author_check_sql = $conn->prepare("SELECT id_autor FROM autores WHERE id_autor = ?");
$author_check_sql->bind_param("i", $id_autor);
$author_check_sql->execute();
$author_check_result = $author_check_sql->get_result();

if ($author_check_result->num_rows == 0) {
    echo "Error: El autor con ID $id_autor no existe.";
} else {
    // Verificar si el autor tiene libros asociados
    $books_check_sql = $conn->prepare("SELECT id_libro FROM libros WHERE id_autor = ?");
    $books_check_sql->bind_param("i", $id_autor);
    $books_check_sql->execute();
    $books_check_result = $books_check_sql->get_result();

    if ($books_check_result->num_rows > 0) {
        echo "Error: No se puede eliminar el autor con ID $id_autor porque tiene libros asociados.";
    } else {
        // Eliminar el autor
        $delete_sql = $conn->prepare("DELETE FROM autores WHERE id_autor = ?");
        $delete_sql->bind_param("i", $id_autor);

        if ($delete_sql->execute() === TRUE) {
            echo "Autor eliminado exitosamente.";
        } else {
            echo "Error: " . $delete_sql->error;
        }
    }
}

$conn->close();
?>
