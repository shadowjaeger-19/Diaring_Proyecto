<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diaring - Inicio</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"></link>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- HEADER COMPARTIDO -->
    <?php include 'header.php'; ?>
    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <video autoplay muted loop>
                <source src="../assets/IMG/videoini.mp4" type="video/mp4">
        
            </video>
            <div class="hero-badge">
                ¡Quiero crear mi curso! <a href="crear_curso.php"><span>Conozca más.</span></a>
            </div>
            <div class="hero-content">
                <h2>Encuentra cursos para lo que quieres aprender</h2>
                <p>Explora cursos gratuitos y en promoción de instituciones reconocidas, reunidos en un solo catálogo.</p>
                <div class="hero-buttons">
                    <a href="catalogo.php" class="btn-primary">Explorar catálogo</a>
                    <a href="crear_curso.php" class="btn-secondary">Sugerir un curso</a>
                </div>
            </div>
        </section>
        <section class="catalog-highlights-section">
            <div class="catalog-highlights-text">
                <h2>Un catálogo para aprender <span>a tu manera.</span></h2>
                <p>Compara opciones y encuentra cursos que se ajusten a tus intereses, sin tener que buscar en decenas de plataformas.</p>
                
                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-dot"></div>
                        <div>
                            <h4>Instituciones <span>reconocidas.</span></h4>
                            <p>Encuentra cursos de instituciones educativas y plataformas de aprendizaje en un solo lugar.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-dot"></div>
                        <div>
                            <h4>Busca por <span>tema.</span></h4>
                            <p>Explora áreas de interés y revisa duración, descripción y condiciones del certificado antes de elegir.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-dot"></div>
                        <div>
                            <h4>Sugerencias <span>revisadas.</span></h4>
                            <p>El equipo revisa los cursos propuestos por la comunidad antes de publicarlos en el catálogo.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="catalog-highlights-image">
                <img src="../assets/IMG/inicio.jpg" alt="Graduación y título">
            </div>
        </section>
        <section class="guarantee-section">
            <div class="guarantee-info">
                <h2>Cursos reales, instituciones <span>reconocidas.</span></h2>
                <p>Reunimos opciones educativas y revisamos cada sugerencia antes de que aparezca en el catálogo.</p>
            </div>
            <div class="guarantee-card">
                <h4>Un catálogo cuidado</h4>
                <ul class="guarantee-checks">
                    <li>Información organizada para comparar cursos e instituciones.</li>
                    <li>Revisión del equipo antes de publicar cursos sugeridos.</li>
                </ul>
                <a href="catalogo.php" class="btn-primary" style="width: 100%; text-align: center;">Ver catálogo</a>
            </div>
        </section>
    </main>
<?php include 'footer.php'; ?>