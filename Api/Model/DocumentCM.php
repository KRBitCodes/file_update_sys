<?php
include_once "./../Config/DatabaseConfig.php";
// Defining class for database interaction
class DocumentCM extends DatabaseConfig
{
    protected function openedDocument(
        $document_title,
        $document_desc,
        $document_file,
        $document_type,
        $document_size,
    ) {
        $stashStmt = $this->integrate()->prepare('INSERT INTO `documents` (`documentTitle`, `documentDesc`, `documentFile`, `documentType`, `documentSize`) VALUES (?,?,?,?,?);');
        if (!$stashStmt->execute([$document_title, $document_desc, $document_file, $document_type, $document_size])) {
            return ['success' => false, 'message' => 'Server error'];
        }
        return ['success' => true, 'message' => 'Document uploaded successfully'];
    }
    protected function removeDoc($document_id)
    {
        $remStmt = $this->integrate()->prepare('DELETE FROM `documents` WHERE `documentId` = ?;');
        if (!$remStmt->execute([$document_id])) {
            return [
                'success' => false,
                'message' => 'Delete failed'
            ];
        }
        return [
            'success' => true,
            'message' => 'Delete success'
        ];
    }
    protected function fetchFileName($document_id) {
        $fetchStmt = $this->integrate()->prepare('SELECT `documentFile` FROM `documents` WHERE `documentId`= ?;');
        if(!$fetchStmt->execute([$document_id])) {
            return [
                'success' => false,
                'message' => 'Fetching-error'
            ];
        }
        if($fetchStmt->rowCount() >0) {
            $record = $fetchStmt->fetch(PDO::FETCH_ASSOC);
            return $record['documentFile'];
        }else {
            return ['success' => false, 'message' => 'No Data Available'];
        }
    }

    protected function modifyDocument($document_id, $document_title, $document_desc) {
        $upStmt = $this->integrate()->prepare('UPDATE `documents` SET `documentTitle`=?, `documentDesc`=? WHERE `documentId`=?;');
        if(!$upStmt->execute([$document_title, $document_desc, $document_id])){
            return [
                'success' => false,
                'message' => 'Server_error'
            ];
        }
        return [
            'success' => true,
            'meassage' => 'document_updates'
        ];
    }
}
