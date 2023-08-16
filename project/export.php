<?php
include 'connect1.php'; // Make sure to include the database connection file.

// Fetch data from the database
$sql = "SELECT * FROM `userlist`";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Create a file pointer (output stream) for the CSV file
    $file = fopen('users_data.csv', 'w');

    // Add the CSV headers
    fputcsv($file, array('ID', 'Name', 'Email', 'Phone', 'Password'));

    // Loop through the data and write to the CSV file
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($file, $row);
    }

    // Close the file pointer
    fclose($file);

    // Set the appropriate headers for the downloadable CSV file
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="users_data.csv"');

    // Output the contents of the CSV file
    readfile('users_data.csv');

    // Delete the temporary CSV file
    unlink('users_data.csv');
} else {
    echo "Failed to fetch data from the database.";
}
?>