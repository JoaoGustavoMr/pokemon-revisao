<?php

include('../php/conexao.php');

$sql = "SELECT pokemon_nome, pokemon_tipo, pokemon_localizacao, pokemon_dataRegistro, pokemon_hp, pokemon_ataque, pokemon_defesa, pokemon_obs, pokemon_foto FROM pokemon";
$result = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <script src="../js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Pokédex</title>
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
    <h1>Bem-vindo à Pokédex</h1>

    <div class="container-busca">
        <input type="text" id="buscaPokemon" placeholder="Digite o nome do Pokémon...">
        <button onclick="buscarPokemon()">🔍</button>
    </div>

    <div id="resultado"></div>
    <section id="cardsContainer" class="cards-container">
    <?php 
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // converte o BLOB para base64
            $fotoBase64 = base64_encode($row['pokemon_foto']);
            ?>
            <div class="card">
                <img src="data:image/jpeg;base64,<?= $fotoBase64 ?>" alt="Foto do <?= htmlspecialchars($row['pokemon_nome']) ?>">
                <div class="card-body">
                    <h3><?= htmlspecialchars($row['pokemon_nome']) ?></h3>
                    <p class='carac'><strong>Tipo:</strong> <?= htmlspecialchars($row['pokemon_tipo']) ?></p>
                    <p class='carac'><strong>Localização:</strong> <?= htmlspecialchars($row['pokemon_localizacao']) ?></p>
                    <p class='carac'><strong>Registrado em:</strong> <?= htmlspecialchars($row['pokemon_dataRegistro']) ?></p>
                    <div class="stats">
                        <span class="stat">HP: <?= (int)$row['pokemon_hp'] ?></span>
                        <span class="stat">Ataque: <?= (int)$row['pokemon_ataque'] ?></span>
                        <span class="stat">Defesa: <?= (int)$row['pokemon_defesa'] ?></span>
                    </div>
                    <p class="observacao"><?= nl2br(htmlspecialchars($row['pokemon_obs'])) ?></p>
                </div>
                <div class="card-footer">
                    <button class="btn-editar" onclick="editarPokemon(<?= $row['pokemon_id'] ?>)">Editar</button>
                    <button class="btn-excluir" onclick="excluirPokemon(<?= $row['pokemon_id'] ?>)">Excluir</button>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p>Nenhum Pokémon cadastrado.</p>";
            }
            $conexao->close();
            ?>
        </section>
    </main>
    <footer>
    </footer>
</body>
</html>