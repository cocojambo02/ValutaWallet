<?php

    session_start();

    if(isset($_SESSION['user_id']) =="") {
        header("Location: login.php");
    }

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <style>

        .grid-container-element {
            display: grid;
            align-items: center;
            grid-template-columns: 2fr 2fr;
            grid-gap: 20px;
            width: 100%;
        }
        .grid-child-element {
            margin: 20px;
        }
    </style>
    <meta charset="UTF-8">
    <title>User Info Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <br>
    <br>
    <div class="col-md-11 d-flex">

        <h2> &nbsp; &nbsp; &nbsp; &nbsp; Welcome back, <?php echo $_SESSION['user_name']; ?>! &nbsp; &nbsp;</h2>
        <a href="add_finance.php" class="btn ml-auto btn-primary pull-right"><i class="fa fa-plus"></i> Add Finance</a>
        <a href="withdraw_finance.php" class="btn ml-auto btn-primary pull-right"><i class="fa fa-plus"></i> Withdraw Finance</a>

    </div>

    <hr>
    <br>
    <br>
    <div class="grid-container-element">
        <div class="grid-child-element">

            <?php
            // Include config file
            require_once "config.php";


            function currencyConverter($from_currency, $to_currency, $amount) {
                $req_url = 'https://api.exchangerate-api.com/v4/latest/' . $from_currency;
                $response_json = file_get_contents($req_url);

                // Continuing if we got a result
                if(false !== $response_json) {

                    // Try/catch for json_decode operation
                    try {

                        // Decoding
                        $response_object = json_decode($response_json);

                        return round(($amount * $response_object->rates->$to_currency), 2);


                    }
                    catch(Exception $e) {
                        return "Conversion not avalable";
                    }
                }
            }


            $sql = "SELECT * FROM pair";
            $stmt = $mysqli->prepare($sql);
            $stmt->execute();

            if($result = $stmt->get_result()){
                if($result->num_rows > 0){
                    echo '<table class="table table-bordered table-striped">';
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Exchange from</th>";
                    echo "<th>Exchange to</th>";
                    echo "<th>Rate</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>" . $row['from_valuta'] . "</td>";
                        echo "<td>" . $row['to_valuta'] . "</td>";
                        echo "<td>" . currencyConverter($row['from_valuta'], $row['to_valuta'],1) . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    // Free result set
                    $result->free();
                } else{
                    echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close connection
            $mysqli->close();
            ?>
        </div>

        <div class="container grid-child-element .position-r-0">
            <div class="row">

                    <div class="ml-auto col-auto float-child-element">
                        <div class="card " style="width: 20rem;">
                            <div class="card-body">
                                <h5 class="card-title">Name : <?php echo $_SESSION['user_name']?></h5>
                                <p class="card-text">Email : <?php echo $_SESSION['user_email']?></p>
                                <p class="card-text">Mobile : <?php echo $_SESSION['user_mobile']?></p>
                                <p class="card-text">USD Balance : <?php echo $_SESSION['USD']?></p>
                                <p class="card-text">EUR Balance : <?php echo $_SESSION['EUR']?></p>
                                <p class="card-text">GBP Balance : <?php echo $_SESSION['GBP']?></p>

                            </div>
                            <a href="logout.php" class="btn btn-primary pull-right">Logout</a>
                        </div>
                    </div>

            </div>
        </div>
    </div>

</body>
</html>
