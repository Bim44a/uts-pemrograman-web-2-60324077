# UTS Pemrograman Web 2

**Nama**: Bima Adi Nugroho
**NIM**: 60324077

---

## Deskripsi Aplikasi

Aplikasi ini merupakan sistem manajemen kategori buku pada perpustakaan berbasis web menggunakan PHP dan MySQL.
Aplikasi ini menyediakan fitur CRUD (Create, Read, Update, Delete) untuk mengelola data kategori buku.

---

## Cara Instalasi dan Menjalankan Aplikasi

1. Unduh repository ini.

2. Letakkan folder project ke dalam direktori server lokal, misalnya:

   ```
   C:\xampp\htdocs\uts_60324077
   ```

3. Jalankan aplikasi XAMPP, kemudian aktifkan layanan:

   Apache dan MySQL

4. Buka phpMyAdmin melalui browser dengan alamat:

   ```
   http://localhost/phpmyadmin
   ```

5. Buat database baru dengan nama:

   ```
   uts_perpustakaan_60324077
   ```

6. Import file ```uts_perpustakaan_60324077.sql``` ke dalam database yang sudah dibuat

7. Buka file konfigurasi database pada:

   ```
   config/database.php
   ```

   Pastikan pengaturan koneksi sudah sesuai (host, username, password, dan nama database).

8. Jalankan aplikasi melalui browser (URL sesuai dengan nama folder):

   ```
   http://localhost/uts_60324077
   ```


---

## Struktur Folder

```
config/
  └── database.php
database/
  └── uts_perpustakaan_60324077.sql
README.md
create.php
delete.php
edit.php
index.php
```

---

## Link Repository

https://github.com/Bim44a/uts-pemrograman-web-2-60324077
