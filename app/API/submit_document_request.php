<?php
header('Content-Type: application/json');
date_default_timezone_set('Asia/Manila');
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get POST data
        $userId = isset($_POST['userId']) ? intval($_POST['userId']) : null;
        
        // Validate userId
        if (!$userId) {
            throw new Exception('User ID is required');
        }
        
        // Check daily document request limit (4 per day)
        $today = date('Y-m-d');
        $checkLimitSql = "SELECT COUNT(*) FROM document_requests 
                          WHERE userId = :userId 
                          AND DATE(DateRequested) = :today";
        
        $checkStmt = $conn->prepare($checkLimitSql);
        $checkStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $checkStmt->bindParam(':today', $today);
        $checkStmt->execute();
        
        $dailyRequestCount = $checkStmt->fetchColumn();
        
        if ($dailyRequestCount >= 4) {
            throw new Exception('Daily limit reached: You have already submitted 4 document requests today. Please try again tomorrow.');
        }
        
        $documentType = $_POST['documentType'];
        $name = $_POST['name'] ?? '';
        $address = $_POST['address'] ?? '';
        $tin = $_POST['tin'] ?? '';
        $ctc = $_POST['ctc'] ?? '';
        $alias = $_POST['alias'] ?? '';
        $age = isset($_POST['age']) ? intval($_POST['age']) : 0;
        $birthday = $_POST['birthday'] ?? '';
        $placeOfBirth = $_POST['placeOfBirth'] ?? ''; // New field
        $occupation = $_POST['occupation'] ?? '';      // New field
        $lengthOfStay = isset($_POST['lengthOfStay']) ? intval($_POST['lengthOfStay']) : 0;
        $citizenship = $_POST['citizenship'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $civilStatus = $_POST['civilStatus'] ?? '';
        $purpose = $_POST['purpose'] ?? '';
        $status = 'Pending';
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        $dateRequested = date('Y-m-d H:i:s');
        
        $sql = "INSERT INTO document_requests (
            userId, DocumentType, Name, Address, TIN_No, CTC_No, 
            Alias, Age, birthday, PlaceOfBirth, Occupation, LengthOfStay, 
            Citizenship, Gender, CivilStatus, Purpose, Status, Quantity, 
            DateRequested, valid_id, request_picture, rejection_reason
        ) VALUES (
            :userId, :documentType, :name, :address, :tin, :ctc,
            :alias, :age, :birthday, :placeOfBirth, :occupation, :lengthOfStay,
            :citizenship, :gender, :civilStatus, :purpose, :status, :quantity,
            :dateRequested, '', '', ''
        )";

        $stmt = $conn->prepare($sql);
        
        // Bind all parameters
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':documentType', $documentType);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':tin', $tin);
        $stmt->bindParam(':ctc', $ctc);
        $stmt->bindParam(':alias', $alias);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        $stmt->bindParam(':birthday', $birthday);
        $stmt->bindParam(':placeOfBirth', $placeOfBirth); // New binding
        $stmt->bindParam(':occupation', $occupation);      // New binding
        $stmt->bindParam(':lengthOfStay', $lengthOfStay, PDO::PARAM_INT);
        $stmt->bindParam(':citizenship', $citizenship);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':civilStatus', $civilStatus);
        $stmt->bindParam(':purpose', $purpose);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':dateRequested', $dateRequested);

        if ($stmt->execute()) {
            $requestId = $conn->lastInsertId();
            echo json_encode([
                'success' => true,
                'message' => 'Document request submitted successfully',
                'requestId' => $requestId
            ]);
        } else {
            throw new Exception("Database error: " . implode(", ", $stmt->errorInfo()));
        }
    } catch (Exception $e) {
        error_log("Error in document request: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Error submitting request: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}