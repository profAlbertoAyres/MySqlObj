<?php
spl_autoload_register(function ($class) {
    require_once "./Classes/{$class}.class.php";
});
if (filter_has_var(INPUT_POST, 'pacienteCon')) {
    $idPac = filter_input(INPUT_POST, 'pacienteCon');
} else {
?>
    <script>
        alert("Nenhum paciente selecionado");
        window.location.href = "pacientes.php"
    </script>
<?php

}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/layout.css">
    <title>Consultas de </title>
</head>

<body>
    <header>
        <?php include '_part/_menu.php'?>
    </header>
    <main class="mt-3">
        <div class="container mt-3">
            <div class="d-flex flex-row-reverse">
                <a href="consultaGer.php" class="btn btn-info">Nova Consulta</a>
            </div>

            <table class="table mt-3">
                <thead class="table-dark">
                    <tr>
                        <!-- <th scope="col">Açoẽs</th> -->
                        <th scope="col">Medico</th>
                        <th scope="col">Data</th>
                        <th scope="col">Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $consulta = new Consulta;
                    $where =  "where C.pacienteCon = $idPac";
                    $dadosBanco = $consulta->listar($where);
                    while ($row = $dadosBanco->fetch_object()) {
                    ?>
                        <tr>
                            <!-- <td class="align-middle" scope="row">
                                <a href="pacienteGer.php?id=<?php echo $row->idCon ?>" class="btn btn-secondary">
                                    <span class="material-symbols-outlined">
                                        edit_square
                                    </span>
                                </a>
                                <a href="#" class="btn btn-danger">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </a>
                            </td> -->
                            <td class="align-middle"><?php echo $row->nomeMed ?></td>
                            <td class="align-middle"><?php echo date('d/m/Y',strtotime($row->dataCon)) ?></td>
                            <td class="align-middle"><?php echo $row->horaCon ?></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>