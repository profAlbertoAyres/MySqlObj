<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/layout.css">
    <title>Médicos</title>
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
                        <th scope="col">Nome</th>
                        <th scope="col">CRM</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Celular</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    spl_autoload_register(function ($class) {
                        require_once "./Classes/{$class}.class.php";
                    });
                    $medico = new Medico();
                    if (filter_has_var(INPUT_POST, 'txtPesquisar')) {
                        $parametro = filter_input(INPUT_POST, 'txtPesquisar');
                        $where = "where (nomeMed like '%$parametro%' ) or (emailMed like '%$parametro%' )";
                        $dadosBanco =  $medico->listar($where);
                    } else {
                        $dadosBanco =  $medico->listar();
                    }
                    while ($row = $dadosBanco->fetch_object()) {
                    ?>
                        <tr>
                            <td class="align-middle" scope="row">
                                <a href="medicoGer.php?id=<?php echo $row->idMed ?>" class="btn btn-secondary">
                                    <span class="material-symbols-outlined">
                                        edit_square
                                    </span>
                                </a>
                                <a href="#" class="btn btn-danger">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </a>
                            </td>
                            <td class="align-middle"><?php echo $row->nomeMed ?></td>
                            <td class="align-middle"><?php echo $row->crmMed ?></td>
                            <td class="align-middle"><?php echo $row->emailMed ?></td>
                            <td class="align-middle"><?php echo $row->celularMed ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="col-12">
                <a href="medicoGer.php" class="btn btn-primary">
                    <span class="material-symbols-outlined">
                        note_add
                    </span> Novo Médico

                </a>
            </div>
        </div>
    </main>

</body>

</html>