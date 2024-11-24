<?php
session_start();
include('includes/db.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Verificar se o agendamento foi passado como parâmetro
if (!isset($_GET['appointment_id'])) {
    echo "Agendamento não encontrado!";
    exit;
}

$appointment_id = $_GET['appointment_id'];
$user_id = $_SESSION['user_id'];

// Verificar se o agendamento pertence ao usuário
$sql_check_appointment = "SELECT * FROM appointments WHERE id = ? AND user_id = ?";
$stmt_check = $pdo->prepare($sql_check_appointment);
$stmt_check->execute([$appointment_id, $user_id]);

$appointment = $stmt_check->fetch();

if (!$appointment) {
    echo "Agendamento não encontrado ou você não tem permissão para excluí-lo!";
    exit;
}

// Excluir o agendamento do banco de dados
$sql_delete = "DELETE FROM appointments WHERE id = ? AND user_id = ?";
$stmt_delete = $pdo->prepare($sql_delete);
$stmt_delete->execute([$appointment_id, $user_id]);

echo "Agendamento excluído com sucesso!";

// Redirecionar de volta para o perfil
header('Location: perfil.php');
exit;
