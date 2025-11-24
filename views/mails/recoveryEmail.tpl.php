<?php
echo'
<div style="max-width: 600px; margin: 0 auto; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif; background: #ffffff;">
    <div style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); padding: 2.5rem; text-align: center;">
        <h1 style="margin: 0; color: #ffffff; font-size: 1.75rem; font-weight: 300; letter-spacing: -0.02em;">ClimaLink</h1>
    </div>
    
    <div style="padding: 2.5rem 2rem;">
        <h2 style="margin: 0 0 1.25rem 0; color: #1e293b; font-size: 1.5rem; font-weight: 400;">Restablecimiento de contraseña</h2>
        <p style="margin: 0 0 1rem 0; color: #475569; font-size: 1rem; line-height: 1.6;">Recibimos una solicitud para restablecer la contraseña de tu cuenta en ClimaLink.</p>
        
        <p style="margin: 0 0 1.5rem 0; color: #475569; font-size: 1rem; line-height: 1.6;">Hacé clic en el siguiente botón para crear una nueva contraseña:</p>
        
        <div style="margin: 1.5rem 0;">
            <a href='.htmlspecialchars($link).' style="display: inline-block; padding: 0.875rem 2rem; background-color: #1e293b; color: #ffffff; text-decoration: none; border-radius: 0.375rem; font-size: 1rem; font-weight: 500;">Click aquí para restablecer contraseña</a>
        </div>
        
        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0 0 0.5rem 0; color: #64748b; font-size: 0.875rem;">Si no solicitaste este cambio, podés ignorar este mensaje de forma segura.</p>
            <p style="margin: 0; color: #64748b; font-size: 0.875rem;">Este enlace expirará en 24 horas por razones de seguridad.</p>
        </div>
    </div>
    
    <div style="padding: 1.5rem; text-align: center; background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
        <p style="margin: 0; color: #94a3b8; font-size: 0.875rem;">ClimaLink - App que muestra datos del clima en tiempo real</p>
    </div>
</div>
';
?>