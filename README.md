# 📚 Absensi  
A Laravel-based application to record student attendance in a school environment.

![php](https://img.shields.io/badge/php-8.1-blue)
![laravel](https://img.shields.io/badge/laravel-10-red)
![major](https://img.shields.io/badge/fix-major-orange)
![minor](https://img.shields.io/badge/fix-minor-yellow)
![maintenance](https://img.shields.io/badge/maintained-no-critical)

---

## 🧰 Tech Stack
- Laravel 10 (PHP 8.1)
- Bootstrap 5 (Modernize Admin Template)

---

## 📦 Packages Used
- [phpflasher](https://github.com/php-flasher/php-flasher) — Flash message notifications  
- [maatwebsite/excel](https://laravel-excel.com/) — Excel file importer

---

## 🗑️ Removed / Deprecated Packages
These packages were once used, but have been removed due to maintenance reasons or unused features:
- ❌ [simple-qrcode](https://github.com/SimpleSoftwareIO/simple-qrcode) — QR code generator *(required Imagick)*  
- ❌ [laravel-ngrok](https://github.com/jn-jairo/laravel-ngrok) — No longer relevant for local development

---

## ⚙️ How to Install
```bash
git clone https://github.com/andraadev/PresensiSiswa.git
cd PresensiSiswa
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```


## 🔥 Major Issues
- ❗ Timeout occurs when importing Excel files with **30+ rows**
- ❗ Absence number logic is **not reliable** (still uses auto-incremented ID)

---

## 🐞 Minor Bugs
- The "view password" button (👁️) doesn't function properly  
- Icon positioning breaks at certain screen resolutions

---

## 📌 Project Status
> **Archived – No Longer Maintained**

This project was built for internal use during an exam, and has since been retired.  
It remains online for reference, laughs, and the occasional facepalm 🤦.

If you're looking for a reliable attendance system in 2025:  
**This ain't it, chief.**

---

## ⚠️ Disclaimer
You are free to fork, explore, and cry.  
No warranty, no support, no refunds — just code history.
