const app = {
    url: document.getElementById('url').content,
    login:async function (form) {
        try {
            let res = await fetch(`${this.url}signin/login`, {
                method:'POST',
                body: new FormData(form)
            });
            let data = await res.json();
            if(data.status===200){
                document.location.replace(this.url+"dashboard");
            }
            if(data.status===400){
                document.getElementById('email').classList.add('is-invalid');
                document.getElementById('email-error').innerHTML = data.message;
            }
            if(data.status===401){
                document.getElementById('password').classList.add('is-invalid');
                document.getElementById('password-error').innerHTML = data.message;
            }
            document.getElementById('btnLogin').removeAttribute('disabled');
            document.getElementById('btnLogin').value = "Iniciar Sesión"
        } catch (error) {
            console.log(error);
        }
    }
}

$(document).ready(function () {
    document.getElementById('form').onsubmit = function (e) {
        document.getElementById('btnLogin').setAttribute('disabled', true);
        document.getElementById('btnLogin').value = "Cargando ..."
        e.preventDefault();
        app.login(this);
    }
    let show = false;
    document.getElementById('showHide').onclick = function(){
        if(show){
            document.getElementById('password').setAttribute('type', 'password');
            document.getElementById('icon').classList.add('fa-eye-slash');
            document.getElementById('icon').classList.remove('fa-eye');
            show = !show;
        }else{
            document.getElementById('password').setAttribute('type', 'text');
            document.getElementById('icon').classList.remove('fa-eye-slash');
            document.getElementById('icon').classList.add('fa-eye');
            show = !show; 
        }
    }
});

