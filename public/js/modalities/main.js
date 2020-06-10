const app = {
        url: document.getElementById('url').content,
        edit: false,
        list: async function () {
            let resp = await fetch(`${this.url}modalities/index`);
            let res = await resp.json();
            let modalities = res.modalities;
            let html = '';
            modalities.forEach(modalities => {
                html += `
                <div class="col-3 mb-2">
                    <div class="card" data-id="${modalities.id}">
                        <div class="card-header bg-primary"></div>
                        <div class="card-body text-center">
                            <h5>${modalities.name}</h5>
                            <button class="btn btn-sm btn-outline-danger delete">Eliminar</button>
                            <button class="btn btn-sm btn-outline-primary edit" data-toggle="modal" data-target="#modal">Editar</button>
                        </div>
                    </div>
                </div>
                `
            });
            document.getElementById('data-modalities').innerHTML = html;
        },
        create: async function () {
            let resp = await fetch(`${this.url}modalities/store`, {
                method: 'POST',
                body: new FormData(document.getElementById('form'))
            });
            let res = await resp.json();
            console.log(res.status);
            if (res.status == "ok") {
                console.log(res.message);
                $('#form').trigger('reset');
                await app.list();
            }
        },
        delete: async function (id) {
            let resp = await fetch(`${this.url}modalities/destroy/${id}`);
            let res = await resp.json();
            console.log(res);
        },
        update: async function (id) {
            let resp = await fetch(`${this.url}modalities/edit/${id}`, {
                method: 'POST',
                body: new FormData(document.getElementById('form'))
            });
            let res = await resp.json();
            console.log(res);
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
            Swal.fire({
                title: '¿Estas seguro?',
                text: "No podras revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Eliminado!',
                        'El Usuario ha sido eliminado.',
                        'success'
                    )
                    let id = $($(this)[0].parentElement.parentElement).data('id');
                    app.delete(id);
                    app.list();
                }
            })
            
        });
        document.getElementById('btnCreate').onclick = function () {
            app.edit = false;
            let modal = $('#modal');
            modal.find('.modal-title').text('Crear Modalidad');
            $('#form').trigger('reset');
        }
        $(document).on('click', '.edit', async function () {
            id = $($(this)[0].parentElement.parentElement).data('id');
            app.edit = true;
            let modal = $('#modal');
            modal.find('.modal-title').text('Editar Modalidad');
            let resp = await fetch(`${app.url}modalities/show/${id}`);
            let res = await resp.json();
            document.getElementById('name').value = res.name;
        });
    });