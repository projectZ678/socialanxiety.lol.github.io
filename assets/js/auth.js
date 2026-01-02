// assets/js/auth.js - Supabase Authentication

// Supabase configuration
const SUPABASE_URL = 'https://kleonejdkmalzkgehhgt.supabase.co';
const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImtsZW9uZWpka21hbHprZ2VoaGd0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjczODc1MjksImV4cCI6MjA4Mjk2MzUyOX0.5YmLdNK_-1ZydX6tVOXBFMmv9IChj8Ta8O-WLYERDQw';

// Hash password (client-side)
async function hashPassword(password) {
    const encoder = new TextEncoder();
    const data = encoder.encode(password + 'socialanxiety_salt_2024');
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
}

// Sign up function
async function supabaseSignup(username, email, password) {
    try {
        // Hash password
        const passwordHash = await hashPassword(password);
        
        // Create user
        const userResponse = await fetch(`${SUPABASE_URL}/rest/v1/users`, {
            method: 'POST',
            headers: {
                'apikey': SUPABASE_KEY,
                'Authorization': `Bearer ${SUPABASE_KEY}`,
                'Content-Type': 'application/json',
                'Prefer': 'return=representation'
            },
            body: JSON.stringify({
                username: username.toLowerCase(),
                email: email.toLowerCase(),
                password_hash: passwordHash,
                profile_link: username.toLowerCase()
            })
        });
        
        if (!userResponse.ok) {
            const error = await userResponse.json();
            return { success: false, error: error.message || 'Signup failed' };
        }
        
        const userData = await userResponse.json();
        const user = userData[0];
        
        // Create profile
        const pfpUrl = `https://api.dicebear.com/7.x/avataaars/svg?seed=${encodeURIComponent(username)}`;
        const bannerUrl = 'https://images.unsplash.com/photo-1614850523060-8da1d56ae167?w=1200&h=400&fit=crop';
        
        await fetch(`${SUPABASE_URL}/rest/v1/profiles`, {
            method: 'POST',
            headers: {
                'apikey': SUPABASE_KEY,
                'Authorization': `Bearer ${SUPABASE_KEY}`,
                'Content-Type': 'application/json',
                'Prefer': 'return=representation'
            },
            body: JSON.stringify({
                user_id: user.id,
                username: username,
                pfp_url: pfpUrl,
                banner_url: bannerUrl,
                theme: 'dark'
            })
        });
        
        return {
            success: true,
            user: {
                id: user.id,
                username: user.username,
                email: user.email,
                profileLink: user.profile_link
            }
        };
        
    } catch (error) {
        console.error('Signup error:', error);
        return { success: false, error: 'Connection error. Please try again.' };
    }
}

// Login function
async function supabaseLogin(identifier, password) {
    try {
        // Find user by username or email
        const userResponse = await fetch(
            `${SUPABASE_URL}/rest/v1/users?or=(username.eq.${identifier.toLowerCase()},email.eq.${identifier.toLowerCase()})&select=*`,
            {
                headers: {
                    'apikey': SUPABASE_KEY,
                    'Authorization': `Bearer ${SUPABASE_KEY}`,
                    'Content-Type': 'application/json'
                }
            }
        );
        
        if (!userResponse.ok) throw new Error('Login failed');
        
        const users = await userResponse.json();
        if (!users || users.length === 0) {
            return { success: false, error: 'Invalid credentials' };
        }
        
        const user = users[0];
        
        // Verify password
        const passwordHash = await hashPassword(password);
        if (passwordHash !== user.password_hash) {
            return { success: false, error: 'Invalid credentials' };
        }
        
        // Get profile
        const profileResponse = await fetch(
            `${SUPABASE_URL}/rest/v1/profiles?user_id=eq.${user.id}&select=*`,
            {
                headers: {
                    'apikey': SUPABASE_KEY,
                    'Authorization': `Bearer ${SUPABASE_KEY}`,
                    'Content-Type': 'application/json'
                }
            }
        );
        
        let profile = null;
        if (profileResponse.ok) {
            const profiles = await profileResponse.json();
            profile = profiles ? profiles[0] : null;
        }
        
        return {
            success: true,
            user: {
                id: user.id,
                username: user.username,
                email: user.email,
                profileLink: user.profile_link,
                profile: profile || {
                    pfp_url: 'https://i.pinimg.com/736x/70/35/7d/70357d016a70c4be051145972893c04e.jpg',
                    banner_url: 'https://images.unsplash.com/photo-1614850523060-8da1d56ae167?w=1200&h=400&fit=crop'
                }
            }
        };
        
    } catch (error) {
        console.error('Login error:', error);
        return { success: false, error: 'Connection error. Please try again.' };
    }
}

