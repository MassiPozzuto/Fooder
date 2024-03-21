<?php 
    require_once "../includes/config.php";
    /*
    $sqlM = "BULK INSERT memingos.cuotas FROM ../db/base.csv
                WITH(
                    FORMAT = 'CSV',
                    FIELDTERMINATOR = ',',
                    ROWTERMINATOR = '\n',
                )
            ";

    if(!mysqli_query($conn, $sqlM)){
        echo die('Error de consulta: ' . mysqli_error($conn));
    }*/
    $regs = $_GET['reg'];
    $sqlm = "INSERT INTO cuotas (cantidad, fecha_alta, propietario, contacto) SELECT * FROM cuotas LIMIT 0, $regs";

    if(!mysqli_query($conn, $sqlm)){
        echo "Hubo un error";
    }
    else{
        echo "$regs registros insertados";
    }
?>