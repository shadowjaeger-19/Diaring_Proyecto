<?php
session_start();
require_once __DIR__ . '/conexion.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['id_usuario'])) {
	header('Location: login.php');
	exit;
}

$usuarioId = (int) ($_SESSION['user_id'] ?? $_SESSION['id_usuario']);
$errorBorradoPerfil = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_tema'])) {
	$tema = $_POST['tema'] ?? 'claro';
	if (in_array($tema, ['claro', 'neon'], true)) {
		$stmtTema = $conexion->prepare('UPDATE usuarios SET tema = ? WHERE id = ?');
		$stmtTema->bind_param('si', $tema, $usuarioId);
		$stmtTema->execute();
		$stmtTema->close();
	}
	header('Location: perfil.php');
	exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_nombre'])) {
	$nuevoNombre = trim($_POST['nombre'] ?? '');
	if ($nuevoNombre !== '' && mb_strlen($nuevoNombre) <= 100) {
		$stmtNombre = $conexion->prepare('UPDATE usuarios SET nombre = ? WHERE id = ?');
		$stmtNombre->bind_param('si', $nuevoNombre, $usuarioId);
		$stmtNombre->execute();
		$stmtNombre->close();
		$_SESSION['user_nombre'] = $nuevoNombre;
		header('Location: perfil.php?mensaje=nombre_actualizado');
		exit;
	}
	header('Location: perfil.php?error=nombre');
	exit;
}

// Procesar cambio de foto de perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto_perfil'])) {
	$archivo = $_FILES['foto_perfil'];
	if ($archivo['error'] === UPLOAD_ERR_OK) {
		$extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
		if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
			$carpetaPerfiles = __DIR__ . '/../uploads/perfiles/';
			if (!is_dir($carpetaPerfiles)) {
				mkdir($carpetaPerfiles, 0755, true);
			}
			$nombreFoto = bin2hex(random_bytes(12)) . '.' . $extension;
			if (move_uploaded_file($archivo['tmp_name'], $carpetaPerfiles . $nombreFoto)) {

				$stmtVieja = $conexion->prepare('SELECT foto FROM usuarios WHERE id = ?');
				$stmtVieja->bind_param('i', $usuarioId);
				$stmtVieja->execute();
				$fotoVieja = $stmtVieja->get_result()->fetch_assoc()['foto'] ?? '';
				$stmtVieja->close();

				if ($fotoVieja && str_starts_with($fotoVieja, 'uploads/perfiles/')) {
					$rutaVieja = __DIR__ . '/../' . $fotoVieja;
					if (is_file($rutaVieja)) {
						@unlink($rutaVieja);
					}
				}

				$rutaGuardar = 'uploads/perfiles/' . $nombreFoto;
				$stmt = $conexion->prepare('UPDATE usuarios SET foto = ? WHERE id = ?');
				$stmt->bind_param('si', $rutaGuardar, $usuarioId);
				$stmt->execute();
				$stmt->close();
			}
		}
	}
	header('Location: perfil.php');
	exit;
}

$stmt = $conexion->prepare('SELECT id, nombre, correo, contrasena, foto, rol, tema, fecha_registro FROM usuarios WHERE id = ?');
$stmt->bind_param('i', $usuarioId);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$usuario) {
	session_destroy();
	header('Location: login.php');
	exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrar_perfil'])) {
	$contrasenaActual = $_POST['contrasena_actual'] ?? '';
	if (!password_verify($contrasenaActual, $usuario['contrasena'])) {
		$errorBorradoPerfil = 'La contraseña no coincide. No se borró tu perfil.';
	} else {
		$stmt = $conexion->prepare('DELETE FROM usuarios WHERE id = ?');
		$stmt->bind_param('i', $usuarioId);
		$stmt->execute();
		$stmt->close();

		if (!empty($usuario['foto']) && str_starts_with($usuario['foto'], 'uploads/perfiles/')) {
			$rutaFoto = __DIR__ . '/../' . $usuario['foto'];
			if (is_file($rutaFoto)) {
				@unlink($rutaFoto);
			}
		}

		$_SESSION = [];
		session_destroy();
		header('Location: index.php');
		exit;
	}
}

