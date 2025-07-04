<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determina o prefixo do caminho para os assets (CSS, JS, imagens)
$isInsideAdminFolder = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
$pathPrefix = $isInsideAdminFolder ? '../' : '';

// Define o título da página dinamicamente
$currentPage = basename($_SERVER['PHP_SELF']);
$pageTitle = $_SESSION['current_page_title'] ?? '';

// Se o título não foi definido via sessão, define um título padrão baseado na página atual
if (empty($pageTitle)) {
    if ($isInsideAdminFolder) {
        switch ($currentPage) {
            case 'admin.php':
                $pageTitle = 'Cadastro de Árvore';
                break;
            case 'login_admin.php':
                $pageTitle = 'Login Administrativo';
                break;
            case 'gerenciar_usuarios_admin.php':
                $pageTitle = 'Gerenciar Administradores';
                break;
            default:
                $pageTitle = 'Painel Administrativo';
                break;
        }
    } else {
        switch ($currentPage) {
            case 'index.php':
                $pageTitle = 'Página Inicial';
                break;
            case 'catalogo.php':
                $pageTitle = 'Catálogo de Árvores';
                break;
            default:
                $pageTitle = 'Catálogo de Árvores';
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo htmlspecialchars($pageTitle); ?> - Catálogo de Árvores</title>

    <!-- ============== INÍCIO DAS NOVAS TAGS ============== -->

    <!-- Meta Tags Padrão -->
    <meta name="description" content="Um catálogo digital para documentar e promover a educação ambiental e a preservação da flora de Itapetininga.">
    <meta name="author" content="Nathanael Netto e equipe da Fatec Itapetininga">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://catalogo-de-arvores.onrender.com/">
    <meta property="og:title" content="Catálogo de Árvores - Fatec Itapetininga">
    <meta property="og:description" content="Explore o catálogo de espécies arbóreas de Itapetininga. Um projeto para a educação e preservação ambiental.">
    <meta property="og:image" content="https://catalogo-de-arvores.onrender.com/assets/images/og-image.png"> <!-- Atualize este link com sua imagem! -->

    <!-- Twitter Card -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://catalogo-de-arvores.onrender.com/">
    <meta property="twitter:title" content="Catálogo de Árvores - Fatec Itapetininga">
    <meta property="twitter:description" content="Explore o catálogo de espécies arbóreas de Itapetininga. Um projeto para a educação e preservação ambiental.">
    <meta property="twitter:image" content="https://catalogo-de-arvores.onrender.com/assets/images/og-image.png"> <!-- Atualize este link com sua imagem! -->

    <!-- Favicon e Ícones Adicionais (Alterado para .png) -->
    <link rel="icon" type="image/png" href="<?php echo $pathPrefix; ?>favicon.png">
    <link rel="apple-touch-icon" href="<?php echo $pathPrefix; ?>apple-touch-icon.png">

    <!-- ============== FIM DAS NOVAS TAGS ============== -->

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AOS (Animate On Scroll) Library CSS e JS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Swiper JS Library CSS e JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <!-- Estilos CSS personalizados -->
    <link rel="stylesheet" href="<?php echo $pathPrefix; ?>assets/css/custom_styles.css" /> 
    <link rel="stylesheet" href="<?php echo $pathPrefix; ?>assets/css/index_styles.css" />

    <!-- Script para aplicar o tema (dark/light) inicial -->
    <script>
        (function() {
            try {
                const theme = localStorage.getItem('theme');
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (theme === 'dark' || (!theme && systemPrefersDark)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {
                // Silencia erros
            }
        })();
    </script>
    <!-- Configuração do Tailwind CSS -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#2E7D32',
                        'primary-light': '#4CAF50',
                        'primary-lighter': '#E8F5E9',
                        secondary: '#FFA000',
                        accent: '#00796B',
                        'card-border': '#4CAF50',
                        'card-hover': 'rgba(46, 125, 50, 0.05)',
                        'light-bg': '#f7faf7',
                        'dark-bg': '#1a202c',
                        'dark-card': '#2d3748',
                        'dark-card-header': '#1f2937',
                        'dark-text': '#e2e8f0',
                        'dark-primary': '#38a169',
                        'dark-primary-hover': '#2f855a',
                        'dark-secondary': '#dd6b20',
                        'dark-border': '#4a5568',
                        'dark-input-border': '#4A5568',
                        'dark-input-bg': '#2D3748',
                        'dark-input-focus-ring': '#38A169',
                        'dark-remove-btn-bg': '#C53030',
                        'dark-remove-btn-hover-bg': '#9B2C2C'
                    },
                    boxShadow: {
                        card: '0 2px 8px rgba(0, 0, 0, 0.08)',
                        'card-hover': '0 4px 12px rgba(0, 0, 0, 0.12)'
                    },
                    maxHeight: {
                        '0': '0', 
                        '9999px': '9999px'
                    },
                    transitionProperty: {
                        height: 'height', 
                        'max-height': 'max-height'
                    }
                }
            }
        }
    </script>
    <!-- Scripts JS personalizados -->
    <script src="<?php echo $pathPrefix; ?>assets/js/style.js" defer></script>
</head>
<body class="bg-light-bg dark:bg-dark-bg text-gray-800 dark:text-dark-text flex flex-col min-h-screen">

<!-- O resto do seu header... -->
<header class="fixed top-0 left-0 w-full bg-green-700 dark:bg-gray-800 text-white shadow-lg z-50 transition-colors duration-300">
    <div class="container mx-auto flex items-center justify-between px-4 sm:px-6 h-20">
        <!-- Logo/Título do Site -->
        <a href="<?php echo $pathPrefix; ?>index.php" 
           class="text-xl sm:text-2xl md:text-3xl font-bold hover:opacity-80 transition-opacity" data-aos="fade-down" data-aos-delay="100">
            <?php 
                if ($isInsideAdminFolder) {
                    echo htmlspecialchars($pageTitle);
                } else {
                    echo 'Catálogo de Árvores';
                }
            ?>
        </a>
        <!-- Navegação Principal -->
        <nav class="flex items-center gap-2 md:gap-3">
            <!-- Link para a Página Inicial -->
            <a href="<?php echo $pathPrefix; ?>index.php" class="flex items-center gap-2 px-3 py-2 md:px-4 rounded-lg hover:bg-green-600 dark:hover:bg-gray-700 transition text-sm md:text-base <?php if ($currentPage === 'index.php' && !$isInsideAdminFolder) echo 'bg-green-600 dark:bg-dark-primary font-semibold'; ?>">
                <i class="fas fa-home text-md md:text-lg"></i>
                <span class="hidden sm:inline">Início</span>
            </a>
            <!-- Link para o Catálogo -->
            <a href="<?php echo $pathPrefix; ?>catalogo.php" class="flex items-center gap-2 px-3 py-2 md:px-4 rounded-lg hover:bg-green-600 dark:hover:bg-gray-700 transition text-sm md:text-base <?php if ($currentPage === 'catalogo.php' && !$isInsideAdminFolder) echo 'bg-green-600 dark:bg-dark-primary font-semibold'; ?>">
                <i class="fas fa-leaf text-md md:text-lg"></i>
                <span class="hidden sm:inline">Catálogo</span>
            </a>
            
            <?php // Links Condicionais para Administração ?>
            <?php if (isset($_SESSION['admin_logado']) && $_SESSION['admin_logado'] === true): ?>
                <!-- Link para o Painel Administrativo -->
                <a href="<?php echo $pathPrefix; ?>admin/admin.php" class="flex items-center gap-2 px-3 py-2 md:px-4 rounded-lg hover:bg-green-600 dark:hover:bg-gray-700 transition text-sm md:text-base <?php if ($currentPage === 'admin.php' || $currentPage === 'gerenciar_usuarios_admin.php') echo 'bg-green-600 dark:bg-dark-primary font-semibold'; ?>">
                    <i class="fas fa-user-cog text-md md:text-lg"></i>
                    <span class="hidden sm:inline">Painel Admin</span>
                </a>
                <!-- Link para Logout -->
                <a href="<?php echo $pathPrefix; ?>admin/logout_admin.php" class="flex items-center gap-2 px-3 py-2 md:px-4 rounded-lg hover:bg-red-600 dark:hover:bg-red-700 transition text-sm md:text-base">
                    <i class="fas fa-sign-out-alt text-md md:text-lg"></i>
                    <span class="hidden sm:inline">Sair</span>
                </a>
            <?php else: ?>
                <!-- Link para Login Administrativo -->
                <a href="<?php echo $pathPrefix; ?>admin/login_admin.php" class="flex items-center gap-2 px-3 py-2 md:px-4 rounded-lg hover:bg-green-600 dark:hover:bg-gray-700 transition text-sm md:text-base <?php if ($currentPage === 'login_admin.php') echo 'bg-green-600 dark:bg-dark-primary font-semibold'; ?>">
                    <i class="fas fa-user-shield text-md md:text-lg"></i>
                    <span class="hidden sm:inline">Admin</span>
                </a>
            <?php endif; ?>

            <!-- Botão para alternar o tema (Dark/Light Mode) -->
            <button id="theme-toggle-button" type="button" class="text-white hover:bg-green-500 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-300 dark:focus:ring-gray-600 rounded-lg text-sm p-2.5 transition-colors duration-300">
                <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
            </button>
        </nav>
    </div>
</header>
<!-- Espaçador para compensar a altura do header fixo -->
<div class="h-20"></div> 
