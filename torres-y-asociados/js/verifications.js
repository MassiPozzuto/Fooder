/* -- Registro de Usuario -- */
const campos = {
  usuario: false,
  correo: false,
  contra: false,
  edad: false,
  genero: false
}

function ajaxCallBack(verif, etiqueta) {
  if (verif == true) {
    document.getElementById(etiqueta).style.border = "3px solid #003f68";
    document.getElementById('msg-' + etiqueta).innerHTML = '';
    if (etiqueta == 'usu') {
      campos.usuario = true;
    } else if (etiqueta == 'mail') {
      campos.correo = true;
    }
  } else if (verif == false) {
    document.getElementById(etiqueta).style.border = "3px solid #cb1a1a";
    msg = etiqueta == 'usu' ? 'Este usuario ya se encuentra registrado' : 'Este email ya se encuentra registrado';
    document.getElementById('msg-' + etiqueta).innerHTML = msg;
  }
}

// --Validar Nombre de Usuario-- 
function usuario() {
  inputVal = document.getElementById('usu').value;

  var datosRegis = $("#formulario_regis").serialize();

  if (inputVal.length > 3 && inputVal.length < 16) {
    $.ajax({
      //async: false,
      url: "/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/verif-usuario.php",
      type: "POST",
      data: datosRegis,
      success: function (result) {
        ajaxCallBack(result, 'usu');
      },
      error: function () {
        alert("error");
      },
    });
  } else {
    document.getElementById("usu").style.border = "3px solid #cb1a1a";
    document.getElementById('msg-usu').innerHTML = 'El nombre de usuario debe contener un mínimo de 4 y un maximo de 15 caracteres';
    campos.usuario = false;
  }
}

// Comprobar Gmail
function correo() {
  var correo_val = document.getElementById("mail").value.split("@");

  var datosRegis = $("#formulario_regis").serialize();

  if (correo_val[1] == "gmail.com" && correo_val[0] != '') {
    $.ajax({
      //async: false,
      url: "/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/verif-email.php",
      type: "POST",
      data: datosRegis,
      success: function (result) {
        ajaxCallBack(result, 'mail');
      },
      error: function () {
        alert("error");
      },
    });
  } else {
    document.getElementById("mail").style.border = "3px solid #cb1a1a";
    document.getElementById('msg-mail').innerHTML = 'El email no tiene un formato correcto. Tiene que ser de Gmail';
    campos.correo = false;
  }
}

function password() {
  clave = document.getElementById("clave").value;

  if (clave.length > 7 && clave.length < 51) {
    document.getElementById("clave").style.border = "3px solid #003f68";
    document.getElementById('msg-pass').innerHTML = '';
    campos.contra = true;
  } else {
    document.getElementById("clave").style.border = "3px solid #cb1a1a";
    document.getElementById('msg-pass').innerHTML = 'La contraseña debe contener un mínimo de 8 y un maximo de 50 caracteres';
    campos.contra = false;
  }

  verifPass();
}

function verifPass() {
  clave2 = document.getElementById("clave2").value;

  if (clave != clave2 || clave2.length < 2) {
    document.getElementById("clave2").style.border = "3px solid #cb1a1a";
    document.getElementById('msg-pass2').innerHTML = 'Ambas contraseñas deben ser identicas';
    campos.contra = false;
  } else {
    if (clave2.length > 7 && clave2.length < 51) {
      document.getElementById("clave2").style.border = "3px solid #003f68";
      document.getElementById('msg-pass2').innerHTML = '';
      campos.contra = true;
    } else {
      document.getElementById("clave2").style.border = "3px solid #cb1a1a";
      document.getElementById('msg-pass2').innerHTML = 'Ambas contraseñas deben ser identicas';
      campos.contra = false;
    }
  }
}

// Comprobar Edad
function edad() {
  var anio = document.getElementById("nac").value.split("-");
  var hoy = new Date();
  var anioA = hoy.getFullYear()

  if (anioA - anio[0] >= 13) {
    //mayor o igual a 13 anios 
    document.getElementById("nac").style.border = "3px solid #003f68";
    document.getElementById('msg-edad').innerHTML = '';
    campos.edad = true;
  } else {
    //menor a 13 anios
    document.getElementById("nac").style.border = "3px solid #cb1a1a";
    document.getElementById('msg-edad').innerHTML = 'Debe ser mayor de 13 años';
    campos.edad = false;
  }
}

// Seleccion Genero
function genero(label) {
  if (label == 1) {
    document.getElementById("hombre-l").style.borderColor = "transparent";
    document.getElementById("mujer-l").style.borderColor = "#003f68";
    document.getElementById("personalizado-l").style.borderColor = "#003f68";
  } else if (label == 2) {
    document.getElementById("hombre-l").style.borderColor = "#003f68";
    document.getElementById("mujer-l").style.borderColor = "transparent";
    document.getElementById("personalizado-l").style.borderColor = "#003f68";
  } else {
    document.getElementById("hombre-l").style.borderColor = "#003f68";
    document.getElementById("mujer-l").style.borderColor = "#003f68";
    document.getElementById("personalizado-l").style.borderColor = "transparent";
  }
}

// Submit con Javascript 
function registrarse() {
  // Comprobar Genero Seleccionado
  if (document.querySelector('input[name="genero_id"]:checked')) {
    document.querySelector('input[name="genero_id"]').style.borderColor = "#003f68";
    document.querySelector('input[name="genero_id"]:checked').style.borderColor = "transparent";
    campos.genero = true;
  } else {
    document.getElementById("hombre-l").style.borderColor = "#cb1a1a";
    document.getElementById("mujer-l").style.borderColor = "#cb1a1a";
    document.getElementById("personalizado-l").style.borderColor = "#cb1a1a";
    campos.genero = false;
  }

  // Comprobar todos los campos fueron llenados correctamente
  if (campos.usuario && campos.correo && campos.contra && campos.edad && campos.genero) {
    document.getElementById('final-msg').innerHTML = '';
    document.getElementById('msg-error').setAttribute('class', 'usuario');

    setTimeout(function () { document.formulario_regis.submit(); }, 500);
  } else {
    let arreglo = Object.values(campos);
    console.log(arreglo);
    for(i=0; i<4; i++){
      if(!arreglo[i]){
        console.log(i);
        $('.us-'+i).attr('style', 'border:3px solid #cb1a1a;');
      }
    }
    document.getElementById('msg-error').style.display = 'block';
    document.getElementById('final-msg').innerHTML = '<b>Error:</b> Rellene el formulario correctamente';
  }
}

/* --- LOGIN --- */

const fields = {
  email: false,
  password: false,
}



$(document).ready(function () {
  log_direct_e();
  log_direct_c();

  $(".login-index").click(function () {
    if (fields.email && fields.password) {
      var data = $("#inicio-sesion").serialize();
      console.log(data);
      $.ajax({
        type: "POST",
        url: "/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/login.php",
        dataType: 'json',
        data: data,
        success: function (result) {
          if (result['success'] == 1) {
            document.getElementById("msg-error-inicio").style.display = "none";
            document.getElementById("errorEmail").style.border = "3px solid #003f68";
            document.getElementById("errorClave").style.border = "3px solid #003f68";
            
            window.location.href = `/proyectos/22-4.10-proyectos/torres-y-asociados/login.php?emailInicio=${result['email']}&claveInicio=${result['pass']}${result['remind'] == 'SI' ? '&recordar-checkbox=' + result['remind'] : ''}&success=${result['success']}`;

          } else {
            $('#msg-error-inicio').text(result['response']);
            document.getElementById("msg-error-inicio").style.display = "block";
            document.getElementById("errorEmail").style.border = "3px solid #cb1a1a";
            document.getElementById("errorClave").style.border = "3px solid #cb1a1a";
          }
        },
        error: function () {
          alert("error");
        },
      });
    }
    return false;
  });

});

$(document).ready(function(){
  var eye = document.getElementById("eye");
  var errorClave = document.getElementById("errorClave");
  eye.addEventListener("click", function(){  
    if(errorClave.type == "password"){
        errorClave.type = "text";
        eye.setAttribute('src', 'img/ojito.png');
    }else{
      errorClave.type = "password";
      eye.setAttribute('src', 'img/ojo-tachado.png');
    }
  })

  $('#eye2').click(function(){
    if($('#clave').attr('type') == 'password'){
      $('#clave').attr('type', 'text');
      $('#eye2').attr('src', 'img/ojito.png');
      $('#clave2').attr('type', 'text');
    }else{
      $('#clave').attr('type', 'password');
      $('#eye2').attr('src', 'img/ojo-tachado.png');
      $('#clave2').attr('type', 'password');
    }
  })
})

