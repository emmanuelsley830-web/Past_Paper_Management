<?php
require_once __DIR__ . '/../includes/auth_check.php';

function departments(): array
{
    return db()->query('SELECT * FROM departments ORDER BY department_name')->fetchAll();
}

function courses(): array
{
    return db()->query('SELECT c.*, d.department_name FROM courses c JOIN departments d ON d.id = c.department_id ORDER BY c.course_code')->fetchAll();
}

function paper_query(string $where = '1=1', array $params = []): array
{
    $sql = "SELECT p.*, c.course_name, c.course_code, d.department_name, u.fullname AS uploader
            FROM past_papers p
            JOIN courses c ON c.id = p.course_id
            JOIN departments d ON d.id = c.department_id
            LEFT JOIN users u ON u.id = p.uploaded_by
            WHERE {$where}
            ORDER BY p.created_at DESC";
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function handle_user_action(): void
{
    require_role(['admin']);
    verify_csrf();
    $action = $_POST['action'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);
    if ($action === 'create') {
        $_POST['role'] = 'lecturer';
    }
    $errors = required($_POST, ['fullname', 'email']);
    if ($emailError = validate_email_value($_POST['email'] ?? '')) {
        $errors[] = $emailError;
    }
    if ($action === 'create' && empty($_POST['password'])) {
        $errors[] = 'Password is required.';
    }
    if ($errors && $action !== 'delete' && $action !== 'reset_password') {
        flash('error', implode(' ', $errors));
        redirect('admin/users.php');
    }
    if (in_array($action, ['create', 'update'], true)) {
        $emailSql = 'SELECT id FROM users WHERE email=?' . ($action === 'update' ? ' AND id<>?' : '');
        $stmt = db()->prepare($emailSql);
        $stmt->execute($action === 'update' ? [$_POST['email'], $id] : [$_POST['email']]);
        if ($stmt->fetch()) {
            flash('error', 'That email address is already registered.');
            redirect('admin/users.php');
        }
    }
    if ($action === 'create') {
        $stmt = db()->prepare('INSERT INTO users (fullname,email,password,role,department_id,status) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$_POST['fullname'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT), 'lecturer', $_POST['department_id'] ?: null, $_POST['status']]);
        log_activity(current_user()['id'], 'Created user ' . $_POST['email']);
    } elseif ($action === 'update') {
        $role = in_array($_POST['role'] ?? '', ['admin', 'lecturer', 'student'], true) ? $_POST['role'] : 'student';
        $stmt = db()->prepare('UPDATE users SET fullname=?, email=?, role=?, department_id=?, course_id=?, academic_year=?, status=? WHERE id=?');
        $stmt->execute([$_POST['fullname'], $_POST['email'], $role, $_POST['department_id'] ?: null, $_POST['course_id'] ?: null, $_POST['academic_year'] ?: null, $_POST['status'], $id]);
        log_activity(current_user()['id'], 'Updated user #' . $id);
    } elseif ($action === 'reset_password') {
        $newPassword = trim($_POST['new_password'] ?? '');
        if (strlen($newPassword) < 8) {
            flash('error', 'Password reset requires at least 8 characters.');
            redirect('admin/users.php');
        }
        $stmt = db()->prepare('UPDATE users SET password=? WHERE id=?');
        $stmt->execute([password_hash($newPassword, PASSWORD_DEFAULT), $id]);
        log_activity(current_user()['id'], 'Reset password for user #' . $id);
    } elseif ($action === 'delete') {
        if ($id === (int) current_user()['id']) {
            flash('error', 'You cannot delete your own account.');
            redirect('admin/users.php');
        }
        db()->prepare('DELETE FROM users WHERE id=?')->execute([$id]);
        log_activity(current_user()['id'], 'Deleted user #' . $id);
    }
    flash('success', 'User action completed.');
    redirect('admin/users.php');
}

function handle_student_registration(): void
{
    verify_csrf();
    $errors = required($_POST, ['fullname', 'email', 'password', 'confirm_password', 'course_id', 'academic_year']);
    if ($emailError = validate_email_value($_POST['email'] ?? '')) {
        $errors[] = $emailError;
    }
    if (strlen($_POST['password'] ?? '') < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }
    if (($_POST['password'] ?? '') !== ($_POST['confirm_password'] ?? '')) {
        $errors[] = 'Password confirmation does not match.';
    }
    if ($yearError = ensure_year($_POST['academic_year'] ?? '')) {
        $errors[] = $yearError;
    }
    $stmt = db()->prepare('SELECT id FROM users WHERE email=? LIMIT 1');
    $stmt->execute([trim($_POST['email'] ?? '')]);
    if ($stmt->fetch()) {
        $errors[] = 'That email address is already registered.';
    }
    $stmt = db()->prepare('SELECT department_id FROM courses WHERE id=? LIMIT 1');
    $stmt->execute([$_POST['course_id'] ?? 0]);
    $course = $stmt->fetch();
    if (!$course) {
        $errors[] = 'Please select a valid course.';
    }
    if ($errors) {
        flash('error', implode(' ', $errors));
        redirect('student/register.php');
    }
    $stmt = db()->prepare('INSERT INTO users (fullname, email, password, role, department_id, course_id, academic_year, status) VALUES (?,?,?,?,?,?,?,?)');
    $stmt->execute([
        trim($_POST['fullname']),
        trim($_POST['email']),
        password_hash($_POST['password'], PASSWORD_DEFAULT),
        'student',
        $course['department_id'],
        $_POST['course_id'],
        $_POST['academic_year'],
        'active',
    ]);
    log_activity((int) db()->lastInsertId(), 'Student registered');
    flash('success', 'Registration successful. Please login.');
    redirect('auth/login.php');
}

function handle_department_action(): void
{
    require_role(['admin']);
    verify_csrf();
    $action = $_POST['action'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);
    if ($action === 'delete') {
        db()->prepare('DELETE FROM departments WHERE id=?')->execute([$id]);
    } else {
        $errors = required($_POST, ['department_name']);
        if ($errors) {
            flash('error', implode(' ', $errors));
            redirect('admin/departments.php');
        }
        if ($action === 'create') {
            db()->prepare('INSERT INTO departments (department_name) VALUES (?)')->execute([$_POST['department_name']]);
        } elseif ($action === 'update') {
            db()->prepare('UPDATE departments SET department_name=? WHERE id=?')->execute([$_POST['department_name'], $id]);
        }
    }
    log_activity(current_user()['id'], ucfirst($action) . ' department');
    flash('success', 'Department action completed.');
    redirect('admin/departments.php');
}

function handle_course_action(): void
{
    require_role(['admin']);
    verify_csrf();
    $action = $_POST['action'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);
    if ($action === 'delete') {
        db()->prepare('DELETE FROM courses WHERE id=?')->execute([$id]);
    } else {
        $errors = required($_POST, ['course_name', 'course_code', 'department_id']);
        if ($errors) {
            flash('error', implode(' ', $errors));
            redirect('admin/courses.php');
        }
        if ($action === 'create') {
            db()->prepare('INSERT INTO courses (course_name, course_code, department_id) VALUES (?,?,?)')->execute([$_POST['course_name'], $_POST['course_code'], $_POST['department_id']]);
        } elseif ($action === 'update') {
            db()->prepare('UPDATE courses SET course_name=?, course_code=?, department_id=? WHERE id=?')->execute([$_POST['course_name'], $_POST['course_code'], $_POST['department_id'], $id]);
        }
    }
    log_activity(current_user()['id'], ucfirst($action) . ' course');
    flash('success', 'Course action completed.');
    redirect('admin/courses.php');
}

function handle_paper_action(string $redirectPath): void
{
    require_role(['admin', 'lecturer']);
    verify_csrf();
    $action = $_POST['action'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);
    $ownerWhere = is_role('lecturer') ? ' AND uploaded_by=' . (int) current_user()['id'] : '';
    if ($action === 'delete') {
        $stmt = db()->prepare("SELECT file_path FROM past_papers WHERE id=? {$ownerWhere}");
        $stmt->execute([$id]);
        $paper = $stmt->fetch();
        if ($paper) {
            remove_uploaded_file($paper['file_path']);
            db()->prepare("DELETE FROM past_papers WHERE id=? {$ownerWhere}")->execute([$id]);
        }
    } else {
        $errors = required($_POST, ['title', 'course_id', 'year', 'semester', 'exam_type']);
        if ($yearError = ensure_year($_POST['year'] ?? '')) {
            $errors[] = $yearError;
        }
        $filePath = $_POST['existing_file'] ?? null;
        if ($action === 'create' || !empty($_FILES['paper_file']['name'])) {
            [$ok, $result] = store_pdf($_FILES['paper_file'] ?? []);
            if (!$ok) {
                $errors[] = $result;
            } else {
                if ($filePath) {
                    remove_uploaded_file($filePath);
                }
                $filePath = $result;
            }
        }
        if ($errors) {
            flash('error', implode(' ', $errors));
            redirect($redirectPath);
        }
        if ($action === 'create') {
            $stmt = db()->prepare('INSERT INTO past_papers (title, course_id, year, semester, exam_type, file_path, uploaded_by) VALUES (?,?,?,?,?,?,?)');
            $stmt->execute([$_POST['title'], $_POST['course_id'], $_POST['year'], $_POST['semester'], $_POST['exam_type'], $filePath, current_user()['id']]);
        } elseif ($action === 'update') {
            $stmt = db()->prepare("UPDATE past_papers SET title=?, course_id=?, year=?, semester=?, exam_type=?, file_path=? WHERE id=? {$ownerWhere}");
            $stmt->execute([$_POST['title'], $_POST['course_id'], $_POST['year'], $_POST['semester'], $_POST['exam_type'], $filePath, $id]);
        }
    }
    log_activity(current_user()['id'], ucfirst($action) . ' paper');
    flash('success', 'Paper action completed.');
    redirect($redirectPath);
}
