<?php 
session_start();
require_once 'auth_check.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BodyFit - Crossfit</title>
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
            <svg width="24" height="24" viewBox="0 极 24 24">
                <path fill="currentColor" d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
            </svg>
        </button>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 style="color: white;">CROSSFIT</h1>
            <p>Treinos de alta intensidade para todos os níveis</p>
        </div>
    </section>

    <!-- Seção de Aulas -->
    <section class="section">
        <h2 style="text-align: center; margin-bottom: 2rem; color: white;">AULAS DE CROSSFIT</h2>
        
        <div class="classes-container">
            <div class="classes-grid" style="justify-content: center;">
                <!-- Aula 1 -->
                <div class="class-card">
                    <div class="image-container">
                        <div class="static-img" style="background-image: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b')"></div>
                        <div class="hover-gif" style="background-image: url('')"></div>
                    </div>
                    <div class="schedule">
                        <h3>Crossfit Intenso</h3>
                        <p>Seg a Sex: 7h - 8h</p>
                        <p>Sábado: 9h - 10h</p>
                        <form method="POST" action="reserva.php" class="reserve-form">
                            <input type="hidden" name="id_aula" value="11">
                            <button type="submit" class="reserve-btn">Reservar Aula</button>
                        </form>
                    </div>
                </div>

                <!-- Aula 2 -->
                <div class="class-card">
                    <div class="image-container">
                        <div class="static-img" style="background-image: url('https://images.unsplash.com/photo-1552674605-db6ffd4facb5')"></div>
                        <div class="hover-gif" style="background-image: url('')"></div>
                    </div>
                    <div class="schedule">
                        <h3>WOD Desafio</h3>
                        <p>Seg a Sex: 12h - 13h</p>
                        <p>Sábado: 11h - 12h</p>
                        <form method="POST" action="reserva.php" class="reserve-form">
                            <input type="hidden" name="id_aula" value="12">
                            <button type="submit" class="reserve-btn">Reservar Aula</button>
                        </form>
                    </div>
                </div>

                <!-- Aula 3 -->
                <div class="class-card">
                    <div class="image-container">
                        <div class="static-img" style="background-image: url('imagens/crossfitrunners.jpg')"></div>
                        <div class="hover-gif" style="background-image: url('')"></div>
                    </div>
                    <div class="schedule">
                        <h3>Endurance Crossfit</h3>
                        <p>Seg a Sex: 18h - 19h30</p>
                        <form method="POST" action="reserva.php" class="reserve-form">
                            <input type="hidden" name="id_aula" value="13">
                            <button type="submit" class="reserve-btn">Reservar Aula</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="training-stats">
            <div class="stat-card">
                <h3>📈 Sua Evolução Semanal</h3>
                <div class="progress-bar">
                    <div class="progress" style="width: 75%">75%</div>
                </div>
                <p>Complete 4 treinos para alcançar sua meta!</p>
            </div>
        </div>
    </section>

    <!-- Rodapé -->
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
        // Menu Mobile
        document.querySelector('.menu-toggle').addEventListener('click', () => {
            document.querySelector('.nav-links').classList.toggle('show');
        });

        // Sistema de Notificação
        function showReservationConfirmation() {
            const notification = document.createElement('div');
            notification.className = 'reservation-notification';
            notification.innerHTML = `
                <i class="bi bi-trophy-fill"></i>
                <span>Aula reservada com sucesso!</span>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Adicionar evento aos formulários de reserva
        document.querySelectorAll('.reserve-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Enviar o formulário via AJAX
                fetch('reserva.php', {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        showReservationConfirmation();
                    } else {
                        alert('Erro ao reservar: ' + (data.error || 'Erro desconhecido'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erro ao reservar aula. Tente novamente.');
                });
            });
        });
    </script>
</body>
</html>

