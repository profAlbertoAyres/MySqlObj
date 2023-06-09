<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/layout.css">
    <title>Pacientes</title>
</head>

<body>
    <header>
        <?php include '_part/_menu.php'?>
    </header>
    <main class="mt-3">
        <div class="container mt-3">
            <div class="d-flex flex-row-reverse">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="txtPesquisar" placeholder="Pesquisar" name="txtPesquisar">
                            <label for="pesquisar">Pesquisar</label>
                        </div>
                        <button class="btn btn-outline-secondary" type="submit" id="btnPesquisar" name="btnPesquisar">
                            <span class="material-symbols-outlined">
                                search
                            </span>
                        </button>
                    </div>
                </form>
            </div>
            <table class="table mt-3">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Açoẽs</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Nome</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Celular</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    spl_autoload_register(function ($class) {
                        require_once "./Classes/{$class}.class.php";
                    });
                    $paciente = new Paciente();
                    if (filter_has_var(INPUT_POST, 'txtPesquisar')) {
                        $parametro = filter_input(INPUT_POST, 'txtPesquisar');
                        $where = "where (nomePac like '%$parametro%' ) or (emailPac like '%$parametro%' )";
                        $dadosBanco =  $paciente->listar($where);
                    } else {
                        $dadosBanco =  $paciente->listar();
                    }
                    while ($row = $dadosBanco->fetch_object()) {
                    ?>
                        <tr>
                            <td class="align-middle" scope="row">
                                <a href="pacienteGer.php?id=<?php echo $row->idPac ?>" class="btn btn-secondary">
                                    <span class="material-symbols-outlined">
                                        edit_square
                                    </span>
                                </a>
                                <a href="pacienteGer.php?idDel=<?php echo $row->idPac ?>" class="btn btn-danger">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </a>
                                <form action="consulta.php" method="post" style="display: inline-block;">
                                <input type="hidden" name="pacienteCon" value="<?php echo $row->idPac ?>">
                                <button type="submit" class="btn btn-success">
                                <span class="material-symbols-outlined">
                                        description
                                    </span>
                                </button>    
                                </form>
                            </td>
                            <td class="align-middle">
                                <img src="imagesPac/<?php echo $row->fotoPac ?>" alt="Foto do paciente <?php echo $row->nomePac ?>" class="imgRed">
                            </td>
                            <td class="align-middle"><?php echo $row->nomePac ?></td>
                            <td class="align-middle"><?php echo $row->emailPac ?></td>
                            <td class="align-middle"><?php echo $row->celularPac ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="col-12">
                <a href="pacienteGer.php" class="btn btn-primary">
                    <span class="material-symbols-outlined">
                        note_add
                    </span> Novo Paciente

                </a>
            </div>
        </div>
    </main>

</body>

</html>