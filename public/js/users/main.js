const app = {
    url: document.getElementById("url").content,
    edit: false,
    getRols: async function () {
        try {
            let res = await fetch(`${this.url}rols/index`);
            let data = await res.json();
            if (data.status === 200) {
                let html = '<option value="0">Seleccione uno</option>';
                data.rols.forEach((rol) => {
                    html += `<option value="${rol.id}">${rol.name}</option>`;
                });
                document.getElementById("rol_id").innerHTML = html;
            }
            if (data.status === 500) {
                console.log(data.error);
            }
        } catch (error) {
            console.log(error);
        }
    },
    get: async function () {
        try {
            let res = await fetch(`${this.url}users/index`);
            let data = await res.json();
            if (data.users.length > 0) {
                let html = "";
                data.users.forEach((user) => {
                    html += `
                    <tr data-id="${user.id}">
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.rol_name}</td>
                        <td>
                        <button class="btn btn-sm btn-outline-danger delete"><i class="far fa-trash-alt"></i></button>
                        <button class="btn btn-sm btn-outline-primary edit"><i class="far fa-edit"></i></button>
                        </td>
                    </tr>
                    `;
                });
                document.getElementById("data-users").innerHTML = html;
            }
        } catch (error) {
            console.log(error);
        }
    },
    getOne:async function (id) {
        try {
            let res = await fetch(`${this.url}users/show/${id}`);
            let data = await res.json();
            if(data.status===200){
                document.getElementById('name').value = data.user.name;
                document.getElementById('email').value = data.user.email;
                document.getElementById('rol_id').value = data.user.rol_id
                $('.modal').find('.modal-title').text('Editar usuario');
                $('.modal').modal('toggle');
            }
            if(data.status===500){
                console.log(data.error);
            }
        } catch (error) {
            console.log(error);
        }
    },
    create: async function (form) {
        try {
            let res = await fetch(`${this.url}users/store`, {
                method: "POST",
                body: new FormData(form),
            });
            let data = await res.json();
            if (data.status === 200) {
                $(".modal").modal("toggle");
                toastr.success('', data.message, {
                    closeButton:true
                });
                await this.get();
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
            let res = await fetch(`${this.url}users/edit/${id}`, {
                method: "POST",
                body: new FormData(form),
            });
            let data = await res.json();
            if (data.status === 200) {
                toastr.success('', data.message, {
                    closeButton: true
                });
                $('.modal').modal('toggle');
                app.get();
            }
            if (data.status === 500) {
                console.log(data.error);
            }
        } catch (error) {
            console.log(error);
        }
    },
    delete: async function (id) {
        try {
            let res = await fetch(`${this.url}users/destroy/${id}`);
            let data = await res.json();
            if(data.status===200){
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
    }
};

$(document).ready(async function () {
    let id = null;
    await app.get();
    await app.getRols();
    $("#users").DataTable({
        language: {
            url:
                "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
        },
    });
    document.getElementById('form').onsubmit = function (e) {
        e.preventDefault();
        if(app.edit){
            app.update(this, id);
        }else{
            app.create(this);
        }
    }
    document.getElementById("btn-create").onclick = async function () {
        $(".modal").modal("toggle");
        $(".modal").find(".modal-title").text("Crear usuario");
        $(".modal #form").trigger("reset");
    };

    $(document).on('click', '.edit', function () {
        app.edit = true;
        id = $(this.parentElement.parentElement).data('id');
        app.getOne(id);
    });
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
              Swal.fire("Eliminado!", "El aprendiz ha sido eliminado.", "success");
              let id = $($(this)[0].parentElement.parentElement).data("id");
              app.delete(id);
              app.get();
            }
          });
    });
});
