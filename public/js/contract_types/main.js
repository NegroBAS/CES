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
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            let data = await res.json();
            let fd = new FormData();
            fd.append('contract_types', JSON.stringify(data.contractTypes));
            res = await fetch(`${this.url}contract_types/masive`, {
                method: 'POST',
                body: fd
            });
            data = await res.json();
            if (data.status === 200) {
                toastr.success('', data.message, {
                    closeButton: true
                });
                await app.get();
            }
        } catch (error) {
            console.log(error);
        }
    },
    get: async function () {
        try {
            let res = await fetch(`${this.url}contract_types/index`);
            let data = await res.json();
            if (data.status === 200) {
                let html = '';
                if (data.contract_types.length > 0) {
                    data.contract_types.forEach(contract_type => {
                        html += `
                        <div class="col-12 col-md-6 col-xl-6 mb-2">
                            <div class="card" data-id="${contract_type.id}">
                                <div class="card-header bg-primary"></div>
                                <div class="card-body text-center">
                                    <h5>${contract_type.name}</h5>
                                    <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                                    <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-primary detail" data-id="${contract_type.id}"><i class="far fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                        `;
                    });
                }else{
                    html+=`
                    <div class="col">
                        <h6>No hay datos</h6>
                    </div>
                    `;    
                }
                document.getElementById('data-contract-types').innerHTML = html;
            }
        } catch (error) {
            console.log(error);
        }
    },
    getOne: async function (id) {
        try {
            let res = await fetch(`${this.url}contract_types/show/${id}`);
            let data = await res.json();
            console.log(data);
            if (data.status === 200) {
                $('.modal #form').trigger('reset');
                $('#modal-creat').modal('toggle');
                $('.modal').find('.modal-title').text('Editar tipo de contrato');
                document.getElementById('name').value = data.contract_type.name

            }
        } catch (error) {
            console.log(error);
        }
    },
    create: async function (form) {
        try {
            let res = await fetch(`${this.url}contract_types/store`, {
                method: 'POST',
                body: new FormData(form)
            });
            let data = await res.json();
            console.log(data);
            if (data.status === 200) {
                $('#modal-creat').modal('toggle');
                app.get();
                toastr.success('', data.message, {
                    closeButton: true
                });
            }
            if (data.status === 500) {
                console.log(data.error);
                toastr.error('', data.error.errorInfo[2], {
                    closeButton: true
                });
            }
        } catch (error) {
            console.log(error);
        }
    },
    delete: async function (id) {
        try {
            let res = await fetch(`${this.url}contract_types/destroy/${id}`);
            let data = await res.json();
            if (data.status === 200) {
                toastr.success('', data.message, {
                    closeButton: true
                });
                this.get();
            }
            if (data.status === 500) {
                console.log(data.error);
            }
        } catch (error) {
            console.log(error);
        }
    },
    update: async function (form, id) {
        try {
            let res = await fetch(`${this.url}contract_types/edit/${id}`, {
                method: 'POST',
                body: new FormData(form)
            });
            let data = await res.json();
            console.log(data.status);
            if (data.status === 200) {
                toastr.success('', data.message, {
                    closeButton: true
                });
                app.get();
                $('#modal-creat').modal('toggle');
                this.edit = false;
            }
            if (data.status === 500) {
                console.log(data.error);
            }
        } catch (error) {
            console.log(error);
        }
    },
    detailContract_type: async function (id) {
		try {
            let res = await fetch(`${this.url}contract_types/view/${id}`);
			console.log(res);
			let data = await res.json();
			console.log(data);
            $('#modal-detail #name').text(data.name);
            $('#modal-detail #name_instructor').text(data.name_instructor);
		} catch (error) {
			console.log(error);
		}
    }
}

$(document).ready(async function () {
    document.getElementById('data-contract-types').innerHTML = `
        <div class="col-6 mx-auto text-center text-primary">
            <h6>Cargando los datos</h6>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        `;
    let id = null;
    await app.get();
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
    $(document).on('click', '.detail', async function () {
        let id = $(this).data('id');
		await app.detailContract_type(id);
		$('#modal-detail').find('.modal-title').text('Detalles del Contrato');
		$('#modal-detail').modal('toggle');
	});
    document.getElementById('btn-create').onclick = function () {
        $('.modal #form').trigger('reset');
        $('#modal-creat').modal('toggle');
        $('.modal').find('.modal-title').text('Crear tipo de contrato');
        val.limpiar();
        val.validaciones();
    }
    document.getElementById('form').onsubmit = function (e) {
        e.preventDefault();
        if (app.edit) {
            app.update(this, id);
        } else {
            app.create(this);
        }
    }
    $(document).on('click', '.delete', function () {
        id = $(this.parentElement.parentElement).data('id');
        Swal.fire({
            title: "¿Estas seguro?",
            text: "No podras revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Si, eliminar",
        }).then((result) => {
            if (result.value) {
                Swal.fire("Eliminado!", "Tipo de contrato eliminado.", "success");
                let id = $($(this)[0].parentElement.parentElement).data("id");
                app.delete(id);
                app.get();
            }
        });

    });
    $(document).on('click', '.edit', function () {
        id = $(this.parentElement.parentElement).data('id');
        app.edit = true;
        val.limpiar();
        val.validaciones();
        app.getOne(id);
    })

});

const val = {
    validaciones() {
        let name = document.getElementById("name");

        let letrasRegex = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\u00E0-\u00FC\s]+$/;
        let btn = document.getElementById("btnForm");

        btn.setAttribute("disabled", "disabled");

        name.oninput = function () {
            if (letrasRegex.test(this.value)) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");
            } else {
                this.classList.remove("is-valid");
                this.classList.add("is-invalid");
                document.getElementById("nameMessage").innerHTML =
                    "Ingrese un nombre valido";
            }

            if (this.value === "") {
                console.log("campo requerido");
                document.getElementById("nameMessage").innerHTML =
                    "Este campo es requerido";
                this.classList.add("is-invalid");
            }

            if (letrasRegex.test(this.value)) {
                btn.removeAttribute("disabled");
            } else {
                btn.setAttribute("disabled", "disabled");
            }
        };

        setInterval(input,3000);
        function input(){       
             if(letrasRegex.test(name.value)){                   
                btnForm.removeAttribute("disabled");
             }  
        }

    },

    limpiar() {
        let name = document.getElementById("name");
        let type = document.getElementById("type");

        name.classList.remove("is-invalid");
        name.classList.remove("is-valid");

    }


}
