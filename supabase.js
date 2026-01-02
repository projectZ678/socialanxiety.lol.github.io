// supabase.js - Database operations
import { supabase } from './config.js';

// User profile functions
export async function createProfile(userId, username, bio = '') {
    const { data, error } = await supabase
        .from('profiles')
        .insert([
            {
                id: userId,
                username: username,
                bio: bio,
                avatar_url: null,
                banner_url: null,
                mp3_url: null,
                created_at: new Date()
            }
        ]);
    
    return { data, error };
}

export async function getProfile(userId) {
    const { data, error } = await supabase
        .from('profiles')
        .select('*')
        .eq('id', userId)
        .single();
    
    return { data, error };
}

export async function getProfileByUsername(username) {
    const { data, error } = await supabase
        .from('profiles')
        .select('*')
        .eq('username', username)
        .single();
    
    return { data, error };
}

export async function updateProfile(userId, updates) {
    const { data, error } = await supabase
        .from('profiles')
        .update({
            ...updates,
            updated_at: new Date()
        })
        .eq('id', userId);
    
    return { data, error };
}

// File upload functions
export async function uploadFile(file, bucket, path) {
    const fileExt = file.name.split('.').pop();
    const fileName = `${Math.random().toString(36).substring(2)}.${fileExt}`;
    const filePath = `${path}/${fileName}`;
    
    const { data, error } = await supabase
        .storage
        .from(bucket)
        .upload(filePath, file);
    
    if (error) throw error;
    
    // Get public URL
    const { data: { publicUrl } } = supabase
        .storage
        .from(bucket)
        .getPublicUrl(filePath);
    
    return { publicUrl, filePath };
}

export async function deleteFile(bucket, filePath) {
    const { error } = await supabase
        .storage
        .from(bucket)
        .remove([filePath]);
    
    return { error };
}

// Get all profiles (for discovery)
export async function getProfiles(limit = 50) {
    const { data, error } = await supabase
        .from('profiles')
        .select('username, bio, avatar_url, created_at')
        .order('created_at', { ascending: false })
        .limit(limit);
    
    return { data, error };
}
