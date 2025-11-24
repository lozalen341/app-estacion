<?php
echo '
    <div style="max-width: 600px; margin: 0 auto; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif; background: #ffffff;">
        <div style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); padding: 2.5rem; text-align: center;">
            <h1 style="margin: 0; color: #ffffff; font-size: 1.75rem; font-weight: 300; letter-spacing: -0.02em;">ClimaLink</h1>
        </div>
        
        <div style="padding: 2.5rem 2rem;">
            <h2 style="margin: 0 0 1.25rem 0; color: #1e293b; font-size: 1.5rem; font-weight: 400;">Tu contraseña se restablecio correctamente</h2>
            <p style="margin: 0 0 1.5rem 0; color: #475569; font-size: 1rem; line-height: 1.6;">Se cambio con los siguientes detalles:</p>
            
            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.375rem; padding: 1.25rem; margin-bottom: 1.5rem;">
                <div style="margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #e2e8f0;">
                    <span style="color: #64748b; font-size: 0.875rem; font-weight: 500;">Dirección IP:</span>
                    <span style="color: #1e293b; font-size: 0.875rem; font-weight: 500; float: right;">'.htmlspecialchars($ip).'</span>
                </div>
                <div>
                    <span style="color: #64748b; font-size: 0.875rem; font-weight: 500;">Sistema:</span>
                    <span style="color: #1e293b; font-size: 0.875rem; font-weight: 500; float: right;">'.htmlspecialchars($info).'</span>
                </div>
            </div>
            
            <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 1rem; border-radius: 0.25rem;">
                <p style="margin: 0; color: #92400e; font-size: 0.875rem;"><strong>¿No fuiste vos?</strong> Si no reconocés esta actividad, presiona aca: <a href='.htmlspecialchars($link).'>Bloquear cuenta</a></p>
            </div>
        </div>
        
        <div style="padding: 1.5rem; text-align: center; background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0; color: #94a3b8; font-size: 0.875rem;">ClimaLink - App que muestra datos del clima en tiempo real</p>
        </div>
    </div>
';
?>