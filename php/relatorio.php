<?php

include('../php/conexao.php');

// Lista fixa de tipos de Pokémon
$tipos = [
    "Normal", "Fogo", "Água", "Elétrico", "Grama", "Gelo", "Lutador", "Venenoso", 
    "Terrestre", "Voador", "Psíquico", "Inseto", "Pedra", "Fantasma", 
    "Dragão", "Sombrio", "Metálico", "Fada"
];

// Consulta para pegar a quantidade de pokémons por tipo
$sqlRelatorio = "SELECT pokemon_tipo, COUNT(*) as quantidade FROM pokemon GROUP BY pokemon_tipo";
$resultRelatorio = $conexao->query($sqlRelatorio);

// Monta um array associativo [tipo => quantidade]
$quantidades = array_fill_keys($tipos, 0);
if ($resultRelatorio->num_rows > 0) {
    while($row = $resultRelatorio->fetch_assoc()) {
        $tipo = $row['pokemon_tipo'];
        if (isset($quantidades[$tipo])) {
            $quantidades[$tipo] = $row['quantidade'];
        }
    }
}

// Consulta principal - Lista os pokemons
$sql = "SELECT pokemon_id, pokemon_nome, pokemon_tipo, pokemon_localizacao, pokemon_dataRegistro, pokemon_hp, pokemon_ataque, pokemon_defesa, pokemon_obs, pokemon_foto FROM pokemon";
$result = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/relatorio.css">
    <title>Pokédex - Relatório</title>
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
        <h1>Relatório de Pokémon por Tipo</h1>

        <!-- Relatório em formato de tabela -->
        <div class="relatorio-tabela">
            <table>
                <thead>
                    <tr>
                        <th>Tipo do Pokémon</th>
                        <th>Quantidade Encontrada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $totalGeral = 0;
                    foreach ($quantidades as $tipo => $qtd) {
                        $totalGeral += $qtd;
                        echo "<tr>
                                <td>".htmlspecialchars($tipo)."</td>
                                <td>$qtd</td>
                              </tr>";
                    }
                    ?>
                    <tr class="total">
                        <td><strong>Total</strong></td>
                        <td><strong><?= $totalGeral ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main> 
</body>
</html>
