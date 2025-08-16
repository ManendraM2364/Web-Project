<?php
include '../includes/db_connect.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch the results for the logged-in user
$result = $conn->query("SELECT exams.exam_name, results.score, results.total_questions, results.result_date 
                        FROM results 
                        JOIN exams ON results.exam_id = exams.id 
                        WHERE results.user_id = $user_id");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Exam Results</title>
    <link rel="stylesheet" href="../assets/css/style.css" defer>
    <style>
        /* Styling for the Results Page */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
            color: #333;
        }

        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            max-width: 600px;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
        }

        .back-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Your Exam Results</h2>
    <table>
        <tr>
            <th>Exam Name</th>
            <th>Score</th>
            <th>Total Questions</th>
            <th>Percentage</th>
            <th>Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['exam_name']); ?></td>
                <td><?php echo htmlspecialchars($row['score']); ?></td>
                <td><?php echo htmlspecialchars($row['total_questions']); ?></td>
                <td><?php echo round(($row['score'] / $row['total_questions']) * 100, 2) . '%'; ?></td>
                <td><?php echo htmlspecialchars($row['result_date']); ?></td>
            </tr>
        <?php } ?>
    </table>

    <!-- Back to Dashboard Button -->
    <a href="../dashboard.php" class="back-button">Back to Dashboard</a>
</body>
</html>

<?php
$conn->close();
?>
