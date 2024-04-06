<!-- edit.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Entry</title>
    <style>
  body{
    background-color: #800000;
  }
  #main {
            transition: margin-left .5s;
            padding: 16px;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-top: 20px;
        }

        form {
    width: 40%;
    margin: 0 auto;
    color:white;
}
.form-control-sm {
        height: calc(1.5em + .5rem + 2px);
        padding: .25rem .5rem;
        font-size: .875rem;
        line-height: 1.5;
        border-radius: .2rem;
    }

label, input[type="text"], input[type="date"], select, input[type="number"], input[type="submit"] {
    display: block;
    margin: 10px 0;
    width: 100%; /* Full width */
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

/* Additional styles */
select, input[type="text"], input[type="date"], input[type="number"] {
    padding: 5px;
    margin-bottom: 2px;
    box-sizing: border-box;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    color:white;
    background-color: green;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    color:white;
}


@media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }

        @media screen and (min-width: 600px) {
            form {
                width: 60%;
            }
        }
        @media (min-width: 992px) {
        .form-group {
            margin-bottom: 0; /* Remove bottom margin for smaller screens */
        }
    }
    </style>
</head>
<body>

    <?php
    session_start(); // Start the session to access logged-in user information

    // Check if user is logged in
    if (!isset($_SESSION['userdata']) || $_SESSION['userdata']['user_role'] !== "agent") {
        // Redirect the user if not logged in or not authorized
        header("Location: login.php"); // Redirect to your login page
        exit();
    }

    // Check if entry ID is provided
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        // Redirect if ID is not provided
        header("Location: user_entry.php"); // Redirect to your dashboard or appropriate page
        exit();
    }

    $id = $_GET['id'];

    $conn = new mysqli("localhost", "root", "", "eslip");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the entry details based on ID
    $sql = "SELECT * FROM slip_entry WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        // Redirect if entry not found
        header("Location: user_entry.php"); // Redirect to your dashboard or appropriate page
        exit();
    }

    // Handle form submission for updating the entry
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission and update the entry in the database
        // Retrieve form data and update the entry
      
        $name = $_POST['name'];
        $zone = $_POST['zone'];
        $barangay = $_POST['barangay'];
        $entry_date = $_POST['entry_date'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $lcp = $_POST['lcp'];
        $contact_number = $_POST['contact_number'];
        $nap = $_POST['nap'];
        $price = $_POST['price'];
        $satisfied = $_POST['satisfied'];
        $locked_in = $_POST['locked_in'];
        $others_not_signing_up = $_POST['others_not_signing_up'];
        $pldt_existing = $_POST['pldt_existing'];
        $pldt_lock_date = $_POST['pldt_lock_date'];
        $pldt_sales_new = $_POST['pldt_sales_new'];
        $pldt_sales_switch = $_POST['pldt_sales_switch'];
        $globe_existing = $_POST['globe_existing'];
        $globe_lock_date = $_POST['globe_lock_date'];
        $globe_sales_new = $_POST['globe_sales_new'];
        $globe_sales_switch = $_POST['globe_sales_switch'];

        $converge_existing = $_POST['converge_existing'];
        $lock_date = $_POST['lock_date'];
        $converge_sales_new = $_POST['converge_sales_new'];
        $converge_sales_switch = $_POST['converge_sales_switch'];

        $no_providers_existing = $_POST['no_providers_existing'];
        $no_providers_sales_new = $_POST['no_providers_sales_new'];
        $no_providers_sales_switch = $_POST['no_providers_sales_switch'];

        $unengaged_existing = $_POST['unengaged_existing'];
        $unengaged_sales_new = $_POST['unengaged_sales_new'];
        $unengaged_sales_switch = $_POST['unengaged_sales_switch'];
        $field_probs = $_POST['field_probs'];
        $other_prov = $_POST['other_prov'];




        // Prepare and bind the SQL statement
        $update_sql = "UPDATE slip_entry SET name=?, zone=?, barangay=?, entry_date=?, city=?, province=?, lcp=?, contact_number=?, nap=?, price=?, satisfied=?, locked_in=?, others_not_signing_up=?, pldt_existing=?, pldt_lock_date=?, pldt_sales_new=?, pldt_sales_switch=?, globe_existing=?, globe_lock_date=?, globe_sales_new=?, globe_sales_switch=?, converge_existing=?, lock_date=?, converge_sales_new=?, converge_sales_switch=?, no_providers_existing=?, no_providers_sales_new=?, no_providers_sales_switch=?, unengaged_existing=?, unengaged_sales_new=?, unengaged_sales_switch=?, field_probs=?, other_prov=?  WHERE id=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssssssssssssssssssssssssssssssssi", $name, $zone, $barangay, $entry_date, $city, $province, $lcp, $contact_number, $nap, $price, $satisfied, $locked_in, $others_not_signing_up, $pldt_existing, $pldt_lock_date, $pldt_sales_new, $pldt_sales_switch, $globe_existing, $globe_lock_date, $globe_sales_new, $globe_sales_switch, $converge_existing, $lock_date, $converge_sales_new, $converge_sales_switch, $no_providers_existing, $no_providers_sales_new, $no_providers_sales_switch, $unengaged_existing, $unengaged_sales_new, $unengaged_sales_switch, $field_probs, $other_prov, $id);

        
        $stmt->execute();

        // Redirect after updating the entry
        header("Location: user_entry.php"); // Redirect to your dashboard or appropriate page
        exit();
    }

    $conn->close();
    ?>

