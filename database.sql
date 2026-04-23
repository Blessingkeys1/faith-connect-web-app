CREATE DATABASE IF NOT EXISTS faith_connect;
USE faith_connect;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS sermons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    pastor VARCHAR(100) NOT NULL,
    duration VARCHAR(50),
    date DATE,
    url VARCHAR(255),
    category ENUM('Faith', 'Healing', 'Grace', 'Other') DEFAULT 'Other',
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author VARCHAR(100) NOT NULL,
    title VARCHAR(255),
    content TEXT NOT NULL,
    date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    type ENUM('Offertory', 'Tithe', 'Seed') NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    reason TEXT,
    status ENUM('Pending', 'Completed', 'Failed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS prayer_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    category ENUM('Healing', 'Family', 'Finance', 'Other') DEFAULT 'Other',
    request TEXT NOT NULL,
    is_anonymous BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS devotions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    scripture TEXT NOT NULL,
    content TEXT NOT NULL,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS music (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    artist VARCHAR(100) NOT NULL,
    duration VARCHAR(50),
    category ENUM('Worship', 'Praise', 'Hymns', 'Other') DEFAULT 'Other',
    cover_image_url VARCHAR(255),
    url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert some dummy data for initial view
INSERT INTO sermons (title, pastor, duration, date, category) VALUES 
('The Power of Faith', 'Pastor James Kawalya', '45m', '2025-10-12', 'Faith'),
('Walking in Wisdom', 'Pastor James Kawalya', '38m', '2025-10-05', 'Faith'),
('Divine Healing', 'Pastor James Kawalya', '52m', '2025-09-28', 'Healing'),
('Faith over Fear', 'Pastor James Kawalya', '48m', '2025-09-21', 'Faith');

INSERT INTO devotions (title, date, scripture, content) VALUES
('Strength for the Day', '2025-10-13', '"But those who hope in the Lord will renew their strength. They will soar on wings like eagles; they will run and not grow weary, they will walk and not be faint." — Isaiah 40:31', 'Today, remember that your strength doesn’t come from your own efforts alone, but from the grace of God. In moments of tiredness, lean on His everlasting arms. He is your source of power and peace.');



INSERT INTO music (title, artist, duration, category, cover_image_url, url) VALUES
('Way Maker', 'Sinach', '5:04', 'Worship', 'https://images.unsplash.com/photo-1514320298574-2c9d81791a50?auto=format&fit=crop&q=80&w=400', 'https://www.youtube.com/results?search_query=sinach+way+maker'),
('10,000 Reasons', 'Matt Redman', '4:26', 'Praise', 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&q=80&w=400', 'https://www.youtube.com/results?search_query=matt+redman+10000+reasons'),
('Amazing Grace', 'Chris Tomlin', '4:15', 'Hymns', 'https://images.unsplash.com/photo-1498243639359-40c9c52bd4a3?auto=format&fit=crop&q=80&w=400', 'https://www.youtube.com/results?search_query=chris+tomlin+amazing+grace'),
('Ocean (Where Feet May Fail)', 'Hillsong United', '8:56', 'Worship', 'https://images.unsplash.com/photo-1507838153414-b4b713384a76?auto=format&fit=crop&q=80&w=400', 'https://www.youtube.com/results?search_query=hillsong+united+oceans');

CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (email),
    INDEX (token)
);
