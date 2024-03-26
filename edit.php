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
        $pldt_sales_new = $_POST['pldt_sales_new'];
        $pldt_sales_switch = $_POST['pldt_sales_switch'];
        $globe_existing = $_POST['globe_existing'];
        $globe_sales_new = $_POST['globe_sales_new'];
        $globe_sales_switch = $_POST['globe_sales_switch'];

        $converge_existing = $_POST['converge_existing'];
        $converge_sales_new = $_POST['converge_sales_new'];
        $converge_sales_switch = $_POST['converge_sales_switch'];

        $no_providers_existing = $_POST['no_providers_existing'];
        $no_providers_sales_new = $_POST['no_providers_sales_new'];
        $no_providers_sales_switch = $_POST['no_providers_sales_switch'];

        $unengaged_existing = $_POST['unengaged_existing'];
        $unengaged_sales_new = $_POST['unengaged_sales_new'];
        $unengaged_sales_switch = $_POST['unengaged_sales_switch'];
        $other_prov = $_POST['other_prov'];




        // Prepare and bind the SQL statement
        $update_sql = "UPDATE slip_entry SET name=?, zone=?, barangay=?, entry_date=?, city=?, province=?, lcp=?, contact_number=?, nap=?, price=?, satisfied=?, locked_in=?, others_not_signing_up=?, pldt_existing=?, pldt_sales_new=?, pldt_sales_switch=?, globe_existing=?, globe_sales_new=?, globe_sales_switch=?, converge_existing=?, converge_sales_new=?, converge_sales_switch=?, no_providers_existing=?, no_providers_sales_new=?, no_providers_sales_switch=?, unengaged_existing=?, unengaged_sales_new=?, unengaged_sales_switch=?, other_prov=?  WHERE id=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssssssssssssssssssssssssssssi", $name, $zone, $barangay, $entry_date, $city, $province, $lcp, $contact_number, $nap, $price, $satisfied, $locked_in, $others_not_signing_up, $pldt_existing, $pldt_sales_new, $pldt_sales_switch, $globe_existing, $globe_sales_new, $globe_sales_switch, $converge_existing, $converge_sales_new, $converge_sales_switch, $no_providers_existing, $no_providers_sales_new, $no_providers_sales_switch, $unengaged_existing, $unengaged_sales_new, $unengaged_sales_switch, $other_prov, $id);

        
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
            <th>SALES NEW</th>
            <th>SALES SWITCH</th>
        </tr>
        <tr>
            <td>PLDT:</td>
            <td>
                <select name="pldt_existing">
                   <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </td>
            <td>
                <select name="pldt_sales_new">
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </td>
            <td>
                <select name="pldt_sales_switch">
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>GLOBE:</td>
            <td>
                <select name="globe_existing">
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </td>
            <td>
                <select name="globe_sales_new">
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </td>
            <td>
                <select name="globe_sales_switch">
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>CONVERGE:</td>
            <td>
                <select name="converge_existing">
                    
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </td>
            <td>
                <select name="converge_sales_new">
                   
                    <option value="No">No</option> 
                    <option value="Yes">Yes</option>
                </select>
            </td>
            <td>
                <select name="converge_sales_switch">
                   
                    <option value="No">No</option> 
                    <option value="Yes">Yes</option>
                </select>
            </td>
        </tr>
        <tr style="display: none">
           <td>OTHERS:</td>
            <td>
                <select name="others_existing">
                    
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </td>
            <td>
                <select name="others_sales_new">
                   
                    <option value="No">No</option> 
                    <option value="Yes">Yes</option>
                </select>
            </td>
            <td>
                <select name="others_sales_switch">
                   
                    <option value="No">No</option> 
                    <option value="Yes">Yes</option>
                </select>
            </td>
        </tr> 
        <tr>
            <td>NO PROVIDERS:</td>
            <td>
                <select name="no_providers_existing">
                   
                    <option value="No">No</option>
                     <option value="Yes">Yes</option>
                </select>
            </td>
            <td>
                <select name="no_providers_sales_new">
                   
                    <option value="No">No</option>
                     <option value="Yes">Yes</option>
                </select>
            </td>
            <td>
                <select name="no_providers_sales_switch">
                    
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>UNENGAGED:</td>
            <td>
                <select name="unengaged_existing">
                    
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </td>
            <td>
                <select name="unengaged_sales_new">
                   
                    <option value="No">No</option>
                     <option value="Yes">Yes</option>
                </select>
            </td>
            <td>
                <select name="unengaged_sales_switch">
                   
                    <option value="No">No</option>
                     <option value="Yes">Yes</option>
                </select>
            </td>
            
      
            </tr>

    <th rowspan="1">OTHER PROVIDERS</th>
    <td>
        <label for="other_provider">OTHER PROVIDER</label>
        <input type="text" id="other_prov" name="other_prov"><br>
    </td>
</tr>
    </table>
    
        </div>
    
        </tr>
    </table>
    </div>

      <center><label for="not_signing_up_reason">IF NOT SIGNING-UP TO PLDT- WHY?</label></center>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
               
            <input type="checkbox" id="price" name="price" value="PRICE"> 
            <label for="price">PRICE:</label>
                </div>
        </div>
                <div class="col-md-4">
                <div class="form-group">
              
            <input type="checkbox" id="satisfied" name="satisfied" value="SATISFIED"> 
             <label for="satisfied">SATISFIED:</label>
                </div>
        </div>
        <div class="col-md-4">
                <div class="form-group">
            
            <input type="checkbox" id="locked_in" name= "locked_in" value="LOCKED_IN"> 
            <label for="locked_in">LOCKED-IN:</label>
                </div>
        </div>
  
            <label for="others_not_signing_up">OTHERS:</label>
            <input type="text" id="others_not_signing_up" name="others_not_signing_up"oninput="this.value = this.value.toUpperCase()">
          
    <label for="other provider">OTHER PROVIDER</label>
    <input type="text" name="other_prov" id="other_prov" value="<?php echo $row['other_prov']; ?>"><br>
    <input type="submit" value="Submit">
</form>

</body>
</html>
