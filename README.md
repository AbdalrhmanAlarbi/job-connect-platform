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
4. Rename the `env` file to `.env` if you haven't already:
   ```bash
   cp env .env
   ```
5. Open `.env` and verify your database credentials match:
   ```ini
   database.default.hostname = localhost
   database.default.database = job_connect
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi
   ```

## 4. Run the Application
Start the built-in development server:

```bash
php spark serve
```

Open your browser and navigate to: http://localhost:8080

## 5. Admin Credentials (If Applicable)
- **Email**: `admin@admin.com`
- **Password**: `password123` (or as configured in database)
