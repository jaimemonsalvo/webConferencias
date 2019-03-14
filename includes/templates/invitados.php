        
    <?php
      
      
      try {
          require_once('includes/funciones/bd_conexion.php'); //--Paso 1--esto nos permite hacer una conexion a nuestra base de datos
          
          $sql=" SELECT * FROM `invitados` "; 
          
          
          $resultado= $conn->query($sql);//---Paso 3---, (con query, realizar la consulta)--resultado es la variable que hace la consulta a la base de datos $sql.
          
      } catch(Exception $e) {
          echo $e->getMessage();
          
      }  
      
   
      ?>
      
      
       
         
          
          <section class="invitados contenedor seccion">
      <h2>Nuestros Invitados</h2>
      
      <ul class="lista-invitados clearfix">
          
                 

          <?php while ($invitados = $resultado->fetch_assoc() ) {  ?> 
          
          <li>
              <div class="invitado">
                 <a class="invitado_info" href="#invitado<?php  echo $invitados['invitado_id'];  ?>">
                      <img src="img/<?php echo $invitados['url_imagen']  ?>" alt="imagen invitado">
                      <p><?php echo $invitados['nombre_invitado']." ".$invitados['apellido_invitado'] ?></p>
                  </a>
              </div>
          </li>
    <div style="display:none;">
      
       <div class="invitado_info" id="invitado<?php  echo $invitados['invitado_id'];  ?>">
           <h2><?php $invitados['nombre_invitado']." ".$invitados['apellido_invitado']     ?></h2>
            <img src="img/<?php echo $invitados['url_imagen']  ?>" alt="imagen invitado">
            <p><?php  echo $invitados['descripcion']    ?></p>
       </div>
        
        
    </div>
            
         <?php } //cierra el while de fetch_assoc() ?>
         
         </ul>
      </section>
           
           
           <?php 
              $conn->close();//---Paso 5---cerrando la conexion a la base de datos
              
              ?>