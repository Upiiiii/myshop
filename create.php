<?php

use LDAP\Connection;

$servername = "localhost:3307";
$username = "root";
$password = "";
$database = "myshop";

//create conntection
$connection = new mysqli($servername, $username, $password, $database);

$name = "";
$email = "";
$phone = "";
$address = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    do {
        if (empty($name) || empty($email) || empty($phone) || empty($address)) {
            $errorMessage = "All the fields are required";
            break;
        }

        // add new client  to database
        $sql = "INSERT INTO clients (name, email, phone, address) " .
               "VALUES ('$name', '$email', '$phone', '$address')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break; 
        }

        $name = "";
        $email = "";
        $phone = "";
        $address = "";

        $successMessage = "Client added correctly";

        header("location: /myshop/index.php");
        exit;

    } while (false);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h2>New Clients</h2>

        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div> 
            ";
        }
        ?>

        <form method="post">
                <div class="container mt-5">
                <div class="card">
                <div class="card-header">
                Create / Edit Siswa
                </div>
        
                <div class="card-body">
                        <div class="mb-3">
                        <label  class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                        </div>

                        <div class="mb-3">
                        <label  class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" value=" <?php echo $email; ?>">
                        </div>

                        <div class="mb-3">
                        <label  class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" value=" <?php echo $phone; ?>"></input>
                        </div>

                        <div class="mb-3">
                        <label  class="form-label">Address</label>
                        <textarea type="text" class="form-control" name="address" value=" <?php echo $address; ?>"></textarea>
                        </div>


                        <?php
                        if (!empty($successMessage)) {
                            echo "
                            <div class='row mb-3'>
                            <div class='offset-sm-3 col-sm-6'>
                            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div> 
                            </div>
                            </div>
                        ";
                        }
                        ?>
                        <div class="row g-2">
                            <div class="col-6 d-grid">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <div class="col-6 d-grid">
                            <button role="button" class="btn btn-outline-primary" href="/myshop/index.php" >Cancel</button>
                            </div>
                        </div>
                        
                        
                </div>
                </div>
                </div>
        </form>
    </div>
</body>
</html>