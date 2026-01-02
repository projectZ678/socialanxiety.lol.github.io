<?php
// signup.php
session_start();
require_once 'config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required';
    } elseif (strlen($username) < 3) {
        $error = 'Username must be at least 3 characters';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = 'Username can only contain letters, numbers, and underscores';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        // Check if username or email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
            $error = 'Username or email already exists';
        } else {
            // Create user
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $profile_link = strtolower($username);
            
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, profile_link) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $email, $password_hash, $profile_link]);
            
            $user_id = $pdo->lastInsertId();
            
            // Create profile
            $pfp_url = "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($username);
            $banner_url = "https://images.unsplash.com/photo-1614850523060-8da1d56ae167?w=1200&h=400&fit=crop";
            
            $stmt = $pdo->prepare("INSERT INTO profiles (user_id, username, pfp_url, banner_url) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user_id, $username, $pfp_url, $banner_url]);
            
            // Set session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['profile_link'] = $profile_link;
            
            $success = 'Account created successfully!';
            header('Refresh: 2; URL=/dashboard');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - socialanxiety.lol</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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

        /* Particles */
        #particlesCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
            filter: grayscale(100%);
        }

        /* Form Container */
        .form-container {
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 2;
        }

        .form-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 40px;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .logo a {
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 2px;
            text-decoration: none;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 300;
            letter-spacing: 3px;
            margin-bottom: 12px;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-subtitle {
            font-size: 14px;
            opacity: 0.6;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
            opacity: 0.7;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            color: var(--text-primary);
            font-size: 16px;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.05);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
            letter-spacing: 1px;
        }

        .error-message {
            color: var(--error-color);
            font-size: 14px;
            margin-top: 8px;
            display: block;
        }

        .success-message {
            color: var(--success-color);
            font-size: 14px;
            margin-top: 8px;
            display: block;
        }

        .form-btn {
            width: 100%;
            padding: 18px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            color: var(--text-primary);
            font-size: 16px;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            border: none;
            font-family: inherit;
        }

        .form-btn:hover:not(:disabled) {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .form-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .form-links {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
            font-size: 14px;
            opacity: 0.7;
        }

        .form-link {
            color: var(--text-primary);
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            padding-bottom: 2px;
            transition: all 0.3s ease;
        }

        .form-link:hover {
            opacity: 1;
            border-bottom-color: rgba(255, 255, 255, 0.8);
        }

        @media (max-width: 768px) {
            .form-card {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <!-- Particles -->
    <canvas id="particlesCanvas"></canvas>

    <!-- Signup Form -->
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <div class="logo">
                    <a href="/">socialanxiety.lol</a>
                </div>
                <h1 class="form-title">CREATE PROFILE</h1>
                <p class="form-subtitle">Claim your unique link</p>
            </div>

            <?php if ($error): ?>
                <div class="error-message" style="margin-bottom: 20px; padding: 12px; background: rgba(255, 107, 107, 0.1); border-radius: 8px;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success-message" style="margin-bottom: 20px; padding: 12px; background: rgba(76, 217, 100, 0.1); border-radius: 8px;">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username" class="form-label">USERNAME</label>
                    <input type="text" id="username" name="username" class="form-input" placeholder="choose username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">EMAIL</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="email@example.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">PASSWORD</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password" class="form-label">CONFIRM PASSWORD</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-input" placeholder="••••••••" required>
                </div>

                <button type="submit" class="form-btn">
                    CREATE ACCOUNT
                </button>
            </form>

            <div class="form-links">
                <a href="/login" class="form-link">Already have an account?</a>
                <a href="/" class="form-link">Back to home</a>
            </div>
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

        // Initialize
        document.addEventListener('DOMContentLoaded', initParticles);
    </script>
</body>
</html>
