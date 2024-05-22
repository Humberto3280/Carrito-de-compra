<?php
  // Definición de las estructuras
  $nombreLancesDe = 0;      // Número de lanzamientos
  $listeSerialisee = '';      // Cadena de serialización de la cookie
  $listeLancesDe = array();    // Tabla de valores de los lanzamientos
 
  // Comprobación de la existencia de la variable
  if(!empty($_COOKIE['lancesDe']))
  {
    // Recuperar el valor de la cookie en la variable $listeLancesDe para la desealización
    $listaSerializada= $_COOKIE['lanzamientos'];
    $listaDeLanzamientos= unserialize($listaSerializada);
  }
 
  // Almacenamos cada lanzamiento
  $listaDeLanzamientos[] = rand(1,6);
  // Serializar de nuevo el array
  $listaSerializada= serialize($listaDeLanzamientos);
  setcookie('lanzamientos', $listaSerializada, time()+3600*24);
  // Calcular el número de lanzamientos
  $numeroDeLanzamientos= count($listaDeLanzamientos);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>
        Has lanzado el dado <?php echo $nombreLancesDe; ?> veces con los siguientes resultados :
    </p>
    <?php
  if($numeroDeLanzamientos> 0)
  {
    echo '<ul>';
    // Recoerremos el array de lanzamientos
    foreach($listaDeLanzamientos as $numeroDeLanzamientos => $valor)
    {
      echo '<li>Lanzamiento n#', ($numeroDeLanzamientos+1) ,' : ', $valor,'</li>';
    }
    echo '</ul>';
  }
?>

</body>

</html>