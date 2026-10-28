-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-10-2026 a las 05:08:44
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `diaring`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `id_institucion` int(11) NOT NULL,
  `duracion_horas` int(11) NOT NULL,
  `area` varchar(100) NOT NULL,
  `link_original` varchar(255) NOT NULL,
  `certificado_gratis` tinyint(1) NOT NULL DEFAULT 1,
  `imagen` varchar(255) NOT NULL,
  `id_usuario_creador` int(11) DEFAULT NULL,
  `estado` enum('pendiente','aprobado','rechazado') NOT NULL DEFAULT 'aprobado',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `titulo`, `descripcion`, `id_institucion`, `duracion_horas`, `area`, `link_original`, `certificado_gratis`, `imagen`, `id_usuario_creador`, `estado`, `fecha_creacion`) VALUES
(8, 'CS50\'s Introduction to Computer Science', 'A broad and robust understanding of computer science and programming\r\n\r\nHow to think algorithmically and solve programming problems efficiently\r\n\r\nConcepts like abstraction, algorithms, data structures, encapsulation, resource management, security, software engineering, and web development\r\n\r\nFamiliarity in a number of languages, including C, Python, SQL, and JavaScript plus CSS and HTML\r\n\r\nHow to engage with a vibrant community of like-minded learners from all levels of experience\r\n\r\nHow to develop and present a final programming project to your peers', 4, 20, 'Software', 'https://www.edx.org/learn/computer-science/harvard-university-cs50-s-introduction-to-computer-scien', 1, 'f997c24e22554d828b48d99e.png', 1, 'aprobado', '2026-09-23 00:01:04'),
(10, 'Curso de artística', 'En este curso de artística aprenderás una serie de técnicas y estrategias para desarrollar díbujos y utilizar el color. También, en este curso de artística aprenderás las técnicas necesarias para pintar con acuarelas, óleo y acrílico.', 6, 12, 'Dibujo', 'https://edutin.com/curso-de-artistica-1390', 1, '', NULL, 'aprobado', '2026-09-23 12:31:45'),
(11, 'Final Markets', 'Una introducción magistral impartida por el Premio Nobel Robert Shiller sobre riesgo, bolsa, banca y crisis. (En inglés con subtítulos).', 7, 50, 'Finanzas', 'https://www.coursera.org/learn/finanzas-personales', 1, '4a2306f4a7259be4e3949476.png', NULL, 'aprobado', '2026-09-23 12:44:49'),
(12, 'Certificación de Fundamentos de Marketing Digital', 'Digital GarageEl clásico para empezar. 40 horas con los conceptos básicos de SEO, SEM, analítica y redes sociales. Avalado por el Interactive Advertising Bureau (IAB).', 8, 40, 'Finanzas', 'https://skillshop.exceedlms.com/student/collection/1830727-fundamentos-de-marketing-digital', 1, '1b230505c9109edd3d6436df.png', NULL, 'aprobado', '2026-09-23 12:50:23'),
(13, 'English for Career Development', 'Diseñado para el mercado laboral global. Te enseña a armar tu CV en inglés, escribir cartas de presentación y simular entrevistas de trabajo.', 9, 15, 'Idiomas', 'https://www.coursera.org/learn/careerdevelopment', 1, '9835b4a1a1d6b5644af3c559.png', NULL, 'aprobado', '2026-09-23 13:06:12'),
(15, 'Leading with Character', 'Un curso excepcional de 30 días, diseñado de forma conjunta por equipos de Oxford y Harvard. accedes directamente en su portal interactivo y se enfoca en tres pilares del liderazgo humano: coraje, propósito y empatía.', 11, 30, 'Liderazgo', 'https://leadingwithcharacter.com/course-overview/course-v1:Legatum+101+2023', 1, '6135039d7f5a5d225251281f.png', NULL, 'aprobado', '2026-09-23 13:25:37'),
(17, 'Meta Certified Digital Marketing Associate', 'El curso oficial para aprender a dominar la publicidad pagada (Ads) en Instagram, Facebook y Messenger desde cero.', 13, 20, 'Finanzas', 'https://web.facebook.com/business/learn?_rdc=1&_rdr#', 1, '', NULL, 'aprobado', '2026-09-23 13:45:38'),
(18, 'BBC Learning English', 'BBC Learning English te ofrece numerosos programas y cursos para ayudarte a aprender inglés. Publicamos nuevos programas todos los días laborables. ¡Suscríbete a nuestro boletín para saber más! También contamos con 8 podcasts diferentes para complementar tu aprendizaje', 12, 30, 'Idiomas', 'https://www.bbc.co.uk/learningenglish/english/hygiene/course-information', 1, '7f822bd14a467c482d9d459a.png', 1, 'aprobado', '2026-09-23 14:18:42'),
(20, 'BBC Learning English', 'h5555555', 6, 22, 'Liderazgo', 'https://aws.amazon.com/es/', 1, 'd5aae4eaa94f921ffd830612.png', NULL, 'rechazado', '2026-09-23 21:29:28'),
(28, 'Introducción a las finanzas corporativas', 'Fundamentos de valoración de activos, proyectos, inversión, tiempo, dinero e introducción al análisis financiero a nivel corporativo', 17, 9, 'Finanzas', 'https://www.coursera.org/learn/wharton-finance', 1, 'f6717fbcb8d04e21e2f4644e.jpg', 1, 'aprobado', '2026-09-30 13:05:21'),
(29, 'Introduction to Mathematical Thinking', 'Orientado a desarrollar el análisis crítico y el razonamiento matemático abstracto \"fuera de la caja\" indispensable para ciencias, computación y analítica de datos', 18, 40, 'Matemáticas', 'https://www.coursera.org/learn/mathematical-thinking', 1, '168771ca2d4eff5338f833b5.jpeg', 1, 'aprobado', '2026-09-30 13:09:53'),
(30, 'Dibujo y Pintura: Técnicas Contemporáneas', 'Guía paso a paso sobre el manejo de proporciones, luz, perspectiva, teoría del color y construcción de formas desde el boceto inicial.', 19, 15, 'Dibujo', 'https://www.arts.ac.uk/subjects/fine-art/short-courses/painting/contemporary-drawing-and-painting-online-short-course-csm', 1, '5bf6aa891800e14c5bcb3ad3.jpeg', 1, 'aprobado', '2026-09-30 13:13:46'),
(31, 'Ideas from the History of Graphic Design', 'Un recorrido histórico por el origen de los estilos visuales modernos, la evolución de la tipografía y el uso conceptual de las formas desde la Revolución Industrial hasta finales del siglo XX.', 20, 11, 'Diseño Gráfico', 'https://www.coursera.org/learn/graphic-design-history', 1, '9114fbf5649afd23d19f9c38.png', 1, 'aprobado', '2026-09-30 13:16:54'),
(32, 'Introduction to Solid State Chemistry', 'Análisis sobre los principios de los enlaces químicos, estructuras atómicas, reacciones de la materia y su aplicación práctica en la ingeniería y ciencias aplicadas.', 21, 180, 'Quimica', 'https://www.edx.org/learn/chemistry', 1, 'd132bca8204f7f344fc4c27d.jpg', 1, 'aprobado', '2026-09-30 13:21:18'),
(33, 'Finanzas Personales', 'Herramientas para planear tu presupuesto, ahorrar, invertir y tomar decisiones financieras familiares acertadas.', 22, 7, 'Finanzas', 'https://www.coursera.org/learn/finanzas-personales', 1, '0c3ad7aeffad27bd235cc1f8.png', 1, 'aprobado', '2026-09-30 13:24:13'),
(34, 'Python para todos', 'El curso más popular para aprender a programar desde cero utilizando el lenguaje de programación Python.', 23, 20, 'Software', 'https://www.coursera.org/specializations/python-espanol', 1, '6b86041a3dba1f9570b606b0.jpeg', 1, 'aprobado', '2026-09-30 13:26:18'),
(35, 'Chino Básico: Lenguaje cotidiano', 'Curso introductorio de chino mandarín para principiantes. Cubre vocabulario, fonética y frases cotidianas.', 24, 18, 'Idiomas', 'https://courses.ea.asu.edu/college-algebra-mat-117/', 1, 'ed0a7e3f1bfda60eda59c6bd.jpg', 1, 'aprobado', '2026-09-30 13:29:04'),
(36, 'Bioquímica: Biomoléculas', 'Una introducción profunda a las macromoléculas de la vida, su estructura química y sus funciones celulares.', 25, 36, 'Quimica', 'https://pll.harvard.edu/course/cell-biology-mitochondria', 1, '7ace1f2de1f3fbe11eed53ad.png', 1, 'aprobado', '2026-09-30 13:35:00'),
(37, 'Marketing Digital: Fundamentos y Estrategias', 'Domina el uso de analítica web, optimización de motores de búsqueda (SEO) y estrategias de conversión aplicadas.', 26, 24, 'Marketing', 'https://www.coursera.org/professional-certificates/coursera-social-media-marketing?utm_medium=sem&utm_source=gg&utm_campaign=b2c_latam_multi_coursera_ftcof_x_cx_dr_bau_gg_sem_bd_s1_es_m_hyb_26-09_brand-excel-smm-sql&campaignid=24211251322&adgroupid=197011', 1, '3dc0f7d04c95c40a40d0bc34.jpg', 1, 'aprobado', '2026-09-30 13:40:14'),
(38, 'Introducción al Desarrollo Web', 'Enseña las bases estructuradas de internet: codificación pura utilizando lenguajes esenciales como HTML, CSS y JavaScript.', 27, 22, 'Software', 'https://www.coursera.org/learn/introduccion-desarrollo-web', 1, '25e2473ebac55a760937922d.png', 1, 'aprobado', '2026-09-30 13:45:49'),
(39, 'Pixar  El arte de contar historias', 'Lecciones creadas por animadores de Pixar que explican cómo usan el dibujo, la geometría y la animación para dar vida a personajes.', 28, 15, 'Dibujo', 'https://www.khanacademy.org/computing/pixar', 1, '5478e7fa7f6e125a825e9a18.jpeg', 1, 'rechazado', '2026-09-30 13:49:24'),
(41, 'Óptica cuántica 1 : Fotones simples', 'Curso ofrecido en Coursera donde puedes aprender Óptica Cuántica', 30, 30, 'Física', 'https://www.coursera.org/learn/quantum-optics-single-photon', 1, 'e9bcd2ab05089669eca05720.png', 108, 'aprobado', '2026-10-14 07:30:01'),
(42, 'Lecciones de biología', 'Un curso ofrecido por Khan Academy en donde desarrollarás grandes conocimientos y aprendizajes acerca de la Biología.', 31, 45, 'Biología', 'https://es.khanacademy.org/science/biology', 1, 'fef91e1505efa60afd305b37.png', NULL, 'aprobado', '2026-10-14 13:50:58'),
(44, 'Explorar el Universo: Introducción a la Astronomía', 'Se trata de un curso que puedes encontrar en el sitio de Alison en donde te ayudará a entender las teorías y principios clave de la astronomía.', 33, 6, 'Física', 'https://alison.com/es/curso/explorar-el-universo-introduccion-a-la-astronomia', 0, '619e762a6442143dfb9adc8a.jpg', NULL, 'aprobado', '2026-10-14 14:14:41'),
(45, 'Introducción a la Filosofía', 'Este curso le introducirá en algunas de las principales áreas de investigación de la filosofía contemporánea. En cada módulo, un filósofo diferente le hablará de algunas de las cuestiones y temas más importantes de su área de especialización. Empezaremos tratando de entender qué es la filosofía: cuáles son sus objetivos y métodos característicos, y en qué se diferencia de otras materias A continuación, dedicaremos el resto del curso a obtener una visión general introductoria de varias áreas diferentes de la filosofía.', 34, 20, 'Filosofía', 'https://www.coursera.org/learn/philosophy?irclickid=1KKV3iTYyxyZWLh1vy2hMw73Ukr1iHXX%3AWv0R80&irgwc=1&afsrc=1&utm_medium=partners&utm_source=impact&utm_campaign=1720753&utm_content=b2c&utm_campaignid=cursando.cl&utm_term=14726_CR_1164545_', 1, '6c9cde0b8e0201cce59bb849.webp', 1, 'rechazado', '2026-10-14 14:29:40'),
(47, 'filosofiA', 'Este curso le introducirá en algunas de las principales áreas de investigación de la filosofía contemporánea. En cada módulo, un filósofo diferente le hablará de algunas de las cuestiones y temas más importantes de su área de especialización.', 34, 20, 'Filosofía', 'https://www.coursera.org/learn/philosophy?irclickid=1KKV3iTYyxyZWLh1vy2hMw73Ukr1iHXX%3AWv0R80&irgwc=1&afsrc=1&utm_medium=partners&utm_source=impact&utm_campaign=1720753&utm_content=b2c&utm_campaignid=cursando.cl&utm_term=14726_CR_1164545_', 1, '75d738a88443c5dcfd856902.jpg', 109, 'rechazado', '2026-10-14 14:46:03'),
(48, 'UPValenciaX: Células', 'Es un curso que puedes encontrar en el sitio de edX en donde descubrirás los distintos tipos de células y tejidos que forman el cuerpo humano y como estos trabajan de forma coordinada para mantener la vida.', 35, 24, 'Biología', 'https://www.edx.org/learn/cellular-biology/universitat-politecnica-de-valencia-celulas-y-tejidos?index=rv_product_summary&queryId=2dedf9715db73506e214d1bc0910c3f6&position=2&utm_source=affiliate&utm_medium=Cursos+gratis+UNAM&utm_campaign=Online+Tracking+L', 0, 'acc156c7290cdd04e24620ff.jpg', NULL, 'rechazado', '2026-10-14 15:07:31'),
(50, 'filosofia', '¡Bienvenido a un viaje de reflexión y descubrimiento! Este curso es una invitación a explorar las grandes preguntas que nos definen como seres humanos. A través de la filosofía, la ciencia y las ideas que han dado forma a nuestra historia, descubrirás nuevas perspectivas sobre la existencia, la sociedad y nuestra relación con el mundo.Aquí, más que buscar respuestas definitivas, aprenderás a cuestionar, analizar y conectar ideas que te permitirán entender mejor quién eres y cuál es tu lugar en el universo. Este es un espacio para desafiar tus propias creencias, expandir tu pensamiento y encontrar nuevas formas de mirar el mundo y a ti mismo', 34, 20, 'Filosofía', 'https://www.coursera.org/learn/philosophy?irclickid=1KKV3iTYyxyZWLh1vy2hMw73Ukr1iHXX%3AWv0R80&irgwc=1&afsrc=1&utm_medium=partners&utm_source=impact&utm_campaign=1720753&utm_content=b2c&utm_campaignid=cursando.cl&utm_term=14726_CR_1164545_', 1, '7c5dc7e9b31fd937091eb32c.jpg', 111, 'aprobado', '2026-10-20 20:32:52'),
(52, 'Certificación en bases de datos relacionales', 'Este curso te enseña los fundamentos de las bases de datos relacionales', 36, 22, 'Software', 'https://www.freecodecamp.org/espanol/learn/relational-databases-v9/', 1, '9174683b6133b125da837ddd.jpg', 3, 'aprobado', '2026-10-27 22:43:59'),
(53, 'Diseño Web', 'Este curso enseña los fundamentos de HTML y CSS, incluyendo diseño moderno, diseño adaptable, accesibilidad y desarrollo web adaptable. Construirás proyectos prácticos y adquirirás las habilidades para crear páginas web profesionales y fáciles de usar.', 36, 30, 'Software', 'https://www.freecodecamp.org/espanol/learn/responsive-web-design-v9/#review-html', 1, '56a9511187868ac40d2227c3.jpg', 3, 'aprobado', '2026-10-27 22:45:43'),
(54, 'JavaScript', 'Este curso te enseña conceptos básicos de programación en JavaScript como trabajar con variables, funciones, objetos, arreglos y control de flujo. También aprenderás a manipular el DOM, manejar eventos y aplicar técnicas como programación asíncrona, programación y buenas prácticas de accesibilidad.', 36, 24, 'Software', 'https://www.freecodecamp.org/espanol/learn/javascript-v9/', 1, '844584b50fbdea855b750c30.jpg', 3, 'aprobado', '2026-10-27 22:48:26'),
(55, 'Diseño Grafico', 'En este curso de diseño gráfico aprenderás a crear composiciones visuales y comunicar ideas en proyectos creativos, de la mano de Nicolás Montañez, diseñador gráfico e ilustrador especializado en e-learning e interfaces digitales, responsable del diseño de producto y contenido visual de Edutin Academy. Al finalizar, serás capaz de desarrollar piezas gráficas aplicando principios de diseño, tipografía, color y composición, y tendrás tu propio portafolio gráfico como carta de presentación.', 32, 10, 'Diseño Gráfico', 'https://edutin.com/curso-de-diseno-grafico', 0, 'e6489546b66714e5a82ac8d6.jpg', 3, 'aprobado', '2026-10-27 22:56:34'),
(56, 'Matemática Preuniversitaria', 'Habilidades matemáticas necesarias para situaciones cotidianas que requieren comprensión y aplicación de conceptos matemáticos básicos y avanzados.', 37, 20, 'Matemáticas', 'https://www.coursera.org/learn/matematica-preuniversitaria?action=enroll', 0, 'cd7db3a4a1905a78a6d5a2f2.jpg', 3, 'aprobado', '2026-10-27 23:07:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instituciones`
--

CREATE TABLE `instituciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `sitio_web` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `instituciones`
--

INSERT INTO `instituciones` (`id`, `nombre`, `sitio_web`) VALUES
(4, 'HarvardX', NULL),
(6, 'Edutin', NULL),
(7, 'Universidad de Yale', NULL),
(8, 'Google', NULL),
(9, 'Universidad de Pensilvania', NULL),
(11, 'Oxford', NULL),
(12, 'BBC', NULL),
(13, 'Meta', NULL),
(14, 'MIT', NULL),
(15, 'Fundación Carlos Jillm', NULL),
(16, 'Noble Prog', NULL),
(17, 'Wharton School (Universidad de Pensilvania)', NULL),
(18, 'Universidad de Stanford y Coursera', NULL),
(19, 'Universidad del Arte de Londres (UAL) o lecciones introductorias en plataformas de diseño.', NULL),
(20, 'Instituto de Artes de California (CalArts) y Coursera', NULL),
(21, 'Instituto Tecnológico de Massachusetts (MIT) en edX', NULL),
(22, 'Universidad Nacional Autónoma de México (UNAM)', NULL),
(23, 'Universidad de Míchigan', NULL),
(24, 'Universidad de Pekín', NULL),
(25, 'Universidad de Harvard', NULL),
(26, 'Universidad de Maryland', NULL),
(27, 'Universidad de California en Davis (UC Davis)', NULL),
(28, 'Pixar Animation Studios y Khan Academy', NULL),
(29, 'unam', NULL),
(30, 'Intitut Polytechnique de Paris', NULL),
(31, 'Khan Academy', NULL),
(32, 'Edutin Academy', NULL),
(33, 'Training Facility UK', NULL),
(34, 'THE UNIVERSITY of EDINBURGH', NULL),
(35, 'Universitat Politècnica de València', NULL),
(36, 'freecodecamp', NULL),
(37, 'UP universidad de Palermo', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `rol` enum('usuario','admin') NOT NULL DEFAULT 'usuario',
  `tema` enum('claro','neon') NOT NULL DEFAULT 'claro',
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `contrasena`, `foto`, `rol`, `tema`, `fecha_registro`) VALUES
(1, 'Nicolas Merchan Sanchez', 'pvptakeo@gmail.com', '$2y$10$te4MEcMWLN0b4VKf8BY1dufHjEuYX7mtdQGJylGrBTHVY4gnrVRvG', 'uploads/perfiles/1da903b9acb7e5d1a3af02db.jpg', 'admin', 'claro', '2026-09-20 21:56:24'),
(2, 'wilouzet22*', 'samugomedo@gmail.com', '$2y$10$OpQMZGOyeM44S9ndpCVQMeuiTEbBrsMuTJVAqX/ELIVmx75H8EqhS', 'uploads/perfiles/8ef5487e53c2734d0046da75.jpg', 'usuario', 'claro', '2026-10-13 16:05:49'),
(3, 'davidcto', 'daviddiazmedina01@gmail.com', '$2y$10$1IEWNapkgMWTUtxO733XBeF3WQ210DG9KorXp5zgbMNMg87dgSsf6', '../assets/IMG/ini.jpg', 'admin', 'claro', '2026-10-14 06:59:01'),
(4, 'Marín', 'usocarruso012@gmail.com', '$2y$10$KY40qedcIR0ZCRrdF/Kg5OxBkSk1WNlrQ6uacw5xDJ1ToU/mvg2YW', '../assets/IMG/ini.jpg', 'admin', 'claro', '2026-10-14 07:05:20'),
(108, 'ArleyFL', 'arleyflorez@iejorgerobledo.edu.co', '$2y$10$RgxW4PDZXzBfIBllqhoV5eecg7wx/Oent/eEYcIrCuJURtPbB1GQq', '../assets/IMG/ini.jpg', 'usuario', 'claro', '2026-10-14 07:23:39'),
(109, 'cristo', 'daviddiadsdfgfdfghjzmedina03@gmail.com', '$2y$10$tkFY9Nhq6Ji7ZAIfMKCTTuIsYCLSsuyiAgRxbw0yeHSoM4svAOeJ2', 'uploads/perfiles/5344a2f94fe9195f685b4003.jpg', 'usuario', 'claro', '2026-10-14 14:43:49'),
(110, 'uvaira perez', 'maira.perez@upb.edu.co', '$2y$10$ipIueCPelqeqBUMzPB8qCelWIcGQAQHm5FG5fCcRAblrjCkeRFCGm', 'uploads/perfiles/d2c799463947c6b9e08c8ee5.jpg', 'usuario', 'claro', '2026-10-14 16:13:36'),
(111, 'cri', 'dadvivda@gmail.com', '$2y$10$kwmXSmFoosq7m3lrrX1vPOOGY71NCyFsMbPQ9dTbYufKtHHCJ4/8G', '../assets/IMG/ini.jpg', 'usuario', 'claro', '2026-10-20 20:31:42'),
(112, 'cri', 'daviddiazmedeeeeeeina01@gmail.com', '$2y$10$LEw4vpwq.sm83py4d8qQYuRQ1V1oDk22Ab6c85ghiBRAJdELBQpHO', '../assets/IMG/ini.jpg', 'usuario', 'claro', '2026-10-20 20:35:18');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tabla_institucion` (`id_institucion`),
  ADD KEY `fk_cursos_creador_usuario` (`id_usuario_creador`);

--
-- Indices de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `fk_cursos_creador_usuario` FOREIGN KEY (`id_usuario_creador`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
