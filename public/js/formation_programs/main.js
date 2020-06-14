const app = {
        url: document.getElementById('url').content,
        edit: false,
        get: async function () {
            let resp = await fetch(`${this.url}formation_programs/index`);
            let res = await resp.json();

            let formation_program_types = res.formation_program_types;
            let html = '';
            formation_program_types.forEach(formation_program_types => {
                html += `
                       <option value="${formation_program_types.id}">${formation_program_types.name}</option>
                         `
            });
            document.getElementById('formation_program_type_id').innerHTML = html;


            let formation_programs = res.formation_programs;
             html = '';
            formation_programs.forEach(formation_programs => {
                html += `
                        <tr data-id="${formation_programs.id}">
                        <td>${formation_programs.code}</td>
                        <td>${formation_programs.name}</td>
                        <!-- //NOMBRE DE typo de programa// -->
                        <td>${formation_programs.name_formation}</td>
                        <td>

                        <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                        <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>

                        </td>
                        
                        </tr>
                         `
            });
            document.getElementById('data-formation_programs').innerHTML = html;
        },
        getOne: async function (id) {
            try {
                let res = await fetch(`${this.url}formation_programs/show/${id}`);
                let data = await res.json();
                console.log(data);
                if(data.status===200){
                    $('.modal #form').trigger('reset');
                    $('.modal').modal('toggle');
                    $('.modal').find('.modal-title').text('Editar programa de formacion');
                    document.getElementById('name').value = data.formation_programs.name
                    document.getElementById('code').value = data.formation_programs.code
 
                }
            } catch (error) {
                console.log(error);
            }
        },
        create:async function(form){
            try {
                let res = await fetch(`${this.url}formation_programs/store`, {
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
                let res  = await fetch(`${this.url}formation_programs/destroy/${id}`);
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
                let res = await fetch(`${this.url}formation_programs/edit/${id}`, {
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
            $('.modal').find('.modal-title').text('Crear programa de formacion');
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
                  Swal.fire("Eliminado!", "El programa ha sido eliminado.", "success");
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

    const val = {
            validaciones(){

                let code = document.getElementById('code');
                let name = document.getElementById('name');
               
                let numberRegex = /^([0-9])*$/;
                let letrasRegex = /^[A-Za-z _]*[A-Za-z][A-Za-z _]*$/;
                let btnForm = document.getElementById('btnForm');
                let estado = new Array(5);
              
                btnForm.setAttribute('disabled','disabled');
                
              
              
                  code.oninput = function(){
              
                     
                      if(numberRegex.test(this.value)){
                          this.classList.remove('is-invalid');
                              this.classList.add('is-valid');
                              estado[0] = 'si';
                      }else {
                          document.getElementById('codeMessage').innerHTML = "Este campo es requerido"
                          this.classList.add('is-invalid');
                          estado[0] = 'no';
                      }
              
                      if(this.value.length < 6){
                          this.classList.remove('is-valid');
                          this.classList.add('is-invalid');
                          document.getElementById('codeMessage').innerHTML = "Este campo es requerido"
                          estado[0] = 'no';
                      }
              
                      
              
                  }
              
                  name.oninput = function(){
                      if(this.value === "" || this.value == null){
                          console.log("campo requerido");
                          document.getElementById('nameMessage').innerHTML = "Este campo es requerido"
                          this.classList.add('is-invalid');
                          estado[1] = 'no';
                      }
              
                      if(this.value.length > 0){
                          this.classList.remove('is-invalid');
                          this.classList.add('is-valid');
                          estado[1] = 'si';
                      }
              
                      if (letrasRegex.test(this.value)){
                          this.classList.remove('is-invalid');
                          this.classList.add('is-valid');
                      }else{
                          this.classList.remove('is-valid');
                          this.classList.add('is-invalid');
                          document.getElementById('nameMessage').innerHTML = "Este campo es requerido"
                      }
      
      
                      if(name.value.length > 0 && code.value.length > 0){
                          console.log('Bueno');
                          document.getElementById('btnForm').removeAttribute('disabled');  
                      }else{
                          btnForm.setAttribute('disabled','disabled');
                      }
              
                  }
              
                    
            },

            limpiar(){
                let code = document.getElementById('code');
                let name = document.getElementById('name');
              
      
              console.log("limpiando");
              code.classList.remove("is-invalid");    
              code.classList.remove("is-valid");
      
              name.classList.remove("is-invalid");
              name.classList.remove("is-valid");
      
            }

    }
        
        
        
       
        



    