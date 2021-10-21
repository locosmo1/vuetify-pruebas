<?php

include("conexion_bd.php");

$conexion=conectar();

    if(!$conexion){
        
		echo "la conexion ah fallado";
		    
	}else{
	    
		if(isset($_POST['id']) && isset($_POST['url']) && isset($_POST['nombre']) && isset($_POST['precio'])){
    
            $id = $_POST['id'];
            $url = $_POST['url'];
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            
            $consulta="update producto set urlImagen= '{$url}', nombre = '{$nombre}', precio = '{$precio}' where idproducto= '{$id}'";
            
            $resultado = mysqli_query($conexion,$consulta);
                
            if($consulta){
                    
                mysqli_close($conexion);
            			
    		}else{
    		            
    		    echo "No se ah podido completar la actualizacion";
            			
    		}
            
        }else{
            
            echo "llenar todos los campos";
            
        }
	}

?>