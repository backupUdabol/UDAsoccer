<?php
include('conexionBD.php');

//Activar las Sesiones en PHP
session_start();

//LOGIN solo cuentas 'ACTIVAS'
$estado_cuenta = 'activa';

$nombre = $_POST['nombre'];
$fecha_registro = date("Y").'-'.date("m").'-'.date("d");

include('equipo_puntos_acumulados.php');


$nombre_tabla = 'equipo';
$query_usuario_insert = "INSERT INTO ".$nombre_tabla."(nombre, pts_acumulados, total_goles, fecha_registro)
VALUES (:nombre, :pts_acumulados, :total_goles, :fecha_registro) ";

try {

    /* Ejecutar una sentencia preparada proporcionando un array de valores de inserción */
    $agenteSQL = $conexionAlServidorBD->prepare($query_usuario_insert);

    //Retorna TRUE si todo fue bien, y FALSE en caso contrario (booleano)
    $okInsercion = $agenteSQL->execute(
                            array(
                                  ':nombre' => $nombre,
                                  ':paterno' => $paterno,
                                  ':materno' => $materno,
                                  ':ci' => $ci,
                                  ':semestre' => $semestre,
                                  ':carrera' => $carrera,
                                  ':fecha_nacimiento' => $fecha_nacimiento
                                ));


    if ($okInsercion) {
      // Inicializar una variable de SESION con valores
      $_SESSION['nombre']= $nombre;
      $_SESSION['paterno']= $paterno;
      $_SESSION['materno']= $materno;
      $_SESSION['ci']= $ci;
      $_SESSION['semestre']= $semestre;
      $_SESSION['carrera']= $carrera;
      $_SESSION['fecha_nacimiento']= $fecha_nacimiento;

       header("Location: lista_jugadores.php");
    } else {
       $_SESSION['mensaje_login'] = 'Fallo el registro del usuario. Intente registrarse nuevamente';
       header("Location: index.php");
    }

    $resultadoSQL = null;

}
catch (PDOException $e) {
    echo "¡Error!: " . $e->getMessage() . "<br/>";
    //Cerrar conexion
    $conexionAlServidorBD = null;
    die();
}
catch(Exception $e){
  echo "¡Error!: " . $e->getMessage() . "<br/>";
  //Cerrar conexion
  $conexionAlServidorBD = null;
  die();
}

//Cerrar conexion
$conexionAlServidorBD = null;
?>