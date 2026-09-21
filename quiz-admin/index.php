<?php
require_once 'db.php';

// Consulta para buscar as perguntas com a alternativa correta
$query = "
    SELECT p.id, p.enunciado, a.texto AS resposta_correta
    FROM perguntas p
    LEFT JOIN alternativas a ON p.id = a.pergunta_id AND a.is_correta = 1
    ORDER BY p.id DESC
";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Quiz</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- NAVBAR CORPORATIVA -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
                <i class="bi bi-patch-question-fill text-primary fs-3"></i>
                <span>QuizCorp Admin</span>
            </a>
        </div>
    </nav>

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="container my-5 flex-grow-1">
        <div class="row">
            <div class="col-12 mb-4">
                <h2 class="fw-bold text-secondary">Gestão de Perguntas e Respostas</h2>
                <p class="text-muted">Cadastre, visualize e gerencie o banco de perguntas do seu Quiz.</p>
            </div>
        </div>

        <!-- FORMULÁRIO DE CADASTRO -->
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-header bg-primary text-white fw-semibold">
                <i class="bi bi-plus-circle me-1"></i> Cadastrar Nova Pergunta
            </div>
            <div class="card-body p-4">
                <form id="quizForm" method="POST" action="salvar.php" novalidate>
                    <div class="mb-3">
                        <label for="enunciado" class="form-label font-weight-bold">Enunciado da Pergunta *</label>
                        <textarea class="form-control" id="enunciado" name="enunciado" rows="2" placeholder="Ex: Qual é a capital do Brasil?" required></textarea>
                        <div class="invalid-feedback">Por favor, digite o enunciado da pergunta.</div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Alternativa 1 *</label>
                            <input type="text" class="form-control" name="alternativa_0" placeholder="Primeira opção" required>
                            <div class="invalid-feedback">Preencha esta alternativa.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alternativa 2 *</label>
                            <input type="text" class="form-control" name="alternativa_1" placeholder="Segunda opção" required>
                            <div class="invalid-feedback">Preencha esta alternativa.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alternativa 3 *</label>
                            <input type="text" class="form-control" name="alternativa_2" placeholder="Terceira opção" required>
                            <div class="invalid-feedback">Preencha esta alternativa.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alternativa 4 *</label>
                            <input type="text" class="form-control" name="alternativa_3" placeholder="Quarta opção" required>
                            <div class="invalid-feedback">Preencha esta alternativa.</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="correta" class="form-label">Selecione qual é a Alternativa Correta *</label>
                        <select class="form-select" id="correta" name="correta" required>
                            <option value="" selected disabled>Escolha a alternativa correta...</option>
                            <option value="0">Alternativa 1</option>
                            <option value="1">Alternativa 2</option>
                            <option value="2">Alternativa 3</option>
                            <option value="3">Alternativa 4</option>
                        </select>
                        <div class="invalid-feedback">Selecione qual das alternativas é a resposta correta.</div>
                    </div>

                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="bi bi-check-lg me-1"></i> Salvar Pergunta
                    </button>
                </form>
            </div>
        </div>

        <!-- TABELA DE PERGUNTAS CADASTRADAS -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-dark text-white fw-semibold">
                <i class="bi bi-list-check me-1"></i> Perguntas Cadastradas
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10%"># ID</th>
                                <th style="width: 50%">Enunciado</th>
                                <th style="width: 25%">Resposta Correta</th>
                                <th style="width: 15%" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong>#<?php echo $row['id']; ?></strong></td>
                                        <td><?php echo htmlspecialchars($row['enunciado']); ?></td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                <?php echo htmlspecialchars($row['resposta_correta'] ?? 'Não informada'); ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="deletar.php?id=<?php echo $row['id']; ?>" 
                                               class="btn btn-outline-danger btn-sm"
                                               onclick="return confirm('Tem certeza que deseja excluir esta pergunta?');">
                                                <i class="bi bi-trash"></i> Excluir
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Nenhuma pergunta cadastrada até o momento.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- RODAPÉ CORPORATIVO -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <div class="container">
            <small>© 2026 QuizCorp System — Todos os direitos reservados.</small>
        </div>
    </footer>

    <!-- Scripts JavaScript e Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/validation.js"></script>
</body>
</html>