LoginApps ini dibuat oleh AM
Silahkan digunakan dengan gratis, mohon jagan hapus creditnya ini(readme.md, maupun readme.txt)

===========================================================================

spesifikasi:

*LoginApps ini menggunakan CodeIgniter4, untuk spesifikasi  menjalankanya bisa kunjungi dokumentasi nya di https://codeigniter.com/user_guide/index.html

*LoginApps ini sudah mengimplementasikan hash pada passwordnya

*LoginApps ini sudah dilengkapi dengan data tables serverside dengan join table


===========================================================================

point penting:
*semua settingan dasar ada di file .env

*jika ingin menghosting app ini cek dulu apakah webhost mendukung .env file atau tidak, jika tidak bisa melakukan setting secara manual 

 	seperti : -base url atau index page berada di folder app/Config/App.php
 		  -database setting berada di folder app/Config/Database.php

*struktur database sudah saya buatkan di migration yg terletak di folder app/Databse/Migrations , jika saya lupa menambahkan file sql

*pada aplikasi ini terdapat 2 hak akses utama yaitu Admin dan SAdmin(Super Admin)

       hak akses admin
       username : admin
       password : admin
       
       hak akses sadmin
       username : sadmin
       password : sadmin
       
       
*super admin hanya bisa di buat di database langsung

*untuk contoh datatables serverside join table ada di bagiab siswa (bisa di check di route nya untuk tahu nama controler)

===========================================================================
# Preview Aplikasi
1. Tampilan hamalan index

![LoginApps](https://user-images.githubusercontent.com/23350205/122867662-0d5f6000-d354-11eb-97b8-95e60e10dcfc.PNG)


2. Tampilan Dashboard (Admin dan Sadmin tampilanya mirip)

![LoginApps Dashboard Admin](https://user-images.githubusercontent.com/23350205/122867642-033d6180-d354-11eb-8fb0-3e87ed665f46.PNG)


3. Tampilan Daftar Siswa (daftar user ataupun kelas mirip)

![LoginApps Daftar Siswa](https://user-images.githubusercontent.com/23350205/122867993-8e1e5c00-d354-11eb-9efe-feb2677b2c20.PNG)



4. Tampilan Input Siswa (input user ataupun kelas mirip)

![LoginApps Input Siswa](https://user-images.githubusercontent.com/23350205/122868166-c9208f80-d354-11eb-8af4-444e2d2ce0e4.PNG)



5. Tampilan Edit Siswa (input user ataupun kelas mirip)

![LoginApps Edit Siswa](https://user-images.githubusercontent.com/23350205/122868191-d473bb00-d354-11eb-922e-e95f41fc169a.PNG)

