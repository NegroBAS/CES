const app = {
	url: document.getElementById("url").content,
	complainers:null,
	learners:null,
	document_types:null,
	getDocumentTypes:async function () {
		try {
			let res = await fetch(`${this.url}document_types/index`);
			let data = await res.json();
			this.document_types = data.document_types;
		} catch (error) {
			console.log(error);
		}
	},
	getComplainers:async function () {
		try {
			let res = await fetch(`${this.url}formative_measure_responsibles/index`);
			let data = await res.json();
			this.complainers = data[0].formative_measure_responsibles;
			res = await fetch(`${this.url}complainers/index`);
			data = await res.json();
			this.complainers.push(...data.complainers);
		} catch (error) {
			console.log(error);
		}
	},
	addComplainer:async function (data) {
		try {
			let fd = new FormData();
			fd.append('name', data.name);
			fd.append('document_type_id', data.document_type_id);
			fd.append('document', data.document);
			let res = await fetch(`${this.url}complainers/store`, {
				body:fd,
				method:'POST'
			});
			let r = await res.json();
			console.log(r);
		} catch (error) {
			console.log(error);
		}
	},
	getLeaners: async function () {
		try {
			let res = await fetch(`${this.url}learners/index`);
			let data = await res.json();
			this.learners = data[0].learners;
		} catch (error) {
			console.log(error);
		}
	},
    get: async function () {
        try {
            let res = await fetch(`${this.url}committees/index`);
            let data = await res.json();
            if (data.status === 200) {
				let html = "";
                if (data.committees.length > 0) {
                    data.committees.forEach((committee) => {
                        html += `
						<div class="col-12 col-md-6 mb-3">
							<div class="card">
								<div class="card-header bg-primary"></div>
								<div class="card-body">
									<div class="row">
										<div class="col">
											Fecha:
											<p class="text-muted">${committee.date}</p>
										</div>
										<div class="col">
											Hora:
											<p class="text-muted">
												${committee.start_hour}
												-
												${committee.end_hour}
											</p>
										</div>
									</div>
									<div class="row">
										<div class="col">
											Numero de acta:
											<p class="text-muted">${committee.record_number}</p>
										</div>
									</div>
									<div class="row">
										<div class="col">
											Lugar:
											<p class="text-muted">${committee.place}</p>
										</div>
									</div>
									<div class="row">
										<div class="col">
											Centro de formacion:
											<p class="text-muted">${committee.formation_center}</p>
										</div>
									</div>
									<div class="row">
										<div class="col">
											<div class="dropdown d-inline">
												<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												  Opciones
												</button>
												<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												  <a class="dropdown-item detail" href="#" data-id="${committee.id}">Ver detalle</a>
												  <a class="dropdown-item" href="#">Ver casos</a>
												  <a class="dropdown-item edit" data-id="${committee.id}" href="#">Editar</a>
												  <a class="dropdown-item delete" data-id="${committee.id}" href="#">Eliminar</a>
												</div>
									  		</div>
									  		<button class="btn btn-sm btn-success btn-add-case" >Agregar caso</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						`;
                    });
                }else{
					html = `
					<div class="col">
						<h5>No hay comites</h5>
					</col>
					`;
				}
				document.getElementById("data-committees").innerHTML = html;
            }
        } catch (error) {
            console.log(error);
        }
	},
	getCommitteeSessionTypes: async function () {
		try {
			let res = await fetch(`${this.url}committee_session_types/index`);
			let data = await res.json();
			if(data.status===200 && data.committee_session_types.length>0){
				let html = '';
				data.committee_session_types.forEach(committee_session_type => {
					html += `
					<div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="committee_session_type_id" id="inlineRadio${committee_session_type.id}" value="${committee_session_type.id}">
                        <label class="form-check-label" for="inlineRadio${committee_session_type.id}">${committee_session_type.name}</label>
                    </div>
					`;
				});
				document.getElementById('committee_session_types').innerHTML = html;
			}
		} catch (error) {
			console.log(error);
		}
	},
	getNoveltyTypes: async function () {
		try {
			let res = await fetch(`${this.url}novelty_types/index`);
			let data = await res.json();
			if(data.status===200){
				let html = '';
				data.novelty_types.forEach(novelty_type=>{
					html += `
					<option value="${novelty_type.id}">${novelty_type.name}</option>
					`;
				});
				document.getElementById('novelty-types').innerHTML = html;
			}
		} catch (error) {
			console.log(error);
		}
	},
	getSubdirector:async function(){
		try {
			let res = await fetch(`${this.url}users/findSubdirector`);
			let data = await res.json();
			if(data.user){
				document.getElementById('subdirector-name').innerHTML = `Este comité se realizara en nombre del subdirector <span class="text-primary">${data.user.name}</span>`;
				return data.user;
			}else{
				document.getElementById('subdirector-name').innerHTML = `<span class="text-primary">${data.message}</span>`;
				document.getElementById('btnCommitteeCreate').setAttribute('disabled', true);
			}
		} catch (error) {
			console.log(error);
		}
	},
    create: async function (form) {
        try {
            let res = await fetch(`${this.url}committees/store`, {
				method: 'POST',
				body: form
			});
            let data = await res.json();
            if(data.status===200){
				await app.get();
			}
        } catch (error) {
            console.log(error);
        }
	},
};

