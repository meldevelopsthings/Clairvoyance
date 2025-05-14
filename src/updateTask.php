<?php
try {
    $input = json_decode(file_get_contents("php://input"), true);
    $db = new SQLite3("database.db");
    $taskID = $input["taskID"];
    $taskName = $input["taskName"];
    $taskDesc = $input["taskDesc"];
    $updates = [];
    $values = [];

    if (!empty($taskName)) {
        $updates[] = 'taskName = :name';
        $values[":name"] = htmlspecialchars($taskName);
    }

    if (!empty($taskDesc)) {
        $updates[] = 'description = :desc';
        $values[":desc"] = htmlspecialchars($taskDesc);
    }

    if (empty($updates)) {
        echo json_encode(["success" => false, "message" => "No changes provided"]);
        exit;
    }

    $stmt = $db->prepare("UPDATE tasks SET " . implode(', ', $updates) . " WHERE taskID = :id");

    foreach ($values as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(":id",$taskID);

    if($stmt->execute()) {
        if ($db->changes() > 0) {
            echo json_encode(["success" => true, "message" => "Task updated"]);
        }
    }

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
}
?>