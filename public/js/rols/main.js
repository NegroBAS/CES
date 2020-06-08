const app = {
    url: document.getElementById('url').content,
    edit: false,
    get: async function(){
        try {
            let res  = await fetch(`${this.url}rols/index`);
            let data = await res.json();
            let html = '';
            if(data.rols.length>0){
                data.rols.forEach(rol => {
                    html+=`
                    <div class="col-3 mb-3">
                        <div class="card" data-id="${rol.id}">
                            <div class="card-header bg-primary"></div>
                            <div class="card-body text-center">
                                <h5>${rol.name}</h5>
                                <button class="btn btn-sm btn-outline-danger delete">Eliminar</button>
                                <button class="btn btn-sm btn-outline-primary edit">Editar</button>
                            </div>
                        </div>
                    </div>
                    `;
                });
            }else{
                html = `
                <div class="col">
                    <p>No hay datos que mostrar</p>
                </div>
                `;
            }
            document.getElementById('data').innerHTML = html;
        } catch (error) {
            console.log(error);
        }
    },
    getOne: async function (id) {
        try {
            let res = await fetch(`${this.url}rols/show/${id}`);
            let data = await res.json();
            if(data.status===200){
                $('.modal').modal('toggle');
                $('.modal').find('.modal-title').text('Editar rol');
                document.getElementById('name').value = data.rol.name
            }
        } catch (error) {
            console.log(error);
        }
    },
    create:async function(form){
        try {
            let res = await fetch(`${this.url}rols/store`, {
                method:'POST',
                body: new FormData(form)
            });
            let data = await res.json();
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
            let res  = await fetch(`${this.url}rols/destroy/${id}`);
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
            let res = await fetch(`${this.url}rols/edit/${id}`, {
                method:'POST',
                body:new FormData(form)
            });
            let data = await res.json();
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

$(document).ready(function () {
    let id = null;
    app.get();
    document.getElementById('btn-create').onclick = function(){
        $('.modal #form').trigger('reset');
        $('.modal').modal('toggle');
        $('.modal').find('.modal-title').text('Crear rol');
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
        app.delete(id);
    });
    $(document).on('click', '.edit', function () {
        id = $(this.parentElement.parentElement).data('id');
        app.edit = true;
        app.getOne(id);
    })
});