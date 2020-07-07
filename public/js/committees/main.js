const app = {
	url: document.getElementById("url").content,
	complainers: null,
	responsibles: null,
	learners: null,
	document_types: null,
	novelties: null,
	novelty_types: null,
	id: null,
	editor: null,
	edit: false,
	getDocumentTypes: async function () {
		try {
			let res = await fetch(`${this.url}document_types/index`);
			let data = await res.json();
			this.document_types = data.document_types;
		} catch (error) {
			console.log(error);
		}
	},
	getComplainers: async function () {
		try {
			let res = await fetch(`${this.url}formative_measure_responsibles/index`);
			let data = await res.json();
			this.responsibles = data[0].formative_measure_responsibles;
			res = await fetch(`${this.url}complainers/index`);
			data = await res.json();
			this.complainers = (data.complainers);
		} catch (error) {
			console.log(error);
		}
	},
	addStimulu: async function (form) {
		try {
			let res = await fetch(`${this.url}committee_sessions/storeStimulu`, {
				method: 'POST',
				body: form
			});
			let data = await res.json();
			if (data.status === 200) {
				$('#modal-case').modal('toggle');
				toastr.success('', data.message, {
					closeButton: true
				});
				document.getElementById('content').innerHTML = '';
			}
		} catch (error) {
			console.log(error);
		}
	},
	addAcademic: async function (form) {
		try {
			let res = await fetch(`${this.url}committee_sessions/storeAcademic`, {
				method: 'POST',
				body: form
			});
			let data = await res.json();
			console.log(data);
			if (data.status === 200) {
				$('#modal-case').modal('toggle');
				toastr.success('', data.message, {
					closeButton: true
				});
				document.getElementById('content').innerHTML = '';
			}
		} catch (error) {
			console.log(error);
		}
	},
	addNovelty: async function (form) {
		try {
			let res = await fetch(`${this.url}learner_novelties/store`, {
				method: 'POST',
				body: form
			});
			let data = await res.json();
			if (data.status === 200) {
				$('#modal-case').modal('toggle');
				$('#modal-case #content').html('');
				toastr.success('', data.message, {
					closeButton: true
				});
			}
		} catch (error) {
			console.log(error);
		}
	},
	getNovelty: async function (id) {
		try {
			let res = await fetch(`${this.url}learner_novelties/show/${id}`);
			let data = await res.json();
			console.log(data);
			if(data.status===200){
				$('#modal-novelty-detail').find('.modal-title').text('Detalle del caso');
				$('#modal-novelty-detail #novelty_type').text(data.learner_novelty.novelty_type_name);
				$('#modal-novelty-detail #learner').text(data.learner_novelty.learner_username);
				$('#modal-novelty-detail #justification').text(data.learner_novelty.justification);
				$('#modal-novelty-detail').modal('toggle');
			}
		} catch (error) {
			console.log(error);
		}
	},
	getStimulu: async function (id) {
		try {
			let res = await fetch(`${this.url}committee_sessions/showStimulu/${id}`);
			let data = await res.json();
			console.log(data);
			if (data.status === 200) {
				$('#modal-stimulus-detail').find('.modal-title').text('Detalle del caso');
				$('#modal-stimulus-detail #hours').text(`${data.committee_session.start_hour} a ${data.committee_session.end_hour}`);
				$('#modal-stimulus-detail #learner').text(`${data.committee_session.learner_name}`);
				$('#modal-stimulus-detail #stimulus').text(`${data.committee_session.stimulus}`);
				$('#modal-stimulus-detail #stimulus_justification').text(`${data.committee_session.stimulus_justification}`);
				$('#modal-stimulus-detail').modal('toggle');
			}
		} catch (error) {
			console.log(error);
		}
	},
	getCases: async function (id) {
		try {
			document.getElementById('stimulus').innerHTML = '';
			let res = await fetch(`${this.url}/committee_sessions/index/${id}`);
			let data = await res.json();
			console.log(data);
			if (data.data[0].status === 200) {
				let html = '<h6>Estimulos e incentivos</h6>';
				if (data.data[0].committee_sessions_stimulus.length === 0) {
					html += '<p>No hay estimulos que tratar</p>'
				} else {
					data.data[0].committee_sessions_stimulus.forEach(stimulu => {
						html += `
						<div class="card mb-1">
							<div class="card-header">
								<div class="row">
									<div class="col">
										${stimulu.start_hour} - ${stimulu.end_hour}
									</div>
									<div class="col-2 text-right">
										<div class="dropdown">
											<button class="btn btn-sm btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											</button>
											<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
											  <a class="dropdown-item stimulus-case" href="#" data-id="${stimulu.id}"><i class="far fa-eye text-primary"></i> Detalle</a>
											  <a class="dropdown-item" href="#"><i class="far fa-edit text-primary"></i> Editar</a>
											  <a class="dropdown-item" href="#"><i class="far fa-trash-alt text-danger"></i> Eliminar</a>
											</div>
								  		</div>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="card-title">${stimulu.learner_name}</div>
								<div class="card-subtitle text-muted">${stimulu.stimulus}</div>
							</div>
						</div>
						`;
					});
				}
				document.getElementById('stimulus').innerHTML = html;
				$(document).on('click', '.stimulus-case', async function () {
					let id = $(this).data('id');
					app.getStimulu(id);
				});
			}
			if (data.data[1].status === 200) {
				let html = '<h6>Novedades del aprendiz</h6>';
				if (data.data[1].learner_novelties.length > 0) {
					data.data[1].learner_novelties.forEach(novelty => {
						html += `
						<div class="card mb-1">
							<div class="card-header">
								<div class="row">
									<div class="col">
										${novelty.novelty_name}
									</div>
									<div class="col-2 text-right">
										<div class="dropdown">
											<button class="btn btn-sm btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											</button>
											<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item novelty-case" href="#" data-id="${novelty.id}"><i class="far fa-eye text-primary"></i> Detalle</a>
											<a class="dropdown-item" href="#"><i class="far fa-edit text-primary"></i> Editar</a>
											<a class="dropdown-item" href="#"><i class="far fa-trash-alt text-danger"></i> Eliminar</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="card-title">${novelty.learners_name}</div>
							</div>
						</div>
						`;
					});
				} else {
					html += '<p class="text-muted">No hay novedades que tratar</p>'
				}
				document.getElementById('novelties').innerHTML = html;
				$(document).on('click', '.novelty-case', async function () {
					let id = $(this).data('id');
					await app.getNovelty(id);
				});
			}
			if (data.data[2].status === 200) {
				let html = '<h6>Academico disciplinario</h6>';
				if (data.data[2].committee_sessions_academics.length > 0) {
					data.data[2].committee_sessions_academics.forEach(academic => {
						html += `
						<div class="card mb-1">
							<div class="card-header">
								<div class="row">
									<div class="col">
										${academic.start_hour} - ${academic.end_hour}
									</div>
									<div class="col-2 text-right">
										<div class="dropdown">
											<button class="btn btn-sm btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											</button>
											<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item academic-case" href="#" data-id="${academic.id}"><i class="far fa-eye text-primary"></i> Detalle</a>
											<a class="dropdown-item" href="#"><i class="far fa-edit text-primary"></i> Editar</a>
											<a class="dropdown-item" href="#"><i class="far fa-trash-alt text-danger"></i> Eliminar</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="card-title">${academic.learner_name}</div>
							</div>
						</div>
						`;
					});
				} else {
					html += '<p class="text-muted">No hay academico/disciplinario que tratar</p>'
				}
				document.getElementById('academics').innerHTML = html;
			}
		} catch (error) {
			console.log(error);
		}
	},
	addComplainer: async function (data) {
		try {
			let fd = new FormData();
			fd.append('name', data.name);
			fd.append('document_type_id', data.document_type_id);
			fd.append('document', data.document);
			let res = await fetch(`${this.url}complainers/store`, {
				body: fd,
				method: 'POST'
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
	getNovelties: async function () {
		try {
			let res = await fetch(`${this.url}learner_novelties/index`);
			let data = await res.json();
			this.novelties = data[0].learner_novelties;
		} catch (error) {
			console.log(error);
		}
	},
	selectCommittee: async function (id) {
		try {
			let res = await fetch(`${this.url}committees/show/${id}`);
			let data = await res.json();
			$('#modal-detail #date').text(data.date);
			$('#modal-detail #start_hour').text(data.start_hour);
			$('#modal-detail #end_hour').text(data.end_hour);
			$('#modal-detail #record_number').text(data.record_number);
			$('#modal-detail #place').text(data.place);
			$('#modal-detail #formation_center').text(data.formation_center);
			$('#modal-detail #qourum').text(data.qourum == 1 ? 'Si' : 'No');
			$('#modal-detail #assistants').html(data.assistants);
		} catch (error) {
			console.log(error);
		}
	},
	getCommittee: async function (id) {
		try {
			this.edit = true;
			let res = await fetch(`${this.url}committees/show/${id}`);
			let data = await res.json();
			this.id = data.id;
			$('#modal-create').find('.modal-title').text('Editar comité');
			$('#modal-create #date').val(data.date);
			$('#modal-create #start_hour').val(data.start_hour);
			$('#modal-create #end_hour').val(data.end_hour);
			$('#modal-create #record_number').val(data.record_number);
			$('#modal-create #place').val(data.place);
			$('#modal-create #formation_center').val(data.formation_center);
			$('#modal-create #formation_center').val(data.formation_center);
			this.editor.setData(data.assistants);
			$('#modal-create #qourum').prop('checked', data.qourum === 1 ? true : false);
			$('#modal-create').modal('toggle');
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
												<button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												  Opciones
												</button>
												<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												  <a class="dropdown-item p-2 detail" href="#" data-id="${committee.id}"><i class="far fa-eye text-primary "></i> Ver detalle</a>
												  <a class="dropdown-item p-2 cases" href="#" data-id="${committee.id}"><i class="far fa-calendar-check text-primary "></i> Ver casos</a>
												  <a class="dropdown-item p-2 edit" data-id="${committee.id}" href="#"><i class="far fa-edit text-primary"></i> Editar</a>
												  <a class="dropdown-item p-2 delete" data-id="${committee.id}" href="#"><i class="far fa-trash-alt text-danger"></i> Eliminar</a>
												</div>
									  		</div>
											<button class="btn btn-outline-success btn-add-case" data-id="${committee.id}" >Agregar caso</button>
										</div>
										<div class="col-4 ml-auto text-right">
											<a href="${app.url}act/committee/${committee.id}" class="btn btn-outline-primary" data-id="${committee.id}" >Generar acta</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						`;
					});
				} else {
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
			if (data.status === 200 && data.committee_session_types.length > 0) {
				let html = '';
				data.committee_session_types.forEach(committee_session_type => {
					html += `
					<div class="form-check form-check-inline">
                        <input class="form-check-input committeeSessionType" type="radio" name="committee_session_type_id" id="inlineRadio${committee_session_type.id}" value="${committee_session_type.id}">
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
			if (data.status === 200) {
				let html = '';
				data.novelty_types.forEach(novelty => {
					html += `<option value="${novelty.id}">${novelty.name}</option>`
				});
				document.getElementById('novelty_type_id').innerHTML = html;
			}
		} catch (error) {
			console.log(error);
		}
	},
	getSubdirector: async function () {
		try {
			let res = await fetch(`${this.url}users/findSubdirector`);
			let data = await res.json();
			if (data.user) {
				document.getElementById('subdirector-name').innerHTML = `Este comité se realizara en nombre del subdirector <span class="text-primary">${data.user.name}</span>`;
				return data.user;
			} else {
				document.getElementById('subdirector-name').innerHTML = `<span class="text-primary">${data.message}</span>`;
				document.getElementById('btnCommitteeCreate').setAttribute('disabled', true);
			}
		} catch (error) {
			console.log(error);
		}
	},
	update: async function (form) {
		try {
			let res = await fetch(`${this.url}committees/edit/${this.id}`, {
				method: 'POST',
				body: form
			});
			let data = await res.json();
			if (data.status === 200) {
				await app.get();
				$('#form').trigger('reset');
				app.editor.setData("");
				$('#modal-create').modal('toggle');
				toastr.success('', data.message, {
					closeButton: true
				});
			}
		} catch (error) {
			console.log(error);
		}
	},
	delete: async function () {
		try {
			let res = await fetch(`${this.url}committees/destroy/${app.id}`);
			let data = await res.json();
			console.log(data);
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
			if (data.status === 200) {
				await app.get();
				$('#modal-create').modal('toggle');
			}
		} catch (error) {
			console.log(error);
		}
	},
};

function selectComplainer(name, id) {
	document.getElementById('complainer_id').value = id;
	document.getElementById('name_or_id').value = name;
	document.getElementById('content-complainer').innerHTML = "";
}
function selectResponsible(name, id) {
	document.getElementById('responsible_id').value = id;
	document.getElementById('responsible').value = name;
	document.getElementById('content-responsible').innerHTML = "";
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
	app.document_types.forEach(document_type => {
		html += `<option value='${document_type.id}'>${document_type.name}</option>`
	});
	document.getElementById('document_type_id').innerHTML = html;
	document.getElementById('btnAddComplainer').onclick = async function () {
		await app.addComplainer({
			name: document.getElementById('name_or_id').value,
			document_type_id: document.getElementById('document_type_id').value,
			document: document.getElementById('document').value
		});
	}
}
function selectLearner(value, id) {
	document.getElementById('leaner_name_id').value = value;
	document.getElementById('learner_id').value = id;
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
	await app.getNovelties();
	await app.getSubdirector();
	await app.getComplainers();
	document.getElementById('form').onsubmit = async function (e) {
		e.preventDefault();
		let fd = new FormData(this)
		fd.append('assistants', app.editor.getData());
		if (app.edit) {
			await app.update(fd);
		} else {
			let subdirector = await app.getSubdirector();
			fd.append('subdirector_name', subdirector.name);
			await app.create(fd);
		}
	}

	ClassicEditor.create(document.querySelector("#assistants"), {
		language: "es",
	}).then((new_editor) => {
		app.editor = new_editor;
	}).catch((error) => {
		console.error(error);
	});

	$(document).on('click', '.btn-add-case', async function () {
		await app.getCommitteeSessionTypes();
		document.getElementById('content').innerHTML = '';
		$('#modal-case').modal('toggle');
		$('#modal-case #committee_id').val($(this).data('id'));
		$('#modal-case').find('.modal-title').text('Agregar caso')
	});

	$(document).on('click', '.detail', async function () {
		let id = $(this).data('id');
		await app.selectCommittee(id);
		$('#modal-detail').find('.modal-title').text('Detalles del comité');
		$('#modal-detail').modal('toggle');
	});



	$(document).on('click', '.cases', async function () {
		let id = $(this).data('id');
		await app.getCases(id);
		$('#modal-cases').find('.modal-title').text('Casos a tratar')
		$('#modal-cases').modal('toggle');
	});

	$(document).on('click', '.committeeSessionType', async function () {
		if (this.value == 1) {
			document.getElementById('content').innerHTML = `
			<form id="formStimulus" method="POST">
				<div className="form-row">
					<div className="col">
						<div class="form-group">
                    		<label for="learner_name_id">Aprendiz</label>
                    		<input type="hidden" name="learner_id" id="learner_id">
							<input type="text" id="leaner_name_id" placeholder="Busca aqui..." class="form-control" autocomplete="off">
							<div id="content-learner"></div>
                		</div>
					</div>
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
			document.getElementById('leaner_name_id').oninput = function () {
				let matches = app.learners.filter(learner => {
					const rgex = new RegExp(`^${this.value}`, 'gi');
					return learner.username.match(rgex) || learner.document.match(rgex);
				});
				if (this.value.length === 0) {
					matches = [];
				}
				let html = '<ul class="list-group">';
				if (matches.length > 0) {
					matches.forEach(match => {
						html += `<li onclick="selectLearner('${match.username}', ${match.id})" class="list-group-item list-group-item-action">${match.username}</li>`
					});
					html += "</ul>";
					document.getElementById('content-learner').innerHTML = html;
				} else {
					document.getElementById('content-learner').innerHTML = "<p class='mt-3'>¿No esta? <a href='#' onclick='formComplainer()'>Registralo</a></p>";
				}
			}
			document.getElementById('btnAddSession').setAttribute('form', 'formStimulus');
			document.getElementById('formStimulus').onsubmit = async function (e) {
				e.preventDefault();
				let fd = new FormData(this);
				fd.append('committee_session_type_id', 1);
				fd.append('committee_id', document.getElementById('committee_id').value);
				await app.addStimulu(fd);
			}
		}
		if (this.value == 2) {
			document.getElementById('content').innerHTML = `
			<form id="formNovelty" method="POST">
				<div className="form-row">
					<div className="col">
						<div class="form-group">
							<label for="learner_name_id">Aprendiz</label>
							<input type="hidden" name="learner_id" id="learner_id">
							<input type="text" id="leaner_name_id" placeholder="Busca aqui..." class="form-control" autocomplete="off">
							<div id="content-learner"></div>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col">
						<div class="form-group">
							<label for="novelty_type_id">Tipo de novedad</label>
							<select name="novelty_type_id" id="novelty_type_id" class="form-control">
							</select>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col">
						<div class="form-group">
							<label for="novelty_id">Novedad</label>
							<input type="text" class="form-control" placeholder="Buscar aqui..." id="novelties"/>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col">
						<div class="form-group">
							<label for="justification">Justificación</label>
							<textarea name="justification" id="justification" class="form-control"></textarea>
						</div>
					</div>
				</div>
            </form>
			`;
			await app.getNoveltyTypes();
			document.getElementById('leaner_name_id').oninput = function () {
				let matches = app.learners.filter(learner => {
					const rgex = new RegExp(`^${this.value}`, 'gi');
					return learner.username.match(rgex) || learner.document.match(rgex);
				});
				if (this.value.length === 0) {
					matches = [];
				}
				let html = '<ul class="list-group">';
				if (matches.length > 0) {
					matches.forEach(match => {
						html += `<li onclick="selectLearner('${match.username}', ${match.id})" class="list-group-item list-group-item-action">${match.username}</li>`
					});
					html += "</ul>";
					document.getElementById('content-learner').innerHTML = html;
				} else {
					document.getElementById('content-learner').innerHTML = "<p class='mt-3'>¿No esta? <a href='#' onclick='formComplainer()'>Registralo</a></p>";
				}
			}
			document.getElementById('btnAddSession').setAttribute('form', 'formNovelty');
			document.getElementById('formNovelty').onsubmit = async function (e) {
				e.preventDefault();
				let fd = new FormData(this);
				fd.append('committee_id', document.getElementById('committee_id').value);
				await app.addNovelty(fd);
			}
		}
		if (this.value == 3) {
			document.getElementById('content').innerHTML = `
			<form id="formAcademic">
				<div class="form-row">
					<div class="col">
						<div class="form-group">
							<h6>Hora</h6>
							<div class="row">
								<div class="col">
									<label class="text-muted" for="start_hour">Inicia</label>
									<input type="time" name="start_hour" id="start_hour" class="form-control"/>
								</div>
								<div class="col">
									<label class="text-muted" for="end_hour">Termina</label>
									<input type="time" name="end_hour" id="end_hour" class="form-control"/>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
				<div class="form-row">
					<div class="col">
						<h6>Aprendiz</h6>
						<div className="form-group">
							<div class="form-group my-3">
								<label class="text-muted">Nombre o identificacion</label>
								<input type="text" name="leaner_name_id" id="leaner_name_id" class="form-control" autocomplete="off">
								<input type="hidden" name="learner_id" id="learner_id"/>
								<div id="content-learner"></div>
							</div>
						</div>
					</div>
				</div>
            </form>
			`;
			document.getElementById('btnAddSession').setAttribute('form', 'formAcademic');
			document.getElementById('leaner_name_id').oninput = async function () {
				let matches = app.learners.filter(learner => {
					const rgex = new RegExp(`^${this.value}`, 'gi');
					return learner.username.match(rgex) || learner.document.match(rgex)
				});
				if (this.value.length === 0) {
					matches = [];
				}
				let html = '<ul class="list-group">';
				if (matches.length > 0) {
					matches.forEach(match => {
						html += `<li onclick="selectLearner('${match.username}', '${match.id}')" class="list-group-item list-group-item-action">${match.username}</li>`
					});
					html += "</ul>";
					document.getElementById('content-learner').innerHTML = html;
				} else {
					document.getElementById('content-learner').innerHTML = "<p class='mt-3'>¿No esta? <a href='#' onclick='formComplainer()'>Registralo</a></p>";
				}
			}
			document.getElementById('formAcademic').onsubmit = async function (e){
				e.preventDefault();
				let fd = new FormData(this);
				fd.append('committee_id', document.getElementById('committee_id').value);
				fd.append('committee_session_type_id', 3);
				await app.addAcademic(fd);
			}
		}
	});

	$(document).on('click', '.edit', async function () {
		let id = $(this).data('id');
		await app.getCommittee(id);
	});

	$(document).on('click', '.delete', async function () {
		let id = $(this).data('id');
		app.id = id;
		Swal.fire({
			title: "¿Estas seguro?",
			text: "No podras revertir esto!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "Si, eliminar",
		}).then(async (result) => {
			if (result.value) {
				await app.delete();
				await app.get();
				Swal.fire("Eliminado!", "Tipo de contrato eliminado.", "success");
			}
		});
	});

	document.getElementById("btn-create").onclick = function () {
		$("#modal-create").modal("toggle");
		$("#modal-create").find(".modal-title").text("Crear comité");
	};
});
