<?php
// Check if the 'filename' parameter is set in the URL
if (isset($_GET['filename'])) {
    // Sanitize the input to prevent directory traversal
    $filename = basename($_GET['filename']);

    // Set the appropriate content type and headers for download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Specify the directory path where images are stored
    $directory = './Images/';

    // Construct the full file path
    $filePath = $directory . $filename;

    // Check if the file exists
    if (file_exists($filePath)) {
        // Output the file content to the browser
        readfile($filePath);
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request. Filename not provided.";
}

