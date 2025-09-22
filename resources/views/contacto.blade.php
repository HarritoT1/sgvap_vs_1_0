
@extends('layout')

@section('content')
<div class="w-100 my-3 div-main">
    <h2 class="fw-bold my-3" style="font-size: 2rem;">Información del desarrollador:</h2>
    <div class="w-100 div-secondary">
        <img src="../img/icono_sgvap.png" alt="icono_sgvap" class="imageResponsive my-3" style="width: 10rem;">
        <hr class="my-4">
        <ul class="flex-column vineta fw-bold" style="font-size: 1.5rem; text-align: justify;">
            <li>
                Instituto de procedencia: Instituto Tecnológico de Tláhuac.
            </li>
            <li>
                Correo electrónico:
                <a href="mailto:haroldgaelcardenastrejo@gmail.com"
                    class="text-decoration-none">haroldgaelcardenastrejo@gmail.com</a>
            </li>
            <li>
                Número de contacto: 55 8837 4683.
            </li>
            <li>
                Desarrollador: Ing. Harol Gael Cardenas Trejo.
            </li>
        </ul>
        <br>
        <br>
        <h3 class="fw-bold text-center" style="font-size: 1.2rem;">
            Todos los derechos reservados &copy; 2025 E Core Network S.A de C.V.
        </h3>
    </div>
</div>
@endsection
