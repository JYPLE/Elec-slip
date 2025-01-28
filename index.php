
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="android" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
         body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color:#800000;
        }
        form {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color:green;
        }
        h2 {
            text-align: center;
            color: white;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #fff;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
           

            
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #FF2400;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: black;
        }
    </style>
</head>
<body>
    
</head>
<body>
  
    <form action="login.php" method="post">
        <h2>Call-Slip Login </h2>
        <label for="username">New Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <?php
        if (isset($_SESSION['userdata']) && $_SESSION['userdata']['user_role'] == "agent") {
            echo '<label for="agent">Agent:</label>';
            echo '<input type="text" id="agent" name="agent" value="' . $_SESSION['userdata']['username'] . '" readonly><br>';
        } 
        ?>
        <input type="submit" value="logins">
    </form>
</body>
</html>
