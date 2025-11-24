@component(head)
<body>
    <div class="login-container">
        <h2>Regitrarse</h2>
        <div class="error-message">{{ ERROR_REGISTER }}</div>
        <form action="?slug=register" method="POST">
            <div class="form-group">
                <div class="input-group">
                    <label for="txt_name">Nombre</label>
                    <input type="text" id="txt_name" name="txt_name" placeholder="Ingresa tu nombre" required>
                </div>
            </div>
            <div class="form-group">
                <label for="txt_email">Email</label>
                <input type="email" id="txt_email" name="txt_email" placeholder="Ingresa tu correo" required>
            </div>
            <div class="form-group">
                <label for="txt_password">Contraseña</label>
                <input type="password" id="txt_password" name="txt_password" placeholder="Ingresa tu contraseña" required>
            </div>
            <div class="form-group">
                <label for="txt_password">Repetir contraseña</label>
                <input type="password" id="txt_password" name="txt_password-repete" placeholder="Repeti tu contraseña" required>
            </div>
            <input type="submit" id="btn_registrar" name="btn_registrar" value="Registrarse">
            <center><p>Ya tenes una cuenta? <a href="?slug=login">Login</a></p></center>
        </form>
    </div>
</body>