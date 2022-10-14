const codigo = (() => {
  const postData = async (url, data) => {
    const response = await fetch(url, {
      method: "POST",
      body: data,
    });
    return response.json();
  };

  const mostrarMsj = (div, msj, clase) => {
    const contenedor = document.querySelector(div);
    contenedor.classList.remove(
      "alert-success",
      "alert-danger",
      "alert-warning"
    );
    clase != "" && contenedor.classList.add(clase);
    contenedor.innerText = msj;
  };

  const getUsuarios = async (userType) => {
    const data = new FormData();
    let datos = {
      userType: userType,
    };
    data.append("action", "getUsuarios");
    data.append("datos", JSON.stringify(datos));
    return await postData("visitasAjax.php", data);
  };

  const agreOptionSelect = (
    data,
    select,
    value,
    label,
    limpiarSelect = false,
    defau = ""
  ) => {
    if (limpiarSelect) {
      for (let i = select.options.length; i >= 0; i--) {
        select.remove(i);
        const option = document.createElement("option");
        option.value = "";
        option.text = defau;
        select.appendChild(option);
      }
    }

    console.log(data);

    data.forEach((element) => {
      const option = document.createElement("option");
      const valor = element[value];
      const etiqueta = element[label];
      option.value = valor;
      option.text = etiqueta;
      select.appendChild(option);
    });
  };

  return {
    postData,
    mostrarMsj,
    getUsuarios,
    agreOptionSelect,
  };
})();
