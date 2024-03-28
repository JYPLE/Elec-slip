<?php
session_start();

// Dummy login logic for demonstration purposes
if (isset($_POST['logins.php'])) {
    // Assuming you have a database table named 'agents' with fields 'agent_id' and 'agent_name'
    // This code should be replaced with your actual authentication logic
    $user_id = $_POST['user_id']; // Assuming agent_id is unique for each agent
    $_SESSION['user_id'] = $user_id; // Fixed variable name
    $_SESSION['username'] = getAgentName($user_id); // Function to get agent name from database
    header("Location: ".$_SERVER['PHP_SELF']); // Redirect to refresh the page after login
    exit();
}

function getCurrentAgentName() {
    if (isset($_SESSION['user_id'])) {
        return $_SESSION['username'];
    } else {
        return "Unknown"; // Or handle the case when agent name is not available
    }
}

function getAgentName($user_id) {
    // Query the database to get the agent name associated with the given agent_id
    // Replace this with your actual database query
    // Example: SELECT agent_name FROM agents WHERE agent_id = $user_id
    // Example: Assuming you have a database connection stored in $pdo
    global $pdo; // Added global keyword to use $pdo inside the function
    $stmt = $pdo->prepare("SELECT username FROM user WHERE user_id = ?");
    $stmt->execute([$user_id]); // Fixed variable name
    $row = $stmt->fetch();
    return $row['username'];
    
    // For demonstration purposes, returning a hardcoded agent name
    return "Agent " . $user_id;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CALL - SLIP ENTRIES</title>
    <link rel="stylesheet" href="styles.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<head>
    <title>Call Slip Entries Form with Side Nav</title>
    <style>
        body {
            font-family: "Lato", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #800000;
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #a8e4a0;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 20px;
            color: #800000;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: black;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        .sidenav .logout {
            position: absolute;
            bottom: 20px;
            left: 20px;
        }
        /* Style for logout link */
.sidenav .logout {
  position: absolute;
  bottom: 10px;
  left: 5px;
}


        #main {
            transition: margin-left .5s;
            padding: 16px;
        }

        h2 {
            color: white;
            text-align: center;
            margin-top: 20px;
            
        }

        form {
    width: 10%;
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

label, input[type="text"], input[type="date"], select, input[type="number"] {
    display: block;
    margin: 10px 0;
    width: 100%; /* Full width */
}



input[type="submit"] {
    width: 50%;
    padding: 10px;
    background-color: #4CAF50;
    color: black;
    border: none;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto; /* Center horizontally */
}


input[type="submit"]:hover {
    background-color: #45a049;
    color: black;
    
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
    margin-bottom: 5px;
    color: white;
    background-color: #800000;
    
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
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
<script>
        // JavaScript to handle form submission
        function submitForm() {
            // Add your form submission logic here
            alert('Form submitted successfully!');
        }
    </script>
<body>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <!-- <a href="user_table.php">Agent</a>
    <a href="#">Services</a>
    <a href="#">Clients</a>-->
    <a href="user_entry.php">Table</a> 
    <a href="index.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>
<div id="main">
    <span style="color: white; font-size:20px;cursor:pointer" onclick="openNav()">&#9776;</span>
<h2>CALL - SLIP ENTRIES</h2>

<form action="submit_form.php" method="post">
    <div class="container">
        <?php if (isset($_SESSION['userdata']) && $_SESSION['userdata']['user_role'] == "agent") : ?>
            <div class="form-group">
                <label for="agent">Agent:</label>
                <input type="text" id="agent" name="agent" value="<?php echo $_SESSION['userdata']['username']; ?>" readonly>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <input type="hidden" id="user_id" name="user">
        </div>
        <div class="form-group">
            <input type="hidden" id="id" name="entry_number">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="entry_date">ENTRY DATE:</label>
                    <input type="date" id="entry_date" name="entry_date" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>">
             
                </div>
                <div class="form-group">
                    <label for="name">FULL NAME:</label>
                    <input type="text" id="name" name="name" oninput="this.value = this.value.toUpperCase()">
                </div>
                <div class="form-group">
                    <label for="zone">ZONE:</label>
                    <input type="text" id="zone" name="zone"oninput="this.value = this.value.toUpperCase()">
                </div>
                <div class="form-group">
                    <label for="barangay">BARANGAY:</label>
                    <input type="text" id="barangay" name="barangay"oninput="this.value = this.value.toUpperCase()">
                </div>
                <div class="form-group">
                    <label for="city">MUNICIPALITY/CITY:</label>
                    <input type="text" id="city" name="city"oninput="this.value = this.value.toUpperCase()">
                </div>
                <div class="form-group">
                    <label for="province">PROVINCE:</label>
                    <input type="text" id="province" name="province"oninput="this.value = this.value.toUpperCase()">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lcp">LCP:</label>
                    <input type="text" id="lcp" name="lcp"oninput="this.value = this.value.toUpperCase()">
                </div>
                <div class="form-group">
                    <label for="nap">NAP:</label>
                    <input type="text" id="nap" name="nap"oninput="this.value = this.value.toUpperCase()">
                </div>

                <div class="form-group">
                    <label for="contact_number">CONTACT NUMBER:</label>
                    <input type="number" id="contact_number" name="contact_number">
                </div>
               
                <div class="form-group">
                    <button type="button" id="getLocationBtn" class="btn btn-success">Get Current Location</button>
                </div>
                <div class="form-group">
                    <label for="longitude">Longitude:</label>
                    <input type="number" id="longitude" name="longitude" step="any">
                </div>
                <div class="form-group">
                    <label for="latitude">Latitude:</label>
                    <input type="number" id="latitude" name="latitude" step="any">
                </div>
            </div>
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
            <td>PLDT:</td>
            <td>
                <select name="pldt_existing">
                   <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </td>
            <td>
            <label for=""></label>
            <input type="date" id="other_prov" name="other_prov"><br>
        </td> 
            <td>
                <select name="pldt_sales_new">
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </td>
      
      
            <td>
                <select name="pldt_sales_switch" style="display: none;">
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
            <label for=""></label>
            <input type="date" id="other_prov" name="other_prov"><br>
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
            <label for=""></label>
            <input type="date" id="other_prov" name="other_prov"><br>
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
      
           <tr>

            <th rowspan="2">OTHER PROVIDER</th>
        <td>
            <label for="other_provider"></label>
            <input type="text" id="other_prov" name="other_prov"><br>
        </td> 
        <td>
                <select name="pldt_sales_new">
                   
                    <option value="No">No</option>
                     <option value="Yes">Yes</option>
                </select>
            </td>
            <td>
                <select name="sales_switch">
                   
                    <option value="No">No</option>
                     <option value="Yes">Yes</option>
                </select>
            </td>
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
          
    
  
    <!-- <label for="other provider">OTHER PROVIDER</label>
    <input type="text" id="other_prov" name="other_prov"><br>  -->
   <input type="submit" value="Submit">
</form>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>

    <script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
}
</script>

<script>
            // Check if the browser supports Application Cache
            if ('applicationCache' in window) {
                // Create a new Application Cache object
                var appCache = window.applicationCache;

                // Define the manifest file to cache
                appCache.addEventListener('checking', function() {
                    console.log('Checking for updates...');
                });

                // Define event listeners for various cache events
                appCache.addEventListener('noupdate', function() {
                    console.log('No updates found.');
                });

                appCache.addEventListener('updateready', function() {
                    console.log('An update is available.');
                    appCache.swapCache();
                    location.reload();
                });

                appCache.addEventListener('cached', function() {
                    console.log('Content has been cached.');
                });

                appCache.addEventListener('error', function(e) {
                    console.log('Error occurred:', e);
                });

                // Trigger the update process
                appCache.update();
            }
        </script>
<!-- <script>
    // Function to open Google Maps with provided longitude and latitude
    function openGoogleMaps() {
        var longitude = document.getElementById("longitude").value;
        var latitude = document.getElementById("latitude").value;

        // Construct Google Maps URL with the coordinates
        var mapsURL = "https://www.google.com/maps/search/?api=1&query=" + latitude + "," + longitude;

        // Open Google Maps in a new tab
        window.open(mapsURL, "_blank");
    }

    // Add event listener to the "View Location" button
    document.getElementById("getLocationBtn").addEventListener("click", function() {
        openGoogleMaps();
    });
</script> -->
<script>
    // Function to get current location and populate longitude and latitude fields
    function getCurrentLocation() {
        // Check if Geolocation is supported
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                // Populate longitude and latitude fields with current position
                document.getElementById("longitude").value = position.coords.longitude;
                document.getElementById("latitude").value = position.coords.latitude;
            });
        } else {
            alert("Geolocation is not supported by your browser.");
        }
    }

    // Add event listener to the "Get Current Location" button
    document.getElementById("getLocationBtn").addEventListener("click", function() {
        getCurrentLocation();
    });
</script>
<script>
    // Get today's date
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    var yyyy = today.getFullYear();
    
    today = yyyy + '-' + mm + '-' + dd;
    
    // Set the value of the entry date field to today's date
    document.getElementById('entry_date').value = today;
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