/* -- Recuperacion de Cuenta -- */
function generar_codigo() {
  document.getElementById("contenedor-recup-cuenta").style.display = "none";
  document.getElementById("contenedor-gen-codigo").style.display = "flex";

  setTimeout(function () { document.form_envio_correo_recup.submit(); }, 1000);
}
function error_recup_cuenta(razon){
  document.getElementById("email-recup-cuenta").style.border = "3px solid #cb1a1a";
  document.getElementById("email-error-recup").innerHTML = razon
  document.getElementById("email-error-recup").style.display = "block";
}
function verificar_email_recup(){
  var email_recup = document.getElementById("email-recup-cuenta").value;
  console.log(email_recup);
  if(email_recup.length !== 0){
    var emailVefif = email_recup.split("@");
    if(emailVefif[1] == "gmail.com" && emailVefif.length == 2){
      $.ajax({
        type: "POST",
        url: "/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/verif-email.php",
        data: { email_recup: email_recup },
        success: function (result) {
          if (result == true) {
            $("#email-error-recup").css("display", "none");
            $("#email-error-recup").html("");
            document.getElementById("email-recup-cuenta").style.borderColor = "#003f68";
            generar_codigo();
          } else if (result == false) {
            error_recup_cuenta("Error: El correo no existe.");
          }
        },
        error: function () {
          alert("error");
        },
      });
    }else if(emailVefif[1] !== "gmail.com" || emailVefif.length > 2){
      error_recup_cuenta("Error: El correo debe ser de tipo Gmail.");
    }
  }else{
    error_recup_cuenta("Error: No se ingreso ningun email.");
  }
}

/* -- Verificacion del Codigo -- */

function verificar_codigo() {
  var codigoUsu = SHA1(document.getElementById("codigo").value);
  if (codigoUsu== document.getElementById("codigo-mail").value) {
    document.getElementById("codigo-correcto").style.display = 'block';
    document.getElementById("codigo-erroneo").style.display = 'none';

    setTimeout(function () { document.verificacion_codigo.submit(); }, 1000);
  } else {
    document.getElementById("codigo-erroneo").style.display = 'block';
    document.getElementById("codigo-correcto").style.display = 'none';
  }
}
/* -- Verificacion de la contraseña -- */

function verif_pass_recup(){
  var contra1 = document.getElementById("cambiar-pass-recup1").value;
  var contra2 = document.getElementById("cambiar-pass-recup2").value;
  console.log(contra1+"   "+contra2)
  var verifcontra1 = false;
  if (contra1.length > 7 && contra1.length < 51) {
    $("#email-error-recup1").css("display", "none");
    $("#email-error-recup1").html("");
    document.getElementById("cambiar-pass-recup1").style.borderColor = "#003f68";
    verifcontra1 = true;
  } else {
    $("#email-error-recup1").css("display", "block");
    $("#email-error-recup1").html("Error: La contraseña debe contener un mínimo de 8 y un maximo de 50 caracteres");
    document.getElementById("cambiar-pass-recup1").style.borderColor = "#cb1a1a";
    verifcontra1 = false;
  }
  if (contra1 != contra2 || contra2.length < 2) {
    $("#email-error-recup2").css("display", "block");
    document.getElementById("cambiar-pass-recup1").style.borderColor = "#cb1a1a";
    $("#email-error-recup2").html('Ambas contraseñas deben ser identicas');
    document.getElementById("cambiar-pass-recup2").style.borderColor = "#cb1a1a";
    verifcontra1 = false;
  } else {
    if (contra2.length > 7 && contra2.length < 51) {
      $("#email-error-recup2").css("display", "none");
      $("#email-error-recup2").html("");
      document.getElementById("cambiar-pass-recup2").style.borderColor = "#003f68";
      verifcontra1 = true;
    } else {
      $("#email-error-recup2").css("display", "block");
      document.getElementById("cambiar-pass-recup1").style.borderColor = "#cb1a1a";
      $("#email-error-recup2").html('Ambas contraseñas deben ser identicas');
      document.getElementById("cambiar-pass-recup2").style.borderColor = "#cb1a1a";
      verifcontra1 = false;
    }
  }
  if(verifcontra1 === true){
    document.formulario_cambiar_pass_recup.submit();
  }
}

