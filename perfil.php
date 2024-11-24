<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$sql_appointments = "SELECT a.id, a.appointment_date, a.symptoms, d.name AS doctor_name, d.specialty FROM appointments a JOIN doctors d ON a.doctor_id = d.id WHERE a.user_id = ?";
$stmt_appointments = $pdo->prepare($sql_appointments);
$stmt_appointments->execute([$user_id]);
$appointments = $stmt_appointments->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Bem-vindo, <?php echo $user['username']; ?>!</h1>
<p>E-mail: <?php echo $user['email']; ?></p>
<p>Telefone: <?php echo $user['phone']; ?></p>
<p>Endereço: <?php echo $user['address']; ?></p>

<h2>Links Importantes</h2>
<p><a href="artigos_saude.php">Artigos de Saúde</a></p>
<p><a href="politica_privacidade.php">Política de Privacidade</a></p>

<h2>Meus Agendamentos</h2>

<table>
    <tr>
        <th>Data e Hora</th>
        <th>Médico</th>
        <th>Especialidade</th>
        <th>Sintomas</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($appointments as $appointment): ?>
    <tr>
        <td><?php echo date('d/m/Y H:i', strtotime($appointment['appointment_date'])); ?></td>
        <td><?php echo $appointment['doctor_name']; ?></td>
        <td><?php echo $appointment['specialty']; ?></td>
        <td><?php echo htmlspecialchars($appointment['symptoms']); ?></td>
        <td>
            <a href="editar_agendamento.php?appointment_id=<?php echo $appointment['id']; ?>">Editar</a> | 
            <a href="excluir_agendamento.php?appointment_id=<?php echo $appointment['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este agendamento?')">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<p><a href="agendar.php">Agendar nova consulta</a></p>
<p><a href="alterar_senha.php">Alterar Senha</a></p>
<p><a href="logout.php">Sair</a></p>

<h2>Editar Informações</h2>

<form method="POST" action="editar_perfil.php">
    <label for="phone">Telefone:</label>
    <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>

    <label for="address">Endereço:</label>
    <input type="text" name="address" value="<?php echo $user['address']; ?>" required>

    <button type="submit">Atualizar Informações</button>
</form>

<h2>Alterar Tema</h2>

<button id="theme-toggle">Alternar Tema</button>

<script src="script.js"></script>

</body>
</html>
