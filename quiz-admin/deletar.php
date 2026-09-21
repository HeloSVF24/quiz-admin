<?php
require_once 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM perguntas WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: index.php");
exit();
?>