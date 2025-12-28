# JobConnect - Recruitment Platform (Project Submission)

This is the source code for the JobConnect recruitment platform. Follow these steps to set up the project locally.

## 1. Prerequisites
- **PHP** 8.1 or higher
- **Composer** (Dependency Manager)
- **MySQL** / MariaDB Database
- **Web Browser**

## 2. Installation Code
Open your terminal in the project folder and run:

```bash
composer install
```

This will install all necessary framework dependencies (CodeIgniter 4 and libraries).

## 3. Database Setup
1. Open your database management tool (phpMyAdmin, DBeaver, etc.).
2. Create a new database named `job_connect`.
3. Import the provided SQL file: `database.sql` (located in the project root).
4. **Configuration**: The project is pre-configured for a standard local setup.
   - **File**: `app/Config/Database.php`
   - **Default User**: `root`
   - **Default Password**: (empty)
   - **Database Name**: `job_connect`
   
   *If your database has a password, open `app/Config/Database.php` and edit line 31.*

## 4. Run the Application
Start the built-in development server:

```bash
php spark serve
```

Open your browser and navigate to: http://localhost:8080

## 5. Admin Credentials (If Applicable)
- **Email**: `admin@admin.com`
- **Password**: `password123` (or as configured in database)
