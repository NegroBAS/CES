const app = {
    url: document.getElementById("url").content,
    authenticate: async function () {
        try {
            let res = await fetch(
                "https://cronode.herokuapp.com/api/authenticate",
                {
                    method: "POST",
                    headers: {
                        accept: "application/json",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        misena_email: "consulta@misena.edu.co",
                        password: "123456789110",
                    }),
                }
            );
            let data = await res.json();
            return data.token;
        } catch (error) {
            console.log(error);
        }
    },
    getByApi: async function () {
        try {
            let token = await this.authenticate();
            let res = await fetch('https://cronode.herokuapp.com/api/ces/positions', {
                headers:{
                    'Authorization':`Bearer ${token}`
                }
            });
            let data = await res.json();
            console.log(data.positions);
            let fd = new FormData();
            fd.append('positions', JSON.stringify(data.positions));
            document.getElementById('data-positions').innerHTML = `
            <div class="col-6 mx-auto text-center text-primary">
                <h6>Actualizando los datos</h6>
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            `;
            res = await fetch(`${this.url}positions/masive`, {
                method:'POST',
                body:fd
            });
            data = await res.json();
            toastr.success('', data.message, {
                closeButton:true
            });
            app.get();
        } catch (error) {
            console.log(error);
        }
    },
    get: async function () {
        try {
            let res = await fetch(`${this.url}positions/index`);
            let data = await res.json();
            let html = "";
            if (data.positions.length > 0) {
                data.positions.forEach((position) => {
                    html += `
                    <div class="col-3 mb-2">
                        <div class="card" data-id="${position.id}">
                            <div class="card-header bg-primary"></div>
                            <div class="card-body text-center">
                                <h5>${position.name}</h5>
                                <button class="btn btn-sm btn-outline-danger delete">Eliminar</button>
                                <button class="btn btn-sm btn-outline-primary edit" data-toggle="modal" data-target="#modal">Editar</button>
                            </div>
                        </div>
                    </div>
                    `;
                });
                document.getElementById("data-positions").innerHTML = html;
            }
        } catch (error) {
            console.log(error);
        }
    },
};

$(document).ready(async function () {
    await app.get();
    document.getElementById('update').onclick = function () {
        app.getByApi();
    }
});