function selectComplainer(value) {
	document.getElementById('name_or_id').value = value;
	document.getElementById('content-complainer').innerHTML = "";
}

function formComplainer() {
	document.getElementById('name_or_id').placeholder = "Nombre del quejoso";
	document.getElementById('content-complainer').innerHTML = `
		<div class="form-group mt-3">
			<select id="document_type_id" name="document_type_id" class="form-control">
			</select>
		</div>
		<div class="form-group mt-3">
			<input type="text" class="form-control" id="document" name="document" placeholder="Identificacion" />
		</div>
		<button type="button" class="btn btn-sm btn-primary" id="btnAddComplainer">Agregar</button>
	`;
	let html = "<option value='0'>Seleccione una</option>";
	app.document_types.forEach(document_type=>{
		html+=`<option value='${document_type.id}'>${document_type.name}</option>`
	});
	document.getElementById('document_type_id').innerHTML = html;
	document.getElementById('btnAddComplainer').onclick = async function(){
		await app.addComplainer({
			name: document.getElementById('name_or_id').value,
			document_type_id: document.getElementById('document_type_id').value,
			document: document.getElementById('document').value
		});
	}
}
function selectLearner(value) {
	document.getElementById('leaner_name_id').value = value;
	document.getElementById('content-learner').innerHTML = "";
}

