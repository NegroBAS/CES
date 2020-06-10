const app = {
    url: document.getElementById('url').content,
    edit: false,
    list: async function () {
        let resp = await fetch(`${this.url}groups/index`);
        let res = await resp.json();

        let group = res.groups;
        let html = '';
        group.forEach(group => {
            html += `
            <tr data-id="${group.id}">
            <td>${group.code_tab}</td>
            <td>${group.name_modalities}</td>
            <td>${group.name_formation}</td>
            <td>${group.quantity_learners}</td>
            <td>

            <button class="btn btn-sm btn-outline-danger delete">Eliminar</button>
            <button class="btn btn-sm btn-outline-primary edit" data-toggle="modal" data-target="#modal">Editar</button>

            </td>
            
            </tr>
     `
        });
        document.getElementById('data-groups').innerHTML = html;

        let formation_programs = res.formation_programs;
         html = '';
        formation_programs.forEach(formation_programs => {
            html += `
            <option value="${formation_programs.id}">${formation_programs.name}</option>
             `
        });
        document.getElementById('formation_program_id').innerHTML = html;

        let modalities = res.modalities;
         html = '';
        modalities.forEach(modalities => {
            html += `
            <option value="${modalities.id}">${modalities.name}</option>
             `
        });
        document.getElementById('modality_id').innerHTML = html;




        
    },
    create: async function () {
        let resp = await fetch(`${this.url}groups/store`, {
            method: 'POST',
            body: new FormData(document.getElementById('form'))
        });
        let res = await resp.json();

        if (res.status == "ok") {
            console.log(res.message);
            $('#form').trigger('reset');
            await app.list();
        }
    },
    delete: async function (id) {
        let resp = await fetch(`${this.url}groups/destroy/${id}`);
        let res = await resp.json();
        console.log(res);
    },
    update: async function (id) {
        let resp = await fetch(`${this.url}groups/edit/${id}`, {
            method: 'POST',
            body: new FormData(document.getElementById('form'))
        });
        let res = await resp.json();
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
        let id = $($(this)[0].parentElement.parentElement).data('id');
        await app.delete(id);
        await app.list();
    });
    document.getElementById('btnCreate').onclick = function () {
        app.edit = false;
        let modal = $('#modal');
        modal.find('.modal-title').text('Crear Grupo');
        validaciones();
        $('#form').trigger('reset');
       
    }
    $(document).on('click', '.edit', async function () {
        id = $($(this)[0].parentElement.parentElement).data('id');
        app.edit = true;
        let modal = $('#modal');
        modal.find('.modal-title').text('Editar Grupo');
        let resp = await fetch(`${app.url}groups/edit/${id}`);
        let res = await resp.json();
        validaciones();
        
        let electiveStartDate = new Date(res.elective_start_date);
        console.log();
        
        
        document.getElementById('code_tab').value = res.code_tab;
        document.getElementById('quantity_learners').value = res.quantity_learners;
        document.getElementById('active_learners').value = res.active_learners;
        document.getElementById('elective_start_date').value = `${electiveStartDate.getFullYear()}-${(electiveStartDate.getMonth()+1)<10?"0"+(electiveStartDate.getMonth()+1):electiveStartDate.getMonth()+1}-${electiveStartDate.getDate()}`;
        document.getElementById('elective_end_date').value = res.elective_end_date;
        document.getElementById('practice_start_date').value = res.practice_start_date;
        document.getElementById('practice_end_date').value = res.practice_end_date;
    });

    $('#group').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }
    });
    
    // validaciones
    function validaciones(){

        let codetab = document.getElementById('code_tab');
      let quantity_learners = document.getElementById('quantity_learners');
      let active_learners = document.getElementById('active_learners');
     
 
    
      let emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
      let numberRegex = /^([0-9])*$/;
      let letrasRegex = /^[A-Za-z _]*[A-Za-z][A-Za-z _]*$/;
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
    
        //  if(estado.includes('no')){
        //      console.log('desabilitado');
        //     btnForm.removeAttribute('disabled');
    
        //  }else{
        //     btnForm.setAttribute('disabled','disabled');
            
        //  }
    
      }
});