<?php

//en este php se cambiaran todos los id mayores al id eliminado

    include("conexion_bd.php");


    function modificarIds($id){
        $conexion=conectar();

        if($conexion){

            $consulta="select idproducto from producto";
		    $resultado=mysqli_query($conexion,$consulta);
		        
		        if($consulta){
        			while($fila = mysqli_fetch_array($resultado)){
        			    $results=$fila['idproducto'];

                        $encontrado = $results;

                        if($encontrado>$id){
                            $encontrado = $encontrado-1;
                        }

                        $consulta2="update producto set idproducto= '{$encontrado}' where idproducto= '{$results}'";
            
                        $resultado2 = mysqli_query($conexion,$consulta);

                        if($consulta2){
                            echo "todo correcto";
                        }
                        
        			}
        			
		        }else{

		            echo "algo fallo en la consulta";

		        }
                            
        }

    }    

?>
