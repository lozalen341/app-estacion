@component(head)
<body>
  <div class="login-container">
    <h2>Restablecer Contraseña</h2>
    
    <form method="POST" action="?slug=reset&token_action={{ TOKEN_ACTION }}">

      <input type="hidden" name="token_action" value="{{ TOKEN_ACTION }}">

      <div class="info-message">
        Ingresá tu nueva contraseña. Debe tener al menos 8 caracteres.
      </div>

      <div class="error-message" id="error-message">
        {{ RESET_MESSAGE }}
      </div>

      <div class="form-group">
        <label for="password">Nueva contraseña</label>
        <input 
          type="password" 
          id="password" 
          name="password" 
          placeholder="Mínimo 8 caracteres" 
          required
          autocomplete="new-password"
        >
      </div>

      <div class="form-group">
        <label for="confirm-password">Repetir contraseña</label>
        <input 
          type="password" 
          id="confirm-password" 
          name="confirm_password" 
          placeholder="Ingresá la misma contraseña" 
          required
          autocomplete="new-password"
        >
      </div>

      <input type="submit" value="Restablecer contraseña">

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