<?php
include 'connect1.php';
session_start();

if (!isset($_SESSION['id'])) {
    // Redirect the user back to the login page or perform any other action
    header("Location: login.php");
    exit();
}
$id = $_SESSION['id'];


// Your database connection and other session checks, if any

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $about = $_POST['about'];
    $image = ''; // Default value for image

    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        // Image Upload
        $picture = $_FILES['picture']['name'];
        $target_dir = "posting/ "; // Specify the target directory where images will be uploaded
        $target_file = $target_dir . basename($picture);
        $pictureFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Valid image extensions
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");

        if (!in_array($pictureFileType, $allowedExtensions)) {
            echo "Invalid image format. Allowed formats: jpg, jpeg, png, gif";
            exit();
        }

        move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file);
    }

    // Database Insertion
    $sql = "INSERT INTO `gallery` (title,about,picture)
            VALUES ('$title', '$about', '$picture')";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Success: Redirect to the list.php page or any other page you want
        header('location: profile.php');
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
        <div class="d-flex justify-content-center"><h3>POSTING</h3></div>
        
        <form method="post" enctype="multipart/form-data">
            <div class="form-group my-2">
                <label for="">Title</label>
                <input type="text" id="" class="form-control"
                placeholder="Enter your username" name="title" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">About</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="about" rows="3"></textarea>
            </div>


            <div class="form-group my-2">
                <label for="">Image</label>
                <input type="file" name="picture" id="" class="form-control" required>
            </div>
 
            <div class="btn1 my-4">
            
                <button type="submit" class="btn btn-primary" 
            name="submit" style="width:100px;">Submit</button>

            <button type="submit" class="btn btn-primary" 
            name="submit" style="width:100px;"><a href="profile.php">Back</a></button>
        </div>
        </form>

  </div>
</div>
</body>
</html>


