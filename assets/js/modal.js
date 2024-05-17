document.addEventListener("DOMContentLoaded", function() {
    // Selecciona el enlace de login
    var loginLink = document.getElementById("loginLink");

    // Agrega un evento de clic al enlace
    loginLink.addEventListener("click", function(event) {
        event.preventDefault(); // Evita que el enlace siga su comportamiento predeterminado (navegar a una nueva página)
        
        // Obtiene el modal de inicio de sesión por su ID
        var loginModal = new bootstrap.Modal(document.getElementById("exampleModal"));

        // Si se encuentra el modal, lo abre
        loginModal.show();
    });
});
