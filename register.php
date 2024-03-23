
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color:red;
        }
        form {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color:#800000;
        }
        h2 {
            text-align: center;
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
            background-color: green;
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
    <!-- <h2>Register</h2> -->
    
    <form action="add_user.php" method="post">
    <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required><br><br>

        <label for="username">New Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required><br><br>
    
        <label for="user_role">User Role:</label>
        <select id="user_role" name="user_role" required>
            <option value="">Select User Role</option>
            <option value="admin">Admin</option>
            <option value="agent">Agent</option>
        </select><br><br>
    
        <input type="submit" value="Register">
    </form>
    
   
<!-- 
    <table border="1">
        <tr>
          <th colspan="4">Header spanning two columns</th>
          <th>Header</th>
        </tr>
        <tr>
          <td>Row 1, Cell 1</td>
          <td>Row 1, Cell 2</td>
          <td>Row 1, Cell 3</td>
        </tr>
        <tr>
          <td>Row 2, Cell 1</td>
          <td>Row 2, Cell 2</td>
          <td>Row 2, Cell 3</td>
        </tr>
      </table>
       -->

</body>
</html>
