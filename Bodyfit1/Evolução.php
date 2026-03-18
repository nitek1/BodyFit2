<?php
session_start();
require_once 'auth_check.php'; 
require_once 'config.php';
  
$progresso = getTableData($conn, 'progresso');

$success = '';
$error = '';

// Processar formulário de progresso
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Verificar se o usuário está logado usando a variável correta
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("Usuário não está logado.");
        }
        
        $id_usuario = $_SESSION['user_id'];
        $data = $_POST['date'];
        $peso = $_POST['weight'];
        $altura = $_POST['height'];
        $massa_muscular = $_POST['muscle'];
        $forca = $_POST['strength'];
        $resistencia = $_POST['endurance'];
        $explosividade = $_POST['explosiveness'];
        $velocidade = $_POST['speed'];
        $intensidade = $_POST['intensity'];
        
        $query = "INSERT INTO progresso (id_usuario, data, peso, altura, massa_muscular, forca, resistencia, explosividade, velocidade, intensidade) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = array(
            $id_usuario,
            $data,
            $peso,
            $altura,
            $massa_muscular,
            $forca,
            $resistencia,
            $explosividade,
            $velocidade,
            $intensidade
        );
        
        executeQuery($conn, $query, $params);
        $success = "Progresso registrado com sucesso!";
        
    } catch (Exception $e) {
        $error = "Erro ao registrar progresso: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BodyFit - Evolução</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Estilos adicionais para integração do formulário de progresso */
        .progress-form-section {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
        
        .progress-form-section .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .progress-form-section .logo h1 {
            color: #2c3e50;
            font-size: 2.2em;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .progress-form-section .logo span {
            color: #e74c3c;
        }
        
        .progress-form-section .form-group {
            margin-bottom: 15px;
        }
        
        .progress-form-section .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #34495e;
            font-weight: bold;
        }
        
        .progress-form-section .form-group input {
            width: 100%;
            padding: 10px;
            border: 2px solid #bdc3c7;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        .progress-form-section .form-group input:focus {
            outline: none;
            border-color: #e74c3c;
        }
        
        .progress-form-section .login-btn {
            width: 100%;
            padding: 12px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 10px;
        }
        
        .progress-form-section .login-btn:hover {
            background: #c0392b;
        }
        
        .performance-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }
        
        /* Estilos para alertas */
        .alert {
            padding: 15px;
            margin: 20px auto;
            max-width: 600px;
            border-radius: 5px;
            text-align: center;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        @media (max-width: 768px) {
            .progress-form-section {
                padding: 20px;
            }
            
            .progress-form-section .logo h1 {
                font-size: 1.8em;
            }
            
            .performance-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Exibir mensagens -->
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <nav class="navbar">
        <a href="index.html" class="logo">
            <img src="imagens/bodyfit.png" alt="BodyFit Logo" class="logo-img">
            <span class="logo-text">BODY<span>FIT</span></span>
        </a>
    
        <div class="nav-links">
            <a href="index.html">Home</a>
            <a href="Aulas.php">Aulas</a>
            <a href="Evolução.php" class="active">Evolução</a>
            
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

    <section class="hero">
        <div class="hero-content">
            <h2>SUA EVOLUÇÃO FITNESS</h2>
            <p>Acompanhe seu progresso e conquistas</p>
        </div>
    </section>

    <div class="stats-container">
        <div class="stats-card">
            <h3>Resumo do Progresso</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-value">-8.5kg</div>
                    <div class="stat-label">Perda de Peso</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">+5kg</div>
                    <div class="stat-label">Massa Muscular</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Seção do Formulário no estilo login -->
    <div class="progress-form-section">
        <div class="logo">
            <h1>
                <img src="imagens/bodyfit.png" alt="Logo" width="60" height="60">
                BODY<span>FIT</span>
            </h1>
        </div>
        <h2 style="text-align: center; margin-bottom: 20px; color: #2c3e50;">Registrar Novo Progresso</h2>
        
        <form method="POST">
            <div class="form-group">
                <label for="date">Data</label>
                <input type="date" id="date" name="date" required>
            </div>
            
            <div class="form-group">
                <label for="weight">Peso (kg)</label>
                <input type="number" id="weight" name="weight" step="0.1" required>
            </div>

            <div class="form-group">
                <label for="height">Altura (cm)</label>
                <input type="number" id="height" name="height" min="0" required>
            </div>

            <div class="form-group">
                <label for="muscle">Massa Muscular (kg)</label>
                <input type="number" id="muscle" name="muscle" step="0.1" required>
            </div>

            <div class="form-group">
                <h4 style="text-align: center; margin: 20px 0 10px; color: #2c3e50;">Desempenho nas Aulas</h4>
                <div class="performance-grid">
                    <div class="form-group">
                        <label for="strength">Força</label>
                        <input type="number" id="strength" name="strength" min="0" max="100" required>
                    </div>
                    <div class="form-group">
                        <label for="endurance">Resistência</label>
                        <input type="number" id="endurance" name="endurance" min="0" max="100" required>
                    </div>
                    <div class="form-group">
                        <label for="explosiveness">Explosividade</label>
                        <input type="number" id="explosiveness" name="explosiveness" min="0" max="100" required>
                    </div>
                    <div class="form-group">
                        <label for="speed">Velocidade</label>
                        <input type="number" id="speed" name="speed" min="0" max="100" required>
                    </div>
                    <div class="form-group">
                        <label for="intensity">Intensidade</label>
                        <input type="number" id="intensity" name="intensity" min="0" max="100" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="login-btn">Registrar Progresso</button>
        </form>
    </div>

    <div class="charts-container">
        <div class="chart-card">
            <h3>Progresso Mensal</h3>
            <canvas id="progressChart"></canvas>
        </div>
        
        <div class="chart-card">
            <h3>Desempenho nas Aulas</h3>
            <canvas id="performanceChart"></canvas>
        </div>
    </div>

    <section class="calendar-section">
        <div class="stats-container">
            <div class="stats-card">
                <h3 style="text-align: center; margin-bottom: 1.5rem;">CALENDÁRIO DE TREINOS</h3>
                <div class="calendar-container">
                    <div class="calendar-header">
                        <button class="nav-button">&lt;</button>
                        <h4>Janeiro 2025</h4>
                        <button class="nav-button">&gt;</button>
                    </div>
                    <div class="calendar-grid">
                        <div class="calendar-weekday">Dom</div>
                        <div class="calendar-weekday">Seg</div>
                        <div class="calendar-weekday">Ter</div>
                        <div class="calendar-weekday">Qua</div>
                        <div class="calendar-weekday">Qui</div>
                        <div class="calendar-weekday">Sex</div>
                        <div class="calendar-weekday">Sáb</div>
                        
                        <!-- Dias do mês -->
                        <div class="calendar-day">1</div>
                        <div class="calendar-day workout-day">2<div class="workout-marker">HIIT</div></div>
                        <div class="calendar-day">3</div>
                        <div class="calendar-day workout-day">4<div class="workout-marker">Força</div></div>
                        <div class="calendar-day">5</div>
                        <div class="calendar-day workout-day">6<div class="workout-marker">Crossfit</div></div>
                        <div class="calendar-day">7</div>
                        <!-- Repetir para os demais dias -->
                    </div>
                </div>
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
        // Gráfico de Linha - Progresso
        const ctx1 = document.getElementById('progressChart');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai'],
                datasets: [{
                    label: 'Peso (kg)',
                    data: [85, 82, 80, 78, 76.5],
                    borderColor: '#E30613',
                    tension: 0.4
                },
                {
                    label: 'Massa Muscular (kg)',
                    data: [62, 63.5, 65, 66, 67],
                    borderColor: '#000',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Gráfico de Radar - Desempenho
        const ctx2 = document.getElementById('performanceChart');
        new Chart(ctx2, {
            type: 'radar',
            data: {
                labels: ['Força', 'Resistência', 'Explosividade', 'Velocidade', 'Intensidade'],
                datasets: [{
                    label: 'HIIT Explosivo',
                    data: [85, 90, 92, 88, 95],
                    backgroundColor: 'rgba(227, 6, 19, 0.2)',
                    borderColor: '#E30613'
                },
                {
                    label: 'Força Máxima',
                    data: [92, 85, 80, 90, 87],
                    backgroundColor: 'rgba(0, 0, 0, 0.2)',
                    borderColor: '#000'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
</body>
</html>