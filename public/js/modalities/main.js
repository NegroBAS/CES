const app = {
    url: document.getElementById('url').content,
    edit: false,
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
            let res = await fetch('https://cronode.herokuapp.com/api/ces/modalities', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            let data = await res.json();
            let fd = new FormData();
            fd.append('modalities', JSON.stringify(data.modalities));
            res = await fetch(`${this.url}modalities/masive`, {
                method:'POST',
                body:fd
            });
            data = await res.json();
            if(data.status===200){
                toastr.success('', data.message, {
                    closeButton:true
                });
                await app.get();
            }
        } catch (error) {
            console.log(error);
        }
    },
    get: async function () {
        let resp = await fetch(`${this.url}modalities/index`);
        let res = await resp.json();
        let modalities = res.modalities;
        let html = '';
        modalities.forEach(modality => {
            html += `
                <div class="col-12 col-md-6 col-xl-6 mb-2">
                    <div class="card" data-id="${modality.id}">
                        <div class="card-header bg-primary"></div>
                        <div class="card-body text-center text-truncate">
                            <h5>${modality.name}</h5>
                            <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                            <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>
                        </div>
                    </div>
                </div>
                `
        });
        document.getElementById('data-modalities').innerHTML = html;
    },
    getOne: async function (id) {
        try {
            let res = await fetch(`${this.url}modalities/show/${id}`);
            let data = await res.json();
            if (data.status === 200) {
                $('.modal #form').trigger('reset');
                $('.modal').modal('toggle');
                $('.modal').find('.modal-title').text('Editar modalidad');
                document.getElementById('name').value = data.modality.name
            }
        } catch (error) {
            console.log(error);
        }
    },
    create: async function (form) {
        try {
            let res = await fetch(`${this.url}modalities/store`, {
                method: 'POST',
                body: new FormData(form)
            });
            let data = await res.json();
            console.log(data);
            if (data.status === 200) {
                $('.modal').modal('toggle');
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
            let res = await fetch(`${this.url}modalities/destroy/${id}`);
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
            let res = await fetch(`${this.url}modalities/edit/${id}`, {
                method: 'POST',
                body: new FormData(form)
            });
            let data = await res.json();
            console.log(data);
            if (data.status === 200) {
                toastr.success('', data.message, {
                    closeButton: true
                });
                app.get();
                $('.modal').modal('toggle');
                this.edit = false;
            }
            if (data.status === 500) {
                console.log(data.error);
            }
        } catch (error) {
            console.log(error);
        }
    }
}

$(document).ready(async function () {
    let id = null;
    await app.get();
    document.getElementById('btn-create').onclick = function () {
        $('.modal #form').trigger('reset');
        $('.modal').modal('toggle');
        $('.modal').find('.modal-title').text('Crear modalidad');
        val.limpiar();
        val.validaciones();
    }
    document.getElementById('btnUpdate').onclick = async function(){
        document.getElementById('data-modalities').innerHTML = `
        <div class="col">
            <h6>Cargando...</h6>
        </div>
        `
        await app.getByApi();
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
                Swal.fire("Eliminado!", "La Modalidad ha sido eliminada.", "success");
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

        name.classList.remove("is-invalid");
        name.classList.remove("is-valid");

    }


}