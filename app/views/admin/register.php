<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .register-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .register-container input[type="text"],
        .register-container input[type="password"],
        .register-container input[type="email"] {
            width: 91%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .register-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF8C;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .register-container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
        .login-link a {
            color: #4CAF8C;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .error_msg{
            color: red;
            padding: 10px 0px;
        }
        .hide_div{
            display:none;
        }
    </style>
    <script src="<?=WEB_PATH?>/app/js/jquery-3.7.1.min.js"></script>
    <script src="<?=WEB_PATH?>/app/js/login.js"></script>
</head>
<body>
    <div class="register-container">
        <h2>Event Management</h2>
        <form name="register_form" >
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <input type="submit" id="register_btn" value="Register">

            <div class="error_msg hide_div" style="color: red;padding: 10px 0px;"></div>
        </form>
        <div class="login-link">
            Already have an account? <a href="login">Login here</a>
        </div>
    </div>
</body>
</html>
