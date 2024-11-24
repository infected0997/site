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

// Buscar o agendamento atual, sintomas e médicos disponíveis
$sql_appointment = "SELECT a.id, a.appointment_date, a.doctor_id, a.symptoms, d.name AS doctor_name, d.specialty 
                    FROM appointments a 
                    JOIN doctors d ON a.doctor_id = d.id
                    WHERE a.id = ? AND a.user_id = ?";
$stmt_appointment = $pdo->prepare($sql_appointment);
$stmt_appointment->execute([$appointment_id, $user_id]);
$appointment = $stmt_appointment->fetch();

if (!$appointment) {
    echo "Agendamento não encontrado!";
    exit;
}

// Buscar médicos disponíveis
$sql_doctors = "SELECT id, name, specialty FROM doctors";
$stmt_doctors = $pdo->prepare($sql_doctors);
$stmt_doctors->execute();
$doctors = $stmt_doctors->fetchAll();

// Processar a atualização do agendamento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_date = $_POST['appointment_date'];
    $doctor_id = $_POST['doctor_id'];
    $symptoms = $_POST['symptoms'];

    // Atualizar o agendamento no banco de dados
    $sql_update = "UPDATE appointments SET appointment_date = ?, doctor_id = ?, symptoms = ? WHERE id = ? AND user_id = ?";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([$appointment_date, $doctor_id, $symptoms, $appointment_id, $user_id]);

    echo "Agendamento atualizado com sucesso!";
}
?>

<h2>Editar Agendamento</h2>

<form method="POST" action="editar_agendamento.php?appointment_id=<?php echo $appointment_id; ?>">
    <label for="appointment_date">Data e Hora da Consulta:</label>
    <input type="datetime-local" name="appointment_date" value="<?php echo date('Y-m-d\TH:i', strtotime($appointment['appointment_date'])); ?>" required><br><br>

    <label for="doctor_id">Escolha o Médico:</label>
    <select name="doctor_id" required>
        <?php foreach ($doctors as $doctor): ?>
            <option value="<?php echo $doctor['id']; ?>" <?php echo $doctor['id'] == $appointment['doctor_id'] ? 'selected' : ''; ?>>
                <?php echo $doctor['name']; ?> - <?php echo $doctor['specialty']; ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="symptoms">Sintomas:</label>
    <textarea name="symptoms" required><?php echo htmlspecialchars($appointment['symptoms']); ?></textarea><br><br>

    <button type="submit">Atualizar Agendamento</button>
</form>

<p><a href="perfil.php">Voltar ao perfil</a></p>