<form method="POST" action="">
    <div class="container">
        <!-- Display the form with input fields pre-filled with entry details -->
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $row['name']; ?>" oninput="this.value = this.value.toUpperCase()">
        
        <label for="zone">Zone:</label>
        <input type="text" name="zone" id="zone" value="<?php echo $row['zone']; ?>" oninput="this.value = this.value.toUpperCase()">
        
        <label for="barangay">Barangay:</label>
        <input type="text" name="barangay" id="barangay" value="<?php echo $row['barangay']; ?>" oninput="this.value = this.value.toUpperCase()">

        <label for="entry_date">ENTRY DATE:</label>
        <input type="date" id="entry_date" name="entry_date" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>">
        
        <label for="city">City:</label>
        <input type="text" name="city" id="city" value="<?php echo $row['city']; ?>" oninput="this.value = this.value.toUpperCase()">
        
        <label for="province">Province:</label>
        <input type="text" name="province" id="province" value="<?php echo $row['province']; ?>" oninput="this.value = this.value.toUpperCase()">

        <label for="lcp">Lcp:</label>
        <input type="text" name="lcp" id="lcp" value="<?php echo $row['lcp']; ?>" oninput="this.value = this.value.toUpperCase()">

        <label for="contact_number">Contact Number:</label>
        <input type="text" name="contact_number" id="contact_number" value="<?php echo $row['contact_number']; ?>">
        
        <label for="nap">Nap:</label>
        <input type="text" name="nap" id="nap" value="<?php echo $row['nap']; ?>" oninput="this.value = this.value.toUpperCase()">
       
        <br>
            <table>
            <tr>
            <th></th>
            <th>EXISTING</th>
            <th>LOCK IN</th>
            <th>SALES NEW</th>
            <th>SALES SWITCH</th>
        </tr>
      
        
        <tr>
            <td>GLOBE:</td>
            <td>
            <select name="globe_existing">
    <option value="No"<?php if ($row['globe_existing'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['globe_existing'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
            <td>
            
            <input type="date" id="globe_lock_date" name="globe_lock_date" value="<?php echo $row['globe_lock_date']; ?>"><br>
        </td> 
            <td>
                
                <select name="globe_sales_new">
    <option value="No"<?php if ($row['globe_sales_new'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['globe_sales_new'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
            <td>
                
                <select name="globe_sales_switch">
    <option value="No"<?php if ($row['globe_sales_switch'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['globe_sales_switch'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
        </tr>
        
        <tr>
            <td>CONVERGE:</td>
            <td>
               
                <select name="converge_existing">
    <option value="No"<?php if ($row['converge_existing'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['converge_existing'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
            <td>
          
            <input type="date" id="lock_date" name="lock_date" ><br>
        </td> 
            <td>
               
                   
                    
                <select name="converge_sales_new">
    <option value="No"<?php if ($row['converge_sales_new'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['converge_sales_new'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
            <td>
                
                   
                <select name="converge_sales_switch">
    <option value="No"<?php if ($row['converge_sales_switch'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['converge_sales_switch'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
            <tr>
            <td>PLDT:</td>
            <td>
                
                         
                <select name="pldt_existing">
    <option value="No"<?php if ($row['pldt_existing'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['pldt_existing'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
            <td>
            
            <input type="date" id="pldt_lock_date" name="pldt_lock_date"><br>
        </td> 
            <td>
                
                <select name="pldt_sales_new">
    <option value="No"<?php if ($row['pldt_sales_new'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['pldt_sales_new'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
      
      
            <td>
         
                <select name="pldt_sales_switch" style="display: none;">
    <option value="No"<?php if ($row['pldt_sales_switch'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['pldt_sales_switch'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
            
    
        <tr>
            <td>NO PROVIDERS:</td>
            <td>
               
                   
                <select name="no_providers_existing">
    <option value="No"<?php if ($row['no_providers_existing'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['no_providers_existing'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
            <td>
</td>
            <td>
                       
                
            <select name="no_providers_sales_new">
    <option value="No"<?php if ($row['no_providers_sales_new'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['no_providers_sales_new'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
            <td>
            <select name="no_providers_sales_switch">
    <option value="No"<?php if ($row['no_providers_sales_switch'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['no_providers_sales_switch'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
        </tr>
        <tr>
            <td>UNENGAGED:</td>
            <td>
            <select name="unengaged_existing">
    <option value="No"<?php if ($row['unengaged_existing'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['unengaged_existing'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
            <td>
              
    
         </td>
            <td>
            <select name="unengaged_sales_new">
    <option value="No"<?php if ($row['unengaged_sales_new'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['unengaged_sales_new'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
            <td>
            <select name="unengaged_sales_switch">
    <option value="No"<?php if ($row['unengaged_sales_switch'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['unengaged_sales_switch'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>
            </td>
             </tr>
      
           <tr>

            <th rowspan="2">OTHER PROVIDER</th>
        <td>
            <label for="other_provider"></label>
            <input type="text" id="other_prov" name="other_prov" value="<?php echo $row['other_prov']; ?>"><br>
        </td> 
        <td>
    
</td>
        <td>
        <select name="pldt_sales_new">
                   
    <option value="No"<?php if ($row['pldt_sales_new'] == 'No') echo ' selected'; ?>>No</option>
    <option value="Yes"<?php if ($row['pldt_sales_new'] == 'Yes') echo ' selected'; ?>>Yes</option>
</select>

            </td>
            <td>
            <select name="pldt_sales_switch">
                   
                   <option value="No"<?php if ($row['pldt_sales_switch'] == 'No') echo ' selected'; ?>>No</option>
                   <option value="Yes"<?php if ($row['pldt_sales_switch'] == 'Yes') echo ' selected'; ?>>Yes</option>
               </select>
            </td>
        </tr>
    </table>
    
        </div>
    

        <center><label for="not_signing_up_reason">IF NOT SIGNING-UP TO PLDT- WHY?</label></center>
        <td></td>
            <td>
           
                <select name="field_probs">
                <option value="LOCKED IN"<?php if ($row['field_probs'] == 'LOCKED IN') echo ' selected'; ?>>LOCKED IN</option>
                   <option value="PRICE"<?php if ($row['field_probs'] == 'PRICE') echo ' selected'; ?>>PRICE</option>
                   <option value="SATISFIED"<?php if ($row['field_probs'] == 'SATISFIED') echo ' selected'; ?>>SATISFIED</option>
                   <option value="FINANCIAL"<?php if ($row['field_probs'] == 'FINANCIAL') echo ' selected'; ?>>FINANCIAL</option>
                   <option value="DELAYED REPAIR"<?php if ($row['field_probs'] == 'DELAYED REPAIR') echo ' selected'; ?>>DELAYED REPAIR</option>
                    
                </select>
            </td>
            <label for="others_not_signing_up">OTHERS:</label>
            <input type="text" id="others_not_signing_up" name="others_not_signing_up"oninput="this.value = this.value.toUpperCase()">
          
       

           
    
  
    <!-- <label for="other provider">OTHER PROVIDER</label>
    <input type="text" id="other_prov" name="other_prov"><br>  -->
   <input type="submit" value="Submit">
</form>

</body>
</html>
