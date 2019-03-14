<?php

if (!isset($_POST['submit'])) {
    exit("Hubo un Error!!!");
  
}


use PayPal\Api\Payer; /**importando la libreria de payer */
use PayPal\Api\Item; /**importando la libreria de Item */
use PayPal\Api\ItemList; /**importando la libreria de ItemList */
use PayPal\Api\Details; /**importando la libreria de Details */
use PayPal\Api\Amount; /**importando la libreria de Amount */
use PayPal\Api\Transaction; /**importando la libreria de Amount */
use PayPal\Api\RedirectUrls; /**importando la libreria de RedirectUrls */
use PayPal\Api\Payment; /**importando la libreria de Payment */

require 'includes/paypal.php';


if(isset($_POST['submit'])): 
    $nombre=$_POST['nombre'];
    $apellido=$_POST['apellido'];
    $email=$_POST['email'];
    $regalo=$_POST['regalo'];
    $total=$_POST['total_pedido'];
    $fecha=date('Y-m-d H:i:s');
    //  PEDIDO
    $boletos=$_POST['boletos'];
    $numero_boletos=$boletos;

    $pedidoExtra=$_POST['pedido_extra'];
    $camisas=$_POST['pedido_extra']['camisas']['cantidad'];
    $precioCamisa=$_POST['pedido_extra']['camisas']['precio'];
    $etiquetas=$_POST['pedido_extra']['etiquetas']['cantidad'];
    $precioEtiquetas=$_POST['pedido_extra']['etiquetas']['precio'];
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
          $ID_registro=$stmt->insert_id; /**el id se inserta en stmt ID_registro en la base d e datos */
          $stmt->close();
          $conn->close();
      /* header('Location: validar_registro.php?exitoso=1');*/
      } catch(Exception $e) {
          echo $e->getMessage();
         }  
    
  
        endif;


$compra= new Payer();
$compra->setPaymentMethod('paypal');


$articulo =new Item();
$articulo->setName($producto)
         ->setCurrency('USD')
         ->setQuantity(1)
         ->setPrice($precio);

$i=0;
$arreglo_pedido=array();
foreach ($numero_boletos as $key => $value) {
    if ((int) $value['cantidad']>0) {
        ${"articulo$i"}= new Item();
        $arreglo_pedido[]= ${"articulo$i"};
        ${"articulo$i"} ->setName('Pase:' .  $key)
                         ->setCurrency('USD')
                         ->setQuantity( (int) $value['cantidad'] )
                         ->setPrice( (int) $value['precio'] );
        $i++;
       
    }

   
}
 
foreach ($pedidoExtra as $key => $value) {
    if ((int) $value['cantidad']>0) {
        
        if ($key == 'camisas') {
                $precio =(float)$value['precio'] * .93;
        } else {
            $precio =(float)$value['precio'];
        }
        
        
        ${"articulo$i"}= new Item();
        $arreglo_pedido[]= ${"articulo$i"};
        ${"articulo$i"} ->setName('Extras:' .  $key)
                         ->setCurrency('USD')
                         ->setQuantity( (int) $value['cantidad'] )
                         ->setPrice( $precio );
        $i++;
       
    }
}
$envio=0;
$detalles= new details();
$detalles->setShipping($envio)
        ->setSubtotal($precio);

     

$listaArticulos=new ItemList();
$listaArticulos->setItems($arreglo_pedido);  // articulo2..))

 

$cantidad = new Amount();
$cantidad->setCurrency('USD')
                 ->setTotal($total);
                


$transaccion = new Transaction();         
$transaccion->setAmount($cantidad)
            ->setItemList($listaArticulos)
            ->setDescription('Pago GDLWEBCAMP ')
            ->setInvoiceNumber( $ID_registro); 
                            
$redireccionar = new RedirectUrls();   
$redireccionar->setReturnUrl(URL_SITIO . "/pago_finalizado.php?&id_pago={$ID_registro}") 
              ->setCancelUrl(URL_SITIO . "/pago_finalizado.php?&id_pago={$ID_registro}");

$pago = new Payment();
$pago ->setIntent("sale")
      ->setPayer($compra)
      ->setRedirectUrls($redireccionar)
      ->setTransactions(array($transaccion));

 try {
          $pago->create($apiContext);

      } catch (PayPal\Exception\PayPalConnectionException $pce) {
          echo "<pre>";
          print_r(json_decode($pce->getData()));
          exit;
          echo "</pre>";
      }
      
$aprobado = $pago->getApprovalLink();
header("Location: {$aprobado}");   



                        
/* 
$detalles= new details();
$detalles->setShipping($envio)
        ->setSubtotal($precio); 
lo utilizan para fletes y subtotatles en este ejercicio no lo vamos a tener e cuenta
*/


