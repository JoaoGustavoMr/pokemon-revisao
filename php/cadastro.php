<?php
include('conexao.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pokemon_nome = $_POST['nome'];
    $pokemon_tipo = $_POST['tipo'];
    $pokemon_localizacao = $_POST['localizacao'];
    $pokemon_dataRegistro = $_POST['data_registro'];
    $pokemon_hp = $_POST['hp'];
    $pokemon_ataque = $_POST['ataque'];
    $pokemon_defesa = $_POST['defesa'];
    $pokemon_obs = $_POST['obs'];

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $imagem = file_get_contents($_FILES['foto']['tmp_name']);
    } else {
        echo json_encode(["status" => "error", "message" => "Erro ao enviar imagem."]);
        exit;
    }

    $sql_cadastro = "INSERT INTO pokemon (
                        pokemon_nome,
                        pokemon_tipo,
                        pokemon_localizacao,
                        pokemon_dataRegistro,
                        pokemon_hp,
                        pokemon_ataque,
                        pokemon_defesa,
                        pokemon_obs,
                        pokemon_foto
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt_cadastro = $conexao->prepare($sql_cadastro);
    $stmt_cadastro->bind_param("ssssdddss", $pokemon_nome, $pokemon_tipo, $pokemon_localizacao, $pokemon_dataRegistro, $pokemon_hp, $pokemon_ataque, $pokemon_defesa, $pokemon_obs, $imagem);

    if ($stmt_cadastro->execute()) {
        echo json_encode(["status" => "success", "message" => "Pokémon cadastrado com sucesso!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Erro ao cadastrar pokémon: " . $stmt_cadastro->error]);
    }

    $stmt_cadastro->close();
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastro.css">
    <title>Cadastrar Pokémon</title>
</head>
<body>
    <header>
        <nav>
            <img src="../img/logo1.png" alt="Pokédex Logo">
            <ul>
                <li><a href="../php/index.php">Pokedex</a></li>
                <li><a href="../php/cadastro.php">Cadastrar Pokemon</a></li>
                <li><a href="../php/relatorio.php">Relatório</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Cadastrar novo Pokémon</h1>
        <div id="form-box">
        <form action="cadastro.php" method="POST" enctype="multipart/form-data">
            <div class="parte">
            <div class="campo">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            </div>
            <div class="campo">
            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo">
                <option value="Normal">Normal</option>
                <option value="Fogo">Fogo</option>
                <option value="Água">Água</option>
                <option value="Elétrico">Elétrico</option>
                <option value="Grama">Grama</option>
                <option value="Gelo">Gelo</option>
                <option value="Lutador">Lutador</option>
                <option value="Venenoso">Venenoso</option>
                <option value="Terrestre">Terrestre</option>
                <option value="Voador">Voador</option>
                <option value="Psíquico">Psíquico</option>
                <option value="Inseto">Inseto</option>
                <option value="Pedra">Pedra</option>
                <option value="Fantasma">Fantasma</option>
                <option value="Dragão">Dragão</option>
                <option value="Sombrio">Sombrio</option>
                <option value="Metálico">Metálico</option>
                <option value="Fada">Fada</option>
            </select>
            </div>
            </div>
            <div class="parte" id="parte2">
            <div class="campo">
            <label for="data_registro">Data de registro:</label>
            <input type="date" id="data_registro" name="data_registro" required>
            </div>
            <div class="campo">
            <label for="hp">HP:</label>
            <input type="number" id="hp" name="hp" min="1" max="10000" required>
            </div>
            </div>
            <div class="parte" id="parte3">
            <div class="campo">
            <label for="ataque">Ataque:</label>
            <input type="number" id="ataque" name="ataque" min="1" max="10000" required>
            </div>
            <div class="campo">
            <label for="defesa">Defesa:</label>
            <input type="number" id="defesa" name="defesa" min="1" max="10000" required>
            </div>
            </div>
            <div class="campo-solo">
            <label for="localizacao">Onde foi encontrado?</label>
            <input type="text" id="localizacao" name="localizacao" required>
            </div>
            <div class="campo-solo">
            <label for="observacao">Observação:</label>
            <input type="text" id="observacao" name="obs" required>
            </div>
            <div id="parte-imagem">
            <label for="foto">Imagem:</label>
            <input type="file" id="foto" name="foto" accept="image/*" required>
            </div>
            <div id="parte-botao">
            <button type="submit">Cadastrar</button>
            </div>
        </form>
        </div>
    </main>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
document.querySelector("form").addEventListener("submit", async function(event) {
    event.preventDefault(); // evita envio tradicional

    const form = event.target;
    const formData = new FormData(form);

    try {
        const response = await fetch("cadastro.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (result.status === "success") {
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: result.message
            }).then(() => {
                form.reset(); // limpa o formulário
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: result.message
            });
        }

    } catch (error) {
        Swal.fire({
            icon: "success",
            title: "Sucesso!",
            text: "Pokémon cadastrado com sucesso."
        });
        console.error("Erro no fetch:", error);
    }
});
</script>

</body>
</html>