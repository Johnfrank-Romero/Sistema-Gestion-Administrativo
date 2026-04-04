//Manejo de alertas flotantes//
document.addEventListener('DOMContentLoaded', () => {
    const alert = document.querySelector('.floating-alert');

    if (alert) {
        //Cierre manual al hacer clic//
        alert.addEventListener('click', () => {
            removeAlert(alert);
        });

        //Cierre automatico despues de 8 segundos//
        setTimeout(() => {
            removeAlert(alert);
        }, 8000);
    }
});

function removeAlert(element) {
    if (!element) return;

    element.style.transition = "opacity 0.6s ease, transform 0.6s ease, filter 0.3s";
    element.style.opacity = "0";
    element.style.transform = "translateX(-50%) translateY(-20px)";

    setTimeout(() => {
        if (element.parentNode) {
            element.remove();
        }
    }, 2000); //Margen para la transicion//
}