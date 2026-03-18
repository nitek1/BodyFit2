<?php
session_start();
require_once 'auth_check.php';
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BodyFit - Aulas</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Barra de Navegação Atualizada -->
    <nav class="navbar">
        <a href="index.html" class="logo">
            <img src="imagens/bodyfit.png" alt="BodyFit Logo" class="logo-img">
            <span class="logo-text">BODY<span>FIT</span></span>
        </a>

        <div class="nav-links">
            <a href="index.html">Home</a>
            <a href="Aulas.php" class="active">Aulas</a>
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

    <!-- Seção Hero -->
    <section class="classes-hero">
        <div class="hero-content">
            <h2>SUA EVOLUÇÃO COMEÇA AQUI</h2>
            <p>+ de 50 aulas semanais de musculação e força</p>
        </div>
    </section>

    <!-- Cards de Aulas Atualizados -->
    <div class="classes-container">
        <div class="class-filter">
            <input type="text" placeholder="Buscar aula..." id="searchInput">
            <select id="categoryFilter">
                <option value="all">Todas Categorias</option>
                <option value="musculacao">Musculação</option>
                <option value="funcional">Funcional</option>
                <option value="hiit">HIIT</option>
                <option value="powerlifting">Powerlifting</option>
            </select>
        </div>

        <div class="classes-grid">
            <!-- Card 1 -->
            <div class="class-card" data-category="musculacao">
                <div class="image-container">
                    <div class="static-img" style="background-image: url('imagens/Musculação Intensa.jpg')"></div>
                    <div class="hover-g极" style="background-image: url('Treino de Força Máxima.jpg')"></div>
                </div>
                <h4>Musculação Intensa</h4>
                <div class="schedule">
                    <span>⏰ 07:00 - 08:30</span>
                    <span>🏋️ Nível Intermediário</span>
                    <form method="POST" action="reserva.php" class="reserve-form">
                        <input type="hidden" name="id_aula" value="4">
                        <button type="submit" class="reserve-btn">Reservar Aula</button>
                    </form>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="class-card" data-category="musculacao">
                <div class="image-container">
                    <div class="static-img" style="background-image: url('imagens/Treino de Força Máxima.jpg')"></div>
                    <div class="hover-gif" style="background-image: url('Musculação Intensa.jpg')"></div>
                </div>
                <h4>Treino de Força Máxima</h4>
                <div class="schedule">
                    <span>⏰ 12:00 - 13:30</span>
                    <span>🏋️ Nível Avançado</span>
                    <form method="POST" action="reserva.php" class="reserve-form">
                        <input type="hidden" name="id_aula" value="5">
                        <button type="submit" class="reserve-btn">Reservar Aula</button>
                    </form>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="class-card" data-category="hiit">
                <div class="image-container">
                    <div class="static-img" style="background-image: url('imagens/HIT EXPLOSIVO.jpg')"></div>
                    <div class="hover-gif" style="background-image: url('HIIT EXPLOSIVO.jpg')"></div>
                </div>
                <h4>HIIT Explosivo</h4>
                <div class="schedule">
                    <span>⏰ 18:00 - 19:00</span>
                    <span>🔥 Queima de Gordura</span>
                    <form method="POST" action="reserva.php" class="reserve-form">
                        <input type="hidden" name="id_aula" value="6">
                        <button type="submit" class="reserve-btn">Reservar Aula</button>
                    </form>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="class-card" data-category="musculacao">
                <div class="image-container">
                    <div class="static-img" style="background-image: url('imagens/Agachamento Pesado.png')"></div>
                    <div class="hover-gif" style="background-image: url('imagens/agachamento-gif.jpg')"></div>
                </div>
                <h4>Agachamento Pesado</h4>
                <div class="schedule">
                    <span>⏰ 09:00 - 10:30</span>
                    <span>🏋️ Nível Avançado</span>
                    <form method="POST" action="reserva.php" class="reserve-form">
                        <input type="hidden" name="id_aula" value="7">
                        <button type="submit" class="reserve-btn">Reservar Aula</button>
                    </form>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="class-card" data-category="musculacao">
                <div class="image-container">
                    <div class="static-img" style="background-image: url('imagens/Leg Press Explosivo.png')"></div>
                    <div class="hover-gif" style="background-image: url('imagens/leg-press-gif.jpg')"></div>
                </div>
                <h4>Leg Press Explosivo</h4>
                <div class="schedule">
                    <span>⏰ 14:00 - 15:30</span>
                    <span>🏋️ Nível Intermediário</span>
                    <form method="POST" action="reserva.php" class="reserve-form">
                        <input type="hidden" name="id_aula" value="8">
                        <button type="submit" class="reserve-btn">Reservar Aula</button>
                    </form>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="class-card" data-category="musculacao">
                <div class="image-container">
                    <div class="static-img" style="background-image: url('imagens/Afundo com Barra.png')"></div>
                    <div class="hover-gif" style="background-image: url('imagens/afundo-gif.jpg')"></div>
                </div>
                <h4>Afundo com Barra</h4>
                <div class="schedule">
                    <span>⏰ 16:00 - 17:30</极>
                    <span>🏋️ Nível Avançado</span>
                    <form method="POST" action="reserva.php" class="reserve-form">
                        <input type="hidden" name="id_aula" value="9">
                        <button type="submit" class="reserve-btn">Reservar Aula</button>
                    </form>
                </div>
            </div>

            <!-- Card 7 -->
            <div class="class-card" data-category="musculacao">
                <div class="image-container">
                    <div class="static-img" style="background-image: url('imagens/Stiff Terra.png')"></div>
                    <div class="hover-gif" style="background-image: url('imagens/stiff-gif.jpg')"></div>
                </div>
                <h4>Stiff Terra</h4>
                <div class="schedule">
                    <span>⏰ 19:00 - 20:30</span>
                    <span>🏋️ Nível Intermediário</span>
                    <form method="POST" action="reserva.php" class="reserve-form">
                        <input type="hidden" name="id_aula" value="10">
                        <button type="submit" class="reserve-btn">Reservar Aula</button>
                    </form>
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
    </div>

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

        // Filtragem de Aulas
        document.getElementById('categoryFilter').addEventListener('change', filterClasses);
        document.getElementById('searchInput').addEventListener('keyup', filterClasses);
        
        function filterClasses() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const category = document.getElementById('categoryFilter').value;
            
            document.querySelectorAll('.class-card').forEach(card => {
                const matchesSearch = card.querySelector('h4').textContent.toLowerCase().includes(search);
                const matchesCategory = category === 'all' || card.dataset.category === category;
                card.style.display = (matchesSearch && matchesCategory) ? 'block' : 'none';
            });
        }
    </script>

    <script>
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