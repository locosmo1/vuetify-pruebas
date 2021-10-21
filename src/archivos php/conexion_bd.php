<?PHP


function conectar(){
    
    $hostname="151.106.97.153";
    $database="u333469926_consultasvuejs";
    $username="u333469926_stiwar";
    $password="1996Born2019";
    
    $conexion=mysqli_connect($hostname,$username,$password,$database);
    
    /*if($conexion){
        echo "Conexion Exitosa ";    
    }else{
        echo "Conexion Fallida ";
    }*/
    return $conexion;
    
}

?>