$(document).ready(function(){
  $('#eye3').click(function(){
    if($('#cambiar-pass-recup1').attr('type') == 'password'){
      $('#cambiar-pass-recup1').attr('type', 'text');
      $('#eye3').attr('src', 'img/ojito.png');
      $('#cambiar-pass-recup2').attr('type', 'text');
    }else{
      $('#cambiar-pass-recup1').attr('type', 'password');
      $('#eye3').attr('src', 'img/ojo-tachado.png');
      $('#cambiar-pass-recup2').attr('type', 'password');
    }
  })
})
/* -- Fin Recuperacion de Cuentas -- */
/* -- Verificacion del Login Directo -- */

function log_direct_e() {
  var email = $("#errorEmail").val();
  if (email.length !== 0) {
    var gmail = email.split("@");
    if (gmail[1] !== "gmail.com") {
      $("#email-error").css("display", "block");
      $("#email-error").html("Error: El correo debe ser de tipo Gmail.");
      document.getElementById("errorEmail").style.borderColor = "#cb1a1a";
      fields.email = false;
    } else {
      $.ajax({
        type: "POST",
        url: "/proyectos/22-4.10-proyectos/torres-y-asociados/modelos/verif-email.php",
        data: { emailVerif_log: email },
        success: function (result) {
          if (result) {
            $("#email-error").css("display", "none");
            $("#email-error").html("");
            document.getElementById("errorEmail").style.borderColor = "#003f68";
            fields.email = true;
          } else{
            $("#email-error").css("display", "block");
            $("#email-error").html("Error: El correo no existe.");
            document.getElementById("errorEmail").style.borderColor = "#cb1a1a";
            fields.email = false;
          }
        },
        error: function () {
          alert("error");
        },
      });
    }
  } else {
    $("#email-error").css("display", "none");
    $("#email-error").html("");
    document.getElementById("errorEmail").style.borderColor = "#003f68";
    fields.email = false;
  }
}
function log_direct_c() {
  var clave = $("#errorClave").val();
  if (clave.length !== 0) {
    if (clave.length < 8) {
      $("#clave-error").css("display", "block");
      $("#clave-error").html("Error: Contraseña menor a 8 caracteres.");
      document.getElementById("errorClave").style.borderColor = "#cb1a1a";
      fields.password = false;
    } else {
      $("#clave-error").css("display", "none");
      $("#clave-error").html("");
      document.getElementById("errorClave").style.borderColor = "#003f68";
      fields.password = true;
    }
  } else {
    $("#clave-error").css("display", "none");
    $("#clave-error").html("");
    document.getElementById("errorClave").style.borderColor = "#003f68";
    fields.password = false;
  }
}

$(document).ready(function(){
  $('.button-1000').click(function(){
      $('.modal-1000').fadeIn();
      $('.modal-1000').css('display', 'flex');

  $('.modal-1000 input').keyup(function(key){
    if(key.keyCode == 13){
      let regs = document.getElementById("m-int").value;
      console.log(regs);
      $.ajax({
        url: "modelos/insert-reg.php?reg="+regs,
  
        success: function(result){
          document.getElementById("res-m").innerHTML = result;
          document.getElementById('m-int').value = "";
          $('.modal-1000').fadeOut();
          console.log(result);
        },
  
        error: function(result){
          console.log(result);
        }
      })
    }
  })
    /*  
    $.ajax({
      url: "modelos/insert-reg.php",

      success: function(result){
        console.log(result);
      },

      error: function(result){
        console.log(result);
      }
    })*/
  })
  
  if(document.getElementById("recordar-checkbox").checked == true){
    $('.recordar-div').fadeOut(0);
  }else{
    $('.recordar-div').animate({opacity: 0.7}, 700);
  }

  $('.cont-op1').click(function(){
    document.getElementById("recordar-checkbox").checked = true
    $('.recordar-div').fadeOut(0);
  });

  $('#closeC').click(function(){
    $('.recordar-div').fadeOut(0);
  })
})