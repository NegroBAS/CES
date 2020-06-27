const app = {
    url: document.getElementById("url").content,
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
            let res = await fetch('https://cronode.herokuapp.com/api/ces/formationPrograms', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            let data = await res.json();
            let fd = new FormData();
            fd.append('formation_programs', JSON.stringify(data.formationPrograms));
            res = await fetch(`${this.url}formation_programs/masive`, {
                body:fd,
                method:'POST'
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
        let resp = await fetch(`${this.url}formation_programs/index`);
        let res = await resp.json();
        console.log(res);

        let formation_program_types = res[1].formation_program_types;
        let html = "<option value='0'>Seleccione una</option>";
        formation_program_types.forEach((formation_program_type) => {
            html += `<option value="${formation_program_type.id}">${formation_program_type.name}</option>`;
        });
        document.getElementById("formation_program_type_id").innerHTML = html;

        let formation_programs = res[0].formation_programs;
        html = "";
        
        formation_programs.forEach((formation_program) => {
            html += `
                <tr data-id="${formation_program.id}">
                    <td>${formation_program.code}</td>
                    <td>${formation_program.name}</td>
                    <td>${formation_program.name_formation}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                        <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>
                    </td>
                </tr>
            `;
        });
        document.getElementById("data-formation_programs").innerHTML = html;
    },
    getOne: async function (id) {
        try {
            let res = await fetch(`${this.url}formation_programs/show/${id}`);
            let data = await res.json();
            console.log(data);
            if (data.status === 200) {
                $(".modal #form").trigger("reset");
                $(".modal").modal("toggle");
                $(".modal")
                    .find(".modal-title")
                    .text("Editar programa de formacion");
                document.getElementById("name").value =
                    data.formation_program.name;
                    document.getElementById("code").value =
                    data.formation_program.code;
                document.getElementById("formation_program_type_id").value =
                    data.formation_program.formation_program_type_id;
            }
        } catch (error) {
            console.log(error);
        }
    },
    create: async function (form) {
        try {
            let res = await fetch(`${this.url}formation_programs/store`, {
                method: "POST",
                body: new FormData(form),
            });
            let data = await res.json();
            console.log(data);
            if (data.status === 200) {
                $(".modal").modal("toggle");
                app.get();
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
            let res = await fetch(
                `${this.url}formation_programs/destroy/${id}`
            );
            let data = await res.json();
            if (data.status === 200) {
                toastr.success("", data.message, {
                    closeButton: true,
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
            let res = await fetch(`${this.url}formation_programs/edit/${id}`, {
                method: "POST",
                body: new FormData(form),
            });
            let data = await res.json();
            console.log(data);
            if (data.status === 200) {
                toastr.success("", data.message, {
                    closeButton: true,
                });
                app.get();
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
};

$(document).ready(async function () {
    let id = null;
    await app.get();
    $("#tabla").DataTable({
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
    document.getElementById("btn-create").onclick = function () {
        $(".modal #form").trigger("reset");
        $(".modal").modal("toggle");
        $(".modal").find(".modal-title").text("Crear programa de formacion");
    };
    document.getElementById('btnUpdate').onclick = async function(){
        document.getElementById('data-formation_programs').innerHTML = `
        <div class="col">
            <h6>Cargando ...</h6>
        </div>
        `;
        await app.getByApi();
    }
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
                    "El programa ha sido eliminado.",
                    "success"
                );
                let id = $($(this)[0].parentElement.parentElement).data("id");
                app.delete(id);
                app.get();
            }
        });
    });
    $(document).on("click", ".edit", async function () {
        id = $(this.parentElement.parentElement).data("id");
        app.edit = true;
        await app.getOne(id);
    });
});
