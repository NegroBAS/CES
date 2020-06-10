const app = {
    url: document.getElementById('url').content,
    edit: false,
    list: async function () {
        let resp = await fetch(`${this.url}document_types/index`);
        let res = await resp.json();
        let document_types = res.document_types;
        let html = '';
        document_types.forEach(document_types => {
            html += `
            <div class="col-3 mb-2">
                <div class="card" data-id="${document_types.id}">
                    <div class="card-header bg-primary"></div>
                    <div class="card-body text-center">
                        <h5>${document_types.name}</h5>
                        <button class="btn btn-sm btn-outline-danger delete">Eliminar</button>
                        <button class="btn btn-sm btn-outline-primary edit" data-toggle="modal" data-target="#modal">Editar</button>
                    </div>
                </div>
            </div>
            `
        });
        document.getElementById('data-document_types').innerHTML = html;
    },
    create: async function () {
        let resp = await fetch(`${this.url}document_types/store`, {
            method: 'POST',
            body: new FormData(document.getElementById('form'))
        });
        let res = await resp.json();
        console.log(res.status);
        if (res.status == "ok") {
            console.log(res.message);
            $('#form').trigger('reset');
            await app.list();
        }
    },
    delete: async function (id) {
        let resp = await fetch(`${this.url}document_types/destroy/${id}`);
        let res = await resp.json();
        console.log(res);
    },
    update: async function (id) {
        let resp = await fetch(`${this.url}document_types/edit/${id}`, {
            method: 'POST',
            body: new FormData(document.getElementById('form'))
        });
        let res = await resp.json();
        console.log(res);
        if (res.status == "ok") {
            console.log(res.message);
            $('#form').trigger('reset');
            await app.list();
            this.edit = false;
        }
    }
}

$(document).ready(async function () {
    let id = 0;
    await app.list();
    document.getElementById('btnForm').onclick = async function () {
        if (app.edit) {
            console.log('editando');
            await app.update(id);
        } else {
            console.log('creando');
            await app.create();
        }
    }
    $(document).on('click', '.delete', async function () {
        Swal.fire({
            title: '¿Estas seguro?',
            text: "No podras revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Eliminado!',
                    'El Documento ha sido eliminado.',
                    'success'
                )
                    let id = $($(this)[0].parentElement.parentElement).data('id');
                    app.delete(id);
                    app.list();
            }
        })
        await app.list();

    });
    document.getElementById('btnCreate').onclick = function () {
        app.edit = false;
        let modal = $('#modal');
        modal.find('.modal-title').text('Crear Tipo de Documento');
        validaciones();
        $('#form').trigger('reset');
    }
    $(document).on('click', '.edit', async function () {
        id = $($(this)[0].parentElement.parentElement).data('id');
        app.edit = true;
        let modal = $('#modal');
        modal.find('.modal-title').text('Editar Tipo de Documento');
        let resp = await fetch(`${app.url}document_types/show/${id}`);
        let res = await resp.json();
        console.log(res);
        validaciones();
        document.getElementById('name').value = res.name;
    });

    function validaciones(){


        let name = document.getElementById('name');
   

        let letrasRegex = /^[A-Za-z _]*[A-Za-z][A-Za-z _]*$/;
        let btn = document.getElementById('btnForm');
 
      
        btn.setAttribute('disabled','disabled');
        
  
      
          name.oninput = function(){

            if (letrasRegex.test(this.value)){
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                btn.removeAttribute('disabled');
            }else{
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
                document.getElementById('nameMessage').innerHTML = "Este campo es requerido"
                btn.setAttribute('disabled','disabled');
            }


              if(this.value === "" || this.value == null){
                  console.log("campo requerido");
                  document.getElementById('nameMessage').innerHTML = "Este campo es requerido"
                  this.classList.add('is-invalid');
                  btn.setAttribute('disabled','disabled');
              
              }
      
          }
      

      
        }
});