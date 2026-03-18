<?php 
session_start();
require_once 'auth_check.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aulas - Bodyfit</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="index.html" class="logo">
            <img src="imagens/bodyfit.png" alt="BodyFit Logo" class="logo-img">
            <span class="logo-text">BODY<span>FIT</span></span>
        </a>
    
        <div class="nav-links">
        <a href="index.html">Home</a>
        <a href="Aulas.php">Aulas</a>
        <a href="Evolução.php">Evolução</a>
    
        <?php if(isset($_SESSION['authenticated'])): ?>
        <a href="logout.php" class="btn-login">Sair</a>
        <?php else: ?>
        <a href="login.html" class="btn-login">Entrar</a>
        <?php endif; ?>
        </div>
    
        <button class="menu-toggle">
            <svg width="24" height="24" viewBox="0 0 24 24">
                <path fill="currentColor" d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
            </svg>
        </button>
    </nav>

    <!-- Hero Section -->
    <section class="hero classes-hero">
        <div class="hero-content">
           <h1 style="color: white;">NOSSAS MODALIDADES</h1>
            <p>Escolha a atividade que combina com você e transforme seu corpo</p>
        </div>
    </section>

    <!-- Seção de Modalidades -->
    <section class="section">
        <h2 class="section-title" style="color: white;">ESCOLHA SUA ATIVIDADE</h2>
        <p class="section-subtitle" style="color: white;">Diversas modalidades para todos os níveis e objetivos</p>
        
        <div class="classes-grid">
            <div class="class-card">
                <div class="image-container">
                    <div class="static-img" style="background-image: url('https://images.unsplash.com/photo-1576678927484-cc907957088c?q=80&w=2070')"></div>
                </div>
                <div class="schedule">
                    <h3>Musculação</h3>
                   
                    <button class="reserve-btn" onclick="window.location.href='Musculação.php'">Ver Aulas</button>
                </div>
            </div>

            <div class="class-card">
                <div class="image-container">
                    <div class="static-img" style="background-image: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=2070')"></div>
                </div>
                <div class="schedule">
                    <h3>Crossfit</h3>
                    
                    <button class="reserve-btn" onclick="window.location.href='Crossfit.php'">Ver Aulas</button>
                </div>
            </div>

            <div class="class-card">
                <div class="image-container">
                    <div class="static-img" style="background-image: url('https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=2070')"></div>
                </div>
                <div class="schedule">
                    <h3>Yoga</h3>
                   
                    <button class="reserve-btn" onclick="window.location.href='Yoga.php'">Ver Aulas</button>
                </div>
            </div>

            

            

           
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="imagens/bodyfit.png" alt="BodyFit Logo">
                <span class="logo-text">BODY<span>FIT</span></span>
            </div>

            <div class="footer-socials">
                <a href="https://instagram.com" target="_blank" class="social-icon" title="Instagram">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="https://twitter.com" target="_blank" class="social-icon" title="Twitter">
                    <i class="bi bi-twitter-x"></i>
                </a>
                
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 BodyFit. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        // Menu mobile toggle
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.nav-links').classList.toggle('show');
        });
        
        // Efeito de hover nas imagens
        document.querySelectorAll('.class-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                const img = this.querySelector('.static-img');
                img.style.transform = 'scale(1.1)';
            });
            
            card.addEventListener('mouseleave', function() {
                const img = this.querySelector('.static-img');
                img.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>