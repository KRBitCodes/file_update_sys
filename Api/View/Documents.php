<?php
include './Api/Config/DatabaseConfig.php';
class Documents extends DatabaseConfig
{
    public function fetchDocumnets()
    {
        $fetchStmt = $this->integrate()->prepare('SELECT * FROM `documents` ORDER BY `documentAddedDate` DESC;');
        if (!$fetchStmt->execute()) {
            return [
                'sucess' => false,
                'message' => "Server Error"
            ];
        }
        if ($fetchStmt->rowcount() > 0) {
            while ($record = $fetchStmt->fetch(PDO::FETCH_ASSOC)) {
                echo '
             <div class="document-card">
                        <div class="document-icon">';
                if ($record['documentType'] == "application/pdf") {
                    echo '<img src="./Assets/Imgs/Icons/pdf.png">';
                } else if ($record['documentType'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                    echo '<img src="./Assets/Imgs/Icons/docx.png">';
                } else if ($record['documentType'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
                    echo '<img src="./Assets/Imgs/Icons/xls-file.png">';
                } else if ($record['documentType'] == "application/vnd.ms-excel") {
                    echo '<img src="./Assets/Imgs/Icons/xlsx.png">';
                } 
                echo '
                        </div>
                        <div class="document-info">
                            <p><b>' . $record['documentTitle'] . '</b></p>
                            <p><b>' . $record['documentDesc'] . '</b></p>
                            <p><b>' . $record['documentFile'] . '</b></p>
                            <p><b>' . $record['documentSize'] . '</b></p>
                        </div>
                        <div class="card-buttons">
                            <button><a href="./edit-file.php?eid='.$record['documentId'].'">Edit</a></button>
                            <button><a href="./Api/Hook/UploadHk.php?did='.$record['documentId'].'">Delete</a></button>
                            <button><a href="./Uploads/'.$record['documentFile'].'" download>Download</a></button>
                        </div>
                    </div>
            ';
            }
        } else {
            echo "<p align='center'>No Documents Available</p>";
        }
    }
}
