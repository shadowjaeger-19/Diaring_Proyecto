<?php
session_start();
require_once "conexion.php";
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($usuario === '' || $password === '') {
        header("Location: login.php?error=1");
        exit();
    }
 
    $sql = "SELECT id, nombre, correo, contrasena, rol FROM usuarios 
            WHERE correo = ? OR nombre = ? LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $user = $resultado->fetch_assoc();

    if (!$user) {
        header('Location: login.php?error=cuenta_no_existe');
        exit();
    }

    if (password_verify($password, $user['contrasena'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['id_usuario'] = $user['id'];
        $_SESSION['user_nombre'] = $user['nombre'];
        $_SESSION['user_rol'] = $user['rol'];
        header("Location: perfil.php");
        exit();
    } else {
        header('Location: login.php?error=credenciales');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diaring - Iniciar sesión</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main class="auth-section">
        <div class="auth-container">
            <div class="auth-form-wrapper">
                <h2>Bienvenido de <span>nuevo</span></h2>
                <p class="auth-subtitle">Inicia sesión para continuar explorando cursos.</p>
                <?php if (($_GET['error'] ?? '') === 'cuenta_no_existe'): ?>
                    <p class="auth-error" role="alert" style="color: #b91c1c;">Esa cuenta no existe. Verifica tu correo o regístrate.</p>
                <?php elseif (($_GET['error'] ?? '') === 'credenciales' || ($_GET['error'] ?? '') === '1'): ?>
                    <p class="auth-error" role="alert" style="color: #b91c1c;">La contraseña es incorrecta. Inténtalo de nuevo.</p>
                <?php endif; ?>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="usuario">Correo electrónico o nombre de usuario</label>
                        <input id="usuario" type="text" name="usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" name="password" required>
                    </div>
                    <button type="submit" class="btn-auth">Iniciar sesión</button>
                </form>
                <div class="auth-link">
                    ¿No te has registrado? <a href="registro.php">Regístrate aquí</a>
                </div>
            </div>
            <div class="auth-image-wrapper">
                <img src="../assets/IMG/i.png" alt="Graduados celebrando">
                <div class="auth-image-copy">
                    <span>DIARING · APRENDIZAJE</span>
                    <h2>Un curso nuevo puede abrirte caminos.</h2>
                    <p>Descubre cursos de instituciones reconocidas, reunidos en un solo catálogo.</p>
                </div>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
    
</body>
</html>