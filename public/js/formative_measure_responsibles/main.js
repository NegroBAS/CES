const app = {
    url:document.getElementById('url').content,
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
            let res = await fetch('https://cronode.herokuapp.com/api/ces/instructors', {
                headers:{
                    'Authorization':`Bearer ${token}`
                }
            });
            let data = await res.json();
            console.log(data);
            // let fd = new FormData();
            // fd.append('contract_types', JSON.stringify(data.contractTypes));
            // res = await fetch(`${this.url}contract_types/masive`, {
            //     method:'POST',
            //     body:fd
            // });
            // data = await res.json();
            // if(data.status===200){
            //     toastr.success('', data.message, {
            //         closeButton:true
            //     });
            //     app.get();
            // }
        } catch (error) {
            console.log(error);
        }
    },
    get:async function () {
        try {
            let res = await fetch(`${this.url}formative_measure_responsibles/index`);
            let data = await res.json();
            if(data.status==200){
                if(data.formative_measure_responsibles.length>0){
                    let html = '';
                    data.formative_measure_responsibles.forEach(formative_measure_responsible => {
                        html+=`
                        <tr>
                            <td>${formative_measure_responsible.username}</td>
                            <td>${formative_measure_responsible.misena_email}</td>
                            <td>${formative_measure_responsible.document}</td>
                            <td>${formative_measure_responsible.phone}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                <button class="btn btn-sm btn-outline-primary">Editar</button>
                            </td>
                        </tr>
                        `;
                    });
                    document.getElementById('data-formative-measure-responsible').innerHTML = html;
                }
            }
        } catch (error) {
            console.log(error);
        }
    }
};

$(document).ready(async function () {
    await app.get();
    document.getElementById('update').onclick = function () {
        document.getElementById('data-formative-measure-responsible').innerHTML = `
        <tr>
        <td colspan="6" class="text-center text-primary">
            <h6>Actualizando los datos</h6>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </td>
        </tr>
        `;
        app.getByApi();
    }
    $("#formative-measure-responsibles").DataTable({
        responsive: true,
        language: {
            url:
                "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
        },
    });
});