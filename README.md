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

## 📦 Packages
| Package Name | Functions | Status |
|------------- | ---------| --------|
| [phpflasher](https://github.com/php-flasher/php-flasher) | Flash message notifications | Used ✅ |  
| [maatwebsite/excel](https://laravel-excel.com/) | Excel file importer | Used ✅ |
| [simple-qrcode](https://github.com/SimpleSoftwareIO/simple-qrcode) | QR code generator *(required Imagick)* | ❌ Deleted* |  
| [laravel-ngrok](https://github.com/jn-jairo/laravel-ngrok) |  Expose app to public URL via ngrok (local tunneling) | ❌ Deleted* | 

*Deleted because these packages are not used again in version 1.1.0

---

## ⚙️ Quick Install
```bash
git clone https://github.com/andraadev/PresensiSiswa.git
cd PresensiSiswa
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## 🔑 Default Login (For Development Only)
-   **Admin**
    -   **Username and Password:** `Admin123`
-   **Guru**
    -   **Username and Password:** `User123`
-   **BK**
    -   **Username and Password:** `User678`


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
