# Web-Based Past Paper Management System

Production-style PHP 8/MySQL past paper platform using AdminLTE, Bootstrap 5, DataTables, SweetAlert2, prepared statements, CSRF tokens, role guards, secure PDF uploads, and reusable layouts.

## Setup

1. Create the database:
   ```bash
   mysql -u root -p < database/schema.sql
   ```
2. Copy the environment file and edit credentials:
   ```bash
   cp config/env.example.php config/env.php
   ```
3. Start the PHP server:
   ```bash
   php -S localhost:8000
   ```
4. Open `http://localhost:8000`.

Default admin:
- Email: `admin@example.com`
- Password: `Admin@123`

## Architecture

- `config/`: environment, database connection, constants.
- `functions/`: reusable security, validation, query, upload, and controller helpers.
- `includes/`: AdminLTE layout, navbar, sidebar, footer, flash messages, auth guards.
- `auth/`: shared login/logout flow.
- `admin/`: full CRUD for users, departments, courses, papers, reports.
- `lecturer/`: upload and manage own papers.
- `student/`: searchable paper catalog and downloads.
- `ajax/`: DataTables/search endpoint.
- `uploads/papers/`: secured PDF storage path.
- `database/schema.sql`: normalized schema, foreign keys, indexes, seed admin.

## ERD Summary

- One department has many users and many courses.
- One course has many past papers.
- One user can upload many past papers.
- One user can produce many activity log entries.

Security controls include password hashing, PDO prepared statements, session hardening, role-based route guards, CSRF tokens on all state-changing forms, strict PDF validation, escaped output, and direct object access checks for lecturer-owned papers.

# Past_Paper_Management
