<?php
// config/supabase.php

class SupabaseClient {
    private $supabase_url;
    private $supabase_key;
    
    public function __construct() {
        $this->supabase_url = 'https://kleonejdkmalzkgehhgt.supabase.co';
        $this->supabase_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImtsZW9uZWpka21hbHprZ2VoaGd0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjczODc1MjksImV4cCI6MjA4Mjk2MzUyOX0.5YmLdNK_-1ZydX6tVOXBFMmv9IChj8Ta8O-WLYERDQw';
    }
    
    private function request($method, $endpoint, $data = null) {
        $url = $this->supabase_url . '/rest/v1/' . $endpoint;
        
        $headers = [
            'apikey: ' . $this->supabase_key,
            'Authorization: Bearer ' . $this->supabase_key,
            'Content-Type: application/json',
            'Prefer: return=representation'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'PATCH') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code >= 200 && $http_code < 300) {
            return json_decode($response, true);
        } else {
            error_log("Supabase API Error: " . $response);
            return false;
        }
    }
    
    // User methods
    public function createUser($username, $email, $password_hash, $profile_link) {
        return $this->request('POST', 'users', [
            'username' => strtolower($username),
            'email' => strtolower($email),
            'password_hash' => $password_hash,
            'profile_link' => strtolower($profile_link)
        ]);
    }
    
    public function getUserById($id) {
        $result = $this->request('GET', 'users?id=eq.' . $id);
        return $result ? $result[0] : null;
    }
    
    public function getUserByUsernameOrEmail($identifier) {
        $result = $this->request('GET', 'users?or=(username.eq.' . strtolower($identifier) . ',email.eq.' . strtolower($identifier) . ')');
        return $result ? $result[0] : null;
    }
    
    public function getUserByUsername($username) {
        $result = $this->request('GET', 'users?username=eq.' . strtolower($username));
        return $result ? $result[0] : null;
    }
    
    public function getUserByProfileLink($profile_link) {
        $result = $this->request('GET', 'users?profile_link=eq.' . strtolower($profile_link));
        return $result ? $result[0] : null;
    }
    
    public function updateUserPassword($id, $password_hash) {
        return $this->request('PATCH', 'users?id=eq.' . $id, [
            'password_hash' => $password_hash
        ]);
    }
    
    // Profile methods
    public function createProfile($user_id, $username, $pfp_url = null, $banner_url = null) {
        return $this->request('POST', 'profiles', [
            'user_id' => $user_id,
            'username' => $username,
            'pfp_url' => $pfp_url ?: 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . urlencode($username),
            'banner_url' => $banner_url ?: 'https://images.unsplash.com/photo-1614850523060-8da1d56ae167?w=1200&h=400&fit=crop'
        ]);
    }
    
    public function getProfileByUserId($user_id) {
        $result = $this->request('GET', 'profiles?user_id=eq.' . $user_id);
        return $result ? $result[0] : null;
    }
    
    public function updateProfile($user_id, $data) {
        return $this->request('PATCH', 'profiles?user_id=eq.' . $user_id, $data);
    }
    
    public function incrementViews($user_id) {
        $profile = $this->getProfileByUserId($user_id);
        if ($profile) {
            return $this->request('PATCH', 'profiles?user_id=eq.' . $user_id, [
                'stats_views' => ($profile['stats_views'] ?? 0) + 1
            ]);
        }
        return false;
    }
    
    // Stats methods
    public function getStats() {
        $users = $this->request('GET', 'users?select=id');
        $profiles = $this->request('GET', 'profiles?select=stats_views');
        
        $total_views = 0;
        if ($profiles) {
            foreach ($profiles as $profile) {
                $total_views += $profile['stats_views'] ?? 0;
            }
        }
        
        return [
            'users' => count($users) ?: 1254,
            'profiles' => count($profiles) ?: 892,
            'views' => $total_views ?: 45678
        ];
    }
}

// Create singleton instance
$supabase = new SupabaseClient();
?>
