<?php
session_start(); // Starting the session at the beginning of the script

include 'connect1.php';

$error_message = "";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Validate user input (example: basic non-empty checks)
    if (empty($name) || empty($password)) {
        $error_message = "Invalid Output.";
    } else {
        // Prepare the query using a prepared statement
        $query = "SELECT * FROM `userlist` WHERE name=? AND password=?";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt, "ss", $name, $password);
            // Execute the prepared statement
            mysqli_stmt_execute($stmt);
            // Get the result set from the prepared statement
            $result = mysqli_stmt_get_result($stmt);

            // Check if a row with matching credentials is found
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result); 
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['artistname'] = $row['artistname'];
                $_SESSION['password'] = $row['password'];
                $_SESSION['image'] = $row['image'];
                
                // Redirect to the user's profile page or other authorized content
                header("Location: profile.php");
                exit();
            } else {
                $error_message = "Wrong Username or Password.";
            }
        } else {
            $error_message = "Oops! Something went wrong. Please try again later.";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            color:white;
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        .col-md-4
        {
          background: linear-gradient(to top, #6699ff 0%, #9900ff 100%);
          border-radius: 40px;
        }
        a{
            text-decoration: none;
            color: white;
        }

    </style>
    
</head>
<body>
<div class="container d-flex justify-content-center pt-5">
    <div class="col-md-4 px-5 py-2">
        <h3 class="mt-5 d-flex justify-content-center">LOGIN</h3>

        <form method="post">

            <div class="form-group my-3">
                <label for="">Username</label>
                <input type="text" name="name" id="" class="form-control"
                placeholder="Enter your username" autocomplete="off"
                required pattern="[A-Za-z0-9]+" required>
            </div>

            <div class="form-group my-3">
                <label for="">Password</label>
                <input type="password" name="password" id="" class="form-control"
                placeholder="Enter your password" autocomplete="off" required>
            </div>

            <div class="btn1 d-flex justify-content-center py-2"> <button type="submit" class="btn btn-primary" name="submit" style="width:100px;">Submit</button></div>
            <hr>
            <div class="d-flex justify-content-center py-1 pb-3"><a href="create.php">Create Account</a></div>
        </form>
    </div>
</div>

</body>
</html>


