-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-04-2025 a las 05:19:56
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
-- Base de datos: `php_tutor`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `consulta` text NOT NULL,
  `respuesta` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consultas`
--

INSERT INTO `consultas` (`id`, `usuario_id`, `consulta`, `respuesta`, `fecha`) VALUES
(3, 3, '¿Qué es inyección SQL?', 'Inyección SQL (en inglés: SQL injection) es un tipo de ataque de fraude y de seguridad en la que un malicious user introduce su propia inyección de SQL (que se puede usar para consultar bases de datos, alterar la tabla o los usuarios, borrar entradas o mucho más) en un formulario web con el objetivo de penetrar el sistema de control de acceso de la base de datos; es decir, es el insertion of malicious SQL code into an application\'s input fields. \n\nCon el fin de solucionar este tipo de problemas, recomiendo que se utilizarán los parseres de ambos las consultas SQL y los datos en los campos de input. \n\nNotaréis que en cada parsero los caracteres reconocidos', '2025-04-15 03:15:35'),
(6, 3, 'Define procesos SQL', 'Procesos SQL son una funcionalidad especial de las herramientas de manejo de datos relacionales (RM) como MySQL, que sirven para ejecutar mecánicas de almacenamiento y consulta recursivas sobre la información que se encuentra en el servidor de manera que sea más sencilla realizar tareas complejas de manejo de datos. \n\nEn la mayoría de los casos, los procesos SQL son como instrucciones específicas que se ejecutan sobre la base de datos para realizar operaciones de almacenamiento, actualización, consulta y eliminación de datos a través de una conexión estabilizada a la base de datos. \n\nUn ejemplo más sencillo de un proceso SQL es el INSERT, que permite ajustar una nueva circunstancia a una tabla de la base de datos. Esto puede usarse, para ejemplificar, para agregar nuevos usuarios a una tabla de usuarios de una aplicación. \n\nUna ventaja adicional de procesos SQL es que pueden ejecutarse con condiciones y parametros, lo que permite adaptar mejor las funcionalidades de la base de datos a las necesidades específicas de la aplicación. Esto proporciona una protección adicional contra errores y mejora la eficiencia y la seguridad de la base de datos. \n\nAdemás, el hecho de que se pueda ejecutar un proceso SQL que empiece con una consulta, luego ejecuta otras consultas o procesos recursivamente, hace que sea más sencilla realizar tareas complejas sobre la base de datos sin necesidad de destino a la applicación. \n\nPor ejemplo, para realizar el procesamiento de una transición de compra, una consulta puede ser ejecutada inicialmente para obtener la información necesaria sobre el cliente, luego la información puede ser actualizada y agregada a otras consultas para procesos adicionales como el chequeo de existencia de productos en el sistema, lo que garantiza que la información final de la transición es el que se almacena en la base de datos', '2025-04-15 03:21:30'),
(7, 3, 'define las siglas sql', 'SQL stands for Structured Query Language. It is a domain-specific language designed for database management systems that uses syntax queries\' elaboration and database relationships manipulation. SQL is used to manage data held in computerized databases through queries\' formulation like update statements, data modification procedures, and database access control mechanisms. \n\nSQL allows users to access multiple records through the execution of queries and to define the output format of these queries. It is an intuitive tool for gathering specific data from a database through a query and outputting it in a desired format. \n\nThere are numerous functions that SQL supports such as SELECT, UPDATE, INSERT, DELETE, WHERE, ALTER, DROP, etc. that help the communication between databases and users. \n\nWould you like to know more about SQL?', '2025-04-15 03:25:33'),
(8, 3, 'Define msdos', 'MS-DOS stands for Microsoft Disk Operating System, which is an operating system for x86-based personal computers. \nMS-DOS was one of the most prominent operating systems in the early 1990s and was instrumental in the rise of Microsoft within the personal computer industry.\n\nMS-DOS provided a command-line interface where users could execute commands to perform tasks like navigating files and directories, running programs, and managing the computer’s hardware. It was mostly a text-based environment, albeit with some graphical capabilities through later versions like MS-DOS 4.0 and beyond.\n\nWhile MS-DOS is no longer actively maintained, it paved the way for Windows, which has grown to become one of the most widely used operating systems in the world. Windows continues to retain many commands and design influences that originated in MS-DOS, creating a link to its legacy. \n\nIt is important to note that MS-DOS was a proprietary operating system and required a licensed to use it, as opposed to contemporary general-purpose operating systems that are open-source or free to use for personal use.', '2025-04-15 03:28:30'),
(10, 3, 'explicame la metodología scrum', 'respondse en español:\n\nScrum es una metodología de enfoque agile para el desarrollo de software o producto. Está basado en un entorno de trabajo colaborativo, frente a un equipo de desarrollo en una amplia variedad de proyectos. El equipo trabaja en un producto con una capacidad de acuerdo máximo (Sprint) de tiempo, normalmente de unos dos o tres meses. \n\nEl product owner es la persona que define el producto que se necesita y el backlog es el lista de todos los pasos o funcionalidades necesarias para el producto final. Cada uno de los miembros del equipo se encarga de distribuir la labor en un Sprint planning, y se basa en los objetivos, impediments, y el estado actual de la producción para determinar la labor realizada. \n\nCada Sprint empezará con un meeting de Kick-off en donde el product owner y el equipo de desarrollo estarán de acuerdo sobre los objetivos y los hurdles. Luego de iniciar el Sprint, se realizará un \'Stand-up\', dónde todos invocan a la altared para compartir los avances actuales, problemas y logros. Estas reuniones también son conocidas como \'Daily Scrum\'. Finalmente, una vez que un Sprint esté completo, el producto se puede validerse en un meeting de Sprint Review y el equipo puede hablar sobre lo que podía hacer mejor y lo que se realizó correctamente. \n\nEs esperado que los desarrolladores absorben una estricta concentración en el trabajo especifico durante las descargas de trabajo, pero normalmente tienen flexibilidad sobre la hora y el lugar de trabajo. Esto permite a los empleados a mantener un nivel de motivación y satisfacción adicional. \n\nEs esperada que estas características de Scrum apoyen el entorno de trabajo colaborativo y de resultados en el equipo de desarrollo. \n\nFue estrictamente definido para el desarrollo de software, pero es común usarlo para otros tipos de proyectos de producto. \n\nEs esperado que esto ayude a usted comprender mejor la met', '2025-04-15 19:40:31'),
(11, 3, 'Define metodologia agil', 'La metodología agil es un framework para solucionar problemas y realizar proyectos de desarrollo de software en un entorno de variación y flexibilidad. Está basado en el principio de flexibilidad, lo que significa que el equipo de desarrollo puede adaptar rápidamente sus técnicas e inquietudes al cambio para mejorar el producto final y mejorar el proceso de desarrollo. \n\nEl agilismo es un enfoque que promueve la flexibilidad, permitiendo a los usuarios o', '2025-04-15 20:59:17'),
(12, 3, 'cual es la metodología ágil de cascada', 'La metodología ágil de cascada es un enfoque para el desarrollo de software que establece una estructura específica para la organización de los desarrolladores, los tiempos y la velocidad en el proceso de desarrollo. Esta metodología proporciona una flexibilidad para adaptar mejor el desarrollo de una solución de software a los cambios o requerimientos emergentes, lo que le permite a la empresa adaptar mejor su producto a los requisitos de la marca. La metodología ágil de cascada proporciona también una estructura para el seguimiento y la gestión de los desarrollos, así como una serie de etiquetas de nivel para los recursos necesarios para el desarrollo. Estas etiquetas pueden ser usadas para identificar el estado actual del desarrollo, así como su compatibilidad con el plan de desarrollo original. \n\nLa metodología ágil de cascada proporciona a los desarrolladores una estrategia para comenzar el desarrollo de manera independiente y la capacidad de comunicarse y adaptarse entre ellos mientras que trabajan en proyectos simultáneos para completar el desarrollo de manera eficiente. Esta metodología también proporciona al equipo de desarrollo una visión general del desarrollo y los requerimientos originales, lo que permite a los desarrolladores adaptar mejor su desarrollo en un entorno de trabajo colaborativo. La metodología ágil de cascada resulta especialmente útil en un entorno de trabajo donde los desarrolladores trabajen en proyectos independientes simultáneos y necesitan un enfoque que les permite ajustarse a los cambios o requerimientos emergentes. \n\nCascada es un enfoque que permite la flexibilidad necesaria para adaptar el desarrollo de un software a cambios o requisitos emergentes, mientras que también proporciona una estructura para el seguimiento y la gestión de los desarrollos. Esta metodología proporciona una serie de etiquetas de nivel para los recursos ne', '2025-04-15 21:03:50'),
(13, 3, 'enlista 10 metodologías ágiles', 'responding with 10 agile methodologies that can be enlisted are: \n\n1. Kanban\n2. Scrum\n3. Extreme Programming (XP)\n4. Lean Software Development\n5. Agile Software Development\n6. Crystal Clear Methodology\n7. Dynamic Systems Development Method (DSDM)\n8. Adaptive Software Development\n9. Feature-Driven Development\n10. Scrumban \n\nIt\'s important to note that these methodologies share the common theme of adaptability and customer focus, promoting flexible and quick adaptation to change, allowing for rapid delivery of software and greater collaboration with stakeholders.', '2025-04-15 21:09:36'),
(14, 3, 'Qué es Scrumban?', 'Scrumban es una metodología de proceso de desarrollo que combina elementos de Scrum y de Kanban. \n\nScrum es una estructura de iteración de desarrollo de software que invoca a la participación activa de los usuarios, el Equipo de Desarrollo (dev team) y un Equipo de Empleados (product owner) para influir en el alcance de la entrega de producto y la priorización de los distintos tareas. \n\nKanban es un sistema de gestión de proceso de desarrollo de software que utiliza una plataforma de trabajo en la que se visualiza la cantidad de tareas que están en desarrollo, listas de espera y los requerimientos de las personas que usan la plataforma. \n\nEn Scrumban, se utiliza la flexibilidad de Scrum con la eficacia de Kanban para mejorar el flujo del desarrollo de software. Está basado en la visualización de la mayoría de los aspectos de la gestión de desarrollo, que incluye el Equipo de Desarrollo, la capacidad de trabajo, el patrón de trabajo, las cuotas de trabajo y los detalles de la gestión de errores.', '2025-04-15 21:10:43'),
(15, 3, 'Qué es Extreme Programming?', 'Extreme Programming (XP) es una metodología de desarrollo de software dinámica e intuitiva basada en la flexibilidad y la eficacia en un entorno de trabajo de cambio constante. Impulsada por el desarrollo de software de alta calidad y la excelencia de servicio a clientes, XP incluye los aspectos conceptuales de las siguientes prácticas de desarrollo: iterativo, usuario centro, práctica de fidelización de usuarios, práctica de \"manejabilidad\", práctica de \"orgullo de trabajo\", y práctica de seguimiento de resultados. \n\nXP proporciona a los desarrolladores de software una guía clara y eficaz para la implementación de mejoras continuas en su equipo de desarrollo, al igual que una estrategia para mejorar la calidad de sus desarrollos y el nivel de servicio a clients, manteniendo a los usuarios fieles a la empresa. \n\nSu ideología está basada en la flexibilidad y adaptación a cambios, así como en la excelencia de servicio a los clientes y la entrega de software de alta calidad.', '2025-04-15 21:12:09'),
(16, 3, 'Qué es Crystal Clear Methodology?', 'La metodología Crystal Clear es un enfoque que emplea algoritmos inteligentes, tales como la inteligencia artificial, en una plataforma de comunicación para proporcionar respuestas de calidad y claras en un lenguaje natural, sin embargo, se requiere de una larga cantidad de datos para poder obtener un nivel adecuado de eficacia.', '2025-04-15 21:12:40'),
(17, 3, 'Qué es Lean Software Development', 'Lean Software Development es un método de desarrollo de software orientado a mejorar la productividad, mediante el uso de la identidad de los clientes y el conocimiento de los desarrolladores. Está basado en la filosofía de \"el valor agregado\" y la optimización de procesos, buscando la maximización de la productividad y la reducción de los costes. \n\nEl enfoque se centra en la identificación de requisitos específicos y la seguridad de la entrega estricto, a través de la aplicación de prácticas de agile para mejorar la eficacia y la productividad. Además, se ha combinado con otros enfoques como el Agile Development, en la actualidad es un método de desarrollo de software que proporciona una flexibilidad en la entrega de productos, asegurando mejoras continuas y la adaptación a los requerimientos específicos de los clientes. \n\nEs un método avanzado de desarrollo de software que busca la economía de proceso, mejorando la eficiencia, la productividad y la flexibilidad, para lograr el mejor rendimiento en el desarrollo de software.', '2025-04-15 21:19:01'),
(21, 3, 'Programación Orientada a Objetos', 'En programación orientada a objetos, los objetos no solamente tienen una identidad propia y estructura, pero también conocen su estado y pueden intercambiar información con otras instancias de objetos por sí mismos. Cada objeto contiene el enrutador (pointer) a lo que va en su inside, así cada instancia puede manejarse por él sí y así proporcionar un entorno mejorado para el desarrollo de la programación. \n\nLa programación orientada a objetos en sí no proporciona la funcionalidad final, pero proporciona una estructura y seguimiento mejorado sobre la cual otros desarrolladores pueden construir funcionalidades adicionales.', '2025-04-15 21:22:24'),
(22, 3, 'Programación ágil', 'He leído sus preguntas y respondo en español de manera clara y corta. \n\n¿Me permite usted mostrar sus preguntas? \n\nLe di obtener una mayor calidad en mi respuesta si es así. \n\nGracias.', '2025-04-15 21:23:13'),
(23, 3, 'Dime qué es la programación ágil', 'La programación ágil, además conocida como la programación en tiempo real, es una metodología de programación que consiste en la capacidad de adaptar al flujo de trabajo de una ligera, rapida y eficaz manera, en función de los datos y las condiciones actuales. \n\nEsta garantiza la flexibilidad y la velocidad en la gestión de la información, lo que es esencial para la realización de decisiones con las más altas exigencias de tiempo. \n\nEsta disciplina está sustentada en las siguientes pillar sobre la que se basa:\n\n1. El enfoque modular y las librerías: Se puede separar cada proceso en pequeños módulos independientes, lo que facilita la flexibilidad en el código final.\n2. El enfoque orientado a objetos: La protección de la seguridad, la capacidad de adaptación a cambios y la flexibilidad en el código se basa en las ideas en objetos.\n3. El apoyo de la comunicación entre los diferentes módulos a través de canales de información: Esto proporciona transparencia y capacidad de uso y mejora la eficacia y la eficiente la programación. \n\nEs un enfoque ideal para la gestión de exámenes en tiempo real, la gestión de la salud, la gestión de la producción y el servicio de atención al usuario/cliente. \n\nFue originalmente propuesta por Alistair Cockburn y Richard P. Gabriel, y posteriormente fue ampliada y reforzada por la comunidad de programadores. \n\nEs un enfoque que ha ido adaptando a diferentes enfoques y lenguajes de programación, lo que lo ha convertido en un enfoque muy popular y utilizado.', '2025-04-15 21:25:04'),
(24, 3, 'Qué es una máquina virtual?', 'Una máquina virtual es un computador que emula la funcionalidad de una máquina real usando un sistema o plataforma de computación en la que se ejecuta. Se puede usar una máquina virtual para crear una computadora en la nube, un sistema de almacenamiento o servicio de computación a distancia.', '2025-04-15 21:35:39'),
(28, 3, 'Qué es un Distro de Linux', 'Un distro de Linux, o distribution Linux, es una versión del sistema operativo Linux, creada por varias comunidades de usuarios y desarrolladores por intereses particulares o lugares geográficos. Cada distro tiene sus propias características específicas, dependiendo de sus requisitos y uso principal. \n\nLinux ofrece una solución segura, configurable y libre de costes para su sistema operativo. Al ser una solución open source, permite observación, mejoras y adaptaciones para mejorar su experiencia. \n\nExiste una gran variedad de distros disponibles, cada una con su propia característica especial, según sus necesidades: entre ellas, Ubuntu, Debian, Fedora, CentOS, y muchas más. \n\nEs tan simple como ejecutar un sistema operativo seguro, libre, y con una amplia comunidad de usuarios y desarrollo a su disposición. \n\nEspero haberle respondido a su pregunta a su satisfacción. Hay algo más que desea saber sobre Linux o distros? \n\n Gracias!', '2025-04-16 00:11:49'),
(29, 21, 'Qué es Ubuntu', 'Ubuntu es un sistema operativo de código abierto similar a Linux, con licencia GPL viene en varias variaciones desde Ubuntu Desktop utilizado como sistema operativo de computadora a la versión server para uso en la nube, además de proporcionar emuladores de juegos como Steam y empresas como Netflix.', '2025-04-16 01:16:23'),
(31, 21, 'Que es Uwuntu Linux', 'Uwuntu Linux es una versión de Linux especialmente diseñada para usuarios no profesionales, con el propósito de ofrecer un sistema operativo más accesible y amigable para usuarios no profesionales.  \n\nUwuntu Linux le ofrece muchos programas básicos para ayudar a los usuarios a empezar, incluso si no tienen conocimientos previos sobre Linux. Además, proporciona una fantástica coexistencia con otros sistemas operativos, tal como Windows y Mac. \n\nFinalmente, ofrece una experiencia similar a la de usuarios de desktop de Linux, pero con un enfoque amigable para usuarios que no tienen experiencia con el sistema operativo.', '2025-04-16 01:16:58'),
(32, 31, '¿Qué es HTML?', 'HTML es un lenguaje de marcado para crear páginas web.', '2025-04-16 00:07:27'),
(33, 31, '¿Qué es un servidor web?', 'Es un software que entrega contenido web a los usuarios.', '2025-04-16 04:50:14'),
(34, 31, '¿Qué es un sistema operativo?', 'Es el software que gestiona los recursos de hardware y software de un PC.', '2025-04-15 20:14:29'),
(35, 32, '¿Qué es HTML?', 'HTML es un lenguaje de marcado para crear páginas web.', '2025-04-16 02:39:26'),
(36, 32, '¿Qué es un servidor web?', 'Es un software que entrega contenido web a los usuarios.', '2025-04-15 19:13:17'),
(37, 32, '¿Qué es JavaScript?', 'Es un lenguaje de programación usado para hacer páginas web interactivas.', '2025-04-16 04:46:40'),
(38, 33, '¿Qué es una máquina virtual?', 'Una máquina virtual es un software que emula un sistema operativo.', '2025-04-15 17:26:22'),
(39, 33, '¿Qué es una API?', 'Es un conjunto de reglas que permite la comunicación entre aplicaciones.', '2025-04-15 20:40:51'),
(40, 33, '¿Qué es la nube?', 'Es un modelo de computación que permite acceder a servicios a través de internet.', '2025-04-15 12:02:24'),
(41, 34, '¿Qué es una API?', 'Es un conjunto de reglas que permite la comunicación entre aplicaciones.', '2025-04-16 04:06:08'),
(42, 34, '¿Qué es un sistema operativo?', 'Es el software que gestiona los recursos de hardware y software de un PC.', '2025-04-15 18:20:50'),
(43, 34, '¿Qué es una VPN?', 'Es una red privada que protege tu conexión en internet.', '2025-04-15 15:44:01'),
(44, 35, '¿Qué es una base de datos?', 'Es un sistema que almacena y gestiona datos de forma organizada.', '2025-04-15 18:25:06'),
(45, 35, '¿Qué es una IP?', 'Es una dirección única que identifica un dispositivo en una red.', '2025-04-15 18:17:21'),
(46, 35, '¿Qué es una VPN?', 'Es una red privada que protege tu conexión en internet.', '2025-04-15 09:28:13'),
(47, 36, '¿Qué es un servidor web?', 'Es un software que entrega contenido web a los usuarios.', '2025-04-15 20:50:46'),
(48, 36, '¿Qué es JavaScript?', 'Es un lenguaje de programación usado para hacer páginas web interactivas.', '2025-04-16 01:31:44'),
(49, 36, '¿Qué es la nube?', 'Es un modelo de computación que permite acceder a servicios a través de internet.', '2025-04-15 20:22:19'),
(50, 37, '¿Qué es un servidor web?', 'Es un software que entrega contenido web a los usuarios.', '2025-04-15 22:08:05'),
(51, 37, '¿Qué es una API?', 'Es un conjunto de reglas que permite la comunicación entre aplicaciones.', '2025-04-15 21:34:44'),
(52, 37, '¿Qué es JavaScript?', 'Es un lenguaje de programación usado para hacer páginas web interactivas.', '2025-04-15 10:47:47'),
(53, 38, '¿Qué es la nube?', 'Es un modelo de computación que permite acceder a servicios a través de internet.', '2025-04-15 13:40:36'),
(54, 38, '¿Qué es un sistema operativo?', 'Es el software que gestiona los recursos de hardware y software de un PC.', '2025-04-15 22:33:23'),
(55, 38, '¿Qué es una VPN?', 'Es una red privada que protege tu conexión en internet.', '2025-04-15 22:27:46'),
(56, 39, '¿Qué es una máquina virtual?', 'Una máquina virtual es un software que emula un sistema operativo.', '2025-04-15 14:17:15'),
(57, 39, '¿Qué es JavaScript?', 'Es un lenguaje de programación usado para hacer páginas web interactivas.', '2025-04-15 20:11:38'),
(58, 39, '¿Qué es una VPN?', 'Es una red privada que protege tu conexión en internet.', '2025-04-15 15:16:43'),
(59, 40, '¿Qué es JavaScript?', 'Es un lenguaje de programación usado para hacer páginas web interactivas.', '2025-04-15 20:37:23'),
(60, 40, '¿Qué es la nube?', 'Es un modelo de computación que permite acceder a servicios a través de internet.', '2025-04-15 10:45:00'),
(61, 40, '¿Qué es un sistema operativo?', 'Es el software que gestiona los recursos de hardware y software de un PC.', '2025-04-16 04:36:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('usuario','analista','admin') DEFAULT 'usuario',
  `analista_aprobado` tinyint(1) DEFAULT 0,
  `fecha_registro` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `rol`, `analista_aprobado`, `fecha_registro`) VALUES
(1, 'Admin ', 'appMaster', '$2y$10$Lx6/BL8sWyjAM2CWQoauUedTt/w7uLOn.N7HCaN5aJT6m1wedIY4.', 'admin', 1, '2025-04-14'),
(2, 'Gabriel Eduardo', 'gabrieled', '$2y$10$559h6T3gX7OLmOLlItvUtuKusaZAOJLIN/r88DFFLetzQKmn/WMFK', 'analista', 1, '2025-04-14'),
(3, 'Eduardo', 'eduardope', '$2y$10$FbcBDgSxEgDt8zvCmB61aee4BoPOD4rema4C9Kr7JUut1N5hqm7XC', 'usuario', 1, '2025-04-14'),
(4, 'Kevin Jefferson', 'kevinjeff', '$2y$10$aSp.mNAybUR1L5bc5IKuweBGz60DmtOq2cAcA3th/hhb34byY8bZS', 'analista', 1, '2025-04-15'),
(6, 'Francisco', 'franc', '$2y$10$4.Pvg4AJ/kJd9.h3lu7xmeuoufB2Y4LL6ig.O0XiNuhNbEwUb5wx6', 'analista', 1, '2025-04-15'),
(21, 'Felipe', 'felipeci', '$2y$10$ALhTi54QWNNDQjkAcOffGejmgxHG3TUWHhvQO7wulGN2ix3mt/Kqm', 'usuario', 1, '2025-04-16'),
(24, 'Juan', 'juanoc', '$2y$10$9MxUd5ZSF13I7NJKiLGuseULyDurLrLZSYNGQsIxplQb9Gf1iQVpC', 'analista', 1, '2025-04-15'),
(27, 'Marlon', 'marlonoc', '$2y$10$M7PW.pn5ZMR29ScbhgHEkecO12/Dyo55UhvNSG8U7Te/Z.NmYOTAu', 'analista', 0, '2025-04-16'),
(30, 'Steven', 'stevenpe', '$2y$10$Q4/lvAAV.KbQ2tinIlkz6ODC8v5fO3wbflbAeJxFiVbdNc4twAWlO', 'analista', 1, '2025-04-15'),
(31, 'Lucía', 'lucíamu', '$2y$10$1xDToXXPZXqMMpcTyBeEzenA1TyNLTt.Af65I3YelZsXylYkM5qLK', 'usuario', 0, '2025-04-11'),
(32, 'Luis', 'luishi', '$2y$10$aYFvCpN13pIOUakc.vmALO9DdOtzqdzlPq2ORdNY861YNeCqdSuxK', 'usuario', 0, '2025-04-15'),
(33, 'Ana', 'anale', '$2y$10$3uo6Ga39Xpn.tmS9bkzx0.iaur/LIB.J3MO8f/iLdsDXfe6aQSBNi', 'usuario', 0, '2025-04-11'),
(34, 'José', 'josétu', '$2y$10$XSlMd/wbHOFJML3JG3Dmwu.9XWiOVEm7TbHu5tacHgMjhE/auLbmS', 'usuario', 0, '2025-04-11'),
(35, 'Laura', 'lauraji', '$2y$10$9/8ib7vYhjQ19r.VhkogaOuqReczG0FwjnHdc6OQALtjvPlH1.TjC', 'usuario', 0, '2025-04-11'),
(36, 'Jorge', 'jorgefa', '$2y$10$T4nqD38Jt7cBnyCI23GMGOqz5A/Zkhzb4AfUGL88zUVY2eXgBCtqe', 'usuario', 0, '2025-04-13'),
(37, 'Pedro', 'pedrode', '$2y$10$ivGmgPCx1xcvu3Tj6Fx1U.iiu7qrrtJXw5vDTuONqxVsJqCI/.4zC', 'usuario', 0, '2025-04-13'),
(38, 'Oscar', 'luisbu', '$2y$10$aLfzvP1ZKCxppvBvuOpa8OpmPv.WrpYOiLbS0fnoFeGcDbpwsTEeK', 'usuario', 0, '2025-04-10'),
(39, 'Byron', 'joséye', '$2y$10$JxhLgnl6x2rEONSrVmWSIOjavDQp3GZSlGc5nWZPaU8G6zDnjiv/G', 'usuario', 0, '2025-04-16'),
(40, 'William', 'jorgeyi', '$2y$10$SKfDLE4KsoMbIfH2XXAEV.pBVsxM3ZqoHhSEa6NQL3IuB6Pnko1HW', 'usuario', 0, '2025-04-15'),
(41, 'Rafael', 'rafacap', '$2y$10$dWRc.b8UDwzUWCzqntOg7OZe3Z5ol14XixD.vPZduzeR4FT5Wa.Ga', 'analista', 0, '2025-04-16');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
