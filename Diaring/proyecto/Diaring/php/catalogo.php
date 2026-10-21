<?php
require "conexion.php";

$busqueda = trim($_GET['q'] ?? '');
$categoria = trim($_GET['categoria'] ?? '');
$tipo = $_GET['tipo'] ?? '';
$condiciones = ["c.estado = 'aprobado'"];
$parametros = [];
$tipos = '';

if ($busqueda !== '') {
    $condiciones[] = '(c.titulo LIKE ? OR c.descripcion LIKE ? OR c.area LIKE ? OR i.nombre LIKE ?)';
    $texto = '%' . $busqueda . '%';
    array_push($parametros, $texto, $texto, $texto, $texto);
    $tipos .= 'ssss';
}

if ($categoria !== '') {
    $condiciones[] = 'c.area = ?';
    $parametros[] = $categoria;
    $tipos .= 's';
}

if ($tipo === 'gratis') {
    $condiciones[] = 'c.certificado_gratis = 1';
} elseif ($tipo === 'pago') {
    $condiciones[] = 'c.certificado_gratis = 0';
}

$sql = "SELECT c.*, i.nombre AS nombre_institucion
    FROM cursos c
        JOIN instituciones i ON c.id_institucion = i.id
        WHERE " . implode(' AND ', $condiciones) . "
        ORDER BY c.id DESC";

$stmt = $conexion->prepare($sql);
if ($parametros) {
    $stmt->bind_param($tipos, ...$parametros);
}
$stmt->execute();
$resultado = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diaring - Catálogo</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main class="main-container">
        <aside class="sidebar" id="panel-filtros">
            <div class="filters-heading">Filtros</div>
                <div class="filters-content">
                    <ul class="sidebar-menu">
                        <li><a href="catalogo.php" class="<?= ($tipo === '' && $categoria === '' && $busqueda === '') ? 'active' : '' ?>">Cursos nuevos</a></li>
                        <li><a href="catalogo.php?tipo=gratis" class="<?= $tipo === 'gratis' ? 'active' : '' ?>">Cursos gratis</a></li>
                    </ul>

                    <h3>Categoria</h3>
                    <ul class="sidebar-categories">
                        <?php foreach (['Quimica', 'Dibujo', 'Idiomas', 'Software', 'Finanzas', 'Marketing', 'Diseño Gráfico', 'Matemáticas', 'Física', 'Biología', 'Filosofía'] as $nombreCategoria): ?>
                            <li><a href="catalogo.php?categoria=<?= rawurlencode($nombreCategoria) ?>" class="<?= $categoria === $nombreCategoria ? 'active' : '' ?>"><?= htmlspecialchars($nombreCategoria) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
        </aside>
        <button type="button" class="filters-toggle" id="alternar-filtros" aria-controls="panel-filtros" aria-expanded="true" aria-label="Ocultar filtros">&lt;</button>

        <section class="catalog-content">
            <h2 class="catalog-title">Cursos <span>nuevos</span></h2>
            <form class="catalog-search" method="get" action="catalogo.php">
                <input type="search" name="q" value="<?= htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8') ?>" placeholder="Buscar cursos, áreas o instituciones..." aria-label="Buscar cursos">
                <?php if ($categoria !== ''): ?><input type="hidden" name="categoria" value="<?= htmlspecialchars($categoria, ENT_QUOTES, 'UTF-8') ?>"><?php endif; ?>
                <?php if ($tipo !== ''): ?><input type="hidden" name="tipo" value="<?= htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8') ?>"><?php endif; ?>
                <button type="submit" class="btn-primary">Buscar</button>
                <?php if ($busqueda !== '' || $categoria !== '' || $tipo !== ''): ?><a class="catalog-clear" href="catalogo.php">Limpiar</a><?php endif; ?>
            </form>
            <?php if (($_GET['mensaje'] ?? '') === 'curso_enviado'): ?>
                <p role="status" style="color: #166534; margin: 12px 0;">Tu curso se guardó y está pendiente de aprobación. Aparecerá en el catálogo cuando un administrador lo apruebe.</p>
            <?php endif; ?>
            <p class="results-count"><?= $resultado->num_rows ?> resultados</p>

            <div class="content-grid">
                <?php while ($curso = mysqli_fetch_assoc($resultado)): ?>
                    <div class="card">
                        <?php
                        $imagenCurso = trim((string) $curso['imagen']);
                        $imagenUrl = $imagenCurso !== ''
                            ? '../uploads/cursos/' . rawurlencode($imagenCurso)
                            : '../assets/IMG/inicio.jpg';
                        ?>
                        <img src="<?= htmlspecialchars($imagenUrl, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($curso['titulo'], ENT_QUOTES, 'UTF-8') ?>">
                        <div class="card-body">
                            <h4><?= htmlspecialchars($curso['titulo'], ENT_QUOTES, 'UTF-8') ?></h4>
                            <span><?= htmlspecialchars($curso['nombre_institucion'], ENT_QUOTES, 'UTF-8') ?></span>
                            <p><?= htmlspecialchars($curso['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
                            <div class="card-hours"><?= $curso['duracion_horas'] ?> horas</div>
                            <div class="card-tags">
                                <span><?= htmlspecialchars($curso['area'], ENT_QUOTES, 'UTF-8') ?></span>
                                <span><?= $curso['certificado_gratis'] ? 'Gratis' : 'Con costo' ?></span>
                            </div>

                            <a href="curso_detalle.php?id=<?= $curso['id'] ?>" class="btn-primary">Acceder</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>
    <script>
    const catalogoMain = document.querySelector('.main-container');
    const alternarFiltros = document.getElementById('alternar-filtros');
    alternarFiltros.addEventListener('click', () => {
        const ocultos = catalogoMain.classList.toggle('filters-collapsed');
        alternarFiltros.textContent = ocultos ? '>' : '<';
        alternarFiltros.setAttribute('aria-expanded', String(!ocultos));
        alternarFiltros.setAttribute('aria-label', ocultos ? 'Mostrar filtros' : 'Ocultar filtros');
    });
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>
