-- Sample seed data
-- Run with: mysql -u root -p restebooks < database/seeders/seed.sql

INSERT INTO roles (id, name) VALUES
    (1, 'admin'), (2, 'user') 
    ON DUPLICATE KEY UPDATE name = VALUES(name);

-- Default admin login: admin@restebooks.test / Admin@12345
-- (hash below is password_hash('Admin@12345', PASSWORD_BCRYPT) — change immediately)
INSERT INTO admins (full_name, email, password_hash, role_id) VALUES
    ('Super Admin', 'admin@restebooks.test', '$2y$10$oX1s0eYVh7l4E1v5X0Zv8.Qk3l0m1s4nQe8yq3q0K1JhQ8m7r6C4S', 1)
    ON DUPLICATE KEY UPDATE full_name = VALUES(full_name);

INSERT INTO categories (name, slug, icon) VALUES
    ('Cybersecurity', 'cybersecurity', 'fa-shield-halved'),
    ('Programming', 'programming', 'fa-code'),
    ('Artificial Intelligence', 'artificial-intelligence', 'fa-robot'),
    ('Networking', 'networking', 'fa-network-wired'),
    ('Linux', 'linux', 'fa-linux'),
    ('Windows', 'windows', 'fa-window-restore'),
    ('Ethical Hacking', 'ethical-hacking', 'fa-user-secret'),
    ('Web Development', 'web-development', 'fa-globe'),
    ('Mobile Development', 'mobile-development', 'fa-mobile-screen'),
    ('Cloud Computing', 'cloud-computing', 'fa-cloud'),
    ('Business', 'business', 'fa-briefcase'),
    ('Finance', 'finance', 'fa-coins'),
    ('Engineering', 'engineering', 'fa-gears'),
    ('Medicine', 'medicine', 'fa-stethoscope'),
    ('Accounting', 'accounting', 'fa-calculator'),
    ('Literature', 'literature', 'fa-feather'),
    ('Islamic Books', 'islamic-books', 'fa-book-quran'),
    ('Novels', 'novels', 'fa-book-open'),
    ('Science', 'science', 'fa-flask'),
    ('Mathematics', 'mathematics', 'fa-square-root-variable')
    ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO settings (`key`, `value`) VALUES
    ('site_name', 'RESTEBOOKS'),
    ('subscription_price_ngn', '1000')
    ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);
