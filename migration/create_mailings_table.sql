DROP TABLE IF EXISTS mailings;

CREATE TABLE mailings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    sent_at DATETIME,
    is_sent BOOLEAN DEFAULT 0
);
