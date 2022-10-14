(() => {
  const login = async (user, password) => {
    const data = new FormData();
    let datos = {
      user: user,
      password: password,
    };
    data.append("action", "login");
    data.append("datos", JSON.stringify(datos));
    return await codigo.postData("loginAjax.php", data);
  };

  const btnIngresar = document.querySelector("#ingresar");

  btnIngresar.addEventListener("click", async () => {
    let usuario = document.querySelector("#usuario");
    let password = document.querySelector("#password");
    if (usuario.value && password.value) {
      let status = await login(usuario.value, password.value).catch((data) => {
        return { status: 0, msj: "Error, intenta mas tarde", error: data };
      });
      if (status.status == 1) {
        document.location.href = "visitas.php";
      } else {
        codigo.mostrarMsj("#msjLogin", "Datos erroneos", "alert-danger");
      }
    } else {
      codigo.mostrarMsj(
        "#msjLogin",
        "Favor de llenar los datos",
        "alert-danger"
      );
    }
  });
})();
