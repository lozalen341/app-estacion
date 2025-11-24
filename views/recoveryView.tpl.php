@component(head)
<body>
  <div class="login-container">
    <h2>Recuperar Contraseña</h2>
    
    <form method="POST" action="?slug=recovery">
      <div class="info-message">{{ INFO_RECOVERY }}</div>
      <div class="error-message">{{ ERROR_RECOVERY }}</div>
      <div class="success-message">{{ SUCCESS_RECOVERY }}</div>

      <div class="form-group">
        <label for="email">Email</label>
        <input 
          type="email" 
          id="email" 
          name="email" 
          placeholder="tu@email.com" 
          required
          autocomplete="email"
        >
      </div>

      <input type="submit" name="btn_ingresar" value="Enviar enlace de recuperación">

      <center>
        <p>
          ¿Recordaste tu contraseña? 
          <a href="?slug=login">Iniciar sesión</a>
        </p>
      </center>
    </form>
  </div>
</body>
</html>