// Procesar eliminación de un curso propio (cualquier usuario, sin importar el estado del curso)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_curso_id'])) {
	$cursoIdEliminar = filter_input(INPUT_POST, 'eliminar_curso_id', FILTER_VALIDATE_INT);

	if ($cursoIdEliminar) {
		$stmt = $conexion->prepare('SELECT id FROM cursos WHERE id = ? AND id_usuario_creador = ?');
		$stmt->bind_param('ii', $cursoIdEliminar, $usuarioId);
		$stmt->execute();
		$esPropio = $stmt->get_result()->fetch_assoc();
		$stmt->close();

		if ($esPropio) {
			$stmt = $conexion->prepare('DELETE FROM cursos WHERE id = ?');
			$stmt->bind_param('i', $cursoIdEliminar);
			$stmt->execute();
			$stmt->close();
		}
	}
	header('Location: perfil.php');
	exit;
}

$stmt = $conexion->prepare('SELECT c.id, c.titulo, c.imagen, c.estado, c.fecha_creacion, i.nombre AS institucion
	FROM cursos c
	JOIN instituciones i ON i.id = c.id_institucion
	WHERE c.id_usuario_creador = ?
	ORDER BY c.fecha_creacion DESC');
$stmt->bind_param('i', $usuarioId);
$stmt->execute();
$cursos = $stmt->get_result();
$stmt->close();

$foto = '../assets/IMG/ti.png';
if (!empty($usuario['foto'])) {
	$fotoRelativa = ltrim($usuario['foto'], '/');
	if (is_file(__DIR__ . '/../' . $fotoRelativa)) {
		$foto = '../' . $fotoRelativa;
	}
}
function e(string $value): string
{
	return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Mi perfil | Diaring</title>
	<link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
	<?php include 'header.php'; ?>
	<main>
		<section class="progress-page-header">
			<div class="progress-header-content">
				<span>Tu camino de aprendizaje</span>
				<h1>Mi progreso</h1>
				<p>Consulta tu actividad y el estado de los cursos que has sugerido.</p>
			</div>
		</section>

		<section class="profile-page-header">
			<h1>Mi Perfil</h1>
			<p>Gestiona tu aprendizaje y descubre cuánto has avanzado.</p>
		</section>

		<section class="profile-info-card">
			<form method="POST" enctype="multipart/form-data" class="profile-avatar-form">
				<label for="foto_perfil" style="cursor:pointer;" title="Cambiar foto de perfil">
					<div class="profile-avatar"><img src="<?= e($foto) ?>" alt="Foto de <?= e($usuario['nombre']) ?>"></div>
				</label>
				<input type="file" name="foto_perfil" id="foto_perfil" accept=".jpg,.jpeg,.png,.webp" style="display:none;" onchange="this.form.submit()">
			</form>
			<div class="profile-details">
				<div class="profile-name-row">
					<h2><?= e($usuario['nombre']) ?></h2>
					<button type="button" class="profile-name-edit" id="editar-nombre" aria-label="Editar nombre" title="Editar nombre">✏️</button>
				</div>
				<form method="POST" class="profile-name-form" id="formulario-nombre" hidden>
					<label for="nuevo-nombre">Nombre</label>
					<input id="nuevo-nombre" type="text" name="nombre" maxlength="100" value="<?= e($usuario['nombre']) ?>" required>
					<button type="submit" name="guardar_nombre" value="1" class="btn-primary">Guardar</button>
					<button type="button" class="btn-secondary" id="cancelar-nombre">Cancelar</button>
				</form>
				<?php if (($_GET['error'] ?? '') === 'nombre'): ?><p class="profile-delete-error" role="alert">Escribe un nombre válido de hasta 100 caracteres.</p><?php endif; ?>
				<p><?= e($usuario['correo']) ?></p>
				<p>Miembro desde <?= e(date('d/m/Y', strtotime($usuario['fecha_registro']))) ?></p>
				<p>Cursos sugeridos: <?= $cursos->num_rows ?></p>
			</div>
		</section>

		<section class="profile-options-section">
			<div class="profile-options-grid">
				<a href="crear_curso.php" class="profile-option-card"><div class="option-left"><div class="option-info"><h3>Sugerir curso</h3><p>Comparte un curso nuevo</p></div></div><div class="option-arrow">&gt;</div></a>
				<a href="logout.php" class="profile-option-card"><div class="option-left"><div class="option-info"><h3>Cerrar sesión</h3><p>Salir de tu cuenta</p></div></div><div class="option-arrow">&gt;</div></a>
				<?php if ($usuario['rol'] === 'admin'): ?>
				<a href="admin_curso.php" class="profile-option-card"><div class="option-left"><div class="option-info"><h3>Administración</h3><p>Revisar cursos sugeridos</p></div></div><div class="option-arrow">&gt;</div></a>
				<?php endif; ?>
			</div>
		</section>

		<section class="courses-progress-section">
			<div class="section-title-action"><h2>Tus cursos sugeridos</h2><a href="catalogo.php">Ver catálogo →</a></div>
			<div class="progress-courses-grid">
				<?php if ($cursos->num_rows === 0): ?>
					<p>Aún no has sugerido cursos.</p>
				<?php else: ?>
					<?php while ($curso = $cursos->fetch_assoc()): ?>
						<article class="progress-course-card">
							<a class="progress-course-link" href="curso_detalle.php?id=<?= (int) $curso['id'] ?>">
								<img src="<?= e($curso['imagen'] ? '../uploads/cursos/' . $curso['imagen'] : '../assets/IMG/inicio.jpg') ?>" alt="<?= e($curso['titulo']) ?>">
								<div class="progress-course-info">
									<h3><?= e($curso['titulo']) ?></h3>
									<div class="progress-sub"><?= e($curso['institucion']) ?> · <?= e(ucfirst($curso['estado'])) ?></div>
								</div>
							</a>
							<div class="progress-course-actions">
								<a class="btn-secondary" href="crear_curso.php?editar=<?= (int) $curso['id'] ?>">Editar</a>
								<form method="POST" onsubmit="return confirm('¿Eliminar este curso? Esta acción no se puede deshacer.');">
									<input type="hidden" name="eliminar_curso_id" value="<?= (int) $curso['id'] ?>">
									<button type="submit" class="btn-danger">Eliminar</button>
								</form>
							</div>
						</article>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>

			<form method="POST" class="theme-preference-form">
				<fieldset>
					<label class="theme-toggle-option" for="tema-neon">
						<span class="theme-toggle-copy"><strong>Modo oscuro neón</strong><small>Fondo oscuro con acentos brillantes</small></span>
						<input class="theme-toggle-input" type="checkbox" id="tema-neon" name="tema" value="neon" <?= $usuario['tema'] === 'neon' ? 'checked' : '' ?>>
						<span class="theme-toggle-track" aria-hidden="true"><span class="theme-toggle-thumb"></span></span>
					</label>
				</fieldset>
				<button type="submit" name="guardar_tema" value="1" class="btn-primary">Guardar apariencia</button>
			</form>

			<?php if ($errorBorradoPerfil !== ''): ?><p class="profile-delete-error" role="alert"><?= e($errorBorradoPerfil) ?></p><?php endif; ?>
			<button type="button" class="btn-danger profile-delete-trigger" id="abrir-borrado-perfil">Borrar perfil</button>

			<dialog class="delete-profile-dialog" id="dialogo-borrar-perfil">
				<form method="POST" class="delete-profile-form">
					<h2>Borrar perfil</h2>
					<p>Esta acción no se puede deshacer. Tus cursos se conservarán sin autor.</p>
					<label for="contrasena_actual">Confirma tu contraseña actual</label>
					<input id="contrasena_actual" type="password" name="contrasena_actual" autocomplete="current-password" required>
					<div class="delete-profile-actions">
						<button type="button" class="btn-secondary" id="cancelar-borrado-perfil">Cancelar</button>
						<button type="submit" class="btn-danger" name="borrar_perfil" value="1">Borrar definitivamente</button>
					</div>
				</form>
			</dialog>
		</section>
	</main>
	<?php include 'footer.php'; ?>
	<script>
	const dialogoBorrarPerfil = document.getElementById('dialogo-borrar-perfil');
	document.getElementById('abrir-borrado-perfil').addEventListener('click', () => dialogoBorrarPerfil.showModal());
	document.getElementById('cancelar-borrado-perfil').addEventListener('click', () => dialogoBorrarPerfil.close());
	const formularioNombre = document.getElementById('formulario-nombre');
	document.getElementById('editar-nombre').addEventListener('click', () => {
		formularioNombre.hidden = false;
		formularioNombre.querySelector('input').focus();
	});
	document.getElementById('cancelar-nombre').addEventListener('click', () => formularioNombre.hidden = true);
	</script>
</body>
</html>