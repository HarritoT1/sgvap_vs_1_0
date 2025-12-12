
@extends('layout')

@section('content')
<div class="w-100 my-3 div-main text-center">
    <h1 class="my-3" style="font-size: 3rem;">Bienvenid@ usuari@ admin:</h1>
    <h2 class="fw-bold my-3" style="font-size: 2rem;">SGVAP (Sistema Web de Gestión de Viáticos y Personal en Proyectos Foráneos).</h2>
    <img src="{{asset('img/icono_sgvap.png')}}" alt="icono_sgvap" class="imageResponsive my-4" style="width: 10rem;">
    <hr class="my-4">
    <h3 class="fw-bold text-center mb-4" style="font-size: 2rem;">
        Sí eres nuevo, te invito a consultar el manual de usuario:
    </h3>
    <iframe class="d-block mx-auto my-3 border border-radius" src="{{asset('img/MANUAL_USUARIO_FINAL.pdf')}}" title="PDF del manual de usuario." loading="lazy" allow="fullscreen" style="width: 60%; min-height: 400px; height: auto;">
        Tu navegador no soporta PDFs. Por favor descarga el PDF para verlo: <a class="text-decoration-none" download="manual_usuario.pdf" href="{{asset('img/MANUAL_USUARIO_FINAL.pdf')}}">Descargar PDF</a>
    </iframe>

    <p style="font-size: 0.8rem;">
        También puedes descargar el PDF para verlo: <a class="text-decoration-none" download="manual_usuario.pdf" href="{{asset('img/MANUAL_USUARIO_FINAL.pdf')}}">Descargar PDF</a>
    </p>

    <h3 class="fw-bold text-center mt-5" style="font-size: 1.2rem;">
        Todos los derechos reservados &copy; 2025 E Core Network S.A de C.V.
    </h3>
</div>
@endsection
