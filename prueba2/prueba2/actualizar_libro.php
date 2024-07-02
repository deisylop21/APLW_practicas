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
$id_libro = $conn->real_escape_string($_POST['id_libro']);
$titulo = $conn->real_escape_string($_POST['titulo']);
$fecha_publicacion = $conn->real_escape_string($_POST['fecha_publicacion']);
$id_autor = $conn->real_escape_string($_POST['id_autor']);
$precio = $conn->real_escape_string($_POST['precio']);

// Verificar si el libro existe
$book_check_sql = $conn->prepare("SELECT id_libro FROM libros WHERE id_libro = ?");
$book_check_sql->bind_param("i", $id_libro);
$book_check_sql->execute();
$book_check_result = $book_check_sql->get_result();

if ($book_check_result->num_rows == 0) {
    echo "Error: El libro con ID $id_libro no existe.";
} else {
    // Verificar si el autor existe
    $author_check_sql = $conn->prepare("SELECT id_autor FROM autores WHERE id_autor = ?");
    $author_check_sql->bind_param("i", $id_autor);
    $author_check_sql->execute();
    $author_check_result = $author_check_sql->get_result();

    if ($author_check_result->num_rows == 0) {
        echo "Error: El autor con ID $id_autor no existe.";
    } else {
        // Actualizar datos del libro
        $update_sql = $conn->prepare("UPDATE libros SET titulo = ?, fecha_publicacion = ?, id_autor = ?, precio = ? WHERE id_libro = ?");
        $update_sql->bind_param("ssidi", $titulo, $fecha_publicacion, $id_autor, $precio, $id_libro);

        if ($update_sql->execute() === TRUE) {
            echo "Libro actualizado exitosamente.";
        } else {
            echo "Error: " . $update_sql->error;
        }
    }
}

$conn->close();
?>
