<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['user_id']) && !isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$id_usuario_sesion = (int) ($_SESSION['user_id'] ?? $_SESSION['id_usuario']);
$id_curso_edicion = filter_input(INPUT_GET, 'editar', FILTER_VALIDATE_INT) ?: 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['curso_id'])) {
    $id_curso_edicion = filter_var($_POST['curso_id'], FILTER_VALIDATE_INT) ?: 0;
}

$cursoEdicion = null;
if ($id_curso_edicion > 0) {
    $buscar_curso = $conexion->prepare("SELECT c.*, i.nombre AS institucion
        FROM cursos c
        JOIN instituciones i ON i.id = c.id_institucion
        WHERE c.id = ? AND c.id_usuario_creador = ?");
    $buscar_curso->bind_param('ii', $id_curso_edicion, $id_usuario_sesion);
    $buscar_curso->execute();
    $cursoEdicion = $buscar_curso->get_result()->fetch_assoc();
    $buscar_curso->close();

    if (!$cursoEdicion) {
        http_response_code(404);
        exit('Curso no encontrado.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $nombre_institucion = trim($_POST['institucion'] ?? '');
    $duracion = filter_input(INPUT_POST, 'duracion_horas', FILTER_VALIDATE_INT);
    $area = trim($_POST['area'] ?? '');
    $link = trim($_POST['link_original'] ?? '');
    $certificado_gratis = isset($_POST['certificado_gratis']) ? 1 : 0;
    $id_usuario = $id_usuario_sesion;

    if ($titulo === '' || $descripcion === '' || $nombre_institucion === '' || !$duracion || $duracion < 1 || $area === '' || !filter_var($link, FILTER_VALIDATE_URL)) {
        header('Location: crear_curso.php' . ($id_curso_edicion ? '?editar=' . $id_curso_edicion . '&' : '?') . 'error=datos_invalidos');
        exit;
    }

    $imagen = $cursoEdicion['imagen'] ?? '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            header('Location: crear_curso.php' . ($id_curso_edicion ? '?editar=' . $id_curso_edicion . '&' : '?') . 'error=imagen');
            exit;
        }
        $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            header('Location: crear_curso.php' . ($id_curso_edicion ? '?editar=' . $id_curso_edicion . '&' : '?') . 'error=imagen');
            exit;
        }
        $imagen = bin2hex(random_bytes(12)) . '.' . $extension;
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../uploads/cursos/' . $imagen)) {
            header('Location: crear_curso.php' . ($id_curso_edicion ? '?editar=' . $id_curso_edicion . '&' : '?') . 'error=imagen');
            exit;
        }
    }

    $conexion->begin_transaction();
    try {
        $buscar = $conexion->prepare("SELECT id FROM instituciones WHERE LOWER(TRIM(nombre)) = LOWER(?) LIMIT 1");
        $buscar->bind_param('s', $nombre_institucion);
        $buscar->execute();
        $institucion = $buscar->get_result()->fetch_assoc();
        $buscar->close();

        if ($institucion) {
            $id_institucion = (int) $institucion['id'];
        } else {
            $insertar_institucion = $conexion->prepare("INSERT INTO instituciones (nombre) VALUES (?)");
            $insertar_institucion->bind_param('s', $nombre_institucion);
            $insertar_institucion->execute();
            $id_institucion = $insertar_institucion->insert_id;
            $insertar_institucion->close();
        }

        if ($id_curso_edicion > 0) {
            $actualizar_curso = $conexion->prepare("UPDATE cursos SET titulo = ?, descripcion = ?, id_institucion = ?,
                duracion_horas = ?, area = ?, link_original = ?, certificado_gratis = ?, imagen = ?, estado = 'pendiente'
                WHERE id = ? AND id_usuario_creador = ?");
            $actualizar_curso->bind_param('ssiissisii', $titulo, $descripcion, $id_institucion, $duracion, $area, $link, $certificado_gratis, $imagen, $id_curso_edicion, $id_usuario);
            $actualizar_curso->execute();
            $actualizar_curso->close();
        } else {
            $insertar_curso = $conexion->prepare("INSERT INTO cursos
                (titulo, descripcion, id_institucion, duracion_horas, area, link_original, certificado_gratis, imagen, id_usuario_creador, estado)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pendiente')");
            $insertar_curso->bind_param('ssiissisi', $titulo, $descripcion, $id_institucion, $duracion, $area, $link, $certificado_gratis, $imagen, $id_usuario);
            $insertar_curso->execute();
            $insertar_curso->close();
        }

        $conexion->commit();
    } catch (Throwable $error) {
        $conexion->rollback();
        header('Location: crear_curso.php' . ($id_curso_edicion ? '?editar=' . $id_curso_edicion . '&' : '?') . 'error=guardar');
        exit;
    }

    if ($id_curso_edicion > 0) {
        header('Location: perfil.php?mensaje=curso_editado');
    } else {
        header('Location: catalogo.php?mensaje=curso_enviado');
    }
    exit;
}

$existentes = $conexion->query("SELECT nombre FROM instituciones ORDER BY nombre ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diaring - <?= $cursoEdicion ? 'Editar curso' : 'Sugerir curso' ?></title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
<?php include 'header.php'; ?>

    <main class="auth-section">
        <div class="auth-container course-form-container">
            <div class="auth-form-wrapper">
                <h2><?= $cursoEdicion ? 'Edita tu' : 'Sugiere un' ?> <span>curso <?= $cursoEdicion ? 'sugerido' : 'nuevo' ?></span></h2>
                <p class="auth-subtitle"><?= $cursoEdicion ? 'Al guardar, el curso volverá a revisión.' : 'Comparte un curso que valga la pena certificar.' ?></p>

                <?php if (isset($_GET['error'])): ?>
                    <p role="alert" style="color: #b91c1c;">No se pudo guardar. Revisa los datos y vuelve a intentarlo.</p>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <?php if ($cursoEdicion): ?><input type="hidden" name="curso_id" value="<?= (int) $cursoEdicion['id'] ?>"><?php endif; ?>

                    <div class="form-group">
                        <label>Nombre del curso</label>
                        <input type="text" name="titulo" value="<?= htmlspecialchars($cursoEdicion['titulo'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Nombre Institución</label>
                        <input type="text" name="institucion" list="lista-instituciones" value="<?= htmlspecialchars($cursoEdicion['institucion'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                        <datalist id="lista-instituciones">
                            <?php while ($fila = $existentes->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($fila['nombre']) ?>">
                            <?php endwhile; ?>
                        </datalist>
                    </div>

                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="descripcion" required><?= htmlspecialchars($cursoEdicion['descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Duración (horas)</label>
                        <input type="number" name="duracion_horas" min="1" value="<?= (int) ($cursoEdicion['duracion_horas'] ?? '') ?: '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Área/Tema</label>
                        <select name="area" required>
                            <option value="">Selecciona una categoría</option>
                            <?php foreach (['Quimica', 'Dibujo', 'Idiomas', 'Software', 'Finanzas', 'Marketing', 'Diseño Gráfico', 'Matemáticas', 'Física', 'Biología', 'Filosofía'] as $categoria): ?>
                                <option value="<?= htmlspecialchars($categoria, ENT_QUOTES, 'UTF-8') ?>" <?= ($cursoEdicion['area'] ?? '') === $categoria ? 'selected' : '' ?>><?= htmlspecialchars($categoria, ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Link del curso original</label>
                        <input type="url" name="link_original" value="<?= htmlspecialchars($cursoEdicion['link_original'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>

                    <div class="form-group">
                        <label><input type="checkbox" name="certificado_gratis" <?= !$cursoEdicion || $cursoEdicion['certificado_gratis'] ? 'checked' : '' ?>> Certificado gratis</label>
                    </div>

                    <div class="form-group">
                        <label>Imagen del curso</label>
                        <input type="file" name="imagen" accept=".jpg,.jpeg,.png,.webp">
                        <?php if (!empty($cursoEdicion['imagen'])): ?><small>Imagen actual: <?= htmlspecialchars($cursoEdicion['imagen'], ENT_QUOTES, 'UTF-8') ?></small><?php endif; ?>
                    </div>

                    <button type="submit" class="btn-google"><?= $cursoEdicion ? 'Guardar cambios' : 'Enviar' ?></button>
                </form>
            </div>
        </div>
    </main>

<?php include 'footer.php'; ?>

</body>
</html>

