const app = {
    url: document.getElementById("url").content,
    groups: null,
    getData: async function () {
        try {
            let res = await fetch(`${this.url}learners/index`);
            let data = await res.json();
            let html = "";
            data[0].learners.forEach((learner) => {
                //fila de td para imagen
                // <td class="text-center"><img class="img-fluid img-thumbnail" width="200" height="200" src="${learner.photo}"></td>
                html += `
                <tr data-id="${learner.id}">
                    <td>${learner.username}</td>
                    <td>${learner.document_type}</td>                   
                    <td>${learner.document}</td>
                    <td>${learner.phone}</td>
                    <td>${learner.email}</td>
                    <td class="buttons">
                    <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                    <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>
                    <button class="btn btn-sm btn-outline-primary view"><i class="far fa-eye"></i></button>
                    </td>
                </tr>
                `;
            });
            document.getElementById("data-learners").innerHTML = html;

            html = "";
            data[2].groups.forEach((group) => {
                html += `
             <option value="${group.id}">${group.code_tab}</option>
                `;
            });
            document.getElementById("group_id").innerHTML = html;
            document.getElementById("group_id_csv").innerHTML = html;
        } catch (error) {
            console.log(error);
        }
    },
    getOne: async function (id) {
        try {
            let res = await fetch(`${this.url}learners/show/${id}`);
            let data = await res.json();
            if (data.status === 200) {
                $("#createModal").trigger("reset");
                $("#createModal").modal("toggle");
                $("#createModal").find(".modal-title").text("Editar Cargo");
                document.getElementById("username").value =
                    data.learner.username;
                document.getElementById("document").value =
                    data.learner.document;
                document.getElementById("phone").value = data.learner.phone;
                document.getElementById("email").value = data.learner.email;
                document.getElementById("document_type").value = data.learner.document_type;
                document.getElementById("group_id").value = data.learner.group_id;
                document.getElementById("group_id_csv").value = data.learner.group_id;
                document.getElementById("birthdate").value = data.learner.birthdate;
                document.getElementById("photo_2").value = data.learner.photo;
            }
        } catch (error) {
            console.log(error);
        }
    },
    create: async function (form) {
        try {
            let res = await fetch(`${this.url}learners/store`, {
                method: "POST",
                body: new FormData(form),
            });
            let data = await res.json();
            console.log(data);
            if (data.status === 200) {
                $("#createModal").modal("toggle");
                await app.getData();
                toastr.success("", data.message, {
                    closeButton: true,
                });
            }
            if (data.status === 500) {
                console.log(data.error);
                toastr.error("", data.error.errorInfo[2], {
                    closeButton: true,
                });
            }
        } catch (error) {
            console.log(error);
        }
    },
    delete: async function (id) {
        try {
            let res = await fetch(`${this.url}learners/destroy/${id}`);
            let data = await res.json();
            if (data.status === 200) {
                toastr.success("", data.message, {
                    closeButton: true,
                });
                this.getData();
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
            let res = await fetch(`${this.url}learners/edit/${id}`, {
                method: "POST",
                body: new FormData(form),
            });
            let data = await res.json();
            console.log(data);
            if (data.status === 200) {
                toastr.success("", data.message, {
                    closeButton: true,
                });
                app.getData();
                $("#createModal").modal("toggle");
                this.edit = false;
            }
            if (data.status === 500) {
                console.log(data.error);
            }
        } catch (error) {
            console.log(error);
        }
    },
    csv: async function () {
        try {
            let res = await fetch(`${this.url}learners/csv`, {
                method: "POST",
                body: new FormData(form_csv),
            });    
            let data = await res.json();
            if (data.status === 200) {
                $("#filecsv").modal("toggle");
                app.getData();
                toastr.success("", data.message, {
                    closeButton: true,
                });
            }
            if (data.status === 500) {
                console.log(data.error);
                toastr.error("", data.error.errorInfo[2], {
                    closeButton: true,
                });
            }
        } catch (error) {
            console.log(error);
        }
    },
    getGroups: async function(){
        try {
			let res = await fetch(`${this.url}groups/index`);
            let data = await res.json();
			this.groups = data[0].groups;
		} catch (error) {
			console.log(error);
		}
	}
};

function selectGroup(value,name) {
    document.getElementById('group_id').value = value;
    document.getElementById('group_name').value = name;
    document.getElementById('content-group').innerHTML = "";
    document.getElementById('group_id_csv').value = value;
    document.getElementById('group_name_csv').value = name;
    document.getElementById('content_group_csv').innerHTML = "";
}

$(document).ready(async function () {
    await app.getData();
    await app.getGroups();
    $("#learners").DataTable({
        responsive: true,
        info: false,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 1, targets: -1 },
        ],
        language: {
            url:
                "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
        },
    });

    document.getElementById('group_name').oninput = function(){
        let matches = app.groups.filter(group => {
            const rgex = new RegExp(`^${this.value}`, 'gi');
            return group.code_tab.match(rgex)
        });
        if(this.value.length === 0){
            matches=[];
        }
        let html = '<ul class="list-group">';
        if(matches.length > 0){
            matches.forEach(match => {
                html+=`<p onclick="selectGroup('${match.id}','${match.code_tab}')" class="list-group-item list-group-item-action">${match.code_tab}</p>`
            });
            html+="</ul>";
            document.getElementById('content-group').innerHTML = html;
        }else{
            document.getElementById('content-group').innerHTML = "<p class='mt-3'>El registro no existe</p>";
        }
    }

    document.getElementById('group_name_csv').oninput = function(){
        let matches = app.groups.filter(group => {
            const rgex = new RegExp(`^${this.value}`, 'gi');
            return group.code_tab.match(rgex)
        });
        if(this.value.length === 0){
            matches=[];
        }
        let html = '<ul class="list-group">';
        if(matches.length > 0){
            matches.forEach(match => {
                html+=`<p onclick="selectGroup('${match.id}','${match.code_tab}')" class="list-group-item list-group-item-action">${match.code_tab}</p>`
            });
            html+="</ul>";
            document.getElementById('content_group_csv').innerHTML = html;
        }else{
            document.getElementById('content_group_csv').innerHTML = "<p class='mt-3'>El registro no existe</p>";
        }
    }

    document.getElementById("btn-create").onclick = function () {
        $("#createModal").trigger("reset");
        $("#createModal").modal("toggle");
        $("#createModal").find(".modal-title").text("Crear aprendiz");

        limpiar();
        validaciones();
    };


    document.getElementById("form").onsubmit = function (e) {
        e.preventDefault();
        if (app.edit) {
            app.update(this, id);
        } else {
            app.create(this);
        }
    };
    document.getElementById("btn-update").onclick = function () {
        $("#filecsv").trigger("reset");
        $("#filecsv").modal("toggle");
        $("#filecsv").find(".modal-title").text("Cargar aprendices");
        validacion_csv();
    };

    document.getElementById("btnFormCsv").onclick = function (e) {
        e.preventDefault();
        app.csv(this);
        validacion_csv();
        limpiar();
    };


    $(document).on("click", ".delete", function () {
        id = $(this.parentElement.parentElement).data("id");
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
                Swal.fire(
                    "Eliminado!",
                    "El aprendiz ha sido eliminado.",
                    "success"
                );
                let id = $($(this)[0].parentElement.parentElement).data("id");
                app.delete(id);
                app.getData();
            }
        });
    });
    $(document).on("click", ".edit", function () {
        id = $(this.parentElement.parentElement).data("id");
        app.edit = true;
        limpiar();
        validaciones();
        app.getOne(id);
    });

    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this)
            .siblings(".custom-file-label")
            .addClass("selected")
            .html(fileName);
    });


    function validaciones() {
        let documento = document.getElementById("document");
        let username = document.getElementById("username");
        let email = document.getElementById("email");
        let phone = document.getElementById("phone");

        let emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
        let numberRegex = /^([0-9])*$/;
        let letrasRegex = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\u00E0-\u00FC\s]+$/;
        let btnForm = document.getElementById("btnForm");


        btnForm.setAttribute("disabled", "disabled");

        documento.oninput = function () {
            if (numberRegex.test(this.value)) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");
            } else {
                document.getElementById("documentMessage").innerHTML =
                    "Este campo es requerido";
                this.classList.add("is-invalid");
                btnForm.setAttribute("disabled", "disabled");
            }

            if (this.value.length < 7) {
                this.classList.remove("is-valid");
                this.classList.add("is-invalid");
                document.getElementById("documentMessage").innerHTML =
                    "Ingrese un documento valido";
                    btnForm.setAttribute("disabled", "disabled");
            }

            if (this.value == "" || this.value == null || this.value == 0) {
                document.getElementById("documentMessage").innerHTML =
                    "Este campo es requerido";
                this.classList.add("is-invalid");
                btnForm.setAttribute("disabled", "disabled");
            }
        };

        username.oninput = function () {
            if (this.value == "" || this.value == null || this.value == 0) {
                document.getElementById("nameMessage").innerHTML =
                    "Este campo es requerido";
                this.classList.add("is-invalid");
                btnForm.setAttribute("disabled", "disabled");
            }

            if (letrasRegex.test(this.value)) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");
            } else {
                this.classList.remove("is-valid");
                this.classList.add("is-invalid");
                if(this.value == 0 || this.value == ""){
                    document.getElementById("nameMessage").innerHTML =
                    "Este campo es requerido";
                    btnForm.setAttribute("disabled", "disabled");
                }else{
                    document.getElementById("nameMessage").innerHTML =
                    "Ingrese un nombre valido";
                    btnForm.setAttribute("disabled", "disabled");
                }
                
            }
        };

        

        email.oninput = function () {
            let str = email.value;
            let emailValue = str.substr(0,1);

            if (emailRegex.test(this.value)) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");                
            } else {
                document.getElementById("emailMessage").innerHTML =
                    "Ingrese un correo valido";
                this.classList.add("is-invalid");
                btnForm.setAttribute("disabled", "disabled");
            }

            if(numberRegex.test(emailValue)){
                document.getElementById("emailMessage").innerHTML =
                "El correo debe comenzar con una letra";
                this.classList.add("is-invalid");
                btnForm.setAttribute("disabled", "disabled"); 
            }



            if (this.value == "" || this.value == null) {
                this.classList.add("is-invalid");
                document.getElementById("emailMessage").innerHTML =
                "Este campo es requerido";
                btnForm.setAttribute("disabled", "disabled");
            }
        };

        phone.oninput = function () {
            if (this.value === "" || this.value < 9) {
                document.getElementById("phoneMessage").innerHTML =
                    "Ingrese un telefono valido";
                this.classList.add("is-invalid");
                btnForm.setAttribute("disabled", "disabled");
            }

            if (this.value.length > 9) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");
            }

            if (this.value == "" || this.value == null || this.value == 0) {
                document.getElementById("phoneMessage").innerHTML =
                    "Este campo es requerido";
                this.classList.add("is-invalid");
                btnForm.setAttribute("disabled", "disabled");
            }
        };

        
        setInterval(input,3000);
        function input(){
            if(numberRegex.test(documento.value) && documento.value != "" && documento.value.length > 6 ){         
                if(letrasRegex.test(username.value) ){                   
                    if(emailRegex.test(email.value)){
                        if(phone.value.length > 9){
                            btnForm.removeAttribute("disabled");
                        }
                    }             
                }  
            }
        }
        
    }

    function validacion_csv() {
        let group = document.getElementById("group_id_csv");
        let btnForm = document.getElementById("btnFormCsv");

        btnForm.setAttribute("disabled", "disabled");

        group.oninput = function (){
            if (this.value == "" || this.value == null || this.value == 0) {
                this.classList.add("is-invalid");
                btnForm.setAttribute("disabled", "disabled");
            }
        };
        
        setInterval(input,3000);
        function input(){    
            if(group.value != "" || group.value.length > 0){
                btnForm.removeAttribute("disabled");
            }
        }
        
    }

    function limpiar() {
        let documento = document.getElementById("document");
        let username = document.getElementById("username");
        let email = document.getElementById("email");
        let phone = document.getElementById("phone");
        let group_name_csv = document.getElementById("group_name_csv");
        let group_id_csv = document.getElementById("group_id_csv");
        let group_name = document.getElementById("group_name");
        let archivo_label = document.getElementById("archivo_label");

        username.classList.remove("is-invalid");
        username.classList.remove("is-valid");
        username.value ="";

        documento.classList.remove("is-invalid");
        documento.classList.remove("is-valid");
        documento.value ="";


        email.classList.remove("is-invalid");
        email.classList.remove("is-valid");
        email.value ="";


        phone.classList.remove("is-invalid");
        phone.classList.remove("is-valid");
        phone.value ="";

        group_name_csv.classList.remove("is-invalid");
        group_name_csv.classList.remove("is-valid");
        group_name_csv.value ="";

        group_name.classList.remove("is-invalid");
        group_name.classList.remove("is-valid");
        group_name.value ="";

        group_id_csv.classList.remove("is-invalid");
        group_id_csv.classList.remove("is-valid");
        group_id_csv.value ="";

        archivo_label.classList.remove("is-invalid");
        archivo_label.classList.remove("is-valid");
        archivo_label.innerHTML ="Seleccionar Archivo";




    }
});