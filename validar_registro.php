
    <!--validando que se envio el documento con isset , y submit -->
  <?php if(isset($_POST['submit'])): 
    $nombre=$_POST['nombre'];
    $apellido=$_POST['apellido'];
    $email=$_POST['email'];
    $regalo=$_POST['regalo'];
    $total=$_POST['total_pedido'];
    $fecha=date('Y-m-d H:i:s');
    //  PEDIDO
    $boletos=$_POST['boletos'];
    $camisas=$_POST['pedido_camisas'];
    $etiquetas=$_POST['pedido_etiquetas'];
    /*hay  que mandar a llamar ese archivo, donde estan alamacenadas las funciones*/
    include_once 'includes/funciones/funciones.php';
    $pedido= productos_json($boletos, $camisas, $etiquetas);
    /*eventos*/
    $eventos=$_POST['registro'];
    /*se crea una funcion a la que se le pasara los datos del registro */
    $registro=eventos_json($eventos);
    /*Utilizando Prepared Statements para insertar datos a la Base de Datos*/
    try {
          require_once('includes/funciones/bd_conexion.php');
          $stmt= $conn->prepare("INSERT INTO registrados (nombre_registrado, apellido_registrado,email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado) VALUES (?,?,?,?,?,?,?,?)");
          $stmt->bind_param("ssssssis",$nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);
          $stmt->execute();
          $stmt->close();
          $conn->close();
        header('Location: validar_registro.php?exitoso=1');
      } catch(Exception $e) {
          echo $e->getMessage();
         }  
      

         endif;  
         ?>
    
    
    
<?php include_once 'includes/templates/header.php';?>


<section class="seccion contenedor">

    <h2>Resumen Registro </h2>

<?php  if(isset($_GET['exitoso'])) :
    
    if ($_GET['exitoso']=="1"):
        echo "Registro Exitoso";
    endif;
    endif;
    
    
    ?>

  
</section>
 
 
  <?php include_once 'includes/templates/footer.php';?>
