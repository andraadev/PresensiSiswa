# 📚 Absensi  
A Laravel-based application to record student attendance in a school environment.
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

## 🗑️ Removed / Deprecated Packages (Deleted in v1.1.0)
The following packages were previously used but have been removed due to maintenance considerations or unused features:
- ❌ [simple-qrcode](https://github.com/SimpleSoftwareIO/simple-qrcode) — QR code generator *(required Imagick)*  
- ❌ [laravel-ngrok](https://github.com/jn-jairo/laravel-ngrok) — No longer relevant for local development

---

## ⚙️ How to Install
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


## 🔥 Known Issues
- Excel import >30 rows → timeout (fixed v1.1.0)
- View password button layout inconsistent on certain screen sizes (fixed v1.1.0)

To see what's new, please see [changelog](https://github.com/andraadev/PresensiSiswa/blob/main/CHANGELOG.md)

For dev, please see [commit log](https://github.com/andraadev/PresensiSiswa/commits/main/)

---

## 📌 Project Status
> **Maintained, but slowed**

This project was initially developed for an academic assessment. While not actively developed with new features, it is still being maintained to address critical bugs and security issues. The source code is provided for reference and educational purposes. It is **not recommended for use in a production environment** due to its limited scope and known issues.

---

## ⚠️ Disclaimer
This software is provided "as is", without warranty of any kind, express or implied. The user assumes all responsibility and risk for the use of this software. No official support or maintenance will be provided.
