const config = {
    url: document.getElementById('url').content,
    committee_id: document.getElementById('committee_id').value
}

const app = {
    committee_sessions: null,
    getData: async function(){
        try {
            let res = await fetch(`${config.url}committee_sessions/index/${config.committee_id}`);
            let data = await res.json();
            this.committee_sessions = data.committee_sessions;
        } catch (error) {
            console.log(error);
        }
    },
    getInfringementTypes: async function(){
        try {
            let res = await fetch(`${config.url}infringement_types/index`);
            let data = await res.json();
            let html = '';
            data.infringement_types.map(infringement_type=>{
                html+=`
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="infringement_type_id" id="exampleRadios${infringement_type.id}" value="${infringement_type.id}">
                        <label class="form-check-label" for="exampleRadios${infringement_type.id}">
                            ${infringement_type.name}
                        </label>
                    </div>
                `;
            });
            $('#modal-communication').find('#infringement_types').html(html);
        } catch (error) {
            console.log(error);
        }
    },
    getInfringementClassifications: async function(){
        try {
            let res = await fetch(`${config.url}infringement_classifications/index`);
            let data = await res.json();
            let html = '';
            data.infringement_classifications.map(infringement_classification=>{
                html+=`
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="infringement_classification_id" id="example${infringement_classification.id}" value="${infringement_classification.id}">
                        <label class="form-check-label" for="example${infringement_classification.id}">
                            ${infringement_classification.name}
                        </label>
                    </div>
                `;
            })
            $('#modal-communication').find('#infringement_classifications').html(html);
        } catch (error) {
            console.log(error);
        }
    },
    generateCommunication:async function(form){
        try {
            let res = await fetch(`${config.url}act/generate_communication`, {
                method:'POST',
                body:new FormData(form)
            });
            let blob = await res.blob();
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = "Comunicación.docx";
            document.body.appendChild(a); // we need to append the element to the dom -> otherwise it will not work in firefox
            a.click();    
            a.remove();
        } catch (error) {
            console.log(error);
        }
    },
    render: async function(){
        let html = '';
        this.committee_sessions.map(committee_session => {
            html+= `
            <tr>
                <td><a href="#" class="history" data-id="${committee_session.learner.id}">${committee_session.learner.username}</a></td>
                <td>
                    <h5>
                        <a href="#" class="badge badge-pill badge-primary state" data-state="${committee_session.committee_session_state.id}">${committee_session.committee_session_state.name}</a>
                    </h5>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Acciones
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">Editar</a>
                          <a class="dropdown-item" href="#">Eliminar</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item generate-communication" data-learner="${committee_session.learner.id}" data-id="${committee_session.id}" href="#">Generar comunicacion</a>
                          <a class="dropdown-item" href="#">Generar acta comite</a>
                          <a class="dropdown-item" href="#">Generar acto sancionatorio</a>
                        </div>
                    </div>
                </td>
            </tr>
            `;
        });
        document.getElementById('data-academics').innerHTML = html;
        $(document).on('click', '.generate-communication', async function(){
            let id = $(this).data('id');
            let learner_id = $(this).data('learner');
            $('#modal-communication').find('#committee_id').val(id);
            $('#modal-communication').find('#learner_id').val(learner_id);
            await app.getInfringementTypes();
            await app.getInfringementClassifications();
            $('#modal-communication').modal('toggle');
        });
    },
    getLeaner: async function(id){
        try {
            let res = await fetch(`${config.url}learners/show/${id}`);
            let learner = await res.json();
            if(learner.status===200){
                $('#modal-history').modal('toggle');
                $('#modal-history #information').html(`
                <div class="row mt-3">                            
                    <div class="col-2">
                        <img src="${config.url}${learner.learner.photo?learner.learner.photo:'public/img/profile.png'} " alt="profile" class="img-fluid rounded border"/>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <h2>${learner.learner.username}</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p>${learner.learner.document_type} ${learner.learner.document}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p><i class="fas fa-mobile-alt text-primary"></i> ${learner.learner.phone}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p><i class="fas fa-at text-primary"></i> ${learner.learner.email}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <h5>Relacionados con la formacion</h5>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-3">
                        <p class="text-primary">Programa de formacion:</p>
                        <p class="text-primary">Grupo:</p>
                        <p class="text-primary">Inicio electiva: </p>
                        <p class="text-primary">Termina electiva:</p>
                        <p class="text-primary">Inicio practica: </p>
                        <p class="text-primary">Termina practica:</p>
                    </div>
                    <div class="col">
                        <p>${learner.learner.group.formation_program.name} (${learner.learner.group.formation_program.formation_program_type.name})</p>
                        <p>${learner.learner.group.code_tab} (${learner.learner.group.modality.name})</p>
                        <p>${learner.learner.group.elective_start_date}</p>
                        <p>${learner.learner.group.elective_end_date}</p>
                        <p>${learner.learner.group.practice_start_date}</p>
                        <p>${learner.learner.group.practice_end_date}</p>
                    </div>
                </div>
                `);
                res = await fetch(`${config.url}learner_novelties/findByLearner/${learner.learner.id}`);
                let data = await res.json();
                if(data.status===200){
                    let html = '';
                    if(data.learner_novelties.length < 1){
                        html = '<tr><td colspan="4" class="text-center">Este aprendiz no ha presentado novedades</td></tr>';
                    }else{
                        data.learner_novelties.map(novelty => {
                            html+=`
                            <tr>
                                <td>${novelty.novelty_type}</td>
                                <td>${novelty.justification}</td>
                                <td>${novelty.reply_date===null?'<span class="text-danger">Sin fecha de respuesta</span>':novelty.reply_date}</td>
                            </tr>
                            `;
                        });
                    }
                    $('#modal-history #data-novelties').html(html);
                }
                res = await fetch(`${config.url}stimuli/findByLearner/${learner.learner.id}`);
                data = await res.json();
                console.log(data);
                if(data.status===200){
                    let html = '';
                    if(data.stimuli.length < 1){
                        html = '<tr><td colspan="4" class="text-center">Este aprendiz no ha presentado novedades</td></tr>';
                    }else{
                        data.stimuli.map(stimulus => {
                            html+=`
                            <tr>
                                <td>${stimulus.stimulus}</td>
                                <td>${stimulus.justification}</td>
                            </tr>
                            `;
                        });
                    }
                    $('#modal-history #data-stimuli').html(html);
                }
                res = await fetch(`${config.url}committee_sessions/findByLearner/${learner.learner.id}`);
                data = await res.json();
                console.log(data);
                // if(data.status===200){
                //     let html = '';
                //     if(data.stimuli.length < 1){
                //         html = '<tr><td colspan="4" class="text-center">Este aprendiz no ha presentado novedades</td></tr>';
                //     }else{
                //         data.stimuli.map(stimulus => {
                //             html+=`
                //             <tr>
                //                 <td>${stimulus.stimulus}</td>
                //                 <td>${stimulus.justification}</td>
                //             </tr>
                //             `;
                //         });
                //     }
                //     $('#modal-history #data-stimuli').html(html);
                // }
            }
        } catch (error) {
            console.log(error);
        }
    }
}

$(document).ready(async function(){
    document.getElementById('loader').innerHTML = 'Cargando...';
    await app.getData();
    document.getElementById('loader').innerHTML = '';
    await app.render();
    $(document).on('click', '.history', async function(){
        let id = $(this).data('id');
        await app.getLeaner(id);
    });
    document.getElementById('form-communication').onsubmit = async function(e){
        e.preventDefault();
        await app.generateCommunication(this);
    }
});
