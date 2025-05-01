-- Create database
CREATE DATABASE IF NOT EXISTS library;
USE library;

-- Admins table
CREATE TABLE Admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Books table
CREATE TABLE Books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    publisher VARCHAR(255),
    year INT,
    total_copies INT DEFAULT 1,
    available_copies INT DEFAULT 1
);

-- Members table
CREATE TABLE Members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    join_date DATE DEFAULT CURRENT_DATE
);

-- BorrowedBooks table
CREATE TABLE BorrowedBooks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    member_id INT NOT NULL,
    borrow_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE,
    FOREIGN KEY (book_id) REFERENCES Books(id) ON DELETE CASCADE,
    FOREIGN KEY (member_id) REFERENCES Members(id) ON DELETE CASCADE
);

-- Insert default admin (username: admin, password: admin)
INSERT INTO Admins (username, password) VALUES ('admin', 'admin');

-- Insert sample books
INSERT INTO Books (title, author, publisher, year, total_copies, available_copies) VALUES
('The Great Gatsby', 'F. Scott Fitzgerald', 'Scribner', 1925, 3, 3),
('1984', 'George Orwell', 'Secker & Warburg', 1949, 5, 5),
('To Kill a Mockingbird', 'Harper Lee', 'J.B. Lippincott & Co.', 1960, 2, 2);

-- Insert sample members
INSERT INTO Members (name, email, phone, address, join_date) VALUES
('John Doe', 'john@example.com', '1234567890', '123 Elm St', '2025-01-15'),
('Jane Smith', 'jane@example.com', '0987654321', '456 Oak St', '2025-02-20');

-- Insert sample borrowed books (two entries: one overdue, one not)
INSERT INTO BorrowedBooks (book_id, member_id, borrow_date, due_date) VALUES
(1, 1, '2025-04-01', '2025-04-15'),
(2, 2, '2025-04-20', '2025-05-04');

-- Update available_copies for borrowed books
UPDATE Books SET available_copies = available_copies - 1 WHERE id IN (1, 2);
