<?php
echo '
<div style="max-width: 600px; margin: 0 auto; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif; background: #ffffff;">
    <div style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); padding: 2.5rem; text-align: center;">
        <h1 style="margin: 0; color: #ffffff; font-size: 1.75rem; font-weight: 300; letter-spacing: -0.02em;">ClimaLink</h1>
    </div>
    
    <div style="padding: 2.5rem 2rem;">
        <h2 style="margin: 0 0 1.25rem 0; color: #dc2626; font-size: 1.5rem; font-weight: 400;">Tu cuenta ha sido bloqueada</h2>
        <p style="margin: 0 0 1.5rem 0; color: #475569; font-size: 1rem; line-height: 1.6;">Tu cuenta de ClimaLink ha sido bloqueada por motivos de seguridad o incumplimiento de nuestras políticas de uso.</p>
        
        <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 0.375rem; padding: 1.25rem; margin-bottom: 1.5rem;">
            <p style="margin: 0 0 0.75rem 0; color: #991b1b; font-size: 0.875rem; font-weight: 600;">Estado de la cuenta:</p>
            <p style="margin: 0; color: #7f1d1d; font-size: 0.875rem;">🔒 Bloqueada</p>
        </div>
        
        <p style="margin: 0 0 1rem 0; color: #475569; font-size: 1rem; line-height: 1.6;">Ya no podrás acceder a tu cuenta ni utilizar los servicios de ClimaLink.</p>
        
        <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; border-radius: 0.25rem;">
            <p style="margin: 0; color: #1e40af; font-size: 0.875rem;"><strong>¿Creés que esto es un error?</strong> No lo es. Click <a href='.htmlspecialchars($link).'>aquí</a> para cambiar contraseña</p>
        </div>
    </div>
    
    <div style="padding: 1.5rem; text-align: center; background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
        <p style="margin: 0; color: #94a3b8; font-size: 0.875rem;">ClimaLink - App que muestra datos del clima en tiempo real</p>
    </div>
</div>
';
?>