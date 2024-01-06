<?php
$id = $_GET['id'];
if(isset($_GET['accion'])){
    if ($_GET['accion'] == 'eliminar'){
        $sql = "DELETE FROM equipos WHERE id = $id";
        $sql = mysqli_query($con, $sql);
        if (!mysqli_error($con)) { 
            echo "<script> alert('Equipo eliminado con éxito');</script>";
        }else{
            echo "<script> alert('ERROR, no se pudo eliminar');</script>";
        } 
    }
    echo "<script>window.location='index.php?modulo=listado-equipos';</script>";
}
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-6 offset-sm-3">
                <div class="alert alert-danger text-center">
                    <p>¿Desea confirmar la eliminacion del registro?</p>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <form action="index.php?modulo=eliminar-equipo&accion=eliminar&id=<?php echo $id ?>" method="POST">
                            <input type="hidden" name="accion" value="eliminar_registro">
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                            <input type="submit" name="" value="Eliminar" class=" btn btn-danger">
                            <a href="index.php?modulo=listado-equipos" class="btn btn-success">Cancelar</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>