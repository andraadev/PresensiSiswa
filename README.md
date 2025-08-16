# 📚 Absensi  
A Laravel-based application to record student attendance in a school environment.

![php](https://img.shields.io/badge/php-8.1-blue)
![laravel](https://img.shields.io/badge/laravel-10-red)
![major](https://img.shields.io/badge/fix-major-orange)
![minor](https://img.shields.io/badge/fix-minor-yellow)
![maintenance](https://img.shields.io/badge/maintained-no-critical)

---

## ✨ Features
-   Role-based access control (Admin, Guru, BK).
-   CRUD operations for Teachers, Students, Classes, and Users.
-   Record daily student attendance.
-   Export attendance data to Excel.

---

## 🧰 Tech Stack
-   PHP 8.1
-   Laravel 10
-   Bootstrap 5
-   [Modernize Admin Template](https://adminmart.com/product/modernize-free-bootstrap-5-admin-template/) (Free Version)

---

## 📦 Core Packages
- [phpflasher](https://github.com/php-flasher/php-flasher) — Flash message notifications  
- [maatwebsite/excel](https://laravel-excel.com/) — Excel file importer

---

## 🗑️ Removed / Deprecated Packages
The following packages were previously used but have been removed due to maintenance considerations or unused features:
- ❌ [simple-qrcode](https://github.com/SimpleSoftwareIO/simple-qrcode) — QR code generator *(required Imagick)*  
- ❌ [laravel-ngrok](https://github.com/jn-jairo/laravel-ngrok) — No longer relevant for local development

---

## ⚙️ How to Install
> **Prerequisites:** Before you start, ensure you have a local development environment (like [XAMPP](https://www.apachefriends.org/index.html) or [Laragon](https://laragon.org/)), [Git](https://git-scm.com/downloads), and [Composer](https://getcomposer.org/download/) installed on your system. This project requires **PHP 8.1** or higher.
1.  **Clone the repository**:
    ```bash
    git clone https://github.com/andraadev/PresensiSiswa.git
    cd PresensiSiswa
    ```
2.  **Install dependencies**:
    ```bash
    composer install
    ```
3.  **Setup up the environment file**:
    ```bash
    cp .env.example .env
    ```
    > **Note:** Open the `.env` file and configure your database connection (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

4.  **Generate the application key**:
    ```bash
    php artisan key:generate
    ```
5.  **Run database migrations and seeders**:
    ```bash
    php artisan migrate --seed
    ```
6.  **Run the development server**:
    ```bash
    php artisan serve
    ```

## 🔑 Default Login
-   **Admin**
    -   **Username:** `Admin123`
    -   **Password:** `Admin123`
-   **Guru**
    -   **Username:** `User123`
    -   **Password:** `User123`
-   **BK**
    -   **Username:** `User678`
    -   **Password:** `User678`


## 🔥 Known Major Issues
-   **Import Timeout:** Importing Excel files containing more than 30 rows may result in a request timeout.
-   **Unreliable Absence ID:** The absence numbering logic relies on an auto-incrementing primary key, which is not a reliable method for generating sequential attendance numbers.

---

## 🐞 Known Minor Bugs
-   **Password Visibility Toggle:** The "view password" button does not function as intended, and its icon alignment is inconsistent at certain screen resolutions.

---

## 📌 Project Status
> **Archived – No Longer Maintained**

This project was developed for internal use during an academic assessment and has since been archived. The source code is provided for reference and educational purposes only. Due to the known issues and lack of further development, it is **not recommended for use in a production environment.**

---

## ⚠️ Disclaimer
This software is provided "as is", without warranty of any kind, express or implied. The user assumes all responsibility and risk for the use of this software. No official support or maintenance will be provided.
