document.addEventListener('DOMContentLoaded', () => {
    //Selecciona todas las alertas//
    const alerts = document.querySelectorAll('.floating-alert');

    alerts.forEach(alert => {
        //Cierre manual al hacer clic//
        alert.addEventListener('click', () => {
            removeAlert(alert);
        });

        //Cierre automatico despues de 6 segundos//
        setTimeout(() => {
            removeAlert(alert);
        }, 6000);
    });
});

function removeAlert(element) {
    if (!element || element.dataset.removing === "true") return;
    element.dataset.removing = "true";

    //Aplicar estilos de salida//
    element.style.transition = "all 0.6s cubic-bezier(0.4, 0, 0.2, 1)";
    element.style.opacity = "0";
    element.style.transform = "translateX(-50%) translateY(-30px) scale(0.9)";
    element.style.filter = "blur(4px)";

    //Eliminar el DOM cuando termina la transicion//
    setTimeout(() => {
        if (element.parentNode) {
            element.remove();
        }
    }, 600); 
}