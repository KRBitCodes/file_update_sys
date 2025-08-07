<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit File</title>
</head>

<body>
    <?php
    if (!isset($_GET['eid'])) {
    } else {
        $document_id = $_GET['eid'];
        include './Api/View/Document.php';
        $document = new Document();
        $documentData = $document->fetchDocument($document_id);
        // print_r($documentData);
    }
    ?>
    <div class="wrapper">
        <div class="form-container">
            <form action="./Api/Hook/UploadHk.php" method="post" enctype="multipart/form-data">
                <div class="form-header">
                    <h2>Upload Documents</h2>
                </div>
                <div class="form-control">
                    <input type="hidden" name="documentId" value="<?php echo $documentData['documentId']; ?>">
                </div>
                <div class="form-control">
                   <input type="text" name="document_title" value="<?php echo $documentData['documentTitle']; ?>"> 
                </div>
                <div class="form-control">
                    <input type="text" name="document_desc" id="document_desc" value="<?php echo $documentData['documentDesc']; ?>">
                </div>
                <div class="form-control">
                    <input type="submit" name="updateDoc" value="Update Document">
                </div>
            </form>
        </div>
    </div>
</body>

</html>+