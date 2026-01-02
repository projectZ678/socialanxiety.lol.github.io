<?php
// index.php - Home Page
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>socialanxiety.lol - Your Personal Space Online</title>
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
            overflow-x: hidden;
            min-height: 100vh;
            position: relative;
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

        /* Click to Enter */
        #enterScreen {
            position: fixed;
            inset: 0;
            background: var(--bg-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            cursor: pointer;
            transition: opacity 1.2s ease;
        }

        #enterText {
            font-size: 26px;
            letter-spacing: 6px;
            opacity: 0.85;
            animation: breathe 2.5s ease-in-out infinite;
        }

        @keyframes breathe {
            0%, 100% { opacity: 0.85; }
            50% { opacity: 0.4; }
        }

        /* Main Container */
        #app {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 1.4s ease, transform 1.4s ease;
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

        .logo a {
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 2px;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 16px;
        }

        .nav-btn {
            padding: 10px 24px;
            border-radius: 12px;
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
            text-decoration: none;
            display: inline-block;
        }

        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 120px 40px 40px;
            text-align: center;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 300;
            letter-spacing: 4px;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .gradient-text {
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 600;
        }

        .hero-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .cta-btn {
            padding: 18px 36px;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 500;
            letter-spacing: 2px;
            transition: all 0.3s ease;
            min-width: 200px;
            text-align: center;
            cursor: pointer;
            border: none;
            font-family: inherit;
            text-decoration: none;
            display: inline-block;
        }

        .cta-btn.primary {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-primary);
        }

        .cta-btn.secondary {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
        }

        .cta-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        /* Stats */
        .stats {
            padding: 60px 40px;
            text-align: center;
            background: rgba(255, 255, 255, 0.02);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            max-width: 800px;
            margin: 0 auto;
        }

        .stat-item {
            padding: 30px;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 300;
            margin-bottom: 10px;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-label {
            font-size: 14px;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: 0.7;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .navbar {
                padding: 16px;
            }
            
            .hero-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .cta-btn {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>

<!-- CLICK TO ENTER -->
<div id="enterScreen">
    <div id="enterText">CLICK TO ENTER</div>
</div>

<!-- PARTICLES -->
<canvas id="particlesCanvas"></canvas>

<!-- MAIN APP -->
<div id="app">
    <nav class="navbar">
        <div class="logo">
            <a href="/">socialanxiety.lol</a>
        </div>
        <div class="nav-links">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/dashboard" class="nav-btn">Dashboard</a>
                <a href="/logout" class="nav-btn">Logout</a>
            <?php else: ?>
                <a href="/login" class="nav-btn">Login</a>
                <a href="/signup" class="nav-btn">Sign Up</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-content">
            <h1 class="hero-title"><span class="gradient-text">socialanxiety.lol</span></h1>
            <p style="font-size: 1.2rem; color: var(--text-secondary); margin-bottom: 40px; max-width: 600px; margin: 0 auto 40px;">
                Your personal space on the internet. Create a beautiful profile with your unique link.
            </p>
            
            <div class="hero-actions">
                <a href="/signup" class="cta-btn primary">Get Started</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/dashboard" class="cta-btn secondary">Go to Dashboard</a>
                <?php else: ?>
                    <a href="/login" class="cta-btn secondary">Already have account?</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <section class="stats">
        <h2 style="font-size: 2.5rem; font-weight: 300; letter-spacing: 4px; margin-bottom: 60px;" class="gradient-text">Our Community</h2>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number" id="userCount">1254</div>
                <div class="stat-label">Active Users</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="profileCount">892</div>
                <div class="stat-label">Profiles Created</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="viewCount">45678</div>
                <div class="stat-label">Profile Views</div>
            </div>
        </div>
    </section>
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

    // Handle click to enter
    document.getElementById('enterScreen').addEventListener('click', () => {
        document.getElementById('enterScreen').style.opacity = '0';
        setTimeout(() => {
            document.getElementById('enterScreen').style.display = 'none';
            document.getElementById('app').style.opacity = '1';
            document.getElementById('app').style.transform = 'translateY(0)';
        }, 1200);
    });

    // Animate stats
    function animateCount(elementId, target) {
        const element = document.getElementById(elementId);
        if (!element) return;
        
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toLocaleString();
        }, 30);
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        initParticles();
        animateCount('userCount', 1254);
        animateCount('profileCount', 892);
        animateCount('viewCount', 45678);
    });
</script>
</body>
</html>
