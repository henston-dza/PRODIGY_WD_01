<?php
session_start();


$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            header("Location: dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            $error = "Invalid email or password!";
        }
    } else {
        $error = "User not found!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steer Clear - Login</title>
    <link rel="stylesheet" href="login.css">
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
        .login-container {
            display: flex;
            width: 600px;
            height: 500px;
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
      
        .right-section {
            flex: 1;
            padding: 60px;
        }
        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 25px;
            color: white;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group input {
            width: 100%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        .login-btn {
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
        .login-btn:hover {
            background: #e6b800;
        }
        .links {
            display: flex;
            justify-content: space-between;
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
    <div class="login-container">
        <div class="right-section">
            <h2>Login to Your Account</h2>
            <?php if ($error): ?>
                <p style="color: red; text-align: center;"> <?php echo $error; ?> </p>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email Id" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
            <div class="links">
                <a href="#">Login with phone instead</a>
                <a href="#">Forgot password?</a>
            </div>
            <p style="text-align: center; margin-top: 20px;">New member? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>
</body>
</html>
