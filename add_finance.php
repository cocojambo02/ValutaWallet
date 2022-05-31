<?php
    require_once "config.php";
    session_start();

    // Define variables and initialize with empty values
    $USD = $EUR = $GBP = "";
    $usd_err = $eur_err = $gbp_err = "";

    if(isset($_SESSION['user_id']) =="") {
        header("Location: login.php");
    }

    $ok_eur = 0;
    $ok_usd = 0;
    $ok_gbp = 0;

    if($_SERVER["REQUEST_METHOD"] == "POST") {



        // Validate eur
        $input_eur = trim($_POST["eur"]);
        if (empty($input_eur)) {
            $EUR = 0;
            $ok_eur = 1;
        } elseif (!filter_var($input_eur, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^(?!0\d)\d*(\.\d+)?$/")))) {
            $eur_err = "Please enter a valid EUR value.";
        } else {
            $EUR = $input_eur;
            $ok_eur = 1;
        }

        // Validate usd
        $input_usd = trim($_POST["usd"]);
        if (empty($input_usd)) {
            $USD = 0;
            $ok_usd = 1;
        } elseif (!filter_var($input_usd, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^(?!0\d)\d*(\.\d+)?$/")))) {
            $usd_err = "Please enter a valid USD value.";
        } else {
            $USD = $input_usd;
            $ok_usd = 1;
        }

        // Validate gbp
        $input_gbp = trim($_POST["gbp"]);
        if (empty($input_gbp)) {
            $GBP = 0;
            $ok_gbp = 1;
        } elseif (!filter_var($input_gbp, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^(?!0\d)\d*(\.\d+)?$/")))) {
            $gbp_err = "Please enter a valid GBP value.";
        } else {
            $GBP = $input_gbp;
            $ok_gbp = 1;
        }
    }



    // Check input errors before inserting in database
    if(empty($usd_err) || empty($eur_err) || empty($gbp_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET EUR=?, USD=?, GBP=? WHERE uid=?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssi", $param_eur, $param_usd, $param_gbp, $param_id);

            // Set parameters
            $param_eur = strval(intval($EUR) + intval($_SESSION['EUR']));
            $param_usd = strval(intval($USD) + intval($_SESSION['USD']));
            $param_gbp = strval(intval($GBP) + intval($_SESSION['GBP']));
            $param_id = $_SESSION['user_id'];
            $_SESSION['EUR'] = $param_eur;
            $_SESSION['USD'] = $param_usd;
            $_SESSION['GBP'] = $param_gbp;

            // Attempt to execute the prepared statement
            if($stmt->execute() and ($ok_gbp == 1 or $ok_gbp == 1 or $ok_gbp == 1)) {
                // Records created successfully. Redirect to landing page
                header("location: dashboard.php");
                exit();
            }
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $mysqli->close();



?>

<!DOCTYPE html>

<html lang="en">
    <head>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
    <meta charset="UTF-8">
    <title>Add Finance Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

    <br>
    <div class="col-md-11 d-flex">

        <h2> &nbsp; &nbsp; &nbsp; &nbsp; How much do you want to add to wallet? &nbsp; &nbsp;</h2>
        <a href="dashboard.php" class="btn ml-auto btn-primary "> Back </a>

    </div>

    <hr>
    <br>
    <br>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>EUR</label>
                            <input type="text" name="eur" value="0" class="form-control <?php echo (!empty($eur_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $eur_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>USD</label>
                            <input type="text" name="usd" value="0" class="form-control <?php echo (!empty($usd_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $usd_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>GBP</label>
                            <input type="text" name="gbp" value="0" class="form-control <?php echo (!empty($gbp_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $gbp_err;?></span>
                        </div>


                        <input type="submit" class="btn btn-primary" value="Add money securely" data-buttonText="Your label here."/>

                    </form>
                </div>
            </div>
        </div>
    </div>



    <br>
    <br>
</body>
</html>

