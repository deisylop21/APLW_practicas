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
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];

// Insertar datos en la tabla 'autores'
$sql = "INSERT INTO autores (nombre, apellido, fecha_nacimiento) VALUES ('$nombre', '$apellido', '$fecha_nacimiento')";

if ($conn->query($sql) === TRUE) {
    echo "Nuevo autor creado exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