$(document).ready(async function () {
	document.getElementById("data-committees").innerHTML = `
	<div class="col-6 mx-auto text-center text-primary">
		<h6>Cargando los datos</h6>
		<div class="spinner-border" role="status">
			<span class="sr-only">Loading...</span>
		</div>
    </div>
	`;
	await app.get();
	await app.getDocumentTypes();
	await app.getLeaners();
	await app.getSubdirector();
	await app.getComplainers();
	let editor = null;
	document.getElementById('form').onsubmit = async function (e) {
		e.preventDefault();
		let subdirector = await app.getSubdirector();
		let fd = new FormData(this)
		fd.append('assistants', editor.getData());
		fd.append('subdirector_name', subdirector.name);
		await app.create(fd);
	}

    ClassicEditor.create(document.querySelector("#assistants"), {
        language: "es",
    }).then((new_editor) => {
        editor = new_editor;
	}).catch((error) => {
        console.error(error);
	});

	$(document).on('click', '.btn-add-case', async function () {
		await app.getCommitteeSessionTypes();
		$('#modal-case').modal('toggle');
		$('#modal-case').find('.modal-title').text('Agregar caso')
	});

	$(document).on('click', '.form-check-input', async function () {
		console.log(this.value);
		if(this.value==1){
			document.getElementById('content').innerHTML = `
			<form id="form">
                <div class="form-group">
                    <label for="learner_name_id">Aprendiz</label>
                    <input type="hidden" name="leaner_id">
					<input type="text" id="leaner_name_id" placeholder="Busca aqui..." class="form-control">
					<div id="content-learner"></div>
                </div>
                <div class="form-group">
                    <label for="stimulus">Estimulo</label>
                    <input type="text" name="stimulus" id="stimulus" class="form-control">
                </div>
                <div class="form-group">
                    <label for="justification">Justificación</label>
                    <textarea name="justification" id="justification" cols="30" rows="5" class="form-control"></textarea>
                </div>
            </form>
			`;
			document.getElementById('leaner_name_id').oninput = function(){
				let matches = app.learners.filter(learner => {
					const rgex = new RegExp(`^${this.value}`, 'gi');
					return learner.username.match(rgex) || learner.document.match(rgex);
				});
				if(this.value.length === 0){
					matches=[];
				}
				let html = '<ul class="list-group">';
                if(matches.length > 0){
                    matches.forEach(match => {
                        html+=`<p onclick="selectLearner('${match.username}')" class="list-group-item list-group-item-action">${match.username}</p>`
                    });
                    html+="</ul>";
                    document.getElementById('content-learner').innerHTML = html;
                }else{
                    document.getElementById('content-learner').innerHTML = "<p class='mt-3'>¿No esta? <a href='#' onclick='formComplainer()'>Registralo</a></p>";
                }
			}
		}
		if(this.value==2){
			document.getElementById('content').innerHTML = `
			<form id="form">
                <div class="form-group">
                    <label for="learner_name_id">Aprendiz</label>
                    <input type="hidden" name="leaner_id">
                    <input type="text" id="leaner_name_id" placeholder="Busca aqui..." class="form-control">
                </div>
                <div class="form-group">
                    <label for="novelty_type">Tipo de novedad</label>
                    <select name="novelty_type_id" id="novelty-types" class="form-control">
                    </select>
				</div>
				<div class="form-group">
                    <label for="observations">Observaciones</label>
                    <textarea name="observations" id="observations" cols="30" rows="5" class="form-control"></textarea>
                </div>
            </form>
			`;
			await app.getNoveltyTypes();
		}
		if(this.value == 3){
			document.getElementById('content').innerHTML = `
			<form id="form">
                <div class="form-row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                Hora
                                <div class="form-row mt-3">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="start_hour" class="text-muted">Inicio</label>
                                            <input type="time" name="start_hour" id="start_hour" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="end_hour" class="text-muted">Fin</label>
                                            <input type="time" name="end_hour" id="end_hour" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                Quejoso
                                <div class="form-group my-3">
                                    <label class="text-muted">Nombre o identificacion</label>
                                    <input type="text" name="name_or_id" id="name_or_id" class="form-control">
                                    <div id="content-complainer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
			`;
			document.getElementById('name_or_id').oninput = async function () {
				let matches = app.complainers.filter(complainer => {
					const rgex = new RegExp(`^${this.value}`, 'gi');
					return complainer.username.match(rgex) || complainer.document.match(rgex) || complainer.name.match(rgex);
				});
				console.log(matches);
				if(this.value.length === 0){
					matches=[];
				}
				let html = '<ul class="list-group">';
                if(matches.length > 0){
                    matches.forEach(match => {
                        html+=`<p onclick="selectComplainer('${match.username}')" class="list-group-item list-group-item-action">${match.username}</p>`
                    });
                    html+="</ul>";
                    document.getElementById('content-complainer').innerHTML = html;
                }else{
                    document.getElementById('content-complainer').innerHTML = "<p class='mt-3'>¿No esta? <a href='#' onclick='formComplainer()'>Registralo</a></p>";
                }
			}
		}
	});

	

    document.getElementById("btn-create").onclick = function () {
        $("#modal-create").modal("toggle");
        $("#modal-create").find(".modal-title").text("Crear comité");
    };
});
