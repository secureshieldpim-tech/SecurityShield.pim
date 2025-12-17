// js/logic.js
document.addEventListener('DOMContentLoaded', () => {
    const botonEnviar = document.querySelector('.btn-submit');
    
    botonEnviar.addEventListener('click', async (e) => {
        e.preventDefault();
        
        // Captura de datos del DOM
        const datos = {
            nombre: document.querySelector('input').value,
            email: document.querySelector('input[placeholder="correo@ejemplo.com"]').value,
            mensaje: document.querySelector('textarea').value
        };
        
        // Feedback visual de carga
        const textoOriginal = botonEnviar.innerHTML;
        botonEnviar.innerHTML = 'Guardando...';
        botonEnviar.disabled = true;

        try {
            const respuesta = await fetch('api/procesar_contacto.php', { 
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datos)
            });

            const resultado = await respuesta.json();

            if (resultado.estado === 'exito') {
                alert('Registro completado: ' + resultado.mensaje);
                // Limpiar formulario
                document.querySelectorAll('.form-input').forEach(i => i.value = '');
            } else {
                alert('Error: ' + resultado.mensaje);
            }
        } catch (error) {
            console.error(error);
            alert('Error crítico: No se pudo conectar con el sistema de archivos local.');
        } finally {
            botonEnviar.innerHTML = textoOriginal;
            botonEnviar.disabled = false;
        }
    });
});