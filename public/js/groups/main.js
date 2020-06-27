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
            let res = await fetch('https://cronode.herokuapp.com/api/ces/groups', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            let data = await res.json();
            console.log(data);
            let fd = new FormData();
            fd.append('groups', JSON.stringify(data.groups));
            res = await fetch(`${this.url}groups/masive`, {
                method:'POST',
                body:fd
            });
            data = await res.json();
            if(data.status===200){
                await app.get();
                toastr.success('', data.message, {
                    closeButton: true
                });
            }
        } catch (error) {
            console.log(error);
        }
    },
    get: async function () {
        let res = await fetch(`${this.url}groups/index`);
        let data = await res.json();
        let html = '';
        data[0].groups.forEach(group => {
            html += `
            <tr data-id="${group.id}">
                <td>${group.code_tab}</td>
                <td>${group.name_formation}</td>
                <td>${group.name_modalities}</td>
                <td>${group.quantity_learners}</td>
                <td>
                    <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                    <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>
                </td>
            </tr>
     `
        });
        document.getElementById('data-groups').innerHTML = html;
         html = '';
        data[2].formation_programs.forEach(formation_program => {
            html += `
            <option value="${formation_program.id}">${formation_program.name}</option>
             `
        });
        document.getElementById('formation_program_id').innerHTML = html;
         html = '';
        data[1].modalities.forEach(modality => {
            html += `
            <option value="${modality.id}">${modality.name}</option>
             `
        });
        document.getElementById('modality_id').innerHTML = html;        
    },
    getOne: async function (id) {
        try {
            let res = await fetch(`${this.url}groups/show/${id}`);
            let data = await res.json();
            console.log(data.groups);
            if(data.status===200){
                $('.modal #form').trigger('reset');
                $('.modal').modal('toggle');
                $('.modal').find('.modal-title').text('Editar grupo');
                document.getElementById('code_tab').value = data.group.code_tab;
                document.getElementById('quantity_learners').value = data.group.quantity_learners;
                document.getElementById('active_learners').value = data.group.active_learners;
                document.getElementById('elective_start_date').value = data.group.elective_start_date;
                document.getElementById('elective_end_date').value = data.group.elective_end_date;
                document.getElementById('practice_start_date').value = data.group.practice_start_date;
                document.getElementById('practice_end_date').value = data.group.practice_end_date;
            }
        } catch (error) {
            console.log(error);
        }
    },
    create:async function(form){
        try {
            let res = await fetch(`${this.url}groups/store`, {
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
            let res  = await fetch(`${this.url}groups/destroy/${id}`);
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
            let res = await fetch(`${this.url}groups/edit/${id}`, {
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
    $('#group').DataTable({
        language: {
            url:
             "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
        },
    });
    document.getElementById('btn-create').onclick = function(){
        console.log("modal crear")
        $('.modal #form').trigger('reset');
        $('.modal').modal('toggle');
        $('.modal').find('.modal-title').text('Crear grupo');
        val.limpiar();
        val.validaciones();
    }
    document.getElementById('btnUpdate').onclick=async function(){
        document.getElementById('data-groups').innerHTML = 'Cargando ...'
        await app.getByApi();
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
              Swal.fire("Eliminado!", "El grupo ha sido eliminado.", "success");
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
    
    // validaciones
    const val ={
        validaciones(){

        let codetab = document.getElementById('code_tab');
          let quantity_learners = document.getElementById('quantity_learners');
          let active_learners = document.getElementById('active_learners');
         
     
        
          let emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
          let numberRegex = /^([0-9])*$/;
          let letrasRegex = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\u00E0-\u00FC\s]+$/;
          let btnForm = document.getElementById('btnForm');
          let estado = new Array(5);
        
          btnForm.setAttribute('disabled','disabled');
        
        
        
            codetab.oninput = function(){
    
                if(numberRegex.test(this.value)){
                    this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                        estado[0] = 'si';
                }else {
                    document.getElementById('codeMessage').innerHTML = "Este campo es requerido"
                    this.classList.add('is-invalid');
                    estado[0] = 'no';
                }
                    
        
                if(this.value === "" || this.value.length < 4 ){
                    console.log("campo requerido");
                    document.getElementById('codeMessage').innerHTML = "Este campo es requerido"
                    this.classList.add('is-invalid');
                    estado[5] = 'no';
        
                }
        
              
        
        
            }
    
            quantity_learners.oninput = function(){
    
                if(numberRegex.test(this.value)){
                    this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                        estado[0] = 'si';
                }else {
                    document.getElementById('quantityMessage').innerHTML = "Este campo es requerido"
                    this.classList.add('is-invalid');
                    estado[0] = 'no';
                }
                    
        
                if(this.value === "" || this.value.length < 2 || this.value < 8  ){
                    console.log("campo requerido");
                    document.getElementById('quantityMessage').innerHTML = "Este campo es requerido"
                    this.classList.add('is-invalid');
                    estado[5] = 'no';
        
                }
        
            
        
        
            }
    
            active_learners.oninput = function(){
    
                if(numberRegex.test(this.value)){
                    this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                        btnForm.removeAttribute('disabled');
                        estado[0] = 'si';
                }else {
                    document.getElementById('activeMessage').innerHTML = "Este campo es requerido"
                    this.classList.add('is-invalid');
                    btnForm.setAttribute('disabled','disabled');
                    estado[0] = 'no';
                }
                    
        
                if(this.value === "" || this.value.length < 1 || this.value < 8 ){
                    console.log("campo requerido");
                    document.getElementById('activeMessage').innerHTML = "Este campo es requerido"
                    this.classList.add('is-invalid');
                    btnForm.setAttribute('disabled','disabled');
                    estado[5] = 'no';
        
                }
        
        
            }




        },

        limpiar(){
            let codetab = document.getElementById('code_tab');
            let quantity_learners = document.getElementById('quantity_learners');
            let active_learners = document.getElementById('active_learners');
          
  
          console.log("limpiando");
          codetab.classList.remove("is-invalid");    
          codetab.classList.remove("is-valid");
  
          quantity_learners.classList.remove("is-invalid");
          quantity_learners.classList.remove("is-valid");

          active_learners.classList.remove("is-invalid");
          active_learners.classList.remove("is-valid");
  
        }

    }

