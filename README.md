# Jobyaari — Blog Management System

A fully functional, responsive Blog Management System built with **Core PHP**, **MySQL**, **Bootstrap 5**, **jQuery**, and **AJAX**. Built for government job updates — Admit Cards, Results, Latest Jobs, and Answer Keys.

---

## Features

### Frontend
- Responsive blog listing with Bootstrap 5 cards
- AJAX-powered search, category filter, and date filter (no page reload)
- Blog detail page with full content
- Mobile-friendly navbar and layout

### Admin Panel
- Secure session-based login
- Dashboard with stats by category
- Add / Edit / Delete blogs with flash messages
- Image upload with extension + size validation
- CSRF protection on all state-changing actions
- Mobile sidebar toggle

### Security
- All queries use **prepared statements** (SQL injection prevention)
- Admin routes protected by **session authentication**
- Output sanitized with `htmlspecialchars()`
- File uploads validated by extension and MIME size
- PHP execution blocked in `uploads/` directory
- CSRF tokens on delete/add/edit actions

---

## Tech Stack

| Layer         | Technology               |
|---------------|--------------------------|
| Backend       | Core PHP 8+              |
| Database      | MySQL 5.7+               |
| Frontend      | HTML5, CSS3, Bootstrap 5 |
| Interactivity | jQuery 3.7, AJAX         |
| Icons         | Bootstrap Icons 1.11     |

---

## Project Structure

```
Jobyaari/
├── admin/
│   ├── login.php
│   ├── logout.php
│   ├── dashboard.php
│   ├── add-blog.php
│   ├── edit-blog.php
│   ├── delete-blog.php
│   ├── auth_check.php
│   ├── admin_header.php
│   └── admin_footer.php
├── assets/
│   ├── css/style.css
│   ├── js/main.js
│   └── images/default-blog.php
├── config/
│   └── db.php
├── includes/
│   ├── functions.php
│   ├── header.php
│   └── footer.php
├── uploads/
│   └── .htaccess          ← blocks PHP execution
├── .htaccess              ← security headers, caching
├── index.php
├── blog.php
├── filter.php
├── database.sql
└── README.md
```

---

## Local Setup (XAMPP)

### 1. Place Project
```
C:/xampp/htdocs/Jobyaari
```

### 2. Import Database
1. Start Apache + MySQL in XAMPP Control Panel
2. Open `http://localhost/phpmyadmin`
3. Click **Import** → select `database.sql` → click **Go**
   - This auto-creates the `jobyaari_db` database with tables and sample data

### 3. Configure Database
Edit `config/db.php` if your MySQL credentials differ:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'jobyaari_db');
```
> `SITE_URL` is auto-detected — no manual change needed for localhost or live hosting.

### 4. Run
```
http://localhost/Jobyaari/
```

---

## Admin Login

| Field    | Value                        |
|----------|------------------------------|
| URL      | `http://localhost/Jobyaari/admin/login.php` |
| Username | `admin`                      |
| Password | `admin123`                   |

> To change the password, run:
> ```php
> echo password_hash('yournewpassword', PASSWORD_DEFAULT);
> ```
> Then update the `admins` table via phpMyAdmin.

---

## Deployment on InfinityFree / 000webhost

### Step-by-step

1. **Create account** at [infinityfree.net](https://infinityfree.net) or [000webhost.com](https://www.000webhost.com)

2. **Create a hosting account** and note your:
   - FTP host, username, password
   - MySQL host, database name, username, password

3. **Upload files via FTP** (use FileZilla):
   - Connect with your FTP credentials
   - Upload all project files to `htdocs/` or `public_html/`

4. **Import database**:
   - Open your hosting control panel → phpMyAdmin
   - Create a new database (note the exact name)
   - Click **Import** → select `database.sql` → **Go**

5. **Update `config/db.php`** with live credentials:
   ```php
   define('DB_HOST', 'sql123.infinityfree.com'); // your host's MySQL host
   define('DB_USER', 'if0_12345678');             // your DB username
   define('DB_PASS', 'yourpassword');             // your DB password
   define('DB_NAME', 'if0_12345678_jobyaari');    // your DB name
   ```
   > `SITE_URL` auto-detects — no change needed.

6. **Set uploads folder permissions** to `755` via FTP client (right-click → File Permissions)

7. **Visit your site**: `https://yoursubdomain.infinityfree.app`

---

## Production `config/db.php` Example

```php
<?php
define('DB_HOST', 'sql123.infinityfree.com');
define('DB_USER', 'if0_12345678');
define('DB_PASS', 'your_db_password');
define('DB_NAME', 'if0_12345678_jobyaari');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die('Database connection failed.');
}
$conn->set_charset('utf8mb4');

if (!defined('SITE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host     = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $base     = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/\\');
    define('SITE_URL', $protocol . '://' . $host . $base);
}

define('SITE_NAME',     'Jobyaari');
define('UPLOAD_DIR',    __DIR__ . '/../uploads/');
define('UPLOAD_URL',    SITE_URL . '/uploads/');
define('DEFAULT_IMAGE', SITE_URL . '/assets/images/default-blog.php');
```

---

## GitHub Upload

```bash
cd C:/xampp/htdocs/Jobyaari

git init
git add .
git commit -m "Initial commit — Jobyaari Blog Management System"
git branch -M main
git remote add origin https://github.com/yourusername/jobyaari.git
git push -u origin main
```

> Add a `.gitignore` to avoid committing sensitive files:
> ```
> config/db.php
> uploads/*
> !uploads/.htaccess
> fix_admin.php
> ```

---

## Deployment Checklist

- [ ] Database imported successfully
- [ ] `config/db.php` updated with correct credentials
- [ ] `uploads/` folder has write permissions (755)
- [ ] Admin login works (`admin` / `admin123`)
- [ ] Can add, edit, delete a blog post
- [ ] Image upload works and displays correctly
- [ ] AJAX search/filter works without page reload
- [ ] Blog detail page loads correctly
- [ ] Site is responsive on mobile
- [ ] `.htaccess` files are uploaded (including `uploads/.htaccess`)

---

## License

MIT — Free to use for educational and personal projects.
