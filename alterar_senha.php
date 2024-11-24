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
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verificar se a nova senha e a confirmação são iguais
    if ($new_password !== $confirm_password) {
        echo "As senhas não coincidem!";
        exit;
    }

    // Buscar a senha atual do usuário no banco de dados
    $sql_user = "SELECT password FROM users WHERE id = ?";
    $stmt_user = $pdo->prepare($sql_user);
    $stmt_user->execute([$user_id]);
    $user = $stmt_user->fetch();

    // Verificar se a senha antiga está correta
    if (!password_verify($old_password, $user['password'])) {
        echo "Senha antiga incorreta!";
        exit;
    }

    // Atualizar a senha do usuário
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
    $sql_update = "UPDATE users SET password = ? WHERE id = ?";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([$hashed_new_password, $user_id]);

    echo "Senha alterada com sucesso!";
}
?>

<h2>Alterar Senha</h2>

<form method="POST" action="alterar_senha.php">
    <label for="old_password">Senha Antiga:</label>
    <input type="password" name="old_password" required><br><br>

    <label for="new_password">Nova Senha:</label>
    <input type="password" name="new_password" required><br><br>

    <label for="confirm_password">Confirmar Nova Senha:</label>
    <input type="password" name="confirm_password" required><br><br>

    <button type="submit">Alterar Senha</button>
</form>

<p><a href="perfil.php">Voltar ao perfil</a></p>
