<?php
include 'connect1.php';
session_start();

if (!isset($_SESSION['id'])) {
    // Redirect the user back to the login page or perform any other action
    header("Location: login.php");
    exit();
}
$id = $_SESSION['id'];

if ($_SESSION['id'] !== 1) {
  // Redirect the user to another page or display an error message
  header("Location: unauthorized.php");
  exit();
}

// Your database connection and other session checks, if any

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $artist = $_POST['artistname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $image = ''; // Default value for image

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target_dir = "upload/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        // Use the default profile picture if no image was uploaded
        $image = 'default.png';
    }


    // Database Insertion
    $sql = "INSERT INTO `userlist` (name,artistname,email,password,image)
            VALUES ('$name', '$artist', '$email', '$password', '$image')";

    // Execute the query    
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Success: Redirect to the list.php page or any other page you want
        header('location: list.php');
        exit();
    } else {
        die(mysqli_error($conn));
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
        .col-md-5
        {
            background: linear-gradient(to top, #6699ff 0%, #9900ff 100%);
            border-radius: 40px;
        }
        a{
            text-decoration: none;
            color: white;
        }
        .password-container {
            position: relative;
        }

        .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: gray;
        }

    </style>
    
</head>
<body>
<div class="container d-flex justify-content-center pt-5">
    <div class="col-md-5 py-3 px-5">
        <div class="img1 d-flex justify-content-center"><img src="Sauce/logo.png" style="width:100px;"></div>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group my-2">
                <label for="">Username</label>
                <input type="text" id="" class="form-control"
                placeholder="Enter your username" name="name" autocomplete="off" 
                required pattern="[A-Za-z0-9]+" required>
            </div>

            <div class="form-group my-2">
                <label for="">Email</label>
                <input type="email" name="email" id="" class="form-control"
                placeholder="Enter your email" autocomplete="off" required>
            </div>

            <div class="form-group my-2">
                <label for="">Artist Name</label>
                <input type="text" name="artistname" id="" class="form-control"
                placeholder="Enter your artist name" autocomplete="off" required>
            </div>

            <div class="form-group my-2">
                <label for="">Password</label>
                <div class="password-container">
                <input type="password" name="password" id="password" class="form-control"
                placeholder="Enter your password" autocomplete="off" required>
                <span class="password-toggle" onclick="togglePasswordVisibility()">
                <img id="eyeIconImg" src="Sauce/eye3.png" alt="See Password" height="30">
                </div>
            </div>

            <div class="form-group my-2">
                <label for="">Image</label>
                <input type="file" name="image" id="" class="form-control" required>
            </div>
 
            <div class="btn1 my-4">
            
                <button type="submit" class="btn btn-primary" 
            name="submit" style="width:100px;">Submit</button>

            <button type="submit" class="btn btn-primary" 
            name="submit" style="width:100px;"><a href="list.php">Back</a></button>
        </div>
        </form>

  </div>
</div>

<script>
function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const eyeIconImg = document.getElementById('eyeIconImg');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIconImg.src = 'Sauce/eye4.png'; // Show the open eye icon image
        eyeIconImg.alt = 'Hide Password';
    } else {
        passwordField.type = 'password';
        eyeIconImg.src = 'Sauce/eye3.png'; // Show the crossed eye icon image
        eyeIconImg.alt = 'See Password';
    }
}
</script>
</body>
</html>


