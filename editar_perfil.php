<?php
session_start();
include('includes/db.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Atualizar o telefone e o endereço no banco de dados
    $sql = "UPDATE users SET phone = ?, address = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$phone, $address, $user_id]);

    echo "Informações atualizadas com sucesso!";
    header('Location: perfil.php'); // Redirecionar de volta para o perfil
    exit;
}

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<h2>Editar Informações de Perfil</h2>

<form method="POST" action="editar_perfil.php">
    <label for="phone">Telefone:</label>
    <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>

    <label for="address">Endereço:</label>
    <input type="text" name="address" value="<?php echo $user['address']; ?>" required>

    <button type="submit">Atualizar Informações</button>
</form>

<p><a href="perfil.php">Voltar ao perfil</a></p>
