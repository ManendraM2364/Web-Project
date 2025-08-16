<?php
include '../includes/db_connect.php';
session_start();

// Check if the user is a student
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

// Fetch exams
$exams = $conn->query("SELECT * FROM exams");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Portal</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/exam.css">
</head>
<body>
    <div class="container">
        <!-- Back to Dashboard Button -->
        <a href="../dashboard.php" class="back-button">Back to Dashboard</a>

        <?php if (isset($_GET['exam_id'])): ?>
            <?php
            $exam_id = $_GET['exam_id'];
            // Fetch questions for the selected exam
            $questions = $conn->query("SELECT * FROM questions WHERE exam_id = $exam_id");
            ?>
            
            <header>
                <h2>Take Exam</h2>
            </header>
            <form method="post" action="submit_exam.php" class="exam-form">
                <?php while ($row = $questions->fetch_assoc()): ?>
                    <div class="question">
                        <p><?php echo htmlspecialchars($row['question_text']); ?></p>
                        <label>
                            <input type="radio" name="answers[<?php echo $row['id']; ?>]" value="A" required>
                            <?php echo htmlspecialchars($row['option_a']); ?>
                        </label><br>
                        <label>
                            <input type="radio" name="answers[<?php echo $row['id']; ?>]" value="B">
                            <?php echo htmlspecialchars($row['option_b']); ?>
                        </label><br>
                        <label>
                            <input type="radio" name="answers[<?php echo $row['id']; ?>]" value="C">
                            <?php echo htmlspecialchars($row['option_c']); ?>
                        </label><br>
                        <label>
                            <input type="radio" name="answers[<?php echo $row['id']; ?>]" value="D">
                            <?php echo htmlspecialchars($row['option_d']); ?>
                        </label><br><br>
                    </div>
                <?php endwhile; ?>
                <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
                <button type="submit" class="submit-button">Submit Exam</button>
            </form>
        <?php else: ?>
            <header>
                <h2>Available Exams</h2>
            </header>
            <ul class="exam-list">
                <?php while ($row = $exams->fetch_assoc()): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($row['exam_name']); ?></strong>
                        <a href="exam.php?exam_id=<?php echo $row['id']; ?>" class="take-exam-link">Take Exam</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
