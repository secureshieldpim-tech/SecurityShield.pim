document.addEventListener('DOMContentLoaded', () => {
    // Obtener parámetros de la URL para saber qué plan es
    const params = new URLSearchParams(window.location.search);
    const plan = params.get('plan') || 'Desconocido';
    const precio = params.get('precio') || '0';

    // Mostrar en pantalla qué se está comprando
    const displayElement = document.getElementById('plan-display');
    if(displayElement) {
        displayElement.textContent = `Suscripción: Plan ${plan.toUpperCase()}`;
    }

    const form = document.getElementById('payment-form');
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const btn = document.querySelector('.btn-submit');
        const btnText = document.getElementById('btn-text');
        const spinner = document.getElementById('spinner');

        // Simular carga
        btn.disabled = true;
        btnText.textContent = 'Procesando...';
        spinner.style.display = 'block';

        // Simular espera de 1.5 segundos
        await new Promise(r => setTimeout(r, 1500));

        // Preparar datos para el "Backend"
        const titular = document.querySelector('input[placeholder="Nombre completo"]').value;

        const datosCompra = {
            plan: plan,
            precio: precio,
            titular: titular
        };

        try {
            const respuesta = await fetch('api/procesar_compra.php', { 
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datosCompra)
            });

            const resultado = await respuesta.json();

            if (resultado.estado === 'exito') {
                // Éxito simulado
                btnText.textContent = '¡Pago Aceptado!';
                spinner.style.display = 'none';
                btn.style.background = '#10b981'; // Verde
                btn.style.borderColor = '#10b981';
                
                alert('✅ Transacción completada con éxito.\nEl servicio ha sido activado.');
                
                // Redirigir al inicio
                window.location.href = 'index';
            } else {
                alert('Error en el pago: ' + resultado.mensaje);
            }

        } catch (error) {
            console.error(error);
            alert('Error de conexión con la pasarela.');
        } finally {
            // Restaurar botón si hubo error o para la siguiente
            if (btnText.textContent !== '¡Pago Aceptado!') {
                btn.disabled = false;
                btnText.textContent = 'Pagar y Activar';
                spinner.style.display = 'none';
            }
        }
    });
});