// Check if username is available
async function checkUsernameAvailability(username) {
    try {
        const response = await fetch(
            `${SUPABASE_URL}/rest/v1/users?username=eq.${username.toLowerCase()}&select=id`,
            {
                headers: {
                    'apikey': SUPABASE_KEY,
                    'Authorization': `Bearer ${SUPABASE_KEY}`,
                    'Content-Type': 'application/json'
                }
            }
        );
        
        if (!response.ok) return true; // Available on error
        
        const data = await response.json();
        return data.length === 0; // Available if no results
        
    } catch (error) {
        console.error('Username check error:', error);
        return true; // Available on error
    }
}

// Reset password
async function resetPassword(email) {
    try {
        // Find user by email
        const userResponse = await fetch(
            `${SUPABASE_URL}/rest/v1/users?email=eq.${email.toLowerCase()}&select=id,username`,
            {
                headers: {
                    'apikey': SUPABASE_KEY,
                    'Authorization': `Bearer ${SUPABASE_KEY}`,
                    'Content-Type': 'application/json'
                }
            }
        );
        
        if (!userResponse.ok) {
            return { success: false, error: 'User not found' };
        }
        
        const users = await userResponse.json();
        if (!users || users.length === 0) {
            return { success: false, error: 'No account found with this email' };
        }
        
        const user = users[0];
        
        // Generate temporary password
        const tempPassword = Math.random().toString(36).slice(2, 10);
        const passwordHash = await hashPassword(tempPassword);
        
        // Update password
        const updateResponse = await fetch(
            `${SUPABASE_URL}/rest/v1/users?id=eq.${user.id}`,
            {
                method: 'PATCH',
                headers: {
                    'apikey': SUPABASE_KEY,
                    'Authorization': `Bearer ${SUPABASE_KEY}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    password_hash: passwordHash
                })
            }
        );
        
        if (updateResponse.ok) {
            return {
                success: true,
                message: `Password reset! Your temporary password: ${tempPassword}`,
                tempPassword: tempPassword
            };
        } else {
            return { success: false, error: 'Failed to reset password' };
        }
        
    } catch (error) {
        console.error('Reset password error:', error);
        return { success: false, error: 'Connection error. Please try again.' };
    }
}

// Logout
function logout() {
    localStorage.removeItem('socialanxiety_user');
    window.location.href = '/';
}

// Check authentication
function checkAuth() {
    const userData = localStorage.getItem('socialanxiety_user');
    if (!userData) {
        // Redirect to login if not on login/signup pages
        if (!window.location.pathname.includes('/login') && 
            !window.location.pathname.includes('/signup') &&
            !window.location.pathname.includes('/')) {
            window.location.href = '/login';
        }
        return null;
    }
    return JSON.parse(userData);
}

// Show notification
function showNotification(message, type = 'success') {
    // Remove existing notifications
    document.querySelectorAll('.notification').forEach(n => n.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification ${type === 'error' ? 'error' : ''}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 16px 24px;
        background: ${type === 'error' ? '#ff6b6b' : '#4cd964'};
        color: white;
        border-radius: 12px;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        z-index: 1000;
        animation: slideIn 0.3s ease;
        font-size: 14px;
        letter-spacing: 1px;
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add CSS for notifications
if (!document.querySelector('#notification-styles')) {
    const style = document.createElement('style');
    style.id = 'notification-styles';
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
}
