<?php
session_start();
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consultar o banco de dados pelo e-mail
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verificar se o usuário existe e se a senha está correta
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: perfil.php');
        exit;
    } else {
        echo "Credenciais inválidas!";
    }
}
?>

<form method="POST" action="login.php">
    <label for="email">E-mail:</label>
    <input type="email" name="email" required>

    <label for="password">Senha:</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
</form>

<p>Ainda não tem conta? <a href="register.php">Cadastre-se</a></p>
