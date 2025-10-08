<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streamlined Charity Fundraising Assistant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 320px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 80px;
        }
        p {
            text-align: center;
            color: #333;
            padding-top: 200px;
            font-size: 40px;
            font-weight: bold;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-container {
            text-align: center;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
            background-color: #f2f2f2;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 10px;
        }
        .button-group input[type="submit"],
        .button-group a {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 4px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: center;
        }
        .button-group input[type="submit"]:hover,
        .button-group a:hover {
            background-color: #555;
        }
        .error-message {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div>
        <p>Welcome to Streamlined Charity Fundraising Assistant</p>
    </div>
    <div class="container">
        <h2>Login</h2>
        <div class="form-container">
            <form id="login-form" action="login.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <div class="button-group">
                    <input type="submit" value="Login">
                    <a href="register.php">Register</a>
                </div>
            </form>
            <div class="error-message" id="error-message" style="display: none;">Invalid username or password</div>
        </div>
    </div>
</body>
</html>