# My Internship Project — PHP & MySQL CRUD Application
**Track:** Web Development (PHP & MySQL)

A simple blog-style web application built with PHP and MySQL, featuring user authentication, full CRUD (Create, Read, Update, Delete) operations, search, pagination, and role-based security.

---

## Tech Stack
- **Backend:** PHP (mysqli with prepared statements)
- **Database:** MySQL
- **Frontend:** HTML, CSS
- **Server:** Apache (via XAMPP)
- **Version Control:** Git & GitHub

---

## Project Structure
```
my-internship-project/
├── db.php           # Database connection
├── register.php     # User registration (with validation)
├── login.php        # User login (session-based)
├── logout.php        # Session destroy / logout
├── read.php          # List posts (search + pagination)
├── create.php         # Add new post
├── update.php         # Edit existing post
├── delete.php         # Delete post (admin only)
├── style.css           # UI styling
└── README.md
```

---

## Features by Task

### Task 1 — Development Environment Setup
- Installed XAMPP (Apache + MySQL + PHP) as local server environment
- Installed VS Code as the code editor
- Set up Git version control with an initial commit and GitHub repository

### Task 2 — Basic CRUD Application
- Created MySQL database `blog` with `posts` and `users` tables
- Implemented Create, Read, Update, Delete operations for blog posts
- Implemented user registration and login with session-based authentication
- Passwords stored securely using `password_hash()`

### Task 3 — Advanced Features
- Added search functionality (search posts by title or content)
- Implemented pagination (5 posts per page with navigation links)
- Improved UI with custom CSS styling for forms, tables, and buttons

### Task 4 — Security Enhancements
- All database queries use **prepared statements** to prevent SQL injection
- Added **server-side and client-side form validation** for registration (username format/length, password length)
- Added **role-based access control**: users have a `role` (`admin` or `editor`); only admins can delete posts
- Enforced authentication checks on all protected pages (redirect to login if not logged in)

### Task 5 — Final Project and Certification
- Integrated all features (CRUD, search, pagination, authentication, role-based security) into one cohesive application
- Performed end-to-end testing covering:
  - Full user flow (register → login → role-based UI → logout)
  - CRUD operations (create, read, update, delete)
  - Search and pagination accuracy
  - Security checks: invalid login, weak password rejection, and direct unauthorized access to protected pages (`read.php`, `delete.php`) while logged out — both correctly redirect to login
- Fixed issues found during testing (e.g., missing `README.md` on first setup, accidental Git repo location)
- Final result: a polished, fully functional, tested web application

---

## Database Schema

**`users` table**
| Column | Type | Notes |
|---|---|---|
| id | INT, AUTO_INCREMENT | Primary key |
| username | VARCHAR(255) | Unique |
| password | VARCHAR(255) | Hashed (bcrypt) |
| role | VARCHAR(20) | Default: `editor` |

**`posts` table**
| Column | Type | Notes |
|---|---|---|
| id | INT, AUTO_INCREMENT | Primary key |
| title | VARCHAR(255) | |
| content | TEXT | |
| created_at | TIMESTAMP | Default: current timestamp |

---

## Security Measures Implemented
- **SQL Injection Prevention:** All queries use prepared statements (`mysqli` `bind_param`) instead of raw string concatenation.
- **Password Security:** Passwords hashed with `password_hash()` (bcrypt); never stored in plain text.
- **Form Validation:** Client-side (HTML5 attributes) and server-side (PHP) validation on registration.
- **Session Management:** PHP sessions track login state; protected pages redirect unauthenticated users to `login.php`.
- **Role-Based Access Control:** Only users with the `admin` role can delete posts — enforced in both the UI and the backend.

---

## How to Run Locally
1. Install [XAMPP](https://www.apachefriends.org)
2. Copy this project folder into `C:\xampp\htdocs\`
3. Start **Apache** and **MySQL** from the XAMPP Control Panel
4. Open `http://localhost/phpmyadmin` and create the `blog` database with `users` and `posts` tables (see schema above)
5. Visit `http://localhost/my-internship-project/register.php` to create an account
6. Log in at `http://localhost/my-internship-project/login.php`

---

## Status
✅ Task 1 — Environment Setup
✅ Task 2 — Basic CRUD Application
✅ Task 3 — Advanced Features (Search, Pagination, UI)
✅ Task 4 — Security Enhancements
✅ Task 5 — Final Project and Certification

**Project Status: COMPLETE** 
