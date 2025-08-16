<?php
include '../includes/db_connect.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_id = $_POST['exam_id'];
    $user_id = $_SESSION['user_id'];
    $score = 0;
    $total_questions = count($_POST['answers']);

    // Loop through each submitted answer
    foreach ($_POST['answers'] as $question_id => $selected_answer) {
        // Fetch the correct answer for each question from the database
        $result = $conn->query("SELECT correct_answer FROM questions WHERE id = $question_id");
        $row = $result->fetch_assoc();
        
        // Compare the submitted answer with the correct answer
        if ($row['correct_answer'] == $selected_answer) {
            $score++; // Increment score for each correct answer
        }
    }

    // Calculate the percentage score
    $percentage_score = ($score / $total_questions) * 100;

    // Insert the score into the results table
    $stmt = $conn->prepare("INSERT INTO results (user_id, exam_id, score, total_questions, result_date) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiii", $user_id, $exam_id, $score, $total_questions);

    // Display message based on result
    $submitted = $stmt->execute();
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/submit_exam.css">
</head>
<body>
    <div class="container result-page">
        <header>
            <h2>Exam Result</h2>
        </header>
        
        <?php if ($submitted): ?>
            <div class="result-box">
                <p>Exam submitted successfully!</p>
                <p><strong>Your score:</strong> <?php echo $score; ?> / <?php echo $total_questions; ?></p>
                <p><strong>Percentage:</strong> <?php echo round($percentage_score, 2); ?>%</p>
                <a href="../dashboard.php" class="back-button">Back to Exams</a>
            </div>
        <?php else: ?>
            <div class="error-box">
                <p>There was an error submitting your exam. Please try again later.</p>
                <a href="exam.php" class="back-button">Back to Exams</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
