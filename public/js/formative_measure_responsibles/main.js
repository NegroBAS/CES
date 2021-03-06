const app = {
    url: document.getElementById('url').content,
    positions: null,
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
            console.log(data);
            return data.token;
        } catch (error) {
            console.log(error);
        }
    },
    getByApi: async function () {
        try {
            let token = await this.authenticate();
            let res = await fetch('https://cronode.herokuapp.com/api/ces/instructors', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            let data = await res.json();
            let fd = new FormData();
            fd.append('formative_measure_responsibles', JSON.stringify(data.instructors));
            res = await fetch(`${this.url}formative_measure_responsibles/masive`, {
                method: 'POST',
                body: fd
            });
            data = await res.json();
            console.log(data);
            if (data.status === 200) {
                toastr.success('', data.message, {
                    closeButton: true
                });
                await app.get();
            }
            else if(data.status===500){
                toastr.error('', data.message, {
                    closeButton: true
                });
            document.getElementById('data-formative-measure-responsible').innerHTML = '';
            }
        } catch (error) {
            toastr.error('', 'Error: Intenta mas tarde', {
                closeButton: true
            });
            console.log(error);
        }
    },
    get: async function () {
        try {
            let res = await fetch(`${this.url}formative_measure_responsibles/index`);
            let data = await res.json();
            if (data[0].status == 200) {
                if (data[0].formative_measure_responsibles.length > 0) {
                    let html = '';
                    data[0].formative_measure_responsibles.forEach(formative_measure_responsible => {
                        html += `
                        <tr data-id="${formative_measure_responsible.id}">
                            <td>${formative_measure_responsible.username}</td>
                            <td>${formative_measure_responsible.misena_email}</td>
                            <td>${formative_measure_responsible.document_type_id} ${formative_measure_responsible.document}</td>
                            <td>${formative_measure_responsible.phone}</td>
                            <td>
                            <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                            <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>
                            <button class="btn btn-sm btn-outline-primary detail" data-id="${formative_measure_responsible.id}"><i class="far fa-eye"></i></button>
                            </td>
                        </tr>
                        `;
                    });
                    document.getElementById('data-formative-measure-responsible').innerHTML = html;
                }
            }

            // html = '';


            // html = '';
            // data[1].contract_types.forEach(contract_type => {
            //     html += `
            //     <option value="${contract_type.id}">${contract_type.name}</option>
            //     `;
            // });
            // document.getElementById('contract_type_id').innerHTML = html;

            // html = '';
            // data[3].positions.forEach(position => {
            //     html += `
            //     <option value="${position.id}">${position.name}</option>
            //     `;
            // });
            // document.getElementById('position_id').innerHTML = html;
        } catch (error) {
            console.log(error);
        }
    },
    getPositions: async function () {
        try {
            let res = await fetch(`${this.url}positions/index`);
            let data = await res.json();
            this.positions = data.positions;
        } catch (error) {
            console.log(error);
        }
    },
    getContract_types: async function() {
        try {
            let res = await fetch(`${this.url}contract_types/index`);
            let data = await res.json();

            let contract_types = data.contract_types;
            let html = "<option value='0'>Seleccione una</option>";
            contract_types.forEach((contract_types) => {
                html += `<option value="${contract_types.id}">${contract_types.name}</option>`;
            });
            document.getElementById("contract_type_id").innerHTML = html;

        } catch (error) {
            console.log(error);
        }
    },
    getOne: async function (id) {
        try {
            let res = await fetch(`${this.url}formative_measure_responsibles/show/${id}`);
            let data = await res.json();
            console.log(data);
            if (data.status === 200) {
                $('.modal #form').trigger('reset');
                $('#modal').modal('toggle');
                $('.modal').find('.modal-title').text('Editar responsable');
                document.getElementById('username').value = data.formative_measure_responsible.username;
                document.getElementById('misena_email').value = data.formative_measure_responsible.misena_email;
                document.getElementById('institutional_email').value = data.formative_measure_responsible.institutional_email;
                document.getElementById('document_type_id').value = data.formative_measure_responsible.document_type_id;
                document.getElementById('document').value = data.formative_measure_responsible.document;
                document.getElementById('birthdate').value = data.formative_measure_responsible.birthdate;
                document.getElementById('phone').value = data.formative_measure_responsible.phone;
                document.getElementById('phone_ip').value = data.formative_measure_responsible.phone_ip;
                document.getElementById('gender').value = data.formative_measure_responsible.gender;
                document.getElementById('position_id').value = data.formative_measure_responsible.position_id;
                document.getElementById('contract_type_id').value = data.formative_measure_responsible.contract_type_id;
                document.getElementById('type').value = data.formative_measure_responsible.type;
                // document.getElementById('photo').value = data.formative_measure_responsible.photo;
                document.getElementById('state').value = data.formative_measure_responsible.state;
            }
        } catch (error) {
            console.log(error);
        }
    },
    create: async function (form) {
        try {
            let res = await fetch(`${this.url}formative_measure_responsibles/store`, {
                method: 'POST',
                body: new FormData(form)
            });
            let data = await res.text();
            console.log(data);
            if (data.status === 200) {
                $('#modal').modal('toggle');
                app.get();
                toastr.success('', data.message, {
                    closeButton: true
                });
            }
            if (data.status === 500) {
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
            let res = await fetch(`${this.url}formative_measure_responsibles/destroy/${id}`);
            let data = await res.json();
            if (data.status === 200) {
                toastr.success('', data.message, {
                    closeButton: true
                });
                this.get();
            }
            if (data.status === 500) {
                console.log(data.error);
            }
        } catch (error) {
            console.log(error);
        }
    },
    update: async function (form, id) {
        try {
            let res = await fetch(`${this.url}formative_measure_responsibles/edit/${id}`, {
                method: 'POST',
                body: new FormData(form)
            });
            let data = await res.json();
            console.log(data);
            if (data.status === 200) {
                toastr.success('', data.message, {
                    closeButton: true
                });
                app.get();
                $('#modal').modal('toggle');
                this.edit = false;
            }
            if (data.status === 500) {
                console.log(data.error);
            }
        } catch (error) {
            console.log(error);
        }
    },
    detailResponsible: async function (id) {
		try {
            let res = await fetch(`${this.url}formative_measure_responsibles/view/${id}`);
			console.log(res);
			let data = await res.json();
            console.log(data);
            $('#modal-detail #username').text(data.username);
		} catch (error) {
            console.log(error);
        }
    }
}

function selectPosition(value, name){
    document.getElementById('position_id').value = value;
    document.getElementById('position_name').value = name;
    document.getElementById('content-position').innerHTML = "";
}

$(document).ready(async function () {
    let id = null;
    await app.get();
    await app.getPositions();
    await app.getContract_types();
    $("#formative-measure-responsibles").DataTable({
        responsive: true,
        info: false,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 }
        ],
        language: {
            url:
                "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
        },
    });

    $(document).on('click', '.detail', async function () {
        let id = $(this).data('id');
		await app.detailResponsible(id);
		$('#modal-detail').find('.modal-title').text('Detalles del Responsable');
		$('#modal-detail').modal('toggle');
	});

    document.getElementById('position_name').oninput = function(){
        if(document.getElementById('position_name').value.length > 0){
            let matches = app.positions.filter(position => {
                const rgex = new RegExp(`^${this.value}`, 'gi');
                if(isNaN(this.value)){
                    return position.name.match(rgex)
                }else{
                    return position.type.match(rgex)
                }
                
            });
            if(this.value.length === 0){
                matches=[];
            }
            let html = '<ul class="list-group">';
            if(matches.length > 0){
                if(isNaN(this.value)){
                    matches.forEach(match => {
                        html+=`<p onclick="selectPosition('${match.id}','${match.name} (${match.name}) ')" class="list-group-item list-group-item-action">${match.name} ( ${match.type} )</p>`
                    });
                    html+="</ul>";
                    document.getElementById('content-position').innerHTML = html;
                }else{
                    matches.forEach(match => {
                        html+=`<p onclick="selectPosition('${match.id}','${match.type} (${match.name}) ')" class="list-group-item list-group-item-action">${match.type} ( ${match.type} )</p>`
                    });
                    html+="</ul>";
                    document.getElementById('content-position').innerHTML = html;
                }
            }else{
                document.getElementById('content-position').innerHTML = "<p class='mt-3'>El registro no existe</p>";
            }
        }else{
            document.getElementById('content-position').innerHTML = "";
        }
    }

    

    document.getElementById('update').onclick = function () {
        document.getElementById('data-formative-measure-responsible').innerHTML = `
        <tr>
            <td colspan="5" class="text-center">Cargando ... </td>
        </tr>`;
        app.getByApi();
    }
    document.getElementById('btn-create').onclick = function () {
        $('.modal #form').trigger('reset');
        $('#modal').modal('toggle');
        $('.modal').find('.modal-title').text('Crear responsable');
        val.limpiar();
        val.validaciones();
    }
    document.getElementById('form').onsubmit = function (e) {
        e.preventDefault();
        if (app.edit) {
            app.update(this, id);
        } else {
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
        let letrasRegex = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\u00E0-\u00FC\s]+$/;
        let btnForm = document.getElementById('btnForm');
        let estado = new Array(5);

        btnForm.setAttribute('disabled', 'disabled');



        documento.oninput = function () {


            if (numberRegex.test(this.value)) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');

            } else {
                document.getElementById('documentMessage').innerHTML = "Este campo es requerido"
                this.classList.add('is-invalid');
                btnForm.setAttribute('disabled', 'disabled');

            }

            if (this.value == "" || this.value == null || this.value == 0) {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
                document.getElementById('documentMessage').innerHTML = "Este campo es requerido"
                btnForm.setAttribute('disabled', 'disabled');
            }

            if (this.value.length < 7 && this.value.length > 0) {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
                document.getElementById('documentMessage').innerHTML = "Ingrese un documento valido"
                btnForm.setAttribute('disabled', 'disabled');
            }



        }

        username.oninput = function () {

            if (letrasRegex.test(this.value)) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
                document.getElementById('nameMessage').innerHTML = "Ingrese un nombre valido"
                btnForm.setAttribute('disabled', 'disabled');
            }

            if (this.value == "" || this.value == null) {
                document.getElementById('nameMessage').innerHTML = "Este campo es requerido"
                btnForm.setAttribute('disabled', 'disabled');
                this.classList.add('is-invalid');
              
            }

            

        }

        misena_email.oninput = function () {
            let str = misena_email.value;
            let emailValue = str.substr(0,1);

            if (emailRegex.test(this.value)) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");                
            } else {
                document.getElementById("misena_emailMessage").innerHTML =
                    "Ingrese un correo valido";
                this.classList.add("is-invalid");
                btnForm.setAttribute("disabled", "disabled");
            }

            if(numberRegex.test(emailValue)){
                document.getElementById("misena_emailMessage").innerHTML =
                "El correo debe comenzar con una letra";
                this.classList.add("is-invalid");
                btnForm.setAttribute("disabled", "disabled"); 
            }


            if (this.value == "" || this.value == null) {
                this.classList.add("is-invalid");
                document.getElementById("misena_emailMessage").innerHTML =
                    "Este campo es requerido";
                btnForm.setAttribute("disabled", "disabled");
            }




        }

        institutional_email.oninput = function () {
            let str = institutional_email.value;
            let emailValue = str.substr(0,1);

            if (emailRegex.test(this.value)) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");                
            } else {
                document.getElementById("institutional_emailMessage").innerHTML =
                    "Ingrese un correo valido";
                this.classList.add("is-invalid");
                btnForm.setAttribute("disabled", "disabled");
            }

            if(numberRegex.test(emailValue)){
                document.getElementById("institutional_emailMessage").innerHTML =
                "El correo debe comenzar con una letra";
                this.classList.add("is-invalid");
                btnForm.setAttribute("disabled", "disabled"); 
            }


            if (this.value == "" || this.value == null) {
                this.classList.add("is-invalid");
                document.getElementById("institutional_emailMessage").innerHTML =
                    "Este campo es requerido";
                btnForm.setAttribute("disabled", "disabled");
            }




        }


        phone.oninput = function () {

        
            if (this.value == "" || this.value < 9) {
                document.getElementById('phoneMessage').innerHTML = "Este campo es requerido"
                btnForm.setAttribute('disabled', 'disabled');
                this.classList.add('is-invalid');

            }

            if (this.value.length > 9) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
   
            }

            if (this.value.length < 9 && this.value.length > 0) {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
                document.getElementById('phoneMessage').innerHTML = "Ingrese un telefono valido"
                btnForm.setAttribute('disabled', 'disabled');
            }

            


        }

        phone_ip.oninput = function () {


            if (this.value === "" || this.value < 6) {
                document.getElementById('phone_ipMessage').innerHTML = "Este campo es requerido"
                btnForm.setAttribute('disabled', 'disabled');
                this.classList.add('is-invalid');
 

            }

            if (this.value.length > 6) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');

            }

            if (this.value.length < 6 && this.value.length > 0) {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
                document.getElementById('phone_ipMessage').innerHTML = "Ingrese un telefono valido"
                btnForm.setAttribute('disabled', 'disabled');
            }


        }

        setInterval(input,3000);
        function input(){
            if(numberRegex.test(documento.value) && documento.value != ""){         
                if(letrasRegex.test(username.value)){                   
                    if(emailRegex.test(misena_email.value)){
                        if(emailRegex.test(institutional_email.value)){
                            if(phone.value.length > 9  && phone.value != ""){
                                if(phone_ip.value.length > 6 && phone_ip.value != ""){
                                    btnForm.removeAttribute("disabled");
                                }
                            }
                        }
                    }             
                }  
            }
        }

      },


    limpiar() {
        let documento = document.getElementById('document');
        let username = document.getElementById('username');
        let misena_email = document.getElementById('misena_email');
        let institutional_email = document.getElementById('institutional_email');
        let phone = document.getElementById('phone');
        let phone_ip = document.getElementById('phone_ip');


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






