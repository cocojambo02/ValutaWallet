
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 800px;
            margin: 0 auto;
        }
        table tr td:last-child{
            white-space: nowrap;
            width: 240px;
        }
        input[type=submit] {
            padding:5px 15px;
            font-size: 14px;
            border:none;
            width:20ex;
            height:10ex;
            outline: none;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Client Details</h2>

                        <a href="logout.php" class="btn btn-danger pull-right">Logout</a>
                    </div>
                    <div class="btn-toolbar">
                        <a href="clients_sorted.php" class="btn mr-3 btn-success pull-right"> Sort Clients alphabetically</a>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Client</a>
                    </div>
                    <br>
                    <div class="btn-toolbar">

                        <form action="" method="POST">
                            <input type = "text" name="name_input" SIZE="30" placeholder="Name" class=" mr-3 hintTextbox">
                            <input type = "text" name="email_input" SIZE="30" placeholder="E-mail" class=" mr-3 hintTextbox">
                            <button type="submit" class="btn btn-success">Search Client</button>
                        </form>
                    </div>
                    <br>

                    <?php

                    session_start();   // in top of PHP file
                    // Include config file
                    require_once "config.php";

                    set_error_handler(function(int $errno, string $errstr) {
                        if ((strpos($errstr, 'Undefined array key') === false) && (strpos($errstr, 'Undefined variable') === false)) {
                            return false;
                        } else {
                            return true;
                        }
                    }, E_WARNING);



                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        $_SESSION["the_name_input"] = NULL;
                        if (isset($_POST['name_input']) and !empty($_POST['name_input'])) {
                            $_SESSION["the_name_input"] = $_POST['name_input'];
                        }
                        $_SESSION["the_email_input"] = NULL;
                        if (isset($_POST['email_input']) and !empty($_POST['email_input'])) {
                            $_SESSION["the_email_input"] = $_POST['email_input'];
                        }

                    }

                    // Attempt select query execution
                    //no input from email and name
                    if(empty(trim($_SESSION["the_email_input"])) and empty(trim($_SESSION["the_name_input"]))){
                        $sql = "SELECT * FROM users";
                        $stmt = $mysqli->prepare($sql);
                    }
                    //input just from name
                    elseif(empty(trim($_SESSION["the_email_input"])) and !empty(trim($_SESSION["the_name_input"]))){
                        $sql = "SELECT * FROM users WHERE name = ?";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("s", $_SESSION["the_name_input"]);
                    }
                    //input just from email
                    elseif(!empty(trim($_SESSION["the_email_input"])) and empty(trim($_SESSION["the_name_input"]))){
                        $sql = "SELECT * FROM users WHERE email = ?";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("s", $_SESSION["the_email_input"]);
                    }
                    //input from both name and input
                    else{
                        $sql = "SELECT * FROM users WHERE name = ? AND email = ?";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("ss", $_SESSION["the_name_input"], $_SESSION["the_email_input"]);
                    }

                    $stmt->execute();

                    if($result = $stmt->get_result()){
                        if($result->num_rows > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>E-mail</th>";
                                        echo "<th>Mobile</th>";
                                        echo "<th>USD</th>";
                                        echo "<th>EUR</th>";
                                        echo "<th>GBP</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_assoc()){
                                    echo "<tr>";
                                        echo "<td>" . $row['uid'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['mobile'] . "</td>";
                                        echo "<td>" . $row['USD'] . "</td>";
                                        echo "<td>" . $row['EUR'] . "</td>";
                                        echo "<td>" . $row['GBP'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $row['uid'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $row['uid'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $row['uid'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
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
            </div>        
        </div>
    </div>
</body>
</html>