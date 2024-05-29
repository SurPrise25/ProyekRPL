<?php
include("../database.php");
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];

$username_query = "SELECT username FROM users WHERE email = '$email'";
$password_query = "SELECT password FROM users WHERE email = '$email'";
$id_query = "SELECT id FROM users WHERE email = '$email'";
$role_query = "SELECT role FROM users WHERE email = '$email'";

$username_result = mysqli_query($conn, $username_query);
$password_result = mysqli_query($conn, $password_query);
$id_result = mysqli_query($conn, $id_query);
$role_result = mysqli_query($conn, $role_query);

$username_row = mysqli_fetch_assoc($username_result);
$password_row = mysqli_fetch_assoc($password_result);
$id_row = mysqli_fetch_assoc($id_result);
$role_row = mysqli_fetch_assoc($role_result);

$username = $username_row['username'];
$id = $id_row['id'];
$role = $role_row['role'];
$videos_query = "SELECT title, video_file FROM course WHERE uploaded_by = '$username'";
$videos_result = mysqli_query($conn, $videos_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <style>
        .video-list {
            list-style: none;
            padding: 0;
        }
        .video-item {
            margin-bottom: 20px;
        }
        .video-item img {
            width: 200px; /* Adjust size as needed */
            height: auto;
            border: 1px solid #ccc;
            margin-right: 10px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <h1>Home</h1>
    <h3>What are you teaching today, <?php echo htmlspecialchars($username); ?>?</h3>
    <button onclick="window.location.href='profileTeacher.php';">Profile</button>
    <button onclick="window.location.href='createCourse.php';">Create New Course</button>

    <h3>Your Courses</h3>
    <?php
    if (mysqli_num_rows($videos_result) > 0) {
        echo "<ul class='video-list'>";
        while ($video = mysqli_fetch_assoc($videos_result)) {
            echo "<li class='video-item'>";
            echo "<img src='" . htmlspecialchars($video['thumbnail_file']) . "' alt='Thumbnail for " . htmlspecialchars($video['title']) . "'>";
            echo "<strong>" . htmlspecialchars($video['title']) . "</strong> - <a href='" . htmlspecialchars($video['video_file']) . "' target='_blank'>View Video</a>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>You have not uploaded any videos yet.</p>";
    }
    ?>
</body>
</html>
