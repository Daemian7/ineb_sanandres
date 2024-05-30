<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Iniciar Sesion</title>
</head>
<body >
    <section class="ezy__signin3 light d-flex align-items-center"
        style="background-image: url('../images/barber.jpg')">
        <div class="container">
            <div class="row py-5">
                <div class="col-lg-5">
                    <div class="card ezy__signin3-form-card">
                        <div class="card-body p-md-5">
                            <h2 class="ezy__signin3-heading mb-4 mb-md-5">Iniciar Sesion</h2>
                            <form method="post" action="controlador.php">
                                <div class="form-group mb-md-5 mt-2">
                                    <label class="mb-3">Codigo</label>
                                    <input type="password" class="form-control" id="code"
                                        placeholder="Ingrese su codigo unico" name="code" />
                                </div>
                                <button type="submit" class="btn ezy__signin3-btn-submit w-100"
                                    name="btnlogin">Iniciar</button>
                                    <br>
                                    <br>
                                    <a href="../../index.html">Volver al inicio</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        </div>
        <br>
        <br>
        <br>
        
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
