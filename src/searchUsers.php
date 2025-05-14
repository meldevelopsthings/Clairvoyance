<?php
    $db = new SQLite3("database.db");

    header('Content-Type: application/json');

    $term = $_GET["term"] ?? '';

    if(empty($term)) {
        echo json_encode([]);
        exit;
    }
    
    try {
        $stmt = $db->prepare("SELECT username FROM userAccounts WHERE username LIKE :term COLLATE NOCASE");
        $term = "%$term%";
        $stmt->bindValue(":term", $term, SQLITE3_TEXT);
        $result = $stmt->execute();
    
        $users = [];
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $users[] = $row["username"];
        }
    
        echo json_encode($users);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
        exit;
    };    
?>