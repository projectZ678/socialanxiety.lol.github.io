<?php
// profile.php - Dynamic profile pages
header('Content-Type: text/html; charset=utf-8');

$username = $_GET['username'] ?? '';

if (empty($username)) {
    header('Location: /');
    exit;
}

// Simple database connection
$host = 'localhost';
$dbname = 'socialanxiety';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR profile_link = ?");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        die("Profile not found");
    }
    
    // Fetch profile
    $stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = ?");
    $stmt->execute([$user['id']]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Increment view count
    if ($profile) {
        $stmt = $pdo->prepare("UPDATE profiles SET stats_views = stats_views + 1 WHERE id = ?");
        $stmt->execute([$profile['id']]);
    }
    
} catch (PDOException $e) {
    die("Database error");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['username']); ?> - socialanxiety.lol</title>
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

        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        /* Profile Container */
        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 120px 40px 40px;
            position: relative;
            z-index: 2;
        }

        .profile-banner {
            height: 300px;
            background: linear-gradient(45deg, #333, #666);
            background-size: cover;
            background-position: center;
            border-radius: 20px;
            margin-bottom: -100px;
            position: relative;
            background-image: url('<?php echo htmlspecialchars($profile['banner_url'] ?? 'https://images.unsplash.com/photo-1614850523060-8da1d56ae167?w=1200&h=400&fit=crop'); ?>');
        }

        .banner-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7));
            border-radius: 20px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 40px;
        }

        .profile-picture {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            border: 6px solid var(--bg-dark);
            overflow: hidden;
            background: var(--bg-dark);
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            font-size: 3rem;
            font-weight: 300;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }

        .profile-link {
            font-size: 1.2rem;
            opacity: 0.7;
            margin-bottom: 16px;
        }

        .profile-bio {
            font-size: 1.1rem;
            opacity: 0.8;
            line-height: 1.6;
            max-width: 600px;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 40px 0;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 300;
            margin-bottom: 4px;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-label {
            font-size: 12px;
            letter-spacing: 1px;
            opacity: 0.7;
            text-transform: uppercase;
        }

        .profile-actions {
            display: flex;
            gap: 16px;
            margin-top: 30px;
        }

        .action-btn {
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: var(--text-primary);
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            font-family: inherit;
        }

        .action-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        /* Music Player */
        .music-player {
            text-align: center;
            padding: 30px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            margin-top: 40px;
        }

        .music-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .music-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-primary);
            font-size: 20px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: none;
        }

        .music-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: scale(1.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }
            
            .profile-picture {
                width: 140px;
                height: 140px;
            }
            
            .profile-name {
                font-size: 2rem;
            }
            
            .profile-actions {
                justify-content: center;
            }
            
            .navbar {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Particles -->
    <canvas id="particlesCanvas"></canvas>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">
            <a href="/" style="text-decoration: none; color: inherit;">
                <span>socialanxiety.lol</span>
            </a>
        </div>
        <div class="nav-links">
            <a href="/" class="nav-btn">Home</a>
            <a href="/dashboard" class="nav-btn">Dashboard</a>
        </div>
    </nav>

    <!-- Profile Content -->
    <div class="profile-container">
        <div class="profile-banner">
            <div class="banner-overlay"></div>
        </div>

        <div class="profile-header">
            <div class="profile-picture">
                <img src="<?php echo htmlspecialchars($profile['pfp_url'] ?? 'https://i.pinimg.com/736x/70/35/7d/70357d016a70c4be051145972893c04e.jpg'); ?>" alt="<?php echo htmlspecialchars($user['username']); ?>">
            </div>
            <div class="profile-info">
                <h1 class="profile-name">@<?php echo htmlspecialchars($user['username']); ?></h1>
                <div class="profile-link">socialanxiety.lol/<?php echo htmlspecialchars($user['profile_link']); ?></div>
                <?php if (!empty($profile['bio'])): ?>
                    <p class="profile-bio"><?php echo htmlspecialchars($profile['bio']); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="profile-stats">
            <div class="stat-item">
                <div class="stat-number"><?php echo htmlspecialchars($profile['stats_views'] ?? 0); ?></div>
                <div class="stat-label">Profile Views</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo htmlspecialchars($profile['stats_visitors'] ?? 0); ?></div>
                <div class="stat-label">Visitors</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">
                    <?php 
                    $days = floor((time() - strtotime($user['created_at'])) / (60 * 60 * 24));
                    echo $days > 0 ? $days : 1;
                    ?>
                </div>
                <div class="stat-label">Days Active</div>
            </div>
        </div>

        <div class="profile-actions">
            <button class="action-btn" onclick="copyToClipboard()">
                <i class="fas fa-copy"></i> Copy Link
            </button>
            <button class="action-btn" onclick="shareProfile()">
                <i class="fas fa-share-alt"></i> Share
            </button>
            <a href="/" class="action-btn">
                <i class="fas fa-home"></i> Home
            </a>
        </div>

        <?php if (!empty($profile['music_url'])): ?>
            <div class="music-player">
                <h3 style="margin-bottom: 20px; letter-spacing: 2px;">Background Music</h3>
                <div class="music-controls">
                    <button class="music-btn" onclick="playMusic()">
                        <i class="fas fa-play"></i>
                    </button>
                    <button class="music-btn" onclick="pauseMusic()">
                        <i class="fas fa-pause"></i>
                    </button>
                </div>
                <p style="opacity: 0.7; margin-top: 16px;">Click to play background music</p>
            </div>
        <?php endif; ?>
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

        // Copy profile link
        function copyToClipboard() {
            const link = window.location.href;
            navigator.clipboard.writeText(link)
                .then(() => {
                    alert('Link copied to clipboard!');
                })
                .catch(err => {
                    console.error('Failed to copy:', err);
                });
        }

        // Share profile
        function shareProfile() {
            if (navigator.share) {
                navigator.share({
                    title: 'Check out my profile!',
                    text: 'Check out my profile on socialanxiety.lol',
                    url: window.location.href
                });
            } else {
                copyToClipboard();
            }
        }

        // Music player
        let audioPlayer = null;
        
        function playMusic() {
            const musicUrl = '<?php echo htmlspecialchars($profile["music_url"] ?? ""); ?>';
            if (musicUrl) {
                if (!audioPlayer) {
                    audioPlayer = new Audio(musicUrl);
                    audioPlayer.volume = 0.3;
                }
                audioPlayer.play();
            }
        }
        
        function pauseMusic() {
            if (audioPlayer) {
                audioPlayer.pause();
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', initParticles);
    </script>
</body>
</html>
