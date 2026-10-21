<?php
require "conexion.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    http_response_code(404);
    exit('Curso no encontrado.');
}

$stmt = $conexion->prepare("SELECT c.*, i.nombre AS nombre_institucion
    FROM cursos c
    JOIN instituciones i ON c.id_institucion = i.id
    WHERE c.id = ? AND c.estado = 'aprobado'");
$stmt->bind_param('i', $id);
$stmt->execute();
$curso = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$curso) {
    http_response_code(404);
    exit('Curso no encontrado.');
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diaring - <?= htmlspecialchars($curso['titulo']) ?></title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="course-detail">
        <?php
        $imagenCurso = trim((string) $curso['imagen']);
        $imagenUrl = $imagenCurso !== ''
            ? '../uploads/cursos/' . rawurlencode($imagenCurso)
            : '../assets/IMG/inicio.jpg';
        ?>
        <section class="course-overview">
            <img src="<?= htmlspecialchars($imagenUrl, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($curso['titulo'], ENT_QUOTES, 'UTF-8') ?>">
            <div class="course-overview-content">
                <h1><?= htmlspecialchars($curso['titulo'], ENT_QUOTES, 'UTF-8') ?></h1>
                <div class="course-meta">
                    <p><strong>Institución</strong><?= htmlspecialchars($curso['nombre_institucion'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Duración</strong><?= $curso['duracion_horas'] ?> horas</p>
                    <p><strong>Área</strong><?= htmlspecialchars($curso['area'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Certificado</strong><?= $curso['certificado_gratis'] ? 'Gratis' : 'Con costo' ?></p>
                </div>
                <a href="<?= htmlspecialchars($curso['link_original'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" class="btn-primary">Ir al curso</a>
            </div>
        </section>

        <section class="course-description">
            <h2>Sobre este curso</h2>
            <p><?= htmlspecialchars($curso['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
        </section>
    </main>

<?php include 'footer.php'; ?>
</body>
</html>