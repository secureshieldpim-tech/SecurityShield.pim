document.addEventListener('DOMContentLoaded', () => {
    // --- PARTE 1: Lógica Visual (Tu bloque original) ---
    // Obtener parámetros de la URL para saber qué plan es
    const params = new URLSearchParams(window.location.search);
    const plan = params.get('plan') || 'Desconocido';
    const precio = params.get('precio') || '0';

    // Mostrar en pantalla qué se está comprando
    const displayElement = document.getElementById('plan-display');
    if (displayElement) {
        displayElement.textContent = `Suscripción: Plan ${plan.toUpperCase()}`;
        // Si tienes un elemento para el precio, también puedes actualizarlo:
        const priceElement = document.querySelector('.plan-price');
        if (priceElement) priceElement.textContent = `${precio}€`;
    }

    // --- PARTE 2: Lógica del Modal Técnico y Pago ---

    // Elementos del Modal
    const modal = document.getElementById('techInfoModal');
    const payButton = document.getElementById('pay-button'); // El botón "Pagar y Activar" original
    const techForm = document.getElementById('techForm');

    // 1. Interceptar el clic en "Pagar y Activar"
    if (payButton) {
        payButton.addEventListener('click', function (e) {
            e.preventDefault(); // Evita que el formulario original se envíe solo
            // Abrir el modal para pedir datos técnicos
            if (modal) modal.style.display = 'flex';
        });
    }

    // 2. Función global para cerrar el modal (usada por el botón Cancelar)
    window.closeTechModal = function () {
        if (modal) modal.style.display = 'none';
    }

    // 3. Manejar el envío del formulario del MODAL (Aquí ocurre el pago real)
    if (techForm) {
        techForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const submitBtn = document.querySelector('.btn-confirm');
            const originalText = submitBtn.textContent;

            // Simular carga
            submitBtn.textContent = 'Procesando...';
            submitBtn.disabled = true;

            // Simular espera de 1.5 segundos (efecto visual)
            await new Promise(r => setTimeout(r, 1500));

            // Recopilar TODOS los datos (Técnicos + Compra)
            const purchaseData = {
                // Datos del formulario modal
                nombre: document.getElementById('clientName').value,
                os: document.getElementById('clientOS').value,
                arquitectura: document.getElementById('clientArch').value,
                email: document.getElementById('clientEmail').value,

                // Datos del plan (de la URL)
                plan: plan,
                precio: precio,
                fecha: new Date().toISOString()
            };

            try {
                // Enviar al Backend (PHP)
                const respuesta = await fetch('api/procesar_compra.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(purchaseData)
                });

                const resultado = await respuesta.json();

                if (resultado.success || resultado.estado === 'exito') {
                    // Éxito
                    alert('✅ ¡Compra realizada con éxito!\n\nTe hemos enviado los scripts de instalación para ' + purchaseData.os + ' a tu correo: ' + purchaseData.email);
                    window.location.href = 'perfil.php'; // Redirigir al panel del cliente
                } else {
                    alert('Error al procesar: ' + (resultado.message || resultado.mensaje));
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Ocurrió un error de conexión con el servidor.');
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    }
});