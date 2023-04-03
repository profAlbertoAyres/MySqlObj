<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Paciente</title>
</head>

<body>
    <header>
        <nav class="navbar bg-dark navbar-expand-lg" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Clinica IFRO</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pacientes.php">Paciente</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Médico</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">Consultas</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container mt-3">
            <?php
            spl_autoload_register(function ($class) {
                require_once "./Classes/{$class}.class.php";
            });
            if (filter_has_var(INPUT_GET, 'id')) {
                $paciente = new Paciente();
                $id = filter_input(INPUT_GET, 'id');
                $pacEdit = $paciente->buscar('idPac', $id);
            }
            if (filter_has_var(INPUT_GET, 'idDel')) {
                $paciente = new Paciente();
                $id = filter_input(INPUT_GET, 'idDel');
                $paciente->deletar('idPac', $id);
            ?>
                <script>
                    window.location.href = 'pacientes.php';
                </script>
            <?php
            }
            if (filter_has_var(INPUT_POST, 'btnGravar')) {
                if (isset($_FILES['filFoto'])) {
                    $ext = strtolower(pathinfo($_FILES['filFoto']['name'], PATHINFO_EXTENSION));
                    $nomeArq = filter_input(INPUT_POST, 'nomeAntigo');
                    if (empty($nomeArq)) {
                        $nomeArq = md5(date("Y.m.d-H.i.s")) . $ext;
                    }
                    $local = "imagesPac/";
                    move_uploaded_file($_FILES['filFoto']['tmp_name'], $local . $nomeArq);
                }
                $paciente = new Paciente();
                $id = filter_input(INPUT_POST, 'txtCodigo');
                $paciente->setIdPac($id);
                $paciente->setNomePac(filter_input(INPUT_POST, 'txtNome'));
                $paciente->setEnderecoPac(filter_input(INPUT_POST, 'txtEndereco'));
                $paciente->setBairroPac(filter_input(INPUT_POST, 'txtBairro'));
                $paciente->setCidadePac(filter_input(INPUT_POST, 'txtCidade'));
                $paciente->setEstadoPac(filter_input(INPUT_POST, 'sltEstado'));
                $paciente->setCepPac(filter_input(INPUT_POST, 'txtCep'));
                $paciente->setNascimentoPac(filter_input(INPUT_POST, 'txtNascimento'));
                $paciente->setEmailPac(filter_input(INPUT_POST, 'txtEmail'));
                $paciente->setCelularPac(filter_input(INPUT_POST, 'txtCelular'));
                $paciente->setFotoPac($nomeArq);

                if (empty($id)) {
                    $paciente->inserir();
                } else {
                    $paciente->atualizar('idPac', $id);
                }
            }

            ?>
            <form class="row g-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="txtCodigo" value="<?php echo isset($pacEdit->idPac) ? $pacEdit->idPac : null; ?>">
                <div class="col-12">
                    <label for="txtNome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="txtNome" placeholder="Digite seu nome..." name="txtNome" value="<?php echo isset($pacEdit->nomePac) ? $pacEdit->nomePac : null; ?>">
                </div>
                <div class="col-12">
                    <label for="txtEndereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="txtEndereco" placeholder="Digite seu endereço..." name="txtEndereco" value="<?php echo isset($pacEdit->enderecoPac) ? $pacEdit->enderecoPac : null; ?>">
                </div>
                <div class="col-12">
                    <label for="txtBairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control" id="txtBairro" placeholder="Digite seu bairro..." name="txtBairro" value="<?php echo isset($pacEdit->bairroPac) ? $pacEdit->bairroPac : null; ?>">
                </div>
                <div class="col-md-6">
                    <label for="txtCidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control" id="txtCidade" placeholder="Digite sua cidade..." name="txtCidade" value="<?php echo isset($pacEdit->cidadePac) ? $pacEdit->cidadePac : null; ?>">
                </div>
                <div class="col-md-4">
                    <label for="sltEstado" class="form-label">Estado</label>
                    <select id="sltEstado" class="form-select" name="sltEstado">
                        <?php $estSel = isset($pacEdit->estadoPac) ? $pacEdit->estadoPac : null; ?>
                        <option value="" selected hidden>Escolha...</option>
                        <option value="AC" <?php if ($estSel === "AC") {
                                                echo 'selected';
                                            } ?>>Acre</option>
                        <option value="AL" <?php if ($estSel === "AL") {
                                                echo 'selected';
                                            } ?>>Alagoas</option>
                        <option value="AP" <?php if ($estSel === "AP") {
                                                echo 'selected';
                                            } ?>>Amapá</option>
                        <option value="AM" <?php if ($estSel === "AM") {
                                                echo 'selected';
                                            } ?>>Amazonas</option>
                        <option value="BA" <?php if ($estSel === "BA") {
                                                echo 'selected';
                                            } ?>>Bahia</option>
                        <option value="CE" <?php if ($estSel === "CE") {
                                                echo 'selected';
                                            } ?>>Ceará</option>
                        <option value="DF" <?php if ($estSel === "DF") {
                                                echo 'selected';
                                            } ?>>Distrito Federal</option>
                        <option value="ES" <?php if ($estSel === "ES") {
                                                echo 'selected';
                                            } ?>>Espírito Santo</option>
                        <option value="GO" <?php if ($estSel === "GO") {
                                                echo 'selected';
                                            } ?>>Goiás</option>
                        <option value="MA" <?php if ($estSel === "MA") {
                                                echo 'selected';
                                            } ?>>Maranhão</option>
                        <option value="MT" <?php if ($estSel === "MT") {
                                                echo 'selected';
                                            } ?>>Mato Grosso</option>
                        <option value="MS" <?php if ($estSel === "MS") {
                                                echo 'selected';
                                            } ?>>Mato Grosso do Sul</option>
                        <option value="MG" <?php if ($estSel === "MG") {
                                                echo 'selected';
                                            } ?>>Minas Gerais</option>
                        <option value="PA" <?php if ($estSel === "PA") {
                                                echo 'selected';
                                            } ?>>Pará</option>
                        <option value="PB" <?php if ($estSel === "PB") {
                                                echo 'selected';
                                            } ?>>Paraíba</option>
                        <option value="PR" <?php if ($estSel === "PR") {
                                                echo 'selected';
                                            } ?>>Paraná</option>
                        <option value="PE" <?php if ($estSel === "PE") {
                                                echo 'selected';
                                            } ?>>Pernambuco</option>
                        <option value="PI" <?php if ($estSel === "PI") {
                                                echo 'selected';
                                            } ?>>Piauí</option>
                        <option value="RJ" <?php if ($estSel === "RJ") {
                                                echo 'selected';
                                            } ?>>Rio de Janeiro</option>
                        <option value="RN" <?php if ($estSel === "RN") {
                                                echo 'selected';
                                            } ?>>Rio Grande do Norte</option>
                        <option value="RS" <?php if ($estSel === "RS") {
                                                echo 'selected';
                                            } ?>>Rio Grande do Sul</option>
                        <option value="RO" <?php if ($estSel === "RO") {
                                                echo 'selected';
                                            } ?>>Rondônia</option>
                        <option value="RR" <?php if ($estSel === "RR") {
                                                echo 'selected';
                                            } ?>>Roraima</option>
                        <option value="SC" <?php if ($estSel === "SC") {
                                                echo 'selected';
                                            } ?>>Santa Catarina</option>
                        <option value="SP" <?php if ($estSel === "SP") {
                                                echo 'selected';
                                            } ?>>São Paulo</option>
                        <option value="SE" <?php if ($estSel === "SE") {
                                                echo 'selected';
                                            } ?>>Sergipe</option>
                        <option value="TO" <?php if ($estSel === "TO") {
                                                echo 'selected';
                                            } ?>>Tocantins</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="txtCep" class="form-label">Cep</label>
                    <input type="text" class="form-control" id="txtCep" name="txtCep" value="<?php echo isset($pacEdit->cepPac) ? $pacEdit->cepPac : null; ?>">
                </div>
                <div class="col-12">
                    <label for="txtEmail" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="txtEmail" placeholder="Digite seu email..." name="txtEmail" value="<?php echo isset($pacEdit->emailPac) ? $pacEdit->emailPac : null; ?>">
                </div>
                <div class="col-md-6">
                    <label for="txtNascimento" class="form-label">Nascimento</label>
                    <input type="date" class="form-control" id="txtNascimento" name="txtNascimento" value="<?php echo isset($pacEdit->nascimentoPac) ? $pacEdit->nascimentoPac : null; ?>">
                </div>
                <div class="col-md-6">
                    <label for="txtCelular" class="form-label">Celular</label>
                    <input type="text" class="form-control" id="txtCelular" name="txtCelular" value="<?php echo isset($pacEdit->celularPac) ? $pacEdit->celularPac : null; ?>">
                </div>
                <div class="col-12">
                    <input type="hidden" name="nomeAntigo" value="<?php echo isset($pacEdit->fotoPac) ? $pacEdit->fotoPac : null; ?>">
                    <label for="filFoto" class="form-label">Adicione sua Foto</label>
                    <input class="form-control" type="file" id="filFoto" name="filFoto" accept="image/*">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" name="btnGravar">Gravar</button>
                </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>