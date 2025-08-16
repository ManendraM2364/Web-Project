<?php
include '../includes/db_connect.php';
session_start();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_name = $_POST['exam_name'];
    $subject = $_POST['subject'];
    $exam_date = $_POST['exam_date'];

    $stmt = $conn->prepare("INSERT INTO exams (exam_name, subject, exam_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $exam_name, $subject, $exam_date);

    if ($stmt->execute()) {
        echo "Exam created successfully! <a href='add_questions.php'>Add Questions</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Exam</title>
    <link rel="stylesheet" href="../assets/css/add_exam.css" defer>
</head>
<body>
    <h2>Add Exam</h2>
    <form method="post" action="">
        <label>Exam Name:</label><br>
        <input type="text" name="exam_name" required><br>
        <label>Subject:</label><br>
        <input type="text" name="subject" required><br>
        <label>Date:</label><br>
        <input type="date" name="exam_date" required><br><br>
        <button type="submit">Create Exam</button>
    </form>
</body>
</html>
