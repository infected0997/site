<?php
session_start();
include('includes/db.php');

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Verificar se a senha e a confirmação de senha são iguais
    if ($password !== $password_confirm) {
        echo "As senhas não coincidem.";
        exit;
    }

    // Verificar se o email ou username já estão cadastrados
    $check_sql = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt_check = $pdo->prepare($check_sql);
    $stmt_check->execute([$email, $username]);
    if ($stmt_check->rowCount() > 0) {
        echo "E-mail ou nome de usuário já cadastrados.";
        exit;
    }

    // Inserir o usuário no banco de dados
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $email, $hashed_password, $phone, $address]);

    echo "Cadastro realizado com sucesso! Você pode fazer login agora.";
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Cadastrar Novo Usuário</h2>

    <form method="POST" action="register.php" id="registerForm">
        <label for="username">Nome de Usuário:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Senha:</label>
        <input type="password" name="password" id="password" required><br><br>

        <label for="password_confirm">Confirmar Senha:</label>
        <input type="password" name="password_confirm" id="password_confirm" required><br><br>

        <label for="phone">Telefone:</label>
        <input type="text" name="phone" id="phone" required><br><br>

        <label for="address">Endereço:</label>
        <input type="text" name="address" id="address" required><br><br>

        <label>
            <input type="checkbox" name="terms" id="terms" required> Eu concordo com os <a href="termos_de_uso.php" target="_blank">Termos de Uso</a>
        </label><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <p>Já tem uma conta? <a href="login.php">Fazer login</a></p>

    <script src="script.js"></script>
</body>
</html>
