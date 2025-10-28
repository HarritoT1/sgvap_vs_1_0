<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 - SGVAP</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/icono_sgvap.ico') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles_sgvap.css') }}" />

    <style>
        /* Estilo base del botón */
        a.button-custom {
            font-weight: bold !important;
            color: white !important;
            width: 95% !important;
            margin: 10px auto;
            border: none !important;
            padding: 12px 20px;
            border-radius: 8px !important;
            text-align: center !important;
            cursor: pointer !important;
            transition: transform 0.2s ease-in-out, background 0.2s ease-in-out !important;
        }

        /* Brillo solo en hover */
        a.button-custom:hover {
            animation: glow 1.5s infinite alternate;
            transform: scale(1.05);
        }

        /* Efecto al hacer clic */
        a.button-custom:active {
            background: #217dbb !important;
            /* un azul más oscuro */
            transform: scale(0.95);
            /* se encoge un poco */
            box-shadow: 0 0 5px #217dbb, 0 0 15px #217dbb inset;
            /* brilla pero hacia adentro */
        }

        /* Animación de brillo */
        @keyframes glow {
            0% {
                box-shadow: 0 0 5px #3498db, 0 0 10px #3498db;
            }

            100% {
                box-shadow: 0 0 20px #3498db, 0 0 40px #3498db;
            }
        }

    </style>
</head>

<body>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <h1 class="display-1 fw-bold">404</h1>
            <p class="fs-3"> <span class="text-danger">Opps!</span> Recurso no encontrado.</p>
            <p class="lead">
                La página que estás buscando no existe.
            </p>
            <a href="{{ route('login.index') }}" class="btn btn-primary button-custom mt-2">Ir al login</a>
            <img src="{{ asset('img/404.gif') }}" alt="404 Error" class="imageResponsive mt-4" style="width: 10rem;">
        </div>
    </div>
</body>

</html>
