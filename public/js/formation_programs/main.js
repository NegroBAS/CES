const app = {
        url: document.getElementById('url').content,
        edit: false,
        list: async function () {
            let resp = await fetch(`${this.url}formation_programs/index`);
            let res = await resp.json();

            // let formation_program_types = res.formation_program_types;
            // let html = '';
            // formation_program_types.forEach(formation_program_types => {
            //     html += `
            //            <option value="${formation_program_types.id}">${formation_program_types.name}</option>
            //              `
            // });
            // document.getElementById('formation_program_type_id').innerHTML = html;


            let formation_programs = res.formation_programs;
            let html = '';
            formation_programs.forEach(formation_programs => {
                html += `
                        <tr data-id="${formation_programs.id}">
                        <td>${formation_programs.code}</td>
                        <td>${formation_programs.name}</td>
                        <!-- //NOMBRE DE typo de programa// -->
                        <td>${formation_programs.name_formation}</td>
                        <td>

                    <button class="btn btn-sm btn-primary edit" data-toggle="modal" data-target="#modal">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete">
                        <i class="fas fa-trash-alt"></i>
                    </button>

                        </td>
                        
                        </tr>
                         `
            });
            document.getElementById('data-formation_programs').innerHTML = html;
        },
        create: async function () {
            let resp = await fetch(`${this.url}formation_programs/save`, {
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
            let resp = await fetch(`${this.url}formation_programs/destroy/${id}`);
            let res = await resp.json();
            console.log(res);
        },
        update: async function (id) {
            let resp = await fetch(`${this.url}formation_programs/edit/${id}`, {
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
                        'El aprendiz ha sido eliminado.',
                        'success'
                    )
                    let id = $($(this)[0].parentElement.parentElement).data('id');
                    app.delete(id);
                     app.list();
                }
            })

        });
        document.getElementById('btnCreate').onclick = function () {
            app.edit = false;
            let modal = $('#modal');
            modal.find('.modal-title').text('Crear Parametro de comite');
            validaciones();
            $('#form').trigger('reset');
        }
        $(document).on('click', '.edit', async function () {
            id = $($(this)[0].parentElement.parentElement).data('id');
            app.edit = true;
            let modal = $('#modal');
            modal.find('.modal-title').text('Editar Parametro de comite');
            let resp = await fetch(`${app.url}formation_programs/show/${id}`);
            let res = await resp.json();
            validaciones();
            document.getElementById('name').value = res.name;
            document.getElementById('code').value = res.code;
            document.getElementById('formation_program_type_id').value = res.formation_program_type_id;
        });

        $('#tabla').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            }
        });

        function validaciones(){

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
                    document.getElementById('documentMessage').innerHTML = "Este campo es requerido"
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
        
              
          }
        
    });


    