<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullname, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php?signup=success");
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steer Clear - Sign Up</title>
    <link rel="stylesheet" href="signup.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
            overflow: hidden;
        }
        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        .signup-container {
            display: flex;
            width: 600px;
            height: 550px;
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        .right-section {
            flex: 1;
            padding: 50px;
        }
        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: white;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        .signup-btn {
            width: 100%;
            padding: 15px;
            background: #ffcc00;
            border: none;
            color: #000;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }
        .signup-btn:hover {
            background: #e6b800;
        }
        .links {
            text-align: center;
            font-size: 16px;
            margin-top: 15px;
        }
        .links a {
            text-decoration: none;
            color: #007bff;
        }
    </style>

</head>
<body>
    <video autoplay muted loop class="video-background">
        <source src="carss.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="signup-container">
        <div class="right-section">
            <h2>Create Your Account</h2>
            <p style="text-align: center; font-size: 16px; color: white;">Join Steer Clear today and find your perfect car.</p>
            <form action="signup.php" method="post">
                <div class="input-group">
                    <input type="text" name="fullname" placeholder="Full Name" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email Id" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="signup-btn">Sign Up</button>
            </form>
            <div class="links">
                <p style="color: white;">Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
