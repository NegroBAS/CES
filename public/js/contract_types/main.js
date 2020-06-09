const app = {
  authenticate: async function () {
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
      let res = await fetch(
        "https://cronode.herokuapp.com/api/ces/contractTypes",
        {
          headers: {
            authorization: "Bearer " + sessionStorage.getItem("token"),
          },
        }
      );
      let contractTypes = await res.json();
      console.log(contractTypes);
      
      let fd = new FormData();
      fd.append("contract_types", JSON.stringify(contractTypes));
      res = await fetch(`${this.url}ContractType/masive`, {
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
    let resp = await fetch(`${this.url}contract_types/index`);
    let res = await resp.json();
    let contract_types = res.contract_types;

    
    let html = "";
    contract_types.forEach((contract_types) => {
      html += `
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <div class="card" data-id="${contract_types.id}">
                            <div class="card-header bg-primary"></div>
                            <div class="card-body text-center">
                                <h5>${contract_types.name}</h5>
                                <button class="btn btn-sm btn-outline-primary edit" data-toggle="modal" data-target="#modal">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            </div>
                        </div> 
                </div>  `;
    });
    document.getElementById("data-contract_types").innerHTML = html;
  },
  create: async function () {
    let resp = await fetch(`${this.url}contract_types/save`, {
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
    let resp = await fetch(`${this.url}contract_types/del/${id}`);
    let res = await resp.json();
    console.log(res);
  },
  update: async function (id) {
    let resp = await fetch(`${this.url}contract_types/update/${id}`, {
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
  await app.getInfo();
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
    modal.find(".modal-title").text("Crear Tipo de Contrato");
    validaciones();
    $("#form").trigger("reset");
  };
  $(document).on("click", ".edit", async function () {
    id = $($(this)[0].parentElement.parentElement).data("id");
    app.edit = true;
    let modal = $("#modal");
    modal.find(".modal-title").text("Editar Tipo de Contrato");
    let resp = await fetch(`${app.url}contract_types/edit/${id}`);
    let res = await resp.json();
    validaciones();
    document.getElementById("name").value = res.name;
  });

  function validaciones() {
    let name = document.getElementById("name");

    let letrasRegex = /^[A-Za-z _]*[A-Za-z][A-Za-z _]*$/;
    let btn = document.getElementById("btnForm");

    btn.setAttribute("disabled", "disabled");

    name.oninput = function () {
      if (letrasRegex.test(this.value)) {
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
        btn.removeAttribute("disabled");
      } else {
        this.classList.remove("is-valid");
        this.classList.add("is-invalid");
        document.getElementById("nameMessage").innerHTML =
          "Este campo es requerido";
        btn.setAttribute("disabled", "disabled");
      }

      if (this.value === "" || this.value == null) {
        console.log("campo requerido");
        document.getElementById("nameMessage").innerHTML =
          "Este campo es requerido";
        this.classList.add("is-invalid");
        btn.setAttribute("disabled", "disabled");
      }
    };
  }
});
