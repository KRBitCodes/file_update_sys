<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Gallery</title>
    <link rel="stylesheet" href="./Assets/Css/App.css">
</head>

<body>
    <div class="wrapper">
        <div class="form-container">
            <form action="./Api/Hook/UploadHk.php" method="post" enctype="multipart/form-data">
                <div class="form-header">
                    <h2>Upload Documents</h2>
                </div>
                <div class="form-control">
                    <input type="text" name="document_title" id="document_title" placeholder="Document Title">
                </div>
                <div class="form-control">
                    <input type="text" name="document_desc" id="document_desc" placeholder="Document Description">
                </div>
                <div class="form-control">
                    <input type="file" name="document_file">
                </div>
                <div class="form-control">
                    <input type="submit" name="uploadDoc" value="Upload Document">
                </div>
            </form>
            <div class="documents-container">
                <div class="documents-header">
                    <h2>Documents Gallery</h2>
                </div>
                <div class="documents">
                    <?php
                    include './Api/View/Documents.php';
                    $documents = new Documents();
                    $documents->fetchDocumnets();
                    ?>
                    </div>
            </div>
        </div>
    </div>
</body>

</html>