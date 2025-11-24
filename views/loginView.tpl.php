@component(head)
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <div class="error-message">{{ ERROR_LOGIN }}</div>
        <form action="?slug=login" method="POST">
            <div class="form-group">
                <label for="txt_email">Email</label>
                <input type="email" id="txt_email" name="txt_email" placeholder="Ingresa tu correo" required>
            </div>
            <div class="form-group">
                <label for="txt_password">Contraseña</label>
                <input type="password" id="txt_password" name="txt_password" placeholder="Ingresa tu contraseña" required>
            </div>
            <center><a href="?slug=recovery">¿Olvidaste tu contraseña?</a></center>
            <input type="submit" id="btn_ingresar" name="btn_ingresar" value="Ingresar">
            <center><p>No estás registrado? <a href="?slug=register">Registrarse</a></p></center>
        </form>
    </div>
</body>
</html>
