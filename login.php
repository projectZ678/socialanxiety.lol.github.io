<?php
// login.php
session_start();
require_once 'config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = $_POST['identifier'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($identifier) || empty($password)) {
        $error = 'Please enter your username/email and password';
    } else {
        // Find user by username or email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$identifier, $identifier]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password_hash'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['profile_link'] = $user['profile_link'];
            
            $success = 'Login successful! Redirecting...';
            header('Refresh: 1; URL=/dashboard');
        } else {
            $error = 'Invalid username/email or password';
        }
    }
}

// Handle password reset
if (isset($_POST['reset_email'])) {
    $reset_email = $_POST['reset_email'];
    
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE email = ?");
    $stmt->execute([$reset_email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // Generate temporary password
        $temp_password = bin2hex(random_bytes(4));
        $password_hash = password_hash($temp_password, PASSWORD_DEFAULT);
        
        // Update password
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->execute([$password_hash, $user['id']]);
        
        $success = "Password reset! Your temporary password: <strong>$temp_password</strong><br>You can change it in your dashboard.";
    } else {
        $error = 'No account found with that email';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - socialanxiety.lol</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Same CSS as signup.php, just add modal styles */
        :root {
            --bg-dark: #000000;
            --bg-darker: #0a0a0a;
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --text-tertiary: rgba(255, 255, 255, 0.5);
            --border-color: rgba(255, 255, 255, 0.1);
            --accent-color: rgba(255, 255, 255, 0.15);
            --success-color: #4cd964;
            --error-color: #ff6b6b;
            --card-bg: rgba(20, 20, 20, 0.85);
            --card-border: rgba(255, 255, 255, 0.08);
            --gradient: linear-gradient(45deg, #fff, #aaa);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-dark);
            color: var(--text-primary);
            font-family: "Inter", -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Same particles and form styles as signup.php */

        /* Modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .modal-content {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .modal-header h2 {
            font-size: 1.5rem;
            font-weight: 300;
            letter-spacing: 2px;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 2rem;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .modal-close:hover {
            opacity: 1;
        }

        /* Add all other styles from signup.php */
    </style>
</head>
<body>
    <!-- Particles -->
    <canvas id="particlesCanvas"></canvas>

    <!-- Login Form -->
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <div class="logo">
                    <a href="/">socialanxiety.lol</a>
                </div>
                <h1 class="form-title">LOG IN</h1>
                <p class="form-subtitle">Access your profile</p>
            </div>

            <?php if ($error): ?>
                <div class="error-message" style="margin-bottom: 20px; padding: 12px; background: rgba(255, 107, 107, 0.1); border-radius: 8px;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success-message" style="margin-bottom: 20px; padding: 12px; background: rgba(76, 217, 100, 0.1); border-radius: 8px;">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="identifier" class="form-label">USERNAME OR EMAIL</label>
                    <input type="text" id="identifier" name="identifier" class="form-input" placeholder="username or email" value="<?php echo htmlspecialchars($_POST['identifier'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">PASSWORD</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>

                <button type="submit" class="form-btn">
                    LOG IN
                </button>
            </form>

            <div class="form-links">
                <a href="/signup" class="form-link">Create account</a>
                <a href="#" onclick="showResetModal()" class="form-link">Forgot password?</a>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div id="resetModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Reset Password</h2>
                <button class="modal-close" onclick="hideResetModal()">&times;</button>
            </div>
            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label">ENTER YOUR EMAIL</label>
                    <input type="email" name="reset_email" class="form-input" placeholder="email@example.com" required>
                    <p style="font-size: 12px; opacity: 0.7; margin-top: 8px;">We'll email you a temporary password</p>
                </div>
                <button type="submit" class="form-btn">Send Reset Email</button>
            </form>
        </div>
    </div>

    <script>
        // Initialize particles
        function initParticles() {
            const canvas = document.getElementById('particlesCanvas');
            if (!canvas) return;
            
            const ctx = canvas.getContext('2d');
            const particles = [];
            
            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            
            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 1.8 + 0.4;
                    this.vx = Math.random() * 0.4 - 0.2;
                    this.vy = Math.random() * 0.4 - 0.2;
                    this.o = Math.random() * 0.4 + 0.15;
                    this.color = Math.random() > 0.8 ? 
                        `rgba(180, 180, 255, ${this.o})` : 
                        `rgba(255, 255, 255, ${this.o})`;
                }
                
                update() {
                    this.x += this.vx;
                    this.y += this.vy;
                    
                    if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                    if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
                }
                
                draw() {
                    ctx.fillStyle = this.color;
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }
            
            function init() {
                resizeCanvas();
                for (let i = 0; i < 100; i++) {
                    particles.push(new Particle());
                }
            }
            
            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(particle => {
                    particle.update();
                    particle.draw();
                });
                requestAnimationFrame(animate);
            }
            
            init();
            animate();
            window.addEventListener('resize', resizeCanvas);
        }

        function showResetModal() {
            document.getElementById('resetModal').style.display = 'flex';
        }

        function hideResetModal() {
            document.getElementById('resetModal').style.display = 'none';
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', initParticles);
    </script>
</body>
</html>
