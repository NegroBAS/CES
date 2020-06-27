const app = {
    url: document.getElementById("url").content,
    edit: false,
    get: async function () {
        try {
            let res = await fetch(`${this.url}novelty_types/index`);
            let data = await res.json();
            if (data.status === 200) {
                let html = "";
                if (data.novelty_types.length > 0) {
                    data.novelty_types.forEach((novelty_type) => {
                        html += `
                        <div class="col-12 col-md-4 mb-3">
                            <div class="card" data-id="${novelty_type.id}">
                                <div class="card-header bg-primary"></div>
                                <div class="card-body text-center">
                                    <h5>${novelty_type.name}</h5>
                                    <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                                    <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>
                                </div>
                            </div>
                        </div>
                        `;
                    });
                }else{
                    html += `
                    <div class="col">
                        <h6 class="text-muted">No hay datos que mostrar <h6>
                    </div>
                    `;   
                }
                document.getElementById('data-novelty-types').innerHTML = html;
            }
        } catch (error) {
            console.log(error);
        }
    },
    create:async function (form) {
        try {
            let res = await fetch(`${this.url}novelty_types/store`, {
                method:'POST',
                body: new FormData(form)
            });
            let data = await res.json();
            if(data.status===200){
                $('#modal-create').modal('toggle');
                toastr.success('', data.message, {
                    closeButton:true
                });
                await app.get();
            }
        } catch (error) {
            console.log(error);
        }
    },
    getOne:async function (id) {
        try {
            let res = await fetch(`${this.url}novelty_types/show/${id}`);
            let data = await res.json();
            if(data.status===200){
                $('#modal-create #name').val(data.novelty_type.name);
                $('#modal-create').find('.modal-title').text('Actualizar novedad');
                $('#modal-create').modal('toggle');
            }
        } catch (error) {
            console.log(error);
        }
    },
    delete: async function (id) {
        try {
            let res = await fetch(`${this.url}novelty_types/destroy/${id}`);
            let data = await res.json();
            if(data.status===200){
                toastr.success('', data.message, {
                    closeButton: true
                });
                await app.get();
            }
        } catch (error) {
            console.log(error);
        }
    },
    update:async function(form, id){
        try {
            let res = await fetch(`${this.url}novelty_types/edit/${id}`, {
                method:'POST',
                body: new FormData(form)
            });
            let data = await res.json();
            if(data.status===200){
                toastr.success('', data.message, {
                    closeButton:true
                });
                await app.get();
                $('#modal-create').modal('toggle');
            }
        } catch (error) {
            console.log(error);
        }
    }
};

$(document).ready(async function () {
    let id = 0;
    document.getElementById('data-novelty-types').innerHTML = `
    <div class="col-6 mx-auto text-center text-primary">
        <h6>Cargando los datos</h6>
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    `;
    await app.get();
    $(document).on('click', '.delete', async function () {
        id = $(this.parentElement.parentElement).data('id');
        await app.delete(id);
    });
    $(document).on('click', '.edit', async function () {
        id = $(this.parentElement.parentElement).data('id');
        app.edit = true;
        val.limpiar();
        val.validaciones();
        await app.getOne(id);
    })
    document.getElementById('btn-create').onclick = function(){
        app.edit=false;
        $('#form').trigger('reset');
        $('#modal-create').find('.modal-title').text('Crear tipo de novedad');
        $('#modal-create').modal('toggle');
        val.limpiar();
        val.validaciones();
    }
    document.getElementById('form').onsubmit = async function (e) {
        e.preventDefault();
        if(app.edit){
            await app.update(this, id);
        }else{
            await app.create(this);
        }
    }
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
