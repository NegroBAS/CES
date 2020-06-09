const app = {
  authenticate: async function (req, res) {
    try {
      let res = await fetch("https://cronode.herokuapp.com/api/authenticate", {
        method: "POST",
        headers: {
          accept: "application/json",
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          misena_email: "consulta@misena.edu.co",
          password: "123456789110",
        }),
      });
      let data = await res.json();
      sessionStorage.setItem("token", data.token);
    } catch (error) {
      console.log(error);
    }
  },
  getInfo: async function () {
    try {
      await this.authenticate();
      let res = await fetch("https://cronode.herokuapp.com/api/ces/positions", {
        headers: {
          authorization: "Bearer " + sessionStorage.getItem("token"),
        },
      });
      let positions = await res.json();
      let fd = new FormData();
      fd.append("positions", JSON.stringify(positions));
      res = await fetch(`${this.url}Position/masive`, {
        method: "POST",
        body: fd,
      });
      data = await res.json();
      console.log(data);
    } catch (error) {
      console.log(error);
    }
  },
  url: document.getElementById("url").content,
  edit: false,
  list: async function () {
    let resp = await fetch(`${this.url}positions/index`);
    let res = await resp.json();
    let positions = res.positions;
    let html = "";
    positions.forEach((positions) => {
      html += `
            <div class="col-3 mb-3">
                    <div class="card" data-id="${positions.id}">
                        <div class="card-header bg-primary"></div>
                        <div class="card-body text-center">
                            <h5>${positions.name}</h5>
                            <h6>${positions.type}</h6>
                            <button class="btn btn-sm btn-outline-primary edit" data-toggle="modal" data-target="#modal">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div> 
            </div> `;
    });
    document.getElementById("data-positions").innerHTML = html;
  },
  create: async function () {
    let resp = await fetch(`${this.url}positions/save`, {
      method: "POST",
      body: new FormData(document.getElementById("form")),
    });
    let res = await resp.json();
    console.log(res.status);
    if (res.status == "ok") {
      console.log(res.message);
      $("#form").trigger("reset");
      await app.list();
    }
  },
  delete: async function (id) {
    let resp = await fetch(`${this.url}positions/del/${id}`);
    let res = await resp.json();
    console.log(res);
    await app.list();
  },
  update: async function (id) {
    let resp = await fetch(`${this.url}positions/update/${id}`, {
      method: "POST",
      body: new FormData(document.getElementById("form")),
    });
    let res = await resp.json();
    console.log(res);
    if (res.status == "ok") {
      console.log(res.message);
      $("#form").trigger("reset");
      await app.list();
      this.edit = false;
    }
  },
};

$(document).ready(async function () {
  document.getElementById('btnUpdate').onclick = async function(){
    await app.getInfo();
    app.list();
  }
  let id = 0;
  await app.list();
  document.getElementById("btnForm").onclick = async function () {
    if (app.edit) {
      console.log("editando");
      await app.update(id);
    } else {
      console.log("creando");
      await app.create();
    }
  };
  $(document).on("click", ".delete", async function () {
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
        app.list();
      }
    });
  });
  document.getElementById("btnCreate").onclick = function () {
    app.edit = false;
    let modal = $("#modal");
    modal.find(".modal-title").text("Crear Rango");
    $("#form").trigger("reset");
    validaciones();
  };
  $(document).on("click", ".edit", async function () {
    id = $($(this)[0].parentElement.parentElement).data("id");
    app.edit = true;
    let modal = $("#modal");
    modal.find(".modal-title").text("Editar Rango");
    let resp = await fetch(`${app.url}positions/edit/${id}`);
    let res = await resp.json();
    validaciones();
    document.getElementById("name").value = res.name;
    document.getElementById("type").value = res.type;
  });

  function validaciones() {
    let name = document.getElementById("name");
    let type = document.getElementById("type");

    let letrasRegex = /^[A-Za-z _]*[A-Za-z][A-Za-z _]*$/;
    let btn = document.getElementById("btnForm");

    btn.setAttribute("disabled", "disabled");

    name.oninput = function () {
      if (letrasRegex.test(this.value)) {
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
      } else {
        this.classList.remove("is-valid");
        this.classList.add("is-invalid");
        document.getElementById("nameMessage").innerHTML =
          "Este campo es requerido";
      }

      if (this.value === "") {
        console.log("campo requerido");
        document.getElementById("nameMessage").innerHTML =
          "Este campo es requerido";
        this.classList.add("is-invalid");
      }

      if (letrasRegex.test(this.value) && letrasRegex.test(type.value)) {
        btn.removeAttribute("disabled");
      } else {
        btn.setAttribute("disabled", "disabled");
      }
    };

    type.oninput = function () {
      if (letrasRegex.test(this.value)) {
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
      } else {
        this.classList.remove("is-valid");
        this.classList.add("is-invalid");
        document.getElementById("typeMessage").innerHTML =
          "Este campo es requerido";
      }

      if (this.value === "") {
        console.log("campo requerido");
        document.getElementById("typeMessage").innerHTML =
          "Este campo es requerido";
        this.classList.add("is-invalid");
      }

      if (letrasRegex.test(this.value) && letrasRegex.test(name.value)) {
        btn.removeAttribute("disabled");
      } else {
        btn.setAttribute("disabled", "disabled");
      }
    };
  }
});
