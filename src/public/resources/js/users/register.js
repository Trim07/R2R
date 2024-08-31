$(document).ready(function() {
    $('#registerForm').on('submit', function(event) {
        event.preventDefault();
        axios.defaults.withCredentials = true;
        let formData = new FormData(this);

        axios.post('/api/users', formData, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                Swal.fire({
                    title: "Sucesso",
                    text: "Registro realizado com sucesso!",
                    icon: "success",
                    confirmButtonText: "Ok",
                });
                setTimeout(() => {
                    window.location.href = "/login.php";
                }, 1000);

            })
            .catch(error => {

                Swal.fire({
                    icon: 'error',
                    title: "Ops...",
                    text: `Ocorreu um erro durante o cadastro do usuário:\n${error.response.data.error}`,
                });
            });
    });
});