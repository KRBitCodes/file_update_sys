<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "./../Controller/UploadCO.php";
if (!isset($_POST['uploadDoc']) && !isset($_GET['did']) && !isset($_POST['updateDoc'])) {
    exit(json_encode(['success' => false, 'message' => 'Invalid request']));
} else if (isset($_POST['uploadDoc'])) {
    $document_title = $_POST['document_title'];
    $document_desc = $_POST['document_desc'];
    $document_file = $_FILES['document_file'];
    echo "Document Title: $document_title <br>";
    echo "Document Description: $document_desc <br>";
    print_r($document_file);

    $upload = new UploadCO(null, $document_title, $document_desc, $document_file);
    $response = $upload->introduceDoc();

    if ($response['success'] === false) {
        header("Location: ./../../index.php?msg=" . $response['message']);
        exit();
    } else {
        header("Location: ./../../index.php?msg=upload_success");
        exit();
    }
} else if (isset($_GET['did'])) {
    $document_Id = $_GET['did'];
    $deleteDoc = new UploadCO(
        $document_Id,
        null,
        null,
        null
    );
    $res = $deleteDoc->eliminateDoc();
    header("Location: ./../../index.php?msg=" . $res['message']);
} else if (isset($_POST['updateDoc'])) {
    $document_id = $_POST['documentId'];
    $document_title = $_POST['document_title'];
    $document_desc = $_POST['document_desc'];

    $update = new UploadCO(
        $document_id,
        $document_title,
        $document_desc,
        ""
    );
    $res = $update->updateDocument();
    if ($res['success'] == false) {
        header("Location: ./../../edit-file.php?msg=" . $res['message']);
    } else {
        header("Location: ./../../index.php?msg=" . $res['message']);
    }
}
