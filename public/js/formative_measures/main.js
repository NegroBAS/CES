const app = {
    url: document.getElementById('url').content,
    edit: false,
    get: async function () {
        let resp = await fetch(`${this.url}formative_measures/index`);
        let res = await resp.json();
        let formative_measures = res.formative_measures;
        let html = '';
        formative_measures.forEach(formative_measures => {
            html += `
            <div class="col-3 mb-2">
                <div class="card" data-id="${formative_measures.id}">
                    <div class="card-header bg-primary"></div>
                    <div class="card-body text-center">
                        <h5>${formative_measures.name}</h5>
                        <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                        <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>
                    </div>
                </div>
            </div>
            `
        });
        document.getElementById('data-formative_measures').innerHTML = html;
    },
    getOne: async function (id) {
        try {
            let res = await fetch(`${this.url}formative_measures/show/${id}`);
            let data = await res.json();
            console.log(data);
            if(data.status===200){
                $('.modal #form').trigger('reset');
                $('.modal').modal('toggle');
                $('.modal').find('.modal-title').text('Editar medida formativa');
                document.getElementById('name').value = data.measure.name
            }
        } catch (error) {
            console.log(error);
        }
    },
    create:async function(form){
        try {
            let res = await fetch(`${this.url}formative_measures/store`, {
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
            let res  = await fetch(`${this.url}formative_measures/destroy/${id}`);
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
            let res = await fetch(`${this.url}formative_measures/edit/${id}`, {
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
    document.getElementById('btn-create').onclick = function(){
        $('.modal #form').trigger('reset');
        $('.modal').modal('toggle');
        $('.modal').find('.modal-title').text('Crear medida formativa');
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
              Swal.fire("Eliminado!", "La medida formativa ha sido eliminada.", "success");
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
    
        let letrasRegex = /^[a-zA-ZÀ-ÿ\u00E0-\u00FC]+(\s*[a-zA-ZÀ-ÿ\u00E0-\u00FC]*)*[a-zA-ZÀ-ÿ\u00E0-\u00FC]+$/;
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
    
          if (letrasRegex.test(this.value)) {
            btn.removeAttribute("disabled");
          } else {
            btn.setAttribute("disabled", "disabled");
          }
        };
    
      },

      limpiar(){
        let name = document.getElementById("name");
        

        console.log("limpiando");
        name.classList.remove("is-invalid");    
        name.classList.remove("is-valid");


      }


}