CREATE DATABASE IF NOT EXISTS past_paper_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE past_paper_system;

CREATE TABLE departments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  department_name VARCHAR(150) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fullname VARCHAR(150) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','lecturer','student') NOT NULL DEFAULT 'student',
  department_id INT NULL,
  course_id INT NULL,
  academic_year SMALLINT NULL,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_users_department FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL,
  INDEX idx_users_role (role),
  INDEX idx_users_status (status)
) ENGINE=InnoDB;

CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_name VARCHAR(180) NOT NULL,
  course_code VARCHAR(40) NOT NULL UNIQUE,
  department_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_courses_department FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE,
  INDEX idx_courses_department (department_id),
  FULLTEXT INDEX ft_courses (course_name, course_code)
) ENGINE=InnoDB;

ALTER TABLE users
  ADD CONSTRAINT fk_users_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
  ADD INDEX idx_users_course_year (course_id, academic_year);

CREATE TABLE past_papers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(220) NOT NULL,
  course_id INT NOT NULL,
  year SMALLINT NOT NULL,
  semester ENUM('I','II','III') NOT NULL,
  exam_type ENUM('CAT','Midterm','Final','Supplementary','Other') NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  uploaded_by INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_papers_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
  CONSTRAINT fk_papers_user FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_papers_filters (course_id, year, semester, exam_type),
  FULLTEXT INDEX ft_papers_title (title)
) ENGINE=InnoDB;

CREATE TABLE activity_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  activity VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_logs_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_logs_created (created_at)
) ENGINE=InnoDB;

INSERT INTO departments (department_name) VALUES
('Computer Science'),
('Business Administration'),
('Education');

INSERT INTO users (fullname, email, password, role, status) VALUES
('System Administrator', 'admin@example.com', '$2y$12$d1hglf/ZdXTKYM.bnosjL.vqrsgsd8iPYwiMJwysYcQzqi9j4I63y', 'admin', 'active');
