<?php
session_start();
require_once("js/clases.php");
if (isset($_SESSION['fedex19']) ) {  //existe la session
	//echo "valida usuario";
	$recievedJwt=$_SESSION['fedex19'];
	//token valido
	$tokenValid = Tocken::validaToken($recievedJwt);

	if($tokenValid){  //el token es valido
		//datos de token
		$usuarioC = Tocken::datosToken($recievedJwt);
		$usuarioC = json_decode($usuarioC, true);
		//print_r($usuarioC);
		$existe=Usuarios::buscaUsuario($usuarioC['usuario']);

		if($existe['encontrado'] == "si"){ //el usuario es valido
		}else{
			session_destroy();
			header("Location: index.html");
			exit(0);
		}  //termina usuario

	}else{
		session_destroy();
		header("Location: index.thml");
		exit(0);
	}// termina token

}else{
	session_destroy();
	header("Location: index.html");
	exit(0);
}  //termina session

//historial de guias
$guias = Guias::todasGuias($usuarioC['usuario']);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--CSS Bootrstrap 4.3 & Arturo-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/fireworks.css">

    <!-- favion  -->
     <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-touch-icon.png">
     <link rel="icon" type="image/png" sizes="32x32" href="favion/favicon-32x32.png">
     <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
     <link rel="manifest" href="favicon/site.webmanifest">
     <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
     <meta name="msapplication-TileColor" content="#00a300">
     <meta name="theme-color" content="#ffffff">

    <title>Fedex</title>
  </head>
  <body>
    <header>
      <!--NavBar-->
      <nav class="navbar navbar-expand-lg navbar-light " id="NavFedex">
        <img src="images/logo_fedex.png" class="img-fluid" id="Img-Logo" alt="FedEx" onclick="location.href='index.html';">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active text-white" >
              <a class="nav-link text-white" href="index.html#mecanica">Mecánica <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="index.html#registro">Registro</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="index.html#premios">Premios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="index.html#ganadores">Ganadores</a>
            </li>
          </ul>
          <span class="navbar-text"><a href="#" class="text-white">Mi Cuenta</a></span>
          <img src="images/Icon-cuenta.png" class="img-fluid" id="icon-cuenta" alt="Cuenta">
        </div>
      </nav>
    </header>
    <main>
      <div class="container-fluid MiCuenta">
        <div class="container">
          <div class="row">
              <div class="col-12">
                <h6>Mi cuenta</h6>
              </div>
          </div>
          <div class="row">
            <div class="col-12">
              <p class="text">Tabla de resultados</p>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <!--Tabla de resultados-->
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Numero de guía</th>
                    <th scope="col">Fecha de participación</th>
                    <th scope="col">Tu Tiempo</th>
                    <th scope="col">Numero de cajas</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (COUNT($guias)>0) {
                    for ($i=0; $i < COUNT($guias); $i++) {
                      $guia = $guias[$i][2];
                      $calculo = $guias[$i][3];
                      $fecha = $guias[$i][5];
                      $tiempo = $guias[$i][6];

                      echo '
                      <tr>
                      <td>'.$guia.'</td>
                      <td>'.$fecha.'</td>
                      <td>'.$tiempo.'</td>
                      <td>'.$calculo.'</td>
                      </tr>
                      ';
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-6">
              <!--Botón de Volver a jugar-->
              <button class="btn-large" type="button" name="button" onclick="location.href='Calcula&Gana.php';">Volver a jugar</button>
            </div>
            <div class="col-12 col-md-6">
              <!--Botón Salir de Mi Cuenta -->
              <button class="btn-large" type="button" name="button" onclick="location.href='cerrar_sesion.php';">Salir de Mi Cuenta</button>
            </div>
          </div>
        </div>
      </div>
    </main>
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-3 center linea">
            <h4><a href="PDF/TC-FedEx.pdf" target="_blank">Términos y Condiciones de uso</a></h4>
          </div>
          <div class="col-12 col-md-3 center linea">
            <h4><a href="PDF/AvisoPrivacidad.pdf" target="_blank">Aviso de Privacidad</a></h4>
          </div>
          <div class="col-12 col-md-3 center linea">
            <h4><a href="https://www.fedex.com/es-mx/privacy-policy.html" target="_blank">Declaración de Privacidad</a></h4>
          </div>
          <div class="col-12 col-md-3 center linea">
            <h4><a href="PDF/FAQs.pdf" target="_blank">FAQs</a></h4>
          </div>
        </div>
        <div class="row">
          <div class="col-12 center">
            <p class="textFooter">TVP. Este sitio utiliza cookies para ayudarnos a mejorar tu experiencia cada vez que lo visites. Al continuar navegando en el, estarás aceptando su uso. Podrás deshabilitarlas accediendo a la configuración de tu navegador.</p>
          </div>
        </div>
      </div>
    </footer>


    <!-- Scripts Bootstrap 4.3, AOS Library & Arturo -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script src="js/aos.js"></script>
    <script>
      AOS.init({
        easing: 'ease-in-out-sine'
      });
    </script>

    <!--Script para cambiar la seccion de formulario-->
    <script type="text/javascript" src="js/fedex.js"></script>
  </body>
</html>
