function verificarFimDeSemana() {
    var data = document.getElementById("data").value;
    var diaDaSemana = new Date(data).getDay();
    var horario = document.getElementById("horario");
    var btnMarcar = document.getElementById("btnMarcar");
    var msgErro = document.getElementById("msgErro");
    
    if (diaDaSemana === 0 || diaDaSemana === 6) {
      horario.setAttribute("disabled", "disabled");
      btnMarcar.setAttribute("disabled", "disabled");
      msgErro.style.display = "block";
    } else {
      horario.removeAttribute("disabled");
      btnMarcar.removeAttribute("disabled");
      msgErro.style.display = "none";
    }
  }
  