<?PHP
include("conexion_bd.php");
$json=array();
		
		$conexion=conectar();
		
		if($conexion){
		    
		        
		        $consulta="select urlImagen,nombre,precio from producto";
		        $resultado=mysqli_query($conexion,$consulta);
		        
		        if($consulta){
        			while($fila = mysqli_fetch_array($resultado)){
        			    $results["urlImagen"]=$fila['urlImagen'];
			            $results["nombre"]=$fila['nombre'];
			            $results["precio"]=$fila['precio'];
			            $json['datos'][]=$results;
        			}
        			echo json_encode($json);
        			
		        }else{
		            
		        }
		        
		}else{
		    echo json_encode('conexion incorrecta');
		}
		
?>