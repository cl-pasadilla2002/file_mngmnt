<?php 

require_once("include/connection.php");

if (isset($_GET['file_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['file_id']);

    // fetch file to display from database
    $sql = "SELECT * FROM  upload_files WHERE ID=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = '../uploads/' . $file['NAME'];

    if (file_exists($filepath)) {
        // Determine the appropriate content type based on file extension
        $fileExtension = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
        $contentType = '';

        switch ($fileExtension) {
            case 'pdf':
                $contentType = 'application/pdf';
                break;
            case 'doc':
            case 'docx':
                $contentType = 'application/msword';
                break;
            case 'ppt':
            case 'pptx':
                $contentType = 'application/vnd.ms-powerpoint';
                break;
            case 'xls':
            case 'xlsx':
                $contentType = 'application/vnd.ms-excel';
                break;
            case 'odt':
                $contentType = 'application/vnd.oasis.opendocument.text';
                break;
            case 'zip':
                $contentType = 'application/zip';
                break;
            case 'csv':
                $contentType = 'text/csv';
                break;
            case 'dwg':
                $contentType = 'image/vnd.dwg';
                break;
            case 'bak':
                $contentType = 'application/octet-stream';
                break;
            case 'log':
                $contentType = 'text/plain';
                break;
            case 'txt':
                $contentType = 'text/plain';
                break;
            case 'png':
                $contentType = 'image/png';
                break;
            case 'jpeg':
            case 'jpg':
                $contentType = 'image/jpeg';
                break;
            case 'gif':
                $contentType = 'image/gif';
                break;
            default:
                // Add more cases for other file types if needed
                $contentType = 'application/octet-stream';
        }

        // Set appropriate content type header
        header('Content-Type: ' . $contentType);
        header('Content-Disposition: inline; filename="' . basename($filepath) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');

        // Output the file
        readfile($filepath);

        // Increment download count (if needed)
        $newCount = $file['DOWNLOAD'] + 1;
        $updateQuery = "UPDATE upload_files SET DOWNLOAD=$newCount WHERE ID=$id";
        mysqli_query($conn, $updateQuery);
        exit;
    }
}

?>
