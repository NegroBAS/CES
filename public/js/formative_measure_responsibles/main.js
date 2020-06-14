const app = {
    url:document.getElementById('url').content,
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
            let res = await fetch('https://cronode.herokuapp.com/api/ces/instructors', {
                headers:{
                    'Authorization':`Bearer ${token}`
                }
            });
            let data = await res.json();
            console.log(data.instructors);
            let fd = new FormData();
            fd.append('formative_measure_responsibles', JSON.stringify(data.instructors));
            res = await fetch(`${this.url}formative_measure_responsibles/masive`, {
                method:'POST',
                body:fd
            });
            data = await res.json();
            if(data.status===200){
                toastr.success('', data.message, {
                    closeButton:true
                });
                app.get();
            }
        } catch (error) {
            console.log(error);
        }
    },
    get:async function () {
        try {
            let res = await fetch(`${this.url}formative_measure_responsibles/index`);
            let data = await res.json();
            // if(data.status==200){
                if(data.formative_measure_responsible.formative_measure_responsibles.length>0){
                    let html = '';
                    data.formative_measure_responsible.formative_measure_responsibles.forEach(formative_measure_responsible => {
                        html+=`
                        <tr data-id="${formative_measure_responsible.id}">
                            <td>${formative_measure_responsible.username}</td>
                            <td>${formative_measure_responsible.misena_email}</td>
                            <td>${formative_measure_responsible.document}</td>
                            <td>${formative_measure_responsible.phone}</td>
                            <td>
                            <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                            <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>
                            </td>
                        </tr>
                        `;
                    });
                    document.getElementById('data-formative-measure-responsible').innerHTML = html;
                }
            // }

             html = '';
                    data.DocumentType.forEach(DocumentType => {
                        html+=`
                       <option value="${DocumentType.id}">${DocumentType.name}</option>
                        `;
                    });
                    document.getElementById('document_type_id').innerHTML = html;


            html = '';
            data.ContractType.contract_types.forEach(ContractType => {
                html+=`
                <option value="${ContractType.id}">${ContractType.name}</option>
                `;
            });
            document.getElementById('contract_type_id').innerHTML = html;

            html = '';
            data.Position.positions.forEach(positions => {
                html+=`
                <option value="${positions.id}">${positions.name}</option>
                `;
            });
            document.getElementById('position_id').innerHTML = html;

        } catch (error) {
            console.log(error);
        }
    },
    getOne: async function (id) {
        try {
            let res = await fetch(`${this.url}formative_measure_responsibles/show/${id}`);
            let data = await res.json();
            console.log(data);
            if(data.status===200){
                $('.modal #form').trigger('reset');
                $('.modal').modal('toggle');
                $('.modal').find('.modal-title').text('Editar responsable');
                document.getElementById('username').value = data.responsible.username;
                document.getElementById('misena_email').value = data.responsible.misena_email;
                document.getElementById('institutional_email').value = data.responsible.institutional_email;
                document.getElementById('document_type_id').value = data.responsible.document_type_id;
                document.getElementById('document').value = data.responsible.document;
                document.getElementById('birthdate').value = data.responsible.birthdate;
                document.getElementById('phone').value = data.responsible.phone;
                document.getElementById('phone_ip').value = data.responsible.phone_ip;
                document.getElementById('gender').value = data.responsible.gender;
                document.getElementById('position_id').value = data.responsible.position_id;
                document.getElementById('contract_type_id').value = data.responsible.contract_type_id;
                document.getElementById('type').value = data.responsible.type;
                // document.getElementById('photo').value = data.responsible.photo;
                document.getElementById('state').value = data.responsible.state;
            }
        } catch (error) {
            console.log(error);
        }
    },
    create:async function(form){
        try {
            let res = await fetch(`${this.url}formative_measure_responsibles/store`, {
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
            let res  = await fetch(`${this.url}formative_measure_responsibles/destroy/${id}`);
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
            let res = await fetch(`${this.url}formative_measure_responsibles/edit/${id}`, {
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
    document.getElementById('update').onclick = function () {
        app.getByApi();
    }
    document.getElementById('btn-create').onclick = function(){
        $('.modal #form').trigger('reset');
        $('.modal').modal('toggle');
        $('.modal').find('.modal-title').text('Crear responsable');
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
              Swal.fire("Eliminado!", "El responsable ha sido eliminado.", "success");
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

$("#formative-measure-responsibles").DataTable({
    responsive: true,
    language: {
        url:
            "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
    },
});

const val = {
     validaciones() {
        let documento = document.getElementById('document');
        let username = document.getElementById('username');
        let misena_email = document.getElementById('misena_email');
        let institutional_email = document.getElementById('institutional_email');
        let phone = document.getElementById('phone');
        let phone_ip = document.getElementById('phone_ip');


        let emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
        let numberRegex = /^([0-9])*$/;
        let letrasRegex = /^[a-zA-ZÀ-ÿ\u00E0-\u00FC]+(\s*[a-zA-ZÀ-ÿ\u00E0-\u00FC]*)*[a-zA-ZÀ-ÿ\u00E0-\u00FC]+$/;
        let btnForm = document.getElementById('btnForm');
        let estado = new Array(5);

        btnForm.setAttribute('disabled', 'disabled');



        documento.oninput = function () {


            if (numberRegex.test(this.value)) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                estado[0] = 'si';
            } else {
                document.getElementById('documentMessage').innerHTML = "Este campo es requerido"
                this.classList.add('is-invalid');
                estado[0] = 'no';
            }

            if (this.value.length < 7) {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
                document.getElementById('documentMessage').innerHTML = "Este campo es requerido"
                estado[0] = 'no';
            }



        }

        username.oninput = function () {
            if (this.value === "" || this.value == null) {
                console.log("campo requerido");
                document.getElementById('nameMessage').innerHTML = "Este campo es requerido"
                this.classList.add('is-invalid');
                estado[1] = 'no';
            }

            if (this.value.length > 0) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                estado[1] = 'si';
            }

            if (letrasRegex.test(this.value)) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
                document.getElementById('nameMessage').innerHTML = "Este campo es requerido"
            }

        }

        misena_email.oninput = function () {


            if (emailRegex.test(this.value)) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                btnForm.removeAttribute('disabled');
                estado[2] = 'si';
            } else {
                document.getElementById('misena_emailMessage').innerHTML = "Este campo es requerido"
                this.classList.add('is-invalid');
                btnForm.setAttribute('disabled', 'disabled');
                estado[2] = 'no';
            }

            if (this.value === "" || this.value == null) {
                console.log("campo requerido");
                this.classList.add('is-invalid');
                btnForm.setAttribute('disabled', 'disabled');
                estado[2] = 'no';
            }


        }

        institutional_email.oninput = function () {


            if (emailRegex.test(this.value)) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                btnForm.removeAttribute('disabled');
                estado[2] = 'si';
            } else {
                document.getElementById('institutional_emailMessage').innerHTML = "Este campo es requerido"
                this.classList.add('is-invalid');
                btnForm.setAttribute('disabled', 'disabled');
                estado[2] = 'no';
            }

            if (this.value === "" || this.value == null) {
                console.log("campo requerido");
                this.classList.add('is-invalid');
                btnForm.setAttribute('disabled', 'disabled');
                estado[2] = 'no';
            }


        }


        phone.oninput = function () {


            if (this.value === "" || this.value < 9) {
                console.log("campo requerido");
                document.getElementById('phoneMessage').innerHTML = "Este campo es requerido"
                this.classList.add('is-invalid');
                estado[5] = 'no';

            }

            if (this.value.length > 9) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                estado[5] = 'si';

            }


        }

        phone_ip.oninput = function () {


            if (this.value === "" || this.value < 6) {
                console.log("campo requerido");
                document.getElementById('phone_ipMessage').innerHTML = "Este campo es requerido"
                this.classList.add('is-invalid');
                estado[5] = 'no';

            }

            if (this.value.length > 6) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                estado[5] = 'si';

            }


        }
      },

      limpiar(){
        let documento = document.getElementById('document');
        let username = document.getElementById('username');
        let misena_email = document.getElementById('misena_email');
        let institutional_email = document.getElementById('institutional_email');
        let phone = document.getElementById('phone');
        let phone_ip = document.getElementById('phone_ip');
        

        console.log("limpiando");
        username.classList.remove("is-invalid");    
        username.classList.remove("is-valid");

        documento.classList.remove("is-invalid");
        documento.classList.remove("is-valid");

        misena_email.classList.remove("is-invalid");
        misena_email.classList.remove("is-valid");

        institutional_email.classList.remove("is-invalid");
        institutional_email.classList.remove("is-valid");

        phone_ip.classList.remove("is-invalid");
        phone_ip.classList.remove("is-valid");

        phone.classList.remove("is-invalid");
        phone.classList.remove("is-valid");

      }


}






    