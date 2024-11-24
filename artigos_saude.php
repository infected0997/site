<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artigos de Saúde</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Artigos sobre Saúde</h1>
    
    <article>
        <h2>Importância da Atividade Física</h2>
        <p>Manter uma rotina de exercícios físicos é essencial para a saúde do coração e para o bem-estar mental. Estudos mostram que 30 minutos de exercícios diários podem reduzir significativamente o risco de doenças cardiovasculares.</p>
        <a href="#">Leia mais...</a>
    </article>
    
    <article>
        <h2>Cuidados com a Alimentação</h2>
        <p>Uma alimentação balanceada é a chave para uma vida saudável. Evitar o excesso de açúcares e gorduras, e priorizar alimentos ricos em fibras e vitaminas pode melhorar a sua qualidade de vida.</p>
        <a href="#">Leia mais...</a>
    </article>
    
    <article>
        <h2>Saúde Mental</h2>
        <p>A saúde mental é tão importante quanto a saúde física. Encontre formas de lidar com o estresse e priorize momentos de relaxamento para manter o equilíbrio emocional.</p>
        <a href="#">Leia mais...</a>
    </article>
    
    <p><a href="perfil.php">Voltar ao Perfil</a></p>
</body>
</html>
