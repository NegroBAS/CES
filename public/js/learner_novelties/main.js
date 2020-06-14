const app = {
    url: document.getElementById('url').content,
    edit: false,
    get: async function () {
        let resp = await fetch(`${this.url}learner_novelties/index`);
        let res = await resp.json();
        let learner_novelties = res.learner_novelties;
        let html = '';
        console.log(res);
        learner_novelties.forEach(learner_novelties => {
            html += `
            <tr data-id="${learner_novelties.id}">
                <td>${learner_novelties.learners_name}</td>
                <td>${learner_novelties.committees_number}</td>
                <td>${learner_novelties.novelty_name}</td>
                <td>${learner_novelties.justification}</td>
                <td>${learner_novelties.reply_date}</td>
                <td>
                <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>
                </td>
            </tr>
            `
        });
        document.getElementById('data-learner_novelties').innerHTML = html;

        let committees = res.committees.committees;
         html = '';
         committees.forEach(committees => {
            html +=  `
             <option value="${committees.id}">${committees.record_number}</option>
             `
        });
        document.getElementById('committee_id').innerHTML = html;

        let learners = res.learners.learners;
         html = '';
        learners.forEach(learners => {
            html +=  `
             <option value="${learners.id}">${learners.username}</option>
             `
        });
        document.getElementById('learner_id').innerHTML = html;

        let novelty_types = res.novelty_types.novelty_types;
         html = '';
        novelty_types.forEach(novelty_types => {
            html +=  `
             <option value="${novelty_types.id}">${novelty_types.name}</option>
             `
        });
        document.getElementById('novelty_type_id').innerHTML = html;
    },
    getOne: async function (id) {
        try {
            let res = await fetch(`${this.url}learner_novelties/show/${id}`);
            let data = await res.json();
            console.log(data);
            if(data.status===200){
                $('.modal #form').trigger('reset');
                $('.modal').modal('toggle');
                $('.modal').find('.modal-title').text('Editar novedad');
                document.getElementById('learner_id').value = data.novelty.learner_id;
                document.getElementById('committee_id').value = data.novelty.committee_id;
                document.getElementById('novelty_type_id').value = data.novelty.novelty_type_id;
                document.getElementById('justification').value = data.novelty.justification;
                document.getElementById('reply_date').value = data.novelty.reply_date;
            }
        } catch (error) {
            console.log(error);
        }
    },
    create:async function(form){
        try {
            let res = await fetch(`${this.url}learner_novelties/store`, {
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
            let res  = await fetch(`${this.url}learner_novelties/destroy/${id}`);
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
            let res = await fetch(`${this.url}learner_novelties/edit/${id}`, {
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
        $('.modal').find('.modal-title').text('Crear novedad');
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
              Swal.fire("Eliminado!", "La novedad ha sido eliminada.", "success");
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


$('#requestab').DataTable({
    "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
    }
});

const val = {
     validaciones() {
        let justification = document.getElementById("justification");
    
        let letrasRegex = /^[a-zA-ZÀ-ÿ\u00E0-\u00FC]+(\s*[a-zA-ZÀ-ÿ\u00E0-\u00FC]*)*[a-zA-ZÀ-ÿ\u00E0-\u00FC]+$/;
        let btn = document.getElementById("btnForm");

        btn.setAttribute("disabled", "disabled");
    
        justification.oninput = function () {
          if (letrasRegex.test(this.value)) {
            this.classList.remove("is-invalid");
            this.classList.add("is-valid");
          } else {
            this.classList.remove("is-valid");
            this.classList.add("is-invalid");
            document.getElementById("justificationMessage").innerHTML =
              "Este campo es requerido";
          }
    
          if (this.value === "") {
            console.log("campo requerido");
            document.getElementById("justificationMessage").innerHTML =
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
        let justification = document.getElementById("justification");
        

        console.log("limpiando");
        justification.classList.remove("is-invalid");    
        justification.classList.remove("is-valid");

      }


}




