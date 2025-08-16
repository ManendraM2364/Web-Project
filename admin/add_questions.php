<?php
include '../includes/db_connect.php';
session_start();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit;
}

// Retrieve the list of exams to display in the form
$result = $conn->query("SELECT id, exam_name FROM exams");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_id = $_POST['exam_id'];
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_answer = $_POST['correct_answer'];

    $stmt = $conn->prepare("INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $exam_id, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_answer);

    if ($stmt->execute()) {
        echo "Question added successfully!";
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
    <title>Add Question</title>
    <link rel="stylesheet" href="../assets/css/style.css" defer>
    <link rel="stylesheet" href="../assets/css/add_questions.css" defer>
</head>
<body>
    <div class="container">
        <h2>Add Question</h2>
        <form method="post" action="">
            <label>Select Exam:</label><br>
            <select name="exam_id" required>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['exam_name']; ?></option>
                <?php } ?>
            </select><br>
            
            <label>Question Text:</label><br>
            <textarea name="question_text" required></textarea><br>

            <label>Option A:</label><br>
            <input type="text" name="option_a" required><br>

            <label>Option B:</label><br>
            <input type="text" name="option_b" required><br>

            <label>Option C:</label><br>
            <input type="text" name="option_c" required><br>

            <label>Option D:</label><br>
            <input type="text" name="option_d" required><br>

            <label>Correct Answer:</label><br>
            <select name="correct_answer" required>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select><br><br>

            <button type="submit">Add Question</button>
        </form>

        <!-- Link back to the dashboard -->
        <div class="back-to-dashboard">
            <a href="../dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
