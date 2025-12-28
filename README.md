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

### Step 1: Create Database
1. Open your database management tool (phpMyAdmin, MySQL Workbench, command line, etc.)
2. Create a new database:
   ```sql
   CREATE DATABASE job_connect CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
   ```

### Step 2: Create Database User
The project uses dedicated database credentials. Create the MySQL user:

```sql
CREATE USER 'jobuser'@'localhost' IDENTIFIED BY 'TestPass!2025';
GRANT ALL PRIVILEGES ON job_connect.* TO 'jobuser'@'localhost';
FLUSH PRIVILEGES;
```

> **Note**: If you prefer to use your existing MySQL root user, you can modify the credentials in `app/Config/Database.php` (lines 30-31).

### Step 3: Import Database
Import the provided SQL file into the `job_connect` database:
- **File**: `database.sql` (located in project root, ~3.2 MB with full data)
- **Contains**: 10 tables with hundreds of records (users, companies, jobs, applications, etc.)

**Via phpMyAdmin**: Select `job_connect` database → Import → Choose `database.sql`  
**Via Command Line**:
```bash
mysql -u jobuser -p'TestPass!2025' job_connect < database.sql
```

### Step 4: Verify Configuration
Database settings are in `app/Config/Database.php`:
- **Hostname**: `localhost`
- **Username**: `jobuser`
- **Password**: `TestPass!2025`
- **Database**: `job_connect`

## 4. Run the Application
Start the built-in development server:

```bash
php spark serve
```

Open your browser and navigate to: http://localhost:8080

## 5. Admin Access
To access the admin dashboard:
- **URL**: http://localhost:8080/auth/login
- **Admin Email**: `admin@libyanjobs.com`
- **Admin Password**: `admin123`

After logging in as admin, you can manage users, companies, jobs, and applications.
