<?php
include 'connect1.php';

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    // Get the filename associated with the record from the database
    $sql = "SELECT picture FROM gallery WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $filename = $row['picture'];

        // Delete the record from the database
        $deleteSql = "DELETE FROM gallery WHERE id = $id";
        $deleteResult = mysqli_query($conn, $deleteSql);

        if ($deleteResult) {
            // Delete the image file from the folder
            $filePath = "posting/ " . $filename;
            if (file_exists($filePath)) {
                unlink($filePath); // Delete the file
            }
            //echo "deleted";
           header('location: profile.php');
        } else {
            die(mysqli_error($conn));
        }
    } else {
        // Record not found in the database
        // Handle this case as needed (e.g., display an error message)
    }
}
?>
