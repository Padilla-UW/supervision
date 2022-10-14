const usuarios = (() => {
  const tblUsuarios = document.querySelector("#tblUsuarios");
  const btnAgreUsuario = document.querySelector("#agregarUsuario");
  const modalEditUser = new bootstrap.Modal("#modalEditUsuario");
  const modalEditPasswordObj = new bootstrap.Modal("#modalEditPassword");
  const nombreEdit = document.querySelector("#nombreEdit");
  const apellidoEdit = document.querySelector("#apellidoEdit");
  const telefonoEdit = document.querySelector("#telefonoEdit");
  const usuarioEdit = document.querySelector("#usuarioEdit");
  const btnEditarUsuario = document.querySelector("#editarUsuario");
  const btnEditarPassword = document.querySelector("#editarPassword");

  let modalEditPassword = document.getElementById("modalEditPassword");
  modalEditPassword.addEventListener("hidden.bs.modal", function (event) {
    document.getElementById("formCambioPassword").reset();
    codigo.mostrarMsj("#msjEditPassword", "", "");
    btnEditarPassword.setAttribute("data-id", "");
  });

  let modalAgreUser = document.getElementById("modalAgreUsuario");
  modalAgreUser.addEventListener("hidden.bs.modal", function (event) {
    document.getElementById("formAgregarUser").reset();
    codigo.mostrarMsj("#msjAgreUsuario", "", "");
  });

  const getTblUsuarios = async (page) => {
    const data = new FormData();
    let datos = {
      page: page == "" ? 1 : page,
      funcion: "usuarios.getTblUsuarios",
      userType: userType == "admin" ? "supervisor" : "",
    };
    data.append("action", "getTblUsuario");
    data.append("datos", JSON.stringify(datos));
    let usuarios = await codigo.postData("usuariosAjax.php", data);
    tblUsuarios.innerHTML = usuarios.tbl;
    return 0;
  };

  const getUsuario = async (idUser) => {
    const data = new FormData();
    let datos = {
      idUser: idUser,
    };
    data.append("action", "getUsuario");
    data.append("datos", JSON.stringify(datos));
    return await codigo.postData("usuariosAjax.php", data);
  };

  const agregarUsuario = async (usuario) => {
    const data = new FormData();
    data.append("action", "agregarUsuario");
    data.append("datos", JSON.stringify(usuario));
    return await codigo.postData("usuariosAjax.php", data);
  };

  const showUsuarioEdit = async (element) => {
    codigo.mostrarMsj("#msjEditUsuario", "", "");
    btnEditarUsuario.disabled = false;
    let idUser = element.getAttribute("data-id");
    let usuario = await getUsuario(idUser);
    nombreEdit.value = usuario.nombre;
    apellidoEdit.value = usuario.apellido;
    telefonoEdit.value = usuario.telefono;
    usuarioEdit.value = usuario.usuario;
    btnEditarUsuario.setAttribute("data-id", idUser);
    modalEditUser.show();
  };

  const editarUser = async (user) => {
    const data = new FormData();
    data.append("action", "editarUsuario");
    data.append("datos", JSON.stringify(user));
    return await codigo.postData("usuariosAjax.php", data);
  };

  const editPassword = async (datos) => {
    const data = new FormData();
    data.append("action", "editarPassword");
    data.append("datos", JSON.stringify(datos));
    return await codigo.postData("usuariosAjax.php", data);
  };

  const showPasswordEdit = (element) => {
    let idUser = element.getAttribute("data-id");
    btnEditarPassword.setAttribute("data-id", idUser);
    modalEditPasswordObj.show();
  };

  btnEditarUsuario.addEventListener("click", async () => {
    let idUser = btnEditarUsuario.getAttribute("data-id");
    if (
      nombreEdit.value &&
      apellidoEdit.value &&
      usuarioEdit.value &&
      idUser &&
      telefonoEdit.value
    ) {
      btnEditarUsuario.disabled = true;
      let usuario = {
        idUser: idUser,
        nombre: nombreEdit.value,
        apellido: apellidoEdit.value,
        usuario: usuarioEdit.value,
        telefono: telefonoEdit.value,
      };
      if ((await editarUser(usuario)).status == 1) {
        codigo.mostrarMsj(
          "#msjEditUsuario",
          "Usuario editado",
          "alert-success"
        );
        getTblUsuarios("");
      } else {
        codigo.mostrarMsj(
          "#msjEditUsuario",
          "Error, intenta más tarde",
          "alert-danger"
        );
        btnEditarUsuario.disabled = false;
      }
    } else {
      codigo.mostrarMsj(
        "#msjEditUsuario",
        "Favor de llenar todos los campos",
        "alert-danger"
      );
    }
  });

  btnAgreUsuario.addEventListener("click", async () => {
    const nombre = document.querySelector("#nombre");
    const apellido = document.querySelector("#apellido");
    const telefono = document.querySelector("#telefono");
    const usuario = document.querySelector("#usuario");
    const password = document.querySelector("#password");

    if (
      nombre.value &&
      apellido.value &&
      telefono.value &&
      usuario.value &&
      password.value
    ) {
      if (password.value.length >= 6) {
        let usuarioData = {
          nombre: nombre.value,
          apellido: apellido.value,
          telefono: telefono.value,
          usuario: usuario.value,
          password: password.value,
        };
        const registro = await agregarUsuario(usuarioData);
        if (registro.status == 1) {
          codigo.mostrarMsj(
            "#msjAgreUsuario",
            "Usuario agregado",
            "alert-success"
          );
          getTblUsuarios("");
        } else {
          codigo.mostrarMsj(
            "#msjAgreUsuario",
            "Error, intenta más tarde",
            "alert-danger"
          );
        }
      } else {
        codigo.mostrarMsj(
          "#msjAgreUsuario",
          "La contraseña debe tener minimo 6 caracteres",
          "alert-warning"
        );
      }
    } else {
      codigo.mostrarMsj(
        "#msjAgreUsuario",
        "Favor de llenar todos los campos",
        "alert-danger"
      );
    }
  });

  btnEditarPassword.addEventListener("click", async () => {
    let idUser = btnEditarPassword.getAttribute("data-id");
    let password = document.querySelector("#passwordEdit");
    let passwordConfir = document.querySelector("#passwordEditConfir");
    btnEditarPassword.disabled = true;

    if (password.value && passwordConfir.value && idUser) {
      if (password.value == passwordConfir.value) {
        let newPassword = {
          idUser: idUser,
          password: password.value,
        };
        if ((await editPassword(newPassword)).status == 1) {
          codigo.mostrarMsj(
            "#msjEditPassword",
            "Contraseña actualizada",
            "alert-success"
          );
        } else {
          codigo.mostrarMsj(
            "#msjEditPassword",
            "Error, intenta más tarde",
            "alert-danger"
          );
          btnEditarPassword.disabled = false;
        }
      } else {
        codigo.mostrarMsj(
          "#msjEditPassword",
          "Las contraseñas no coinciden",
          "alert-warning"
        );
        btnEditarPassword.disabled = false;
      }
    } else {
      codigo.mostrarMsj(
        "#msjEditPassword",
        "Favor de llenar los campo",
        "alert-danger"
      );
      btnEditarPassword.disabled = false;
    }
  });

  getTblUsuarios("");
  return {
    showUsuarioEdit,
    showPasswordEdit,
  };
})();
