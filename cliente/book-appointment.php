<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
</head>
<body>
    <form>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>
        <label for="telefono">Número de Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" pattern="[0-9]{10}" required>
        <small>Formato: 1234567890</small>
        <br><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>