const app = {
    url: document.getElementById('url').content,
    login:async function (form) {
        try {
            let res = await fetch(`${this.url}signin/login`, {
                method:'POST',
                body: new FormData(form)
            });
            console.log(res);
            let data = await res.json();
            console.log(data.status);

            // if(data.status===200){
            //     document.location.replace(this.url+"rols");
            // }
        } catch (error) {
            console.log(error);
        }
    }
}

// $(document).ready(function () {
//     document.getElementById('form').onsubmit = function (e) {
//         e.preventDefault();
//         app.login(this);
//     }
// });

