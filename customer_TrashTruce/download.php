<?php
// Check if the file parameter is set
if(isset($_GET['file'])) {
    // Get the file name from the URL parameter
    $file = urldecode($_GET['file']);
    
    // Define the path to the file
    $filepath = '../RGuide/' . $file;
    
    // Check if the file exists
    if(file_exists($filepath)) {
        // Set headers for file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf'); // Ensure correct Content-Type for PDF files
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        
        // Clear any output buffers to prevent unwanted output
        ob_clean();
        flush();
        
        // Read the file and output its content
        readfile($filepath);
        exit;
    } else {
        // If the file does not exist, display an error message
        echo "Error: File not found.";
    }
} else {
    // If the file parameter is not set, redirect back to the page
    header('Location: Schedule.php');
    exit;
}
?>