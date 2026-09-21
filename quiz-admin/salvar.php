<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enunciado = trim($_POST['enunciado'] ?? '');
    $correta = $_POST['correta'] ?? null;

    // Coleta as 4 alternativas
    $alternativas = [
        $_POST['alternativa_0'] ?? '',
        $_POST['alternativa_1'] ?? '',
        $_POST['alternativa_2'] ?? '',
        $_POST['alternativa_3'] ?? ''
    ];

    // Validação básica do lado do servidor
    if (!empty($enunciado) && $correta !== null) {
        
        // 1. Insere a pergunta
        $stmt = $conn->prepare("INSERT INTO perguntas (enunciado, categoria) VALUES (?, 'Geral')");
        $stmt->bind_param("s", $enunciado);
        
        if ($stmt->execute()) {
            $pergunta_id = $stmt->insert_id;
            $stmt->close();

            // 2. Insere as 4 alternativas associadas à pergunta
            $stmtAlt = $conn->prepare("INSERT INTO alternativas (pergunta_id, texto, is_correta) VALUES (?, ?, ?)");

            foreach ($alternativas as $index => $texto) {
                $is_correta = ($index == $correta) ? 1 : 0;
                $stmtAlt->bind_param("isi", $pergunta_id, $texto, $is_correta);
                $stmtAlt->execute();
            }

            $stmtAlt->close();
        }
    }
}

// Redireciona de volta para a página principal
header("Location: index.php");
exit();
?>