<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Panadería — Sistema de venta</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/stylespro.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- AOS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"/>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body class="home-page">

<!-- 🔹 Navbar -->
<nav class="navbar navbar-expand-md fixed-top animate__animated animate__fadeInDown">
  <div class="container-fluid">
    <div class="row w-100 align-items-center">
      <div class="col-4"></div>

      <div class="col-4 d-flex justify-content-center">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('panel') }}">
          <i class="fa-solid fa-bread-slice text-warning"></i>
          <span class="fw-semibold">Sistema de venta</span>
        </a>
      </div>

      <div class="col-4 d-flex justify-content-end">
        <a href="{{ route('login.index') }}" class="btn btn-primary">Iniciar sesión</a>
      </div>
    </div>
  </div>
</nav>

<!-- 🔹 Carrusel -->
<div id="carouselExample" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ asset('assets/img/pan1.png') }}" class="d-block w-100" alt="Pan recién horneado">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('assets/img/ama.png') }}" class="d-block w-100" alt="Amasado de pan">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('assets/img/horno.png') }}" class="d-block w-100" alt="Bollería y croissants">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>
<!-- 🔹 Acerca del pan / Historia -->
<section class="story-section">
  <div class="container story-wrap">
    <div class="story-text">
      <h2 class="story-title">
        <i class="fa-solid fa-wheat-awn me-2"></i>
        Acerca del pan
      </h2>

      <p class="story-lead">
        El pan ha acompañado a la humanidad desde las primeras civilizaciones.
        Nació cuando los granos molidos se mezclaron con agua y, por
        accidente o curiosidad, se colocaron sobre superficies calientes. Con el
        paso del tiempo, técnicas como la fermentación transformaron su sabor,
        textura y valor nutricional.
      </p>

      <p class="story-lead">
        En las panaderías modernas, tradición y ciencia se encuentran:
        harinas seleccionadas, tiempos de reposo precisos y hornos de
        última generación conviven con recetas heredadas. El resultado es
        un alimento simple pero noble, capaz de reunir familias, contar historias
        y perfumar barrios enteros cada mañana.
      </p>
    </div>

    <div class="story-media">
      <img
        src="{{ asset('assets/img/histo.png') }}"
        alt="Historia del pan"
        class="img-fluid rounded-4 shadow-sm"
      />
    </div>
  </div>
</section>

<!-- 🔹 Zigzag Features -->
<section class="zigzag-section">
  <div class="zigzag-item" data-aos="fade-up">
    <div class="zigzag-text">
      <h3><i class="fa-solid fa-bread-slice"></i> Control total</h3>
      <p>Recetas, lotes horneados y existencias de insumos en un solo lugar.</p>
    </div>
    <div class="zigzag-img">
      <img src="{{ asset('assets/img/De1.jpg') }}" alt="Pan horneado">
    </div>
  </div>

  <div class="zigzag-item" data-aos="fade-up" data-aos-delay="100">
    <div class="zigzag-text">
      <h3><i class="fa-solid fa-truck-fast"></i> Inventario ágil</h3>
      <p>Automatiza pedidos y evita quedarte sin pan fresco en horas pico.</p>
    </div>
    <div class="zigzag-img">
      <img src="{{ asset('assets/img/IZ1.jpg') }}" alt="Amasado de pan">
    </div>
  </div>

  <div class="zigzag-item" data-aos="fade-up" data-aos-delay="200">
    <div class="zigzag-text">
      <h3><i class="fa-solid fa-chart-line"></i> Reportes claros</h3>
      <p>Ventas por tipo de pan, horarios pico y productos estrella.</p>
    </div>
    <div class="zigzag-img">
      <img src="{{ asset('assets/img/De2.jpg') }}" alt="Reportes panadería">
    </div>
  </div>

  <div class="zigzag-item" data-aos="fade-up" data-aos-delay="300">
    <div class="zigzag-text">
      <h3><i class="fa-solid fa-store"></i> Escala fácil</h3>
      <p>Añade nuevas líneas (integral, dulce, sin gluten) y más sucursales.</p>
    </div>
    <div class="zigzag-img">
      <img src="{{ asset('assets/img/pan.jpg') }}" alt="Sucursal panadería">
    </div>
  </div>
</section>

<!-- 🔹 CTA -->
<section class="container-fluid cta-strip text-center">
  <div class="container-fluid p-5 px-3 px-md-5" data-aos="zoom-in">
    <h2 class="mb-5 animate__animated animate__pulse">
      Dale un nuevo aroma a tu panadería
      <span>— hornea mejores decisiones con tecnología</span>
    </h2>
    <a>
      <i class="fa-solid fa-store me-2"></i> 
    </a>
  </div>
</section>

<!-- 🔹 Footer -->
<footer class="text-center text-white">
  <div class="container p-4 pb-0">
    <section class="mb-4 footer-social">
      <a class="btn btn-outline-light btn-floating m-1" href="https://www.instagram.com/sak_arcangel/" target="_blank">
        <i class="fab fa-instagram"></i>
      </a>
      <a class="btn btn-outline-light btn-floating m-1" href="#" target="_blank">
        <i class="fab fa-linkedin"></i>
      </a>
      <a class="btn btn-outline-light btn-floating m-1" href="https://github.com/Saulcal03" target="_blank">
        <i class="fab fa-github"></i>
      </a>
    </section>
  </div>
  <div class="text-center p-3" style="background-color: rgba(50, 50, 50, 0.2);">
    © 2025 Desarrollado por: 
    <a class="text-white" href="https://ollintem.com.mx/" target="_blank">Ollintem</a>
  </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
