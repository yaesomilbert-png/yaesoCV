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

if (isset($_POST['submit'])) {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $job = $_POST['job'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $postal = $_POST['postal'];
    $summary = $_POST['summary'];

    // Image Upload
    $imgName = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $path = "../assets/uploads/" . $imgName;
    move_uploaded_file($tmp, $path);

    // Insert user
    $conn->query("INSERT INTO users (firstname, lastname, jobtitle, phone, email, address, postal, summary, image)
    VALUES ('$fname','$lname','$job','$phone','$email','$address','$postal','$summary','$imgName')");

    $user_id = $conn->insert_id;

    // Skills
    foreach ($_POST['skills'] as $skill) {
        $conn->query("INSERT INTO skills (user_id, skill) VALUES ('$user_id','$skill')");
    }

    // Education
    foreach ($_POST['education'] as $edu) {
        $conn->query("INSERT INTO education (user_id, education) VALUES ('$user_id','$edu')");
    }

    // Experience
    foreach ($_POST['experience'] as $exp) {
        $conn->query("INSERT INTO experience (user_id, experience) VALUES ('$user_id','$exp')");
    }

    header("Location: displayinfo.php?id=" . $user_id);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CV Builder</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">
    <h1>Create Your CV</h1>

    <form method="POST" enctype="multipart/form-data">
        
        <input type="file" name="image" required>

        <div class="grid">
            <input type="text" name="fname" placeholder="First Name" required>
            <input type="text" name="lname" placeholder="Last Name" required>
        </div>

        <input type="text" name="job" placeholder="Job Title">
        <input type="text" name="phone" placeholder="Phone">
        <input type="email" name="email" placeholder="Email">

        <div class="grid">
            <input type="text" name="address" placeholder="Address">
            <input type="text" name="postal" placeholder="Postal Code">
        </div>

        <textarea name="summary" placeholder="Summary"></textarea>

        <div class="dynamic-section">
            <h3>Skills</h3>
            <div id="skills"></div>
            <button type="button" class="add-btn" onclick="addField('skills')">+ Add Skill</button>
        </div>

        <div class="dynamic-section">
            <h3>Education</h3>
            <div id="education"></div>
            <button type="button" class="add-btn" onclick="addField('education')">+ Add Education</button>
        </div>

        <div class="dynamic-section">
            <h3>Experience</h3>
            <div id="experience"></div>
            <button type="button" class="add-btn" onclick="addField('experience')">+ Add Experience</button>
        </div>

        <button type="submit" name="submit">Generate CV</button>

    </form>
</div>

<script src="../assets/js/script.js"></script>
</body>
</html>