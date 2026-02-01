document.addEventListener('DOMContentLoaded', async () => {


    const emailInput = document.getElementById('clientEmail');
    if (emailInput) {
        try {
            const response = await fetch('/api/check_session.php');
            const data = await response.json();

            if (data.logged_in && data.email) {
                emailInput.value = data.email;
            } else {
                console.warn('No se pudo recuperar el email de la sesión.');
            }
        } catch (error) {
            console.error('Error recuperando email de sesión:', error);
        }
    }


    const params = new URLSearchParams(window.location.search);
    const plan = params.get('plan') || 'Desconocido';
    const precio = params.get('precio') || '0';

    const displayElement = document.getElementById('plan-display');
    if (displayElement) {
        displayElement.textContent = `Suscripción: Plan ${plan.toUpperCase()}`;
        const priceElement = document.querySelector('.plan-price');
        if (priceElement) priceElement.textContent = `${precio}€`;
    }



    const modal = document.getElementById('techInfoModal');
    const payButton = document.getElementById('pay-button');
    const techForm = document.getElementById('techForm');


    if (payButton) {
        payButton.addEventListener('click', function (e) {
            e.preventDefault();
            if (modal) {

                modal.style.display = 'flex';


                setTimeout(() => {
                    modal.classList.add('active');
                }, 10);
            }
        });
    }


    window.closeTechModal = function () {
        if (modal) {

            modal.classList.remove('active');


            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
    }


    if (techForm) {
        techForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const submitBtn = document.querySelector('.btn-confirm');
            const originalText = submitBtn.innerHTML;


            submitBtn.textContent = 'Procesando...';
            submitBtn.disabled = true;

            await new Promise(r => setTimeout(r, 1500));

            const purchaseData = {
                nombre: document.getElementById('clientName').value,
                os: document.getElementById('clientOS').value,
                arquitectura: document.getElementById('clientArch').value,
                email: document.getElementById('clientEmail').value,
                plan: plan,
                precio: precio,
                fecha: new Date().toISOString()
            };

            try {
                const respuesta = await fetch('/api/procesar_compra.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(purchaseData)
                });

                const resultado = await respuesta.json();

                if (resultado.success || resultado.estado === 'exito') {
                    alert('✅ ¡Compra realizada con éxito!\n\nTe hemos enviado los scripts a: ' + purchaseData.email);
                    window.location.href = 'perfil.php';
                } else {
                    alert('Error al procesar: ' + (resultado.message || resultado.mensaje));
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Ocurrió un error de conexión con el servidor.');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
});