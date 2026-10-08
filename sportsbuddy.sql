USE sportsbuddy;

-- USERS TABLE
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(100) NOT NULL,
  role ENUM('user', 'admin') DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- MAIN MATCHES TABLE (consolidated from matches and create_matches)
CREATE TABLE IF NOT EXISTS matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_name VARCHAR(255) NOT NULL,
    sport_type VARCHAR(100) NOT NULL,
    location VARCHAR(255) NOT NULL,
    match_date DATETIME NOT NULL,
    max_participants INT NOT NULL DEFAULT 10,
    needs TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- MATCH PARTICIPANTS TABLE (for tracking who joined which matches)
-- Add this table for participants
CREATE TABLE match_participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT,
    user_id INT,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    FOREIGN KEY (match_id) REFERENCES matches(id)
);

-- MATCH REQUESTS TABLE (for pending join requests if needed)
CREATE TABLE IF NOT EXISTS match_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    match_id INT NOT NULL,
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    notified TINYINT(1) DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (match_id) REFERENCES matches(id)
);

-- Insert default admin user (password: admin123)
INSERT IGNORE INTO users (name, email, password, role) VALUES 
('Admin User', 'admin@sportsbuddy.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert sample matches
INSERT IGNORE INTO matches (match_name, sport_type, location, match_date, max_participants, needs, created_by) VALUES 
('Weekend Football Fun', 'Football', 'Central Park', DATE_ADD(NOW(), INTERVAL 7 DAY), 12, 'Bring your own cleats', 1),
('Basketball Tournament', 'Basketball', 'Downtown Court', DATE_ADD(NOW(), INTERVAL 3 DAY), 10, 'All skill levels welcome', 1),
('Tennis Doubles', 'Tennis', 'City Tennis Club', DATE_ADD(NOW(), INTERVAL 5 DAY), 4, 'Bring tennis balls', 1);

-- Drop duplicate tables if they exist (cleanup)
DROP TABLE IF EXISTS matchess;
DROP TABLE IF EXISTS create_matches;
DROP TABLE IF EXISTS match_registrations;

-- Add missing columns if they don't exist (for existing installations)
SET @dbname = DATABASE();
SET @table_name = 'users';
SET @column_name = 'created_at';
SET @prepared_statement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @table_name AND COLUMN_NAME = @column_name) > 0,
  'SELECT ''Column already exists'' AS status',
  CONCAT('ALTER TABLE ', @table_name, ' ADD COLUMN ', @column_name, ' TIMESTAMP DEFAULT CURRENT_TIMESTAMP')
));
PREPARE alter_if_not_exists FROM @prepared_statement;
EXECUTE alter_if_not_exists;
DEALLOCATE PREPARE alter_if_not_exists;

-- Add max_participants to matches table if it doesn't exist
SET @table_name = 'matches';
SET @column_name = 'max_participants';
SET @prepared_statement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @table_name AND COLUMN_NAME = @column_name) > 0,
  'SELECT ''Column already exists'' AS status',
  CONCAT('ALTER TABLE ', @table_name, ' ADD COLUMN ', @column_name, ' INT NOT NULL DEFAULT 10')
));
PREPARE alter_if_not_exists FROM @prepared_statement;
EXECUTE alter_if_not_exists;
DEALLOCATE PREPARE alter_if_not_exists;

-- Add created_by to matches table if it doesn't exist
SET @table_name = 'matches';
SET @column_name = 'created_by';
SET @prepared_statement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @table_name AND COLUMN_NAME = @column_name) > 0,
  'SELECT ''Column already exists'' AS status',
  CONCAT('ALTER TABLE ', @table_name, ' ADD COLUMN ', @column_name, ' INT, ADD FOREIGN KEY (created_by) REFERENCES users(id)')
));
PREPARE alter_if_not_exists FROM @prepared_statement;
EXECUTE alter_if_not_exists;
DEALLOCATE PREPARE alter_if_not_exists;

-- Ensure sport_type is NOT NULL in matches table
SET @prepared_statement = (SELECT IF(
  (SELECT IS_NULLABLE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = 'matches' AND COLUMN_NAME = 'sport_type') = 'YES',
  'ALTER TABLE matches MODIFY sport_type VARCHAR(100) NOT NULL',
  'SELECT ''Column already NOT NULL'' AS status'
));
PREPARE alter_if_not_exists FROM @prepared_statement;
EXECUTE alter_if_not_exists;
DEALLOCATE PREPARE alter_if_not_exists;