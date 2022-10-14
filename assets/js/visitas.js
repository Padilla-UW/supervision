const visitas = (() => {
  const modalUbicacion = new bootstrap.Modal("#modalUbicacion");
  const iframeUbicacion = document.querySelector("#iframeUbicacion");
  const modalUbicacionEven = document.getElementById("modalUbicacion");
  const modalAgreVisita = document.getElementById("modalAgreVisita");
  const btnAgreVisita = document.querySelector("#agregarVisita");
  const filtrosVisitas = document.querySelectorAll(".filtroVisitas");

  const guardarVisita = async (ubicacion, usuario, tienda) => {
    const data = new FormData();
    let datos = {
      longitud: ubicacion.longitude,
      latitud: ubicacion.latitude,
      usuario: usuario,
      tienda: tienda,
    };
    data.append("action", "guardarVisita");
    data.append("datos", JSON.stringify(datos));
    return await codigo.postData("visitasAjax.php", data);
  };

  const getVisitas = async (page) => {
    const data = new FormData();
    const fecha1 = document.querySelector("#filtroFecha1Visitas");
    const fecha2 = document.querySelector("#filtroFecha2Visitas");
    const usuario = document.querySelector("#filtroUsuarioVisitas");
    const tblVistas = document.querySelector("#tblVisitas");
    const paginationVisitas = document.querySelector("#paginationVisitas");
    let datos = {
      usuario: usuario.value,
      fecha1: fecha1.value,
      fecha2: fecha2.value,
      numVisita: "",
      page: page == "" ? 1 : page,
      funcion: "visitas.getVisitas",
      userType: userType,
    };
    data.append("action", "getVisitas");
    data.append("datos", JSON.stringify(datos));
    let visitas = await codigo.postData("visitasAjax.php", data);
    tblVistas.innerHTML = visitas.tbl;
    paginationVisitas.innerHTML = visitas.pagination;
    return 0;
  };

  const getVisita = async (idVisita) => {
    const data = new FormData();
    let datos = {
      idVisita: idVisita,
    };
    data.append("action", "getVisita");
    data.append("datos", JSON.stringify(datos));
    return await codigo.postData("visitasAjax.php", data);
  };

  const mostrarUbicacion = async (element) => {
    let id = element.getAttribute("data-id");

    let visita = await getVisita(id);
    iframeUbicacion.setAttribute(
      "src",
      `http://maps.google.com/maps?q=${visita.latitud},${visita.longitud}&t=k&z=16&output=embed`
    );
    http: modalUbicacion.show();
  };

  for (let i = 0; i < filtrosVisitas.length; i++) {
    filtrosVisitas[i].addEventListener("change", () => {
      getVisitas("");
    });
  }

  btnAgreVisita.addEventListener("click", async () => {
    const tienda = document.querySelector("#tiendaVisita");
    if (tienda.value) {
      btnAgreVisita.disabled = true;
      navigator.geolocation.getCurrentPosition(async (data) => {
        const response = await guardarVisita(
          data.coords,
          idUser,
          tienda.value
        ).catch((data) => {
          return { status: 0, msj: "Error, intenta mas tarde", error: data };
        });
        if (response.status == 1) {
          codigo.mostrarMsj("#msjAgreVisita", response.msj, "alert-success");
          getVisitas("");
        } else {
          codigo.mostrarMsj("#msjAgreVisita", response.msj, "alert-danger");
          btnAgreVisita.disabled = false;
        }
      });
    } else {
      codigo.mostrarMsj(
        "#msjAgreVisita",
        "Favor de agregar la tienda",
        "alert-danger"
      );
    }
  });

  modalUbicacionEven.addEventListener("hidden.bs.modal", (event) => {
    iframeUbicacion.setAttribute("src", "");
  });
  modalAgreVisita.addEventListener("show.bs.modal", (event) => {
    codigo.mostrarMsj("#msjAgreVisita", "", "");
    btnAgreVisita.disabled = false;
  });

  document.addEventListener("DOMContentLoaded", async (event) => {
    console.log(userType);
    if (userType == "admin") {
      btnAgreVisita.disabled = true;
    }

    const filtroUsuarioVisitas = document.querySelector(
      "#filtroUsuarioVisitas"
    );
    let usuarios = await codigo.getUsuarios("supervisor");
    const selectFilUsersVisitas = document.querySelector(
      "#filtroUsuarioVisitas"
    );
    codigo.agreOptionSelect(
      usuarios.usuarios,
      selectFilUsersVisitas,
      "idUser",
      "nombre",
      true,
      "Selecciona un usuario"
    );
    if (userType != "admin") {
      filtroUsuarioVisitas.value = idUser;
      filtroUsuarioVisitas.disabled = true;
    }
    await getVisitas("");
  });

  return {
    getVisitas,
    mostrarUbicacion,
  };
})();
