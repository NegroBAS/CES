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
                                <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                                <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>
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
    getOne: async function (id) {
        try {
            let res = await fetch(`${this.url}positions/show/${id}`);
            let data = await res.json();
            console.log(data);
            if(data.status===200){
                $('.modal #form').trigger('reset');
                $('.modal').modal('toggle');
                $('.modal').find('.modal-title').text('Editar Cargo');
                document.getElementById('name').value = data.positions.name
                document.getElementById('type').value = data.positions.type
            }
        } catch (error) {
            console.log(error);
        }
    },
    create:async function(form){
        try {
            let res = await fetch(`${this.url}positions/store`, {
                method:'POST',
                body: new FormData(form)
            });
            let data = await res.json();
            console.log(data);
            if(data.status===200){
                $('.modal').modal('toggle');
                app.get();
                toastr.success('', data.message, {
                    closeButton:true
                });
            }
            if(data.status===500){
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
            let res  = await fetch(`${this.url}positions/destroy/${id}`);
            let data = await res.json();
            if(data.status === 200){
                toastr.success('', data.message, {
                    closeButton:true
                });
                this.get();
            }
            if(data.status===500){
                console.log(data.error);
            }
        } catch (error) {
            console.log(error);
        }
    },
    update: async function (form, id) {
        try {
            let res = await fetch(`${this.url}positions/edit/${id}`, {
                method:'POST',
                body:new FormData(form)
            });
            let data = await res.json();
            console.log(data);
            if(data.status===200){
                toastr.success('', data.message, {
                    closeButton: true
                });
                app.get();
                $('.modal').modal('toggle');
                this.edit = false;
            }
            if(data.status===500){
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
    document.getElementById('update').onclick = function () {
        app.getByApi();
    }
    document.getElementById('btn-create').onclick = function(){
        $('.modal #form').trigger('reset');
        $('.modal').modal('toggle');
        $('.modal').find('.modal-title').text('Crear Cargo');
        val.limpiar();
        val.validaciones();
    }
    document.getElementById('form').onsubmit = function(e){
        e.preventDefault();
        if(app.edit){
            app.update(this, id);
        }else{
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
              Swal.fire("Eliminado!", "El aprendiz ha sido eliminado.", "success");
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
        let type = document.getElementById("type");
    
        let letrasRegex = /^[A-Za-z _]*[A-Za-z][A-Za-z _]*$/;
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
              "Este campo es requerido";
          }
    
          if (this.value === "") {
            console.log("campo requerido");
            document.getElementById("nameMessage").innerHTML =
              "Este campo es requerido";
            this.classList.add("is-invalid");
          }
    
          if (letrasRegex.test(this.value) && letrasRegex.test(type.value)) {
            btn.removeAttribute("disabled");
          } else {
            btn.setAttribute("disabled", "disabled");
          }
        };
    
        type.oninput = function () {
          if (letrasRegex.test(this.value)) {
            this.classList.remove("is-invalid");
            this.classList.add("is-valid");
          } else {
            this.classList.remove("is-valid");
            this.classList.add("is-invalid");
            document.getElementById("typeMessage").innerHTML =
              "Este campo es requerido";
          }
    
          if (this.value === "") {
            console.log("campo requerido");
            document.getElementById("typeMessage").innerHTML =
              "Este campo es requerido";
            this.classList.add("is-invalid");
          }
    
          if (letrasRegex.test(this.value) && letrasRegex.test(name.value)) {
            btn.removeAttribute("disabled");
          } else {
            btn.setAttribute("disabled", "disabled");
          }
        };
      },

      limpiar(){
        let name = document.getElementById("name");
        let type = document.getElementById("type");
        

        console.log("limpiando");
        name.classList.remove("is-invalid");    
        name.classList.remove("is-valid");

        type.classList.remove("is-invalid");
        type.classList.remove("is-valid");

      }


}


