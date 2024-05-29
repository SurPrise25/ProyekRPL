<?php
include("../database.php");
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

$email = $_SESSION['email'];


$query = "SELECT username, password FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $currentUsername = $row['username'];
    $currentPassword = $row['password'];  
} else {
    echo "User not found!";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['password']);  
    $updateQuery = "UPDATE users SET email='$newEmail', username='$newUsername', password='$newPassword' WHERE email='$email'";
    
    if (mysqli_query($conn, $updateQuery)) {
        
        $_SESSION['email'] = $newEmail;  
        header("Location: profileTeacher.php?success=Profile updated successfully");
        exit;
    } else {
        // Error updating record
        echo "Error updating record: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body>
    <h1>Edit Profile</h1>
    <form method="post">
        <label for="email">New Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $email; ?>" required><br>
        <label for="username">New Username:</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($currentUsername); ?>" required><br>
        <label for="password">New Password:</label>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" value="Update Profile">
    </form>
    <button onclick="window.location.href='profileTeacher.php';">Back to Profile</button>
</body>
</html>
