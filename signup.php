<?php
// signup.php
session_start();
require_once 'config/supabase.php';

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
        // Check if username exists
        $existingUser = $supabase->getUserByUsername($username);
        if ($existingUser) {
            $error = 'Username already taken';
        } else {
            // Hash password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Create user
            $user_data = $supabase->createUser($username, $email, $password_hash, $username);
            
            if ($user_data && isset($user_data[0]['id'])) {
                $user = $user_data[0];
                
                // Create profile
                $pfp_url = "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($username);
                $profile_data = $supabase->createProfile($user['id'], $username, $pfp_url);
                
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['profile_link'] = $user['profile_link'];
                
                $success = 'Account created successfully! Redirecting...';
                header('Refresh: 2; URL=/dashboard');
            } else {
                $error = 'Failed to create account. Please try again.';
            }
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
        <?php include 'assets/css/auth.css'; ?>
        /* Or copy the CSS from earlier signup examples */
    </style>
</head>
<body>
    <canvas id="particlesCanvas"></canvas>
    
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
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
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

                <button type="submit" class="form-btn">CREATE ACCOUNT</button>
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

        // Real-time username check
        const usernameInput = document.getElementById('username');
        if (usernameInput) {
            let timeout;
            usernameInput.addEventListener('input', function() {
                clearTimeout(timeout);
                const username = this.value.trim();
                
                if (username.length < 3) return;
                
                timeout = setTimeout(async () => {
                    try {
                        const response = await fetch(`/api/check-username?username=${encodeURIComponent(username)}`);
                        const data = await response.json();
                        
                        if (data.available) {
                            // Show available indicator
                        } else {
                            // Show error
                        }
                    } catch (error) {
                        console.error('Error checking username:', error);
                    }
                }, 500);
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', initParticles);
    </script>
</body>
</html>
