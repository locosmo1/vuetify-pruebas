<?PHP
//consulta para consultar el autoincrement de una base de datos y una tabla en especifico
//SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'u333469926_consultasvuejs' AND TABLE_NAME = 'producto' 
//Modificar el autoincrement
//alter table producto AUTO_INCREMENT = 1
//Obtener el ultimo valor coincidente
//SELECT MAX(idproducto) ultimo FROM producto

//require_once("modificarId.php");
//require_once("conexion_bd.php");
require("conexion_bd.php");

$conexion=conectar();

$json=array();

if($conexion){

    if(isset($_POST['id'])){

        
        $id = $_POST['id'];

        $consulta="delete from producto where idproducto='{$id}'";

        $resultado = mysqli_query($conexion,$consulta);

        if($consulta){



            $consulta="select idproducto from producto";
		    $resultado=mysqli_query($conexion,$consulta);
		        
		        if($consulta){
        			while($fila = mysqli_fetch_array($resultado)){
                        
        			    $results = $fila['idproducto'];

                        $encontrado = $results;

                        if($encontrado>$id){
                            $encontrado = $encontrado-1;
                        }

                        $consulta2="update producto set idproducto= '{$encontrado}' where idproducto= '{$results}'";
            
                        $resultado2 = mysqli_query($conexion,$consulta2);

                        $json['datos'][]=$results;
                        
        			}

                    echo json_encode($json);
        			
		        }else{

		            echo "algo fallo en la consulta";

		        }


                mysqli_close($conexion);


		}

    }else{

        echo "por favor enviame datos";

    }

}

?>

