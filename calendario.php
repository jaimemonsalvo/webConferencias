<?php include_once 'includes/templates/header.php';?>
  

  
  
  <section class="seccion contenedor">
     
      <h2>Calendario de Eventos</h2>      
       
      
          
    <?php
      
      
      try {
          require_once('includes/funciones/bd_conexion.php'); //--Paso 1--esto nos permite hacer una conexion a nuestra base de datos
          
          $sql=" SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento,icono, nombre_invitado, apellido_invitado   "; //(codigo sql)--Paso 2--Escribir la consulta que deseas hacer,aqui se relacionan las 3 tablas (evento_id, nombre_evento, fecha_evento, hora_evento,son de la tabla EVENTO), (cat_evento es de la tabla, categoria_evento) y (nombre_invitado, apellido_invitado, es de la tabla INVITADOS)
          $sql .= " FROM eventos ";
          $sql .= " INNER JOIN categoria_evento ";// voy a unir la tabla evento con categoria_evento
          $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";// que dato va a ser igual en ambas tablas
          $sql .= " INNER JOIN invitados ";// voy a unir la tabla evento con invitados
          $sql .= " ON eventos.id_inv = invitados.invitado_id ";
          $sql .= " ORDER BY evento_id ";
          
          
          $resultado= $conn->query($sql);//---Paso 3---, (con query, realizar la consulta)--resultado es la variable que hace la consulta a la base de datos $sql.
          
      } catch(Exception $e) {
          echo $e->getMessage();
          
      }  
      
   
      ?>
      
      
          
      <div class="calendario clearfix">
         
          <?php
         //Aqui en el div.calendario es donde se va a imprimir la consulta ---Paso 4---fetch_assoc --> funcion que imprime los resultados para imprimir todos los resultados de la base de datos se debe utilizar un while
          
                  $calendario = array();

          while ($eventos = $resultado->fetch_assoc() ) {  
          //hacien un arreglo para organizar los eventos por fechas.
              
              $fecha = $eventos['fecha_evento'];
              
              $evento = array (
              'titulo' => $eventos['nombre_evento'],
              'fecha' =>  $eventos['fecha_evento'],
              'hora' =>   $eventos['hora_evento'],
              'categoria' =>  $eventos['cat_evento'], 
              'icono' =>  $eventos['icono'], 
              'invitado' =>  $eventos['nombre_invitado']. " ". $eventos['apellido_invitado']
              );
              
              $calendario[$fecha][] = $evento;
          
          ?>
             
              
         <?php } //cierra el while de fetch_assoc() ?>
         
         <?php //IMPRIME TODOS LOS EVENTOS
          
          foreach($calendario as $dia => $lista_eventos)  { ?>
          
          <h3> 
          
           <i class="fa fa-calendar-alt"></i>
           
          
           <?php // otra forma -- echo date("F j, Y", strtotime($dia)) ; --
                                                           
              setlocale(LC_TIME, 'spanish');
                                                           
               echo utf8_encode(strftime("%A, %d de %B del %Y", strtotime($dia)));   ?>
          
          </h3>
          
          
          <?Php foreach($lista_eventos as $evento) { ?>
          
          <div class="dia">
              <p class="titulo"><?php  echo $evento['titulo'];  ?></p>
              <p class="hora">
               <i class="far fa-clock" aria-hidden="true"></i>
               <?php echo $evento['fecha']. " ".  $evento['hora']; ?>
                </p>
                
                <p>
                <i class="<?php  echo $evento['icono']; ?>" aria-hidden="true"></i>
                <?php  echo $evento['categoria'];  ?></p>
                <p> 
                    <i class="fa fa-user" aria-hidden="true"> </i>
                    <?php  echo $evento['invitado']; ?> </p>
              
          </div>
          
         
          <?php } //cierra el foreach de eventos ?>

          <?php } //cierra el foreach de dias ?>
          
           
            </div><!--calendario-->
           
    
      
         
           <?php 
              $conn->close();//---Paso 5---cerrando la conexion a la base de datos
              
              ?>
          
     
      
  </section>
  
  
  
  <?php include_once 'includes/templates/footer.php';?>