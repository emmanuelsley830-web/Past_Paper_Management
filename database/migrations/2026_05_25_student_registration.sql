USE past_paper_system;

ALTER TABLE users
  ADD COLUMN course_id INT NULL AFTER department_id,
  ADD COLUMN academic_year SMALLINT NULL AFTER course_id,
  ADD CONSTRAINT fk_users_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
  ADD INDEX idx_users_course_year (course_id, academic_year);
