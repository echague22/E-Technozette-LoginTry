-- E-Technozette Database Setup
-- Run this script in phpMyAdmin or MySQL command line

CREATE DATABASE IF NOT EXISTS etechnozette;
USE etechnozette;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Editor-In-Chief', 'Managing Editor', 'Associate Editor - Internal', 'Associate Editor - External', 'Proofreader (Editorial Board)', 'News Editor', 'Editorial Editor', 'Feature Editor', 'Literary Editor', 'Sports Editor', 'Head Layout Artist', 'Head Cartoonist', 'Head Photojournalist', 'News Writer', 'Editorial Writer', 'Feature Writer', 'Literary Writer', 'Sports Writer', 'Layout Artist', 'Cartoonist', 'Photojournalist') NOT NULL,
    birthdate VARCHAR(10) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    session_token VARCHAR(64) NULL,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Articles table
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author_id INT NOT NULL,
    status ENUM('draft', 'review', 'published', 'archived') DEFAULT 'draft',
    category VARCHAR(50) NOT NULL,
    featured_image VARCHAR(255) NULL,
    tags TEXT NULL,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Comments table
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert default categories
INSERT INTO categories (name, description) VALUES
('Technology', 'Articles about technology and innovation'),
('Science', 'Scientific discoveries and research'),
('Education', 'Educational content and news'),
('Campus News', 'News and updates from the campus'),
('Opinion', 'Opinion pieces and editorials'),
('Features', 'Feature articles and stories');

-- Insert sample users with properly hashed passwords
-- Password for Kate: 67890, Password for others: 12345
INSERT INTO users (username, email, password, role, birthdate, first_name, last_name) VALUES
('editor', 'editor@etechnozette.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'Editor-In-Chief', '01-01-95', 'Chief', 'Editor'),
('Kate', 'kate@etechnozette.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Managing Editor', '02-02-02', 'Kate', 'Editor'),
('news_editor', 'news@etechnozette.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'News Editor', '03-03-03', 'Maria', 'Santos'),
('feature_writer', 'feature@etechnozette.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'Feature Writer', '04-04-04', 'Jose', 'Garcia'),
('layout_artist', 'layout@etechnozette.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'Layout Artist', '05-05-05', 'Ana', 'Reyes'),
('sports_writer', 'sports@etechnozette.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'Sports Writer', '06-06-06', 'Carlos', 'Mendoza');

-- Insert sample articles
INSERT INTO articles (title, content, author_id, status, category, tags) VALUES
('Welcome to E-Technozette', 'Welcome to the official publication of Eulogio "Amang" Rodriguez Institute of Science and Technology. This is our first article in the new digital platform.', 2, 'published', 'Campus News', 'welcome, introduction'),
('Technology Trends 2024', 'Exploring the latest technology trends that will shape the future of education and research in 2024.', 3, 'published', 'Technology', 'technology, trends, 2024'),
('Scientific Research at EARIST', 'Highlighting the groundbreaking research being conducted by our faculty and students.', 4, 'draft', 'Science', 'research, science, EARIST');

-- Create indexes for better performance
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_articles_status ON articles(status);
CREATE INDEX idx_articles_category ON articles(category);
CREATE INDEX idx_articles_author ON articles(author_id);
CREATE INDEX idx_comments_article ON comments(article_id);
CREATE INDEX idx_comments_user ON comments(user_id);
