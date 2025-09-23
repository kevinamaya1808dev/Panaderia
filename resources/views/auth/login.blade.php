<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sistema de ventas — Login</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

  <!-- CSS personalizado -->
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
  <main class="login-wrapper">
    <!-- Columna izquierda: formulario -->
    <div class="login-col form-side">
      <div class="login-card">
        <h2 class="login-title">
          <i class="fa-solid fa-bread-slice me-2"></i> Acceso al sistema
        </h2>

        <!-- 🔒 Formulario de login -->
        <form id="loginForm" action="{{ route('login.login') }}" method="POST" novalidate autocomplete="off">
          @csrf

          <!-- Email -->
          <div class="field">
            <label for="email">Correo electrónico</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Correo electrónico"
              value=""
              autocomplete="off"
              autocapitalize="none"
              autocorrect="off"
              spellcheck="false"
              inputmode="email"
            />
            <small id="emailError" class="hint error" style="display:none">
              El correo debe contener @ y un dominio válido.
            </small>
          </div>

          <!-- Password -->
          <div class="field">
            <label for="password">Contraseña</label>
            <div class="password-wrap">
              <input
                type="password"
                id="password"
                name="password"
                placeholder="••••••••"
                value=""
                autocomplete="new-password"
                autocapitalize="none"
                autocorrect="off"
                spellcheck="false"
              />
              <button type="button" id="togglePassword" class="eye" aria-label="Mostrar/ocultar contraseña">
                <i class="fa-solid fa-eye"></i>
              </button>
            </div>
            <small id="passwordError" class="hint error" style="display:none">
              La contraseña debe tener al menos 6 caracteres.
            </small>
          </div>

          <!-- Botones -->
          <div class="actions">
            <button type="submit" class="btn btn-primary">
              <i class="fa-solid fa-right-to-bracket me-2"></i> Iniciar sesión
            </button>
            <a class="btn btn-secondary" href="{{ route('welcome') }}">
              <i class="fa-solid fa-house me-2"></i> Ir a inicio
            </a>
          </div>
        </form>
      </div>
    </div>

    <!-- Columna derecha: imagen -->
    <div class="login-col image-side"></div>
  </main>

  <script>
    // 👁️ Mostrar/Ocultar contraseña
    const toggle = document.getElementById('togglePassword');
    const pass   = document.getElementById('password');
    toggle.addEventListener('click', () => {
      const type = pass.type === 'password' ? 'text' : 'password';
      pass.type = type;
      toggle.innerHTML = type === 'password'
        ? '<i class="fa-solid fa-eye"></i>'
        : '<i class="fa-solid fa-eye-slash"></i>';
    });

    // ✅ Validaciones en vivo
    const email       = document.getElementById('email');
    const emailError  = document.getElementById('emailError');
    const passError   = document.getElementById('passwordError');
    const emailRegex  = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    email.addEventListener('input', () => {
      emailError.style.display = emailRegex.test(email.value) ? 'none' : 'block';
    });

    pass.addEventListener('input', () => {
      passError.style.display = pass.value.length >= 6 ? 'none' : 'block';
    });

    // ⛔️ Evita envío si hay errores
    document.getElementById('loginForm').addEventListener('submit', (e) => {
      const okEmail = emailRegex.test(email.value);
      const okPass  = pass.value.length >= 6;

      emailError.style.display = okEmail ? 'none' : 'block';
      passError.style.display  = okPass  ? 'none' : 'block';

      if (!okEmail || !okPass) e.preventDefault();
    });
  </script>
</body>
</html>
