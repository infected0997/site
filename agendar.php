<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Buscar médicos disponíveis no banco de dados
$sql_doctors = "SELECT id, name, specialty FROM doctors";
$stmt_doctors = $pdo->prepare($sql_doctors);
$stmt_doctors->execute();
$doctors = $stmt_doctors->fetchAll();

// Processar o agendamento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_date = $_POST['appointment_date'];
    $doctor_id = $_POST['doctor_id'];  // Receber o médico escolhido pelo usuário
    $symptoms = $_POST['symptoms'];    // Receber os sintomas informados
    $user_id = $_SESSION['user_id'];

    // Inserir o agendamento na tabela appointments
    $sql = "INSERT INTO appointments (user_id, appointment_date, doctor_id, symptoms) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $appointment_date, $doctor_id, $symptoms]);

    echo "Consulta agendada com sucesso!";
}
?>

<h2>Agendar Consulta</h2>

<form method="POST" action="agendar.php">
    <label for="appointment_date">Data e Hora da Consulta:</label>
    <input type="datetime-local" name="appointment_date" required><br><br>

    <label for="doctor_id">Escolha o Médico:</label>
    <select name="doctor_id" required>
        <option value="">Selecione um médico</option>
        <?php foreach ($doctors as $doctor): ?>
            <option value="<?php echo $doctor['id']; ?>">
                <?php echo $doctor['name']; ?> - <?php echo $doctor['specialty']; ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="symptoms">Sintomas:</label>
    <textarea name="symptoms" placeholder="Descreva seus sintomas..." required></textarea><br><br>

    <button type="submit">Agendar</button>
</form>

<p><a href="perfil.php">Voltar ao perfil</a></p>
