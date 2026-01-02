<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - socialanxiety.lol</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* === ALL STYLES === */
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
            overflow-x: hidden;
            min-height: 100vh;
            position: relative;
        }

        /* Particles Canvas */
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

        /* Navigation */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
        }

        .logo span {
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 2px;
            cursor: pointer;
        }

        .nav-links {
            display: flex;
            gap: 16px;
        }

        .nav-btn {
            padding: 10px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-primary);
            cursor: pointer;
            border: none;
            font-family: inherit;
        }

        .nav-btn.secondary {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        /* Form Container */
        .form-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
            z-index: 2;
        }

        .form-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
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

        .form-error {
            color: var(--error-color);
            font-size: 12px;
            margin-top: 8px;
            display: none;
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
            cursor: pointer;
        }

        .form-link:hover {
            opacity: 1;
            border-bottom-color: rgba(255, 255, 255, 0.8);
        }

        .form-message {
            font-size: 14px;
            text-align: center;
            margin-top: 20px;
            padding: 12px;
            border-radius: 8px;
            display: none;
        }

        .form-success {
            color: var(--success-color);
            background: rgba(76, 217, 100, 0.1);
        }

        .form-error-message {
            color: var(--error-color);
            background: rgba(255, 107, 107, 0.1);
        }

        /* Loading Spinner */
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-left-color: var(--text-primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 10px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 24px;
            background: var(--success-color);
            color: white;
            border-radius: 12px;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1000;
            animation: slideIn 0.3s ease;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .notification.error {
            background: var(--error-color);
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 16px;
            }
            
            .form-container {
                padding: 20px;
            }
            
            .form-card {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <!-- PARTICLES BACKGROUND -->
    <canvas id="particlesCanvas"></canvas>

    <!-- NAVIGATION -->
    <nav class="navbar">
        <div class="logo">
            <span onclick="window.location.href='/'">socialanxiety.lol</span>
        </div>
        <div class="nav-links">
            <button onclick="window.location.href='/signup.html'" class="nav-btn">Sign Up</button>
            <button onclick="window.location.href='/'" class="nav-btn secondary">Home</button>
        </div>
    </nav>

    <!-- LOGIN FORM -->
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h1 class="form-title">LOG IN</h1>
                <p class="form-subtitle">Access your profile</p>
            </div>

            <form id="loginForm">
                <div class="form-group">
                    <label for="identifier" class="form-label">USERNAME OR EMAIL</label>
                    <input type="text" id="identifier" class="form-input" placeholder="username or email" required>
                    <div class="form-error" id="identifierError"></div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">PASSWORD</label>
                    <input type="password" id="password" class="form-input" placeholder="••••••••" required>
                    <div class="form-error" id="passwordError"></div>
                </div>

                <button type="submit" class="form-btn" id="loginBtn">
                    <span id="btnText">LOG IN</span>
                </button>
                <div class="form-message" id="loginMessage"></div>
            </form>

            <div class="form-links">
                <a onclick="window.location.href='/signup.html'" class="form-link">Create account</a>
                <a onclick="showForgotPassword()" class="form-link">Forgot password?</a>
            </div>
        </div>
    </div>

    <script>
        // === DATABASE USING SUPABASE ===
        const SUPABASE_URL = 'https://kleonejdkmalzkgehhgt.supabase.co';
        const SUPABASE_ANON_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImtsZW9uZWpka21hbHprZ2VoaGd0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjczODc1MjksImV4cCI6MjA4Mjk2MzUyOX0.5YmLdNK_-1ZydX6tVOXBFMmv9IChj8Ta8O-WLYERDQw';

        // === INITIALIZE PARTICLES ===
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

        // === SHOW NOTIFICATION ===
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type === 'error' ? 'error' : ''}`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // === SHOW ERROR ===
        function showError(elementId, message) {
            const element = document.getElementById(elementId);
            if (element) {
                element.textContent = message;
                element.style.display = 'block';
            }
        }

        // === CLEAR ERRORS ===
        function clearErrors() {
            document.querySelectorAll('.form-error').forEach(el => {
                el.style.display = 'none';
                el.textContent = '';
            });
        }

        // === HASH PASSWORD ===
        async function hashPassword(password) {
            const encoder = new TextEncoder();
            const data = encoder.encode(password + 'socialanxiety_salt_2024');
            const hashBuffer = await crypto.subtle.digest('SHA-256', data);
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
        }

        // === SUPABASE CLIENT ===
        const supabase = {
            from: (table) => {
                return {
                    select: (columns = '*') => ({
                        eq: (column, value) => ({
                            single: async () => {
                                try {
                                    const response = await fetch(`${SUPABASE_URL}/rest/v1/${table}?${column}=eq.${value}&select=${columns}`, {
                                        headers: {
                                            'apikey': SUPABASE_ANON_KEY,
                                            'Authorization': `Bearer ${SUPABASE_ANON_KEY}`,
                                            'Content-Type': 'application/json'
                                        }
                                    });
                                    if (!response.ok) throw new Error('Network error');
                                    const data = await response.json();
                                    return { data: data[0], error: data.length === 0 ? { message: 'Not found' } : null };
                                } catch (error) {
                                    return { data: null, error };
                                }
                            }
                        }),
                        or: (condition) => ({
                            single: async () => {
                                try {
                                    const response = await fetch(`${SUPABASE_URL}/rest/v1/${table}?${condition}&select=${columns}`, {
                                        headers: {
                                            'apikey': SUPABASE_ANON_KEY,
                                            'Authorization': `Bearer ${SUPABASE_ANON_KEY}`,
                                            'Content-Type': 'application/json'
                                        }
                                    });
                                    if (!response.ok) throw new Error('Network error');
                                    const data = await response.json();
                                    return { data: data[0], error: data.length === 0 ? { message: 'Not found' } : null };
                                } catch (error) {
                                    return { data: null, error };
                                }
                            }
                        })
                    })
                };
            }
        };

        // === FORM SUBMISSION ===
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const identifier = document.getElementById('identifier').value.trim();
            const password = document.getElementById('password').value;
            
            // Clear errors
            clearErrors();
            
            // Validation
            if (!identifier) {
                showError('identifierError', 'Username or email required');
                return;
            }
            
            if (!password) {
                showError('passwordError', 'Password required');
                return;
            }
            
            const btn = document.getElementById('loginBtn');
            const btnText = document.getElementById('btnText');
            btnText.innerHTML = '<span class="spinner"></span>Logging in...';
            btn.disabled = true;
            
            try {
                // Find user by username or email
                const { data: users, error } = await supabase
                    .from('users')
                    .select('*')
                    .or(`username.eq.${identifier.toLowerCase()},email.eq.${identifier.toLowerCase()}`);
                
                if (error || !users || users.length === 0) {
                    showError('identifierError', 'Invalid username or email');
                    throw new Error('User not found');
                }
                
                const user = users[0];
                
                // Verify password
                const passwordHash = await hashPassword(password);
                if (passwordHash !== user.password_hash) {
                    showError('passwordError', 'Invalid password');
                    throw new Error('Invalid password');
                }
                
                // Fetch user profile
                const { data: profiles, error: profileError } = await fetch(`${SUPABASE_URL}/rest/v1/profiles?user_id=eq.${user.id}`, {
                    headers: {
                        'apikey': SUPABASE_ANON_KEY,
                        'Authorization': `Bearer ${SUPABASE_ANON_KEY}`,
                        'Content-Type': 'application/json'
                    }
                }).then(res => res.json());
                
                const profile = profiles ? profiles[0] : null;
                
                // Store user in localStorage
                const userData = {
                    id: user.id,
                    username: user.username,
                    email: user.email,
                    profileLink: user.profile_link,
                    createdAt: user.created_at,
                    customizations: profile || {
                        pfp_url: 'https://i.pinimg.com/736x/70/35/7d/70357d016a70c4be051145972893c04e.jpg',
                        banner_url: 'https://images.unsplash.com/photo-1614850523060-8da1d56ae167?w=1200&h=400&fit=crop',
                        music_url: '',
                        bio: '',
                        theme: 'dark',
                        stats_views: 0,
                        stats_visitors: 0
                    }
                };
                localStorage.setItem('socialanxiety_user', JSON.stringify(userData));
                
                // Show success message
                const message = document.getElementById('loginMessage');
                message.textContent = 'Login successful! Redirecting...';
                message.className = 'form-message form-success';
                message.style.display = 'block';
                
                showNotification('Logged in successfully!');
                
                // Redirect to dashboard
                setTimeout(() => {
                    window.location.href = '/dashboard.html';
                }, 1000);
                
            } catch (error) {
                console.error('Login error:', error);
                showError('identifierError', 'Invalid credentials');
                showNotification('Error logging in', 'error');
            } finally {
                btnText.textContent = 'LOG IN';
                btn.disabled = false;
            }
        });

        // === FORGOT PASSWORD ===
        function showForgotPassword() {
            const email = prompt('Enter your email to reset password:');
            if (email) {
                showNotification(`Password reset link sent to ${email}`);
            }
        }

        // === INITIALIZE ===
        document.addEventListener('DOMContentLoaded', () => {
            initParticles();
            
            // Check if already logged in
            const userData = localStorage.getItem('socialanxiety_user');
            if (userData) {
                window.location.href = '/dashboard.html';
            }
        });
    </script>
</body>
</html>
