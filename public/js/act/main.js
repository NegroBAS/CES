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
    render: async function(){
        let html = '';
        this.committee_sessions.map(committee_session => {
            html+= `
            <tr>
                <td><a href="#" data-id="${committee_session.learner.id}">${committee_session.learner.username}</a></td>
                <td>${committee_session.start_hour}</td>
                <td>${committee_session.end_hour}</td>
                <td>
                    <h5>
                        <span class="badge badge-pill badge-primary">Notificacion</span>
                    </h5>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Acciones
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </td>
            </tr>
            `;
        });
        document.getElementById('data-academics').innerHTML = html;
    },
    getLeaner: async function(id){
        try {
            let res = await fetch(`${config.url}learners/show/${id}`);
            let data = await res.json();
            if(data.status===200){
                $('#modal-history').modal('toggle');
                $('#modal-history #data-novelties').html('<tr><td colspan="4" class="text-center">Cargando...</td></tr>');
                res = await fetch(`${config.url}learner_novelties/findByLearner/${data.learner.id}`);
                data = await res.json();
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
    $(document).on('click', '.start', async function(){
        console.log('click');
    });
});
