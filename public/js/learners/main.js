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
                    <td>${learner.document_type_id}</td>
                    <td>${learner.document}</td>
                    <td>${learner.phone}</td>
                    <td>${learner.email}</td>
                    <td>
                    <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                    <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>
                    </td>
                </tr>
                `;
            });
            document.getElementById("data-learners").innerHTML = html;

            html = "";
            data[1].document_types.forEach((document) => {
                html += `
             <option value="${document.id}">${document.name}</option>
                `;
            });
            document.getElementById("document_type_id").innerHTML = html;
            html = "";
            data[2].groups.forEach((group) => {
                html += `
             <option value="${group.id}">${group.code_tab}</option>
                `;
            });
            document.getElementById("group_id").innerHTML = html;
        } catch (error) {
            console.log(error);
        }
    },
    getOne: async function (id) {
        try {
            let res = await fetch(`${this.url}learners/show/${id}`);
            let data = await res.json();
            if (data.status === 200) {
                $(".modal #form").trigger("reset");
                $(".modal").modal("toggle");
                $(".modal").find(".modal-title").text("Editar aprendiz");
                document.getElementById("username").value =
                    data.learner.username;
                document.getElementById("document").value =
                    data.learner.document;
                document.getElementById("phone").value = data.learner.phone;
                document.getElementById("email").value = data.learner.email;
                document.getElementById("document_type_id").value = data.learner.document_type_id;
                document.getElementById("group_id").value = data.learner.group_id;
                document.getElementById("birthdate").value = data.learner.birthdate;
                document.getElementById("photo").value = data.learner.photo;
                document.getElementById("photo_2").value = data.learner.photo;
            }
        } catch (error) {
            console.log(error);
        }
    },
    create: async function (form) {
        try {
            console.log("creando");
            let res = await fetch(`${this.url}learners/store`, {
                method: "POST",
                body: new FormData(form),
            });
            console.log(res);
            let data = await res.json();
            console.log(data);
            if (data.status === 200) {
                $(".modal").modal("toggle");
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
                $(".modal").modal("toggle");
                this.edit = false;
            }
            if (data.status === 500) {
                console.log(data.error);
            }
        } catch (error) {
            console.log(error);
        }
    },
    getGroups: async function(){
        try {
			let res = await fetch(`${this.url}groups/index`);
            let data = await res.json();
            console.log('SI');
            console.log(data);
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
}

$(document).ready(async function () {
    await app.getData();
    await app.getGroups();
    $("#learners").DataTable({
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

    document.getElementById("btn-create").onclick = function () {
        $(".modal #form").trigger("reset");
        $(".modal").modal("toggle");
        $(".modal").find(".modal-title").text("Crear aprendiz");
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
        let estado = new Array(5);

        btnForm.setAttribute("disabled", "disabled");

        documento.oninput = function () {
            if (numberRegex.test(this.value)) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");
                estado[0] = "si";
            } else {
                document.getElementById("documentMessage").innerHTML =
                    "Este campo es requerido";
                this.classList.add("is-invalid");
                estado[0] = "no";
            }

            if (this.value.length < 7) {
                this.classList.remove("is-valid");
                this.classList.add("is-invalid");
                document.getElementById("documentMessage").innerHTML =
                    "Este campo es requerido";
                estado[0] = "no";
            }
        };

        username.oninput = function () {
            if (this.value === "" || this.value == null) {
                console.log("campo requerido");
                document.getElementById("nameMessage").innerHTML =
                    "Este campo es requerido";
                this.classList.add("is-invalid");
                estado[1] = "no";
            }

            if (this.value.length > 0) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");
                estado[1] = "si";
            }

            if (letrasRegex.test(this.value)) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");
            } else {
                this.classList.remove("is-valid");
                this.classList.add("is-invalid");
                document.getElementById("nameMessage").innerHTML =
                    "Este campo es requerido";
            }
        };

        email.oninput = function () {
            if (emailRegex.test(this.value)) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");
                btnForm.removeAttribute("disabled");
                estado[2] = "si";
            } else {
                document.getElementById("emailMessage").innerHTML =
                    "Este campo es requerido";
                this.classList.add("is-invalid");
                btnForm.setAttribute("disabled", "disabled");
                estado[2] = "no";
            }

            if (this.value === "" || this.value == null) {
                console.log("campo requerido");
                this.classList.add("is-invalid");
                btnForm.setAttribute("disabled", "disabled");
                estado[2] = "no";
            }
        };

        phone.oninput = function () {
            if (this.value === "" || this.value < 9) {
                console.log("campo requerido");
                document.getElementById("phoneMessage").innerHTML =
                    "Este campo es requerido";
                this.classList.add("is-invalid");
                estado[5] = "no";
            }

            if (this.value.length > 9) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");
                estado[5] = "si";
            }
        };
    }

    function limpiar() {
        let documento = document.getElementById("document");
        let username = document.getElementById("username");
        let email = document.getElementById("email");
        let phone = document.getElementById("phone");

        console.log("limpiando");
        username.classList.remove("is-invalid");
        username.classList.remove("is-valid");

        documento.classList.remove("is-invalid");
        documento.classList.remove("is-valid");

        email.classList.remove("is-invalid");
        email.classList.remove("is-valid");

        phone.classList.remove("is-invalid");
        phone.classList.remove("is-valid");
    }
});