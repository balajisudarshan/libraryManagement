<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/style.css" />
    <link rel="stylesheet" href="./styles/navbar.css" />
    <link rel="stylesheet" href="./components/internalStyle/login.css" />
    <title>Login - Library</title>
</head>

<style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            background-color: #f8d7da;
            padding: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
        }
        .login-form {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .input-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>


<body>

<div class="container">
    <nav>
    <div class="logo"><h2>Library</h2></div>
        <div class="burger-menu" id="burgerMenu">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <ul class="link-container" id="navLinks">
          <li class="links"><a href="#">Register User</a></li>
          <li class="links"><a href="#">Contact Us</a></li>
        </ul>
        <!-- Navigation links here -->
    </nav>

    <div class="login-page">
        <div class="login-container">
            <div class="login-box">
                <h2>Login To Continue</h2>
                <form action="login.php" method="post">
                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required />
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required />
                    </div>
                    <input type="submit" name="submit" class="login-button" value="Login">
                    <a href="#" class="forgot" style="margin-left: 55%; margin-top: 10%">Forgot password? Reset it</a>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="error-message"><?php echo $_SESSION['error']; ?></div>
                        <?php unset($_SESSION['error']); // Clear the error after displaying it ?>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="./navbar.js"></script>
</body>
</html>
