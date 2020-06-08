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
                document.location.replace(this.url+"rols");
            }
        } catch (error) {
            console.log(error);
        }
    }
}

$(document).ready(function () {
    document.getElementById('form').onsubmit = function (e) {
        e.preventDefault();
        app.login(this);
    }
});