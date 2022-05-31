<?php
session_start();
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $email = $mobile =$USD = $EUR = $GBP = $password = "";
$name_err = $email_err = $mobile_err = $usd_err = $eur_err = $gbp_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }

    // Validate email address
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an email address.";
    } elseif(!filter_var($input_email, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/")))){
        $email_err = "Please enter a valid email address.";
    }else{
        $email = $input_email;
    }

    // Validate mobile
    $input_mobile = trim($_POST["mobile"]);
    if(empty($input_mobile)){
        $mobile_err = "Please enter the phone number.";
    } elseif(!filter_var($input_mobile, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/(\+\d{1,3}\s?)?((\(\d{3}\)\s?)|(\d{3})(\s|-?))(\d{3}(\s|-?))(\d{4})(\s?(([E|e]xt[:|.|]?)|x|X)(\s?\d+))?/")))){
        $mobile_err = "Please enter an existing phone value.";
    } else{
        $mobile = $input_mobile;
    }

    // Validate eur
    $input_eur = trim($_POST["eur"]);
    if(empty($input_eur)){
        $eur_err = "Please enter the EUR value.";
    } elseif(!filter_var($input_eur, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[+-]?([0-9]*[.])?[0-9]+/")))){
        $eur_err = "Please enter a valid EUR value.";
    } else{
        $EUR = $input_eur;
    }

    // Validate usd
    $input_usd = trim($_POST["usd"]);
    if(empty($input_usd)){
        $usd_err = "Please enter the USD value.";
    } elseif(!filter_var($input_usd, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[+-]?([0-9]*[.])?[0-9]+/")))){
        $usd_err = "Please enter a valid USD value.";
    } else{
        $USD = $input_usd;
    }

    // Validate yen
    $input_yen = trim($_POST["gbp"]);
    if(empty($input_yen)){
        $gbp_err = "Please enter the GBP value.";
    } elseif(!filter_var($input_yen, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[+-]?([0-9]*[.])?[0-9]+/")))){
        $gbp_err = "Please enter a valid GBP value.";
    } else{
        $GBP = $input_yen;
    }

    //validate password
    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Please enter a password.";
    } else{
        $password = $input_password;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($mobile_err) && empty($usd_err) && empty($eur_err) && empty($gbp_err) && empty($password_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO users (name, email, mobile, EUR, USD, GBP, password, admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
 
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $param_admin = "admin@admin";
            $stmt->bind_param("ssssssss", $param_name, $param_email, $param_mobile, $param_eur, $param_usd, $param_yen, $param_password, $_SESSION['admin_email']);
            
            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_mobile = $mobile;
            $param_eur = $EUR;
            $param_usd = $USD;
            $param_yen = $GBP;
            $param_password = md5($password);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: admin_panel.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Phone number</label>
                            <input type="text" name="mobile" class="form-control <?php echo (!empty($mobile_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mobile; ?>">
                            <span class="invalid-feedback"><?php echo $mobile_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>EUR</label>
                            <input type="text" name="eur" class="form-control <?php echo (!empty($eur_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $EUR; ?>">
                            <span class="invalid-feedback"><?php echo $eur_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>USD</label>
                            <input type="text" name="usd" class="form-control <?php echo (!empty($usd_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $USD; ?>">
                            <span class="invalid-feedback"><?php echo $usd_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>GBP</label>
                            <input type="text" name="gbp" class="form-control <?php echo (!empty($gbp_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $GBP; ?>">
                            <span class="invalid-feedback"><?php echo $gbp_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="admin_panel.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>