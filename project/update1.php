<?php
include 'connect1.php';
session_start();

if (!isset($_SESSION['id'])) {
    // Redirect the user back to the login page or perform any other action
    header("Location: login.php");
    exit();
}
$id = $_SESSION['id'];

$id = $_GET['updateid'];
$sql = "SELECT * FROM `userlist` WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$email = $row['email'];
$artist = $row['artistname'];
$password = $row['password'];
$oldImage = $row['image']; // Get the old image path

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $artist = $_POST['artistname'];
    $password = $_POST['password'];

    if (!empty($_FILES['image']['name'])) {
        // If a new image is uploaded, move it to the "uploads" folder
        $target_dir = "upload/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

        // Delete the old image if it's not the default image and if it exists
        if ($oldImage !== 'default.jpg' && file_exists("upload/" . $oldImage)) {
            unlink("upload/" . $oldImage);
        }

        // Update the image path in the database with the new image path
        $image = $_FILES['image']['name'];
    } else {
        // If no new image is uploaded, keep the old image path
        $image = $oldImage;
    }

    $sql = "UPDATE `userlist` SET 
            name='$name', email='$email', artistname='$artist', password='$password', image='$image' 
            WHERE id = $id";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        //echo "updated successfully";
        header('location: profile.php');
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
        <div class="container d-flex justify-content-center mt-3"><h3>UPDATE</h3></div>
        <hr>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group my-2">
                <label for="">Username</label>
                <input type="text" id="" class="form-control"
                placeholder="Enter your username" name="name" autocomplete="off" value=<?php echo $name?>>
            </div>

            <div class="form-group my-2">
                <label for="">Email</label>
                <input type="email" name="email" id="" class="form-control"    
                placeholder="Enter your email" autocomplete="off" value=<?php echo $email?>>
            </div>

            <div class="form-group my-2">
                <label for="">Artist Name</label>
                <input type="text" name="artistname" id="" class="form-control"
                placeholder="Enter your artist name" autocomplete="off" value=<?php echo $artist?>>
            </div>

            <div class="form-group my-2">
                <label for="">Password</label>
                <div class="password-container">
                <input type="password" name="password" id="password" class="form-control"
                placeholder="Enter your password" autocomplete="off" required value=<?php echo $password?>>
                <span class="password-toggle" onclick="togglePasswordVisibility()">
                <img id="eyeIconImg" src="Sauce/eye3.png" alt="See Password" height="30">
                </div>
            </div>

            <div class="form-group my-2">
                <label for="">Image</label>
                <input type="file" name="image" id="" class="form-control">
            </div>

            <div class="my-4">
                <button type="submit" class="btn btn-primary" 
            name="submit" style="width:100px;">Submit</button>

            <button type="submit" class="btn btn-primary" 
            name="submit" style="width:100px;"><a href="profile.php">Back</a></button>
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

