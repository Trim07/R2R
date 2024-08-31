$(document).ready(function() {
    $('#loginForm').on('submit', function(event) {
        event.preventDefault();
        axios.defaults.withCredentials = true;

        let formData = new FormData(this);
        axios.post('/api/users/login', formData, {
                headers: {
                    'Content-Type': 'application/json'
                },
                withCredentials: true
            })
            .then(response => {
                Swal.fire({
                    title: "Sucesso",
                    text: "Login realizado com sucesso!",
                    icon: "success",
                    confirmButtonText: "Ok",
                });
                setTimeout(() => {
                    window.location.href = "/customers/index.php";
                }, 1000);
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: "Ops...",
                    text: `Ocorreu um erro durante o login:\n${error.response.data.error}`,
                });
            });
    });
});