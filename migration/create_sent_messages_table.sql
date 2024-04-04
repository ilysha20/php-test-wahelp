DROP TABLE IF EXISTS sent_messages;

CREATE TABLE sent_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mailing_id INT,
    user_id INT,
    sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_mailing FOREIGN KEY (mailing_id) REFERENCES mailings(id),
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id)
);
