const config = {
    url: document.getElementById('url').content,
    committee_id: document.getElementById('committee_id').value
}

const app = {
    academics: null,
    novelties: null,
    stimulus: null,
    getData: async function(){
        try {
            let res = await fetch(`${config.url}committee_sessions/index/${config.committee_id}`);
            let data = await res.json();
            this.novelties = data.data[1].learner_novelties;
            this.stimulus  = data.data[0].committee_sessions_academics;
            this.academics = data.data[2].committee_sessions_academics;
        } catch (error) {
            console.log(error);
        }
    },
    renderAcademics: async function(){
        let html = '';
        this.academics.map(academic => {
            html+= `
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h6>Hora</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p>${academic.start_hour} a ${academic.end_hour}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h6>Aprendiz</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#">${academic.learner_name}</a>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <button class="btn btn-outline-primary">Empezar proceso</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `
        });
        document.getElementById('content').innerHTML = html;
    }
}

$(document).ready(async function(){
    document.getElementById('loader').innerHTML = 'Cargando...';
    await app.getData();
    document.getElementById('loader').innerHTML = '';
    await app.renderAcademics();
});
