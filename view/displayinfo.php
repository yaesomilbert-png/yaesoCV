<?php
$conn = new mysqli("localhost", "root", "");

// Check if database exists, create if not
if ($conn->select_db("cv_builder") === false) {
    $conn->query("CREATE DATABASE cv_builder");
    $conn->select_db("cv_builder");

    // Create tables
    $tables = [
        "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(50),
            lastname VARCHAR(50),
            jobtitle VARCHAR(100),
            phone VARCHAR(20),
            email VARCHAR(100),
            address VARCHAR(255),
            postal VARCHAR(20),
            summary TEXT,
            image VARCHAR(255)
        )",
        "CREATE TABLE skills (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            skill VARCHAR(100)
        )",
        "CREATE TABLE education (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            education TEXT
        )",
        "CREATE TABLE experience (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            experience TEXT
        )"
    ];

    foreach ($tables as $table) {
        $conn->query($table);
    }
} else {
    $conn->select_db("cv_builder");
}

$id = $_GET['id'];

$user = $conn->query("SELECT * FROM users WHERE id='$id'")->fetch_assoc();
$skills = $conn->query("SELECT * FROM skills WHERE user_id='$id'");
$edu = $conn->query("SELECT * FROM education WHERE user_id='$id'");
$exp = $conn->query("SELECT * FROM experience WHERE user_id='$id'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>CV Output</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="cv">
    <div class="left">
        <img src="../assets/uploads/<?php echo $user['image']; ?>">

        <h2><?php echo $user['firstname'] . " " . $user['lastname']; ?></h2>
        <p><?php echo $user['jobtitle']; ?></p>

        <h4>Contact</h4>
        <p><?php echo $user['phone']; ?></p>
        <p><?php echo $user['email']; ?></p>
        <p><?php echo $user['address']; ?></p>

        <h4>Skills</h4>
        <ul>
            <?php while($s = $skills->fetch_assoc()) echo "<li>{$s['skill']}</li>"; ?>
        </ul>
    </div>

    <div class="right">
        <h3>Summary</h3>
        <p><?php echo $user['summary']; ?></p>

        <h3>Education</h3>
        <ul>
            <?php while($e = $edu->fetch_assoc()) echo "<li>{$e['education']}</li>"; ?>
        </ul>

        <h3>Experience</h3>
        <ul>
            <?php while($x = $exp->fetch_assoc()) echo "<li>{$x['experience']}</li>"; ?>
        </ul>
    </div>
</div>

</body>
</html>