<?php
include './Api/Config/DatabaseConfig.php';
class Document extends DatabaseConfig
{
    public function fetchDocument($documentId)
    {
        $fetchstmt = $this->integrate()->prepare('SELECT * FROM `documents` WHERE `documentId` = ?;');
        if (!$fetchstmt->execute([$documentId])) {
            return false;
        }
        if ($fetchstmt->rowCount() > 0) {
            $record = $fetchstmt->fetch(PDO::FETCH_ASSOC);
            return $record;
        } else {
            return ['success' => false, 'message' => ' No Document Found'];
        }
    }
}
