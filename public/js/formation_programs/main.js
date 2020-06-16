const app = {
    url: document.getElementById("url").content,
    edit: false,
    get: async function () {
        let resp = await fetch(`${this.url}formation_programs/index`);
        let res = await resp.json();

        let formation_program_types = res.formation_program_types;
        let html = "<option value='0'>Seleccione una</option>";
        formation_program_types.forEach((formation_program_types) => {
            html += `<option value="${formation_program_types.id}">${formation_program_types.name}</option>`;
        });
        document.getElementById("formation_program_type_id").innerHTML = html;

        let formation_programs = res.formation_programs;
        html = "";
        formation_programs.forEach((formation_programs) => {
            html += `
                <tr data-id="${formation_programs.id}">
                    <td>${formation_programs.code}</td>
                    <td>${formation_programs.name}</td>
                    <td>${formation_programs.name_formation}</td>
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
                    data.formation_programs.name;
                    document.getElementById("code").value =
                    data.formation_programs.code;
                document.getElementById("formation_program_type_id").value =
                    data.formation_programs.formation_program_type_id;
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
