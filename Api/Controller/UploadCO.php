<?php
include_once "./../Model/DocumentCM.php";
class UploadCO extends DocumentCM
{
    // Defining propertires
    private $documentId;
    private $documentTitle;
    private $documentDesc;
    private $documentFile;
    private $documentName;
    private $documentType;
    private $documentError;
    private $documentSize;
    private $documentTmpName;
    private $destinationDir;
    // Defining Constructor
    public function __construct($documentId, $documentTitle, $documentDesc, $documentFile)
    {
        $this->documentId = $documentId;
        $this->documentTitle = $documentTitle;
        $this->documentDesc = $documentDesc;
        $this->documentFile = $documentFile;
        $this->documentName = $this->documentFile['name'] ?? "";
        $this->documentType = $this->documentFile['type'] ?? "";
        $this->documentError = $this->documentFile['error'] ?? "";
        $this->documentSize = $this->documentFile['size'] ?? "";
        $this->documentTmpName = $this->documentFile['tmp_name'] ?? "";
        $this->destinationDir = "./../../uploads/" . $this->documentName;
    }

    public function introduceDoc()
    {
        if ($this->isEmptyInput() == true) {
            header("Location: ./../../index.php?msg=empty_fields");
            exit();
        }

        if ($this->isUploadOk() == false) {
            header("Location: ./../../index.php?msg=upload_error");
            exit();
        }

        if ($this->isTypeValid() == false) {
            header("Location: ./../../index.php?msg=invalid_type");
            exit();
        }

        if ($this->isSizeValid() == false) {
            header("Location: ./../../index.php?msg=size-error");
            exit();
        }

        if ($this->isFileAlreadyExits() == true) {
            header("Location: ./../../index.php?msg=file_already_exits");
            exit();
        }

        if ($this->isFileMoved() == false) {
            header("Location: ./../../index.php?msg=move_error");
            exit();
        }

        // Add this line
        return $this->openedDocument(
            $this->documentTitle,
            $this->documentDesc,
            $this->documentName,
            $this->documentType,
            $this->documentSize,
        );
    }

    public function eliminateDoc()
    {
        $documentFile = $this->fetchFileName($this->documentId);
        if ($this->isFileUnlinked($documentFile) == false) {
            $response = [
                'success' => false,
                'message' => 'File not Found'
            ];
        }
        $response = $this->removeDoc($this->documentId);
        return $response;
    }

    public function updateDocument()
    {
        if ($this->isEmptyField() == true) {
            header("Location: ./../../edit-file.php?eid=$this->documentId&msg=empty_fields");
            exit();
        }
        $response = $this->modifyDocument($this->documentId, $this->documentTitle, $this->documentDesc);
        return $response;
    }

    private function isFileUnlinked($documentFile)
    {
        if (unlink("./../../Uploads/" . $documentFile)) {
            return true;
        } else {
            return false;
        }
    }
    
    private function isEmptyInput()
    {
        if (empty($this->documentTitle) || empty($this->documentDesc) || empty($this->documentFile)) {
            return true;
        } else {
            return false;
        }
    }

    private function isUploadOk()
    {
        if ($this->documentError > 0) {
            return false;
        } else {
            return true;
        }
    }

    private function isTypeValid()
    {
        if ($this->documentType != "application/pdf" && $this->documentType != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" && $this->documentType != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" && $this->documentType != "application/vnd.ms-excel") {
            return false;
        } else {
            return true;
        }
    }

    private function isSizeValid()
    {
        if ($this->documentSize > 1000000) {
            return false;
        } else {
            return true;
        }
    }

    private function isFileAlreadyExits()
    {
        if (file_exists($this->destinationDir)) {
            return true;
        } else {
            return false;
        }
    }

    private function isFileMoved()
    {
        if (move_uploaded_file($this->documentTmpName, $this->destinationDir)) {
            return true;
        } else {
            return false;
        }
    }

     private function isEmptyField()
    {
        if (empty($this->documentTitle) || empty($this->documentDesc)) {
            return true;
        } else {
            return false;
        }
    }

}
