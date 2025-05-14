<?php
try {
    $db = new SQLite3("database.db");
    $taskID = $_POST["taskID"];
    $taskName = $_POST["taskName"];
    $taskDesc = $_POST["taskDesc"];
    $updates = [];
    $values = [];

    if (!empty($taskName)) {
        $updates[] = 'taskName = :name';
        $values[":name"] = htmlspecialchars($taskName);
    }

    if (!empty($taskDesc)) {
        $updates[] = 'taskDesc = :desc';
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