// particles.js - Falling stars animation
function initStars() {
    const canvas = document.getElementById('starCanvas');
    const ctx = canvas.getContext('2d');
    
    // Set canvas size
    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();
    
    // Star class
    class Star {
        constructor() {
            this.reset();
        }
        
        reset() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * -100;
            this.size = Math.random() * 2 + 1;
            this.speed = Math.random() * 3 + 2;
            this.opacity = Math.random() * 0.5 + 0.5;
            this.tail = Math.random() * 20 + 10;
            this.angle = Math.random() * Math.PI / 4 + Math.PI / 8; // 22.5 to 67.5 degrees
        }
        
        update() {
            this.x += Math.cos(this.angle) * this.speed;
            this.y += Math.sin(this.angle) * this.speed;
            
            // Reset if off screen
            if (this.y > canvas.height || this.x > canvas.width || this.x < 0) {
                this.reset();
                this.y = Math.random() * -100;
            }
        }
        
        draw() {
            ctx.save();
            
            // Draw tail
            ctx.beginPath();
            ctx.moveTo(this.x, this.y);
            ctx.lineTo(
                this.x - Math.cos(this.angle) * this.tail,
                this.y - Math.sin(this.angle) * this.tail
            );
            ctx.strokeStyle = `rgba(255, 255, 255, ${this.opacity})`;
            ctx.lineWidth = this.size;
            ctx.lineCap = 'round';
            ctx.stroke();
            
            // Draw star head
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(255, 255, 255, 1)';
            ctx.fill();
            
            ctx.restore();
        }
    }
    
    // Create stars
    const stars = [];
    const starCount = Math.min(50, Math.floor(window.innerWidth / 30));
    
    for (let i = 0; i < starCount; i++) {
        stars.push(new Star());
    }
    
    // Animation loop
    function animate() {
        // Clear with fade effect for trails
        ctx.fillStyle = 'rgba(0, 0, 0, 0.1)';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Update and draw stars
        stars.forEach(star => {
            star.update();
            star.draw();
        });
        
        requestAnimationFrame(animate);
    }
    
    animate();
}
