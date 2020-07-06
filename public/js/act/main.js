const config = {
    url: document.getElementById('url').content,
    committee_id: document.getElementById('committee_id').value
}

const app = {
    academics: null,
    getData: async function(){
        try {
            let res = await fetch(`${config.url}committee_sessions/index/${config.committee_id}`);
            let data = await res.json();
            this.academics = data.data[2].committee_sessions_academics;
        } catch (error) {
            console.log(error);
        }
    },
    renderAcademics: async function(){
        let html = '';
        this.academics.map(academic => {
            html+= `
            <tr>
                <td>${academic.learner_name}</td>
                <td>${academic.start_hour}</td>
                <td>${academic.end_hour}</td>
                <td></td>
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
    await app.renderAcademics();
    $(document).on('click', '.history', async function(){
        let id = $(this).data('id');
        await app.getLeaner(id);
    });
    $(document).on('click', '.start', async function(){
        console.log('click');
    });
});
