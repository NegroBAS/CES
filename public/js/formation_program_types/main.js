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
            let res = await fetch('https://cronode.herokuapp.com/api/ces/formationProgramTypes', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            let data = await res.json();
            let fd = new FormData();
            fd.append('formation_program_types', JSON.stringify(data.formationProgramTypes));
            res = await fetch(`${this.url}formation_program_types/masive`, {
                method:'POST',
                body: fd
            });
            data = await res.json();
            console.log(data);
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
        let resp = await fetch(`${this.url}formation_program_types/index`);
        let res = await resp.json();
        
        let formation_program_types = res.formation_program_types;
        let html = '';
        formation_program_types.forEach(formation_program_type => {
            html += `
            <div class="col-12 col-md-6 col-xl-6 mb-2">
                    <div class="card" data-id="${formation_program_type.id}">
                        <div class="card-header bg-primary"></div>
                        <div class="card-body text-center text-truncate">
                            <h5>${formation_program_type.name}</h5>
                            <p>Meses Lectivos ${formation_program_type.elective_months} <br>
                             Meses Practicos  ${formation_program_type.practice_months}</p>
                             <button class="btn btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                             <button class="btn btn-outline-primary edit"><i class="far fa-edit"></i></button>                 
                        </div>
                    </div> 
            </div>  `
        });
        document.getElementById('data-formation_program_types').innerHTML = html;
    },
    getOne: async function (id) {
        try {
            let res = await fetch(`${this.url}formation_program_types/show/${id}`);
            let data = await res.json();
            console.log(data);
            if(data.status===200){
                $('.modal #form').trigger('reset');
                $('.modal').modal('toggle');
                $('.modal').find('.modal-title').text('Editar tipo de programa');
                document.getElementById('name').value = data.formation_program_type.name
                document.getElementById('elective_months').value = data.formation_program_type.elective_months
                document.getElementById('practice_months').value = data.formation_program_type.practice_months
            }
        } catch (error) {
            console.log(error);
        }
    },
    create:async function(form){
        try {
            let res = await fetch(`${this.url}formation_program_types/store`, {
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
            let res  = await fetch(`${this.url}formation_program_types/destroy/${id}`);
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
            let res = await fetch(`${this.url}formation_program_types/edit/${id}`, {
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
        $('.modal').find('.modal-title').text('Crear tipo de programa');
        val.limpiar();
        val.validaciones();
    }
    document.getElementById('btnUpdate').onclick = async function(){
        document.getElementById('data-formation_program_types').innerHTML = `
        <div class="col">
            <h6>Cargando ...</h6>
        </div>
        `;
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
              Swal.fire("Eliminado!", "El tipo de programa ha sido eliminado.", "success");
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

    const val= {
        validaciones(){

            let name = document.getElementById('name');
          let elective_months = document.getElementById('elective_months');
          let practice_months = document.getElementById('practice_months');
         
     
        
        
          let numberRegex = /^([0-9])*$/;
          let letrasRegex = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\u00E0-\u00FC\s]+$/;
          let btn = document.getElementById('btnForm');
          let estado = new Array(5);
        
          btn.setAttribute('disabled','disabled');
    
          name.oninput = function(){
    
            if (letrasRegex.test(this.value)){
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }else{
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
                btn.setAttribute('disabled', 'disabled');
                document.getElementById('nameMessage').innerHTML = "Este campo es requerido"
            
            }
    
    
              if(this.value === "" || this.value == null){
                  console.log("campo requerido");
                  document.getElementById('nameMessage').innerHTML = "Este campo es requerido"
                  this.classList.add('is-invalid');
              }
      
          }
        
    
          elective_months.oninput = function(){
    
            if (numberRegex.test(this.value)){
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }else{
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
                btn.setAttribute('disabled', 'disabled');
                document.getElementById('electiveMessage').innerHTML = "Este campo es requerido"
            
            }
                    
        
                if(this.value === "" || this.value == null || this.value < 1 ){
                    console.log("campo requerido");
                    document.getElementById('electiveMessage').innerHTML = "Este campo es requerido"
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
        
        
            
        
        
            }
    
            practice_months.oninput = function(){
    
                if(numberRegex.test(this.value)){
                    this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                }else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                    btn.setAttribute('disabled', 'disabled');
                    document.getElementById('practiceMessage').innerHTML = "Este campo es requerido"
                }
                    
        
                if(this.value === "" || this.value == null){
                    console.log("campo requerido");
                    document.getElementById('practiceMessage').innerHTML = "Este campo es requerido"
                    this.classList.add('is-invalid');
                }
    
                if(numberRegex.test(this.value) && numberRegex.test(elective_months.value) && letrasRegex.test(name.value)){
                    btn.removeAttribute('disabled');
                }else{
                    btn.setAttribute('disabled', 'disabled');
                }
    
            }
    
    
        
          },

          limpiar(){
            let name = document.getElementById('name');
            let elective_months = document.getElementById('elective_months');
            let practice_months = document.getElementById('practice_months');
            
    
            console.log("limpiando");
            name.classList.remove("is-invalid");    
            name.classList.remove("is-valid");
    
            elective_months.classList.remove("is-invalid");
            elective_months.classList.remove("is-valid");

            practice_months.classList.remove("is-invalid");
            practice_months.classList.remove("is-valid");
    
          }


    }
    
    
    
    
