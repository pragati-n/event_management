<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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
        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 91%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF8C;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-container input[type="submit"]:hover {
            background-color: #45a049;
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
    <div class="login-container">
        <h2>Event management</h2>
        <form name="login_form" >
            <label for="email">Email</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" id="login_btn" value="Login">

            <div class="error_msg hide_div" style="color: red;padding: 10px 0px;">sdsdsdsd</div>
        </form>
    </div>
</body>
</html>
