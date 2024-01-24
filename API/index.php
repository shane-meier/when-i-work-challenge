<?php
header('Access-Control-Allow-Origin: *');
echo phpinfo();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    // Upload File incase of failure or later reference
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES['file']['name']);


    // Decode the JSON file and move each employee by EmployeeID into their own arrays
    echo $_SERVER;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        echo json_encode(['success' => true, 'message' => 'File uploaded successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>