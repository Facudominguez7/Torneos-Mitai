<?php
function conectar()
{
    global $con;
    $con= mysqli_connect("localhost","c2480763_mitai","ZOrukewe61","c2480763_mitai");
    /*comprobar conexion*/

    if (mysqli_connect_errno())
    {
        print ("fallo la conexion : %s\n". mysqli_connect_error());
    }
    else
    {
        $con -> set_charset("utf8");
        $ret=true;
    }
    return $ret;

}
function desconectar()
{
    global $con;
    mysqli_close($con);

}
?>
