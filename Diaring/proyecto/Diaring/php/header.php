<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$sesionActiva = !empty($_SESSION['user_id']) || !empty($_SESSION['id_usuario']);
$temaUsuario = 'claro';

if ($sesionActiva) {
    require_once __DIR__ . '/conexion.php';
    $usuarioIdTema = (int) ($_SESSION['user_id'] ?? $_SESSION['id_usuario']);
    $stmtTema = $conexion->prepare('SELECT tema FROM usuarios WHERE id = ? LIMIT 1');
    $stmtTema->bind_param('i', $usuarioIdTema);
    $stmtTema->execute();
    $temaUsuario = $stmtTema->get_result()->fetch_assoc()['tema'] ?? 'claro';
    $stmtTema->close();
}

function claseNavActiva(string $archivoActual, string $destino): string
{
    static $seccionPorArchivo = [
        'index.php' => 'index.php',
        'catalogo.php' => 'catalogo.php',
        'curso_detalle.php' => 'catalogo.php',
        'recursos.php' => 'recursos.php',
        'nosotros.php' => 'nosotros.php',
        'crear_curso.php' => 'perfil.php',
        'perfil.php' => 'perfil.php',
        'admin_curso.php' => 'perfil.php',
    ];

    return ($seccionPorArchivo[basename($archivoActual)] ?? null) === $destino ? 'active' : '';
}

$pagina_actual = basename($_SERVER['PHP_SELF']);
?>
<?php if ($temaUsuario === 'neon'): ?>
<script>document.documentElement.dataset.theme = 'neon';</script>
<?php endif; ?>
<header>
    <div class="logo-area">
        <a href="index.php" class="header-brand">
            <img src="../assets/IMG/Logo_de_Diaring.png" alt="Logo de Diaring" class="logo header-logo-light">
            <img src="../assets/IMG/Logo_de_Diaring_Blanco.png" alt="" aria-hidden="true" class="logo header-logo-dark">
        </a>
    </div>
    
    <nav class="main_nav">
        <ul>
            <li><a href="index.php" class="<?= claseNavActiva($pagina_actual, 'index.php') ?>">Inicio</a></li>
            <li><a href="catalogo.php" class="<?= claseNavActiva($pagina_actual, 'catalogo.php') ?>">Catálogo</a></li>
            <li><a href="recursos.php" class="<?= claseNavActiva($pagina_actual, 'recursos.php') ?>">Recursos</a></li>
            <li><a href="nosotros.php" class="<?= claseNavActiva($pagina_actual, 'nosotros.php') ?>">Nosotros</a></li>
            <?php if ($sesionActiva): ?>
                <li><a href="perfil.php" class="<?= claseNavActiva($pagina_actual, 'perfil.php') ?>">Perfil</a></li>
                <li><a href="logout.php" class="nav-login header-auth-action">Cerrar sesión</a></li>
            <?php else: ?>
                <li><a href="registro.php" class="nav-register header-auth-action">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>