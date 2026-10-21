<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$sesionActiva = !empty($_SESSION['user_id']) || !empty($_SESSION['id_usuario']);


$pagina_actual = basename($_SERVER['PHP_SELF']); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diaring - Recursos</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <!-- Cabecera de la sección -->
        <div class="resources-page-header">
            <div class="resources-header-content">
                <span>Centro de Recursos</span>
                <h1>Herramientas y recursos para tu día a día</h1>
                <p>Todo lo que necesitas para estudiar mejor, organizarte y resolver tareas más rápido.</p>
            </div>
        </div>
        <section class="resources-section">
            <section class="resources-section">
    <div class="resources-grid">
        <a href="https://www.desmos.com/scientific?lang=es" target="_blank">
            <div class="resource-card">
                <div class="resource-card-left">
                    <div class="resource-icon-box bg-green">
                        <img src="../assets/IMG/re1.png" alt="Calculadora Científica">
                    </div>
                    <div class="resource-info">
                        <h3>Calculadora Científica</h3>
                        <p>Realiza operaciones, conversiones y cálculos científicos de forma rápida y sencilla.</p>
                    </div>
                </div>
                <div class="resource-arrow">&gt;</div>
            </div>
        </a>

        <a href="https://www.ilovepdf.com/es" target="_blank">
            <div class="resource-card">
                <div class="resource-card-left">
                    <div class="resource-icon-box bg-purple">
                        <img src="../assets/IMG/re4.png" alt="Documentos">
                    </div>
                    <div class="resource-info">
                        <h3>Documentos</h3>
                        <p>Convierte, edita y gestiona archivos en diferentes formatos.</p>
                    </div>
                </div>
                <div class="resource-arrow">&gt;</div>
            </div>
        </a>

        <a href="https://unab.edu.co/las-14-mejores-bibliotecas-virtuales/" target="_blank">
            <div class="resource-card">
                <div class="resource-card-left">
                    <div class="resource-icon-box bg-orange">
                        <img src="../assets/IMG/re2.png" alt="Bibliotecas">
                    </div>
                    <div class="resource-info">
                        <h3>Bibliotecas</h3>
                        <p>Recomendaciones para acceder a miles de libros, artículos y recursos académicos gratuitos.</p>
                    </div>
                </div>
                <div class="resource-arrow">&gt;</div>
            </div>
        </a>

        <a href="https://www.canva.com/templates" target="_blank">
            <div class="resource-card">
                <div class="resource-card-left">
                    <div class="resource-icon-box bg-pink">
                        <img src="../assets/IMG/re4.png" alt="Plantillas">
                    </div>
                    <div class="resource-info">
                        <h3>Plantillas</h3>
                        <p>Descarga formatos listos para hacer resúmenes, mapas y guías de estudio.</p>
                    </div>
                </div>
                <div class="resource-arrow">&gt;</div>
            </div>
        </a>

        <a href="https://slack.com/intl/es-es/blog/productivity/las-20-mejores-herramientas-con-ia-para-estudiantes" target="_blank">
            <div class="resource-card">
                <div class="resource-card-left">
                    <div class="resource-icon-box bg-blue">
                        <img src="../assets/IMG/re3.png" alt="Herramientas IA">
                    </div>
                    <div class="resource-info">
                        <h3>Herramientas IA</h3>
                        <p>Propuestas para mejorar tus textos, generar ideas y resolver dudas con inteligencia artificial.</p>
                    </div>
                </div>
                <div class="resource-arrow">&gt;</div>
            </div>
        </a>

        <a href="https://www.larksuite.com/es_mx/blog/goal-tracking-software" target="_blank">
            <div class="resource-card">
                <div class="resource-card-left">
                    <div class="resource-icon-box bg-purple">
                        <img src="../assets/IMG/re5.png" alt="Organización">
                    </div>
                    <div class="resource-info">
                        <h3>Organización</h3>
                        <p>Opciones para planificar tu tiempo, establecer metas y manter el enfoque en tus objetivos.</p>
                    </div>
                </div>
                <div class="resource-arrow">&gt;</div>
            </div>
        </a>
    </div>
</section>
    </main>
<?php include 'footer.php'; ?>
</body>
</html>