<?php

include("conexion_bd.php");

$conexion=conectar();

    if($conexion){
        
        if(isset($_POST['id']) && isset($_POST['imagen']) && isset($_POST['titulo']) && isset($_POST['subtitulo']) && isset($_POST['precio']) ){
            
            $id = $_POST['id'];
            $imagen = $_POST['imagen'];
            $titulo = $_POST['titulo'];
            $subtitulo = $_POST['subtitulo'];
            $precio = $_POST['precio'];

            $consulta = "INSERT INTO producto (idproducto, urlImagen, nombre, precio) VALUES ('{$id}', '{$imagen}','{$titulo}', '{$precio}')";
		        
		    $res = mysqli_query($conexion,$consulta);
		    
		    if($consulta){

		        mysqli_close($conexion);

		    }
            
        }else{
            echo "llenar todos los campos";
        }
		    
	}else{
	    
	    echo "la conexion ah fallado";
	
	}

?>

