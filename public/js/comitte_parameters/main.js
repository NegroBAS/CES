const app = {
        url: document.getElementById('url').content,
        edit: false,
        get: async function () {
            let resp = await fetch(`${this.url}committee_parameters/index`);
            let res = await resp.json();
            console.log(res);
            let comitte_session_states = res.comitte_session_states;
            let html = '';
        
            comitte_session_states.forEach(comitte_session_states => {
                html += `
                         <option value="${comitte_session_states.id}">${comitte_session_states.name}</option>
                         `
            });
            document.getElementById('comitte_session_state_id').innerHTML = html;

            let comitte_parameters = res.comitte_parameters;
             html = '';
             
            comitte_parameters.forEach(comitte_parameters => {
                html += `
                        <tr data-id="${comitte_parameters.id}">
                        <td>${comitte_parameters.name}</td>
                        <td>${comitte_parameters.content}</td>
                        <td>${comitte_parameters.name_state}</td>
                        <td>

                        <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                        <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>

                        </td>
                        
                        </tr>
                         `
            });
            document.getElementById('data-comitte_parameters').innerHTML = html;
        },
        getOne: async function (id) {
            try {
                let res = await fetch(`${this.url}committee_parameters/show/${id}`);
                let data = await res.json();
                console.log(data);
                if(data.status===200){
                    $('.modal #form').trigger('reset');
                    $('.modal').modal('toggle');
                    $('.modal').find('.modal-title').text('Editar parametro de comite');
                    document.getElementById('name').value = data.parameters.name
                    document.getElementById('content').value = data.parameters.content
                }
            } catch (error) {
                console.log(error);
            }
        },
        create:async function(form){
            try {
                let res = await fetch(`${this.url}committee_parameters/store`, {
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
                let res  = await fetch(`${this.url}committee_parameters/destroy/${id}`);
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
                let res = await fetch(`${this.url}committee_parameters/edit/${id}`, {
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
            $('.modal').find('.modal-title').text('Crear parametro de comite');
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
                  Swal.fire("Eliminado!", "El parametro ha sido eliminado.", "success");
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

        $('#tabla').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            }
        });


        //area de validaciones de form//

        const val = {

            validaciones (){

                let name = document.getElementById('name');
                let content = document.getElementById('content');
                let letrasRegex = /^[a-zA-ZÀ-ÿ\u00E0-\u00FC]+(\s*[a-zA-ZÀ-ÿ\u00E0-\u00FC]*)*[a-zA-ZÀ-ÿ\u00E0-\u00FC]+$/;
                let btn = document.getElementById('btnForm');
        
                btn.setAttribute('disabled', 'disabled');
        
                name.oninput = function(){
                    
                    if (letrasRegex.test(this.value)){
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }else{
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                        document.getElementById('nameMessage').innerHTML = "Este campo es requerido"
                    }
        
                    if(this.value === ""){
                        console.log("campo requerido");
                        document.getElementById('nameMessage').innerHTML = "Este campo es requerido"
                        this.classList.add('is-invalid');
                        
                    }
        
                    if(letrasRegex.test(name.value) && content.value.length > 0){
                        console.log('Bueno');
                        btn.removeAttribute('disabled');  
                    }else{
                        btn.setAttribute('disabled', 'disabled');
                    }
        
                }
        
                content.oninput = function(){
                    if(this.value === "" || this.value == null){
                        console.log("campo requerido");
                        document.getElementById('contentMessage').innerHTML = "Este campo es requerido"
                        this.classList.add('is-invalid');
                    }
        
                    if(this.value.length > 0){
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
        
        
                    if(letrasRegex.test(name.value) && content.value.length > 0){
                        console.log('Bueno');
                        btn.removeAttribute('disabled');  
                    }else{
                        btn.setAttribute('disabled', 'disabled');
                    }
        
                }
        
            },

            limpiar(){
                let name = document.getElementById('name');
                let content = document.getElementById('content');
              
      
              console.log("limpiando");
              name.classList.remove("is-invalid");    
              name.classList.remove("is-valid");
      
              content.classList.remove("is-invalid");
              content.classList.remove("is-valid");
      
            }

        }



 
         



    

 


    