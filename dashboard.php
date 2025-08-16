<?php
session_start();

// Redirect to home page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="main-container">
        <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="logo">
                <a href="index.php">Online Exam System</a>
            </div>
            <ul class="nav-links">
               
                <li><a href="pages/logout.php" class="logout-link">Logout</a></li>
            </ul>
        </nav>

        <!-- Header Section -->
        <header class="dashboard-header">
            <h1>Welcome to the Online Exam Dashboard</h1>
            <h2>Hello, <?php echo $_SESSION['username']; ?>!</h2>
            <p>You are logged in as a <strong><?php echo $_SESSION['role']; ?></strong>.</p>
        </header>

        <!-- Actions Section -->
        <section class="actions-section">
            <?php if ($_SESSION['role'] === 'admin') : ?>
                <div class="admin-actions card">
                    <h3>Admin Actions</h3>
                    <ul>
                        <li><a href="admin/add_exam.php">Add New Exam</a></li>
                        <li><a href="admin/add_questions.php">Add Questions</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($_SESSION['role'] === 'student') : ?>
                <div class="student-actions card">
                    <h3>Student Actions</h3>
                    <ul>
                        <li><a href="pages/exam.php">Take Available Exams</a></li>
                        <li><a href="pages/view_results.php">View Results</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
