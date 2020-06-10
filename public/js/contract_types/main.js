const app = {
    url: document.getElementById('url').content,
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
            let res = await fetch('https://cronode.herokuapp.com/api/ces/contractTypes', {
                headers:{
                    'Authorization':`Bearer ${token}`
                }
            });
            let data = await res.json();
            let fd = new FormData();
            fd.append('contract_types', JSON.stringify(data.contractTypes));
            res = await fetch(`${this.url}contract_types/masive`, {
                method:'POST',
                body:fd
            });
            console.log('actualizando');
            data = await res.json();
            if(data.status===200){
                toastr.success('', data.message, {
                    closeButton:true
                });
                app.get();
            }
        } catch (error) {
            console.log(error);
        }
    },
    get:async function () {
        try {
            let res = await fetch(`${this.url}contract_types/index`);
            let data = await res.json();
            console.log(data);
            if(data.status===200){
                if(data.contract_types.length>0){
                    let html = '';
                    data.contract_types.forEach(contract_type => {
                        html += `
                        <div class="col-3 mb-2">
                            <div class="card">
                                <div class="card-header bg-primary"></div>
                                <div class="card-body text-center">
                                    <h5>${contract_type.name}</h5>
                                    <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    <button class="btn btn-sm btn-outline-primary">Editar</button>
                                </div>
                            </div>
                        </div>
                        `;
                    });
                    document.getElementById('data-contract-types').innerHTML = html;
                }
            }
        } catch (error) {
            console.log(error);
        }
    }
}

$(document).ready(function () {
    app.get();
    document.getElementById('update').onclick = async function () {
        document.getElementById('data-contract-types').innerHTML = `
        <div class="col-6 mx-auto text-center text-primary">
            <h6>Actualizando los datos</h6>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        `;
        await app.getByApi();
    }
});
