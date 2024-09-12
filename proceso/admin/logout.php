<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <script type="text/javascript">
        // Redireccionar a login.php después de cerrar la sesión
        window.location.href = 'login.php';
    </script>
</head>
<body>
  
</body>
</html>
