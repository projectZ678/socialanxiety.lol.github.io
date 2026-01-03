// config.js
const SUPABASE_URL = 'https://kleonejdkmalzkgehhgt.supabase.co';
const SUPABASE_ANON_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImtsZW9uZWpka21hbHprZ2VoaGd0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjczODc1MjksImV4cCI6MjA4Mjk2MzUyOX0.5YmLdNK_-1ZydX6tVOXBFMmv9IChj8Ta8O-WLYERDQw';

// Initialize Supabase client
const supabase = window.supabase = supabase.createClient(SUPABASE_URL, SUPABASE_ANON_KEY, {
  auth: {
    persistSession: true,
    autoRefreshToken: true,
    detectSessionInUrl: true
  }
});

console.log('Supabase initialized:', SUPABASE_URL);
