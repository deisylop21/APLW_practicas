<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros</title>
</head>
<body>
    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "biblo";


    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }


    $sql = "SELECT id_libro, titulo, fecha_publicacion, precio FROM libros GROUP BY id_libro";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
    
        echo "<h2>Lista de libros</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Título</th><th>Fecha de publicación</th><th>Precio</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_libro"] . "</td>";
            echo "<td>" . $row["titulo"] . "</td>";
            echo "<td>" . $row["fecha_publicacion"] . "</td>";
            echo "<td>" . $row["precio"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron autores.";
    }

    // Cerrar conexión
    $conn->close();
    ?>

</body>
</html>