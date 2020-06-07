const app = {
    url: document.getElementById('url').content,
    getData:async function () {
        try {
            let res  = await fetch(`${this.url}learners/index`);
            let data = await res.json();
            let html = '';
            data.learners.forEach(learner => {
                html+=`
                <tr>
                    <td>${learner.username}</td>
                    <td>${learner.document_type_id}</td>
                    <td>${learner.document}</td>
                    <td>${learner.phone}</td>
                    <td>${learner.email}</td>
                    <td>
                        <button>Editar</button>
                        <button>Eliminar</button>
                    </td>
                </tr>
                `;
            });
            document.getElementById('data-learners').innerHTML = html;
        } catch (error) {
            console.log(error);
        }
    },
}
$(document).ready(function () {
    app.getData();
    $('#learners').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }
    });
});