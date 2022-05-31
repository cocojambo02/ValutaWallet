<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM users WHERE uid = ?";
    
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            if($result->num_rows == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $name = $row["name"];
                $email = $row["email"];
                $mobile = $row["mobile"];
                $usd = $row["USD"];
                $eur = $row["EUR"];
                $yen = $row["GBP"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    $stmt->close();
    
    // Close connection
    $mysqli->close();
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <br>
                    <div class="form-group">
                        <label>Name</label>
                        <p><b><?php echo $name; ?></b></p>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>E-mail</label>
                        <p><b><?php echo $email; ?></b></p>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Phone number</label>
                        <p><b><?php echo $mobile; ?></b></p>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>USD balance</label>
                        <p><b><?php echo $usd; ?></b></p>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>EUR balance</label>
                        <p><b><?php echo $eur; ?></b></p>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>GBP balance</label>
                        <p><b><?php echo $yen; ?></b></p>
                    </div>
                    <hr>
                    <p><a href="admin_panel.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>