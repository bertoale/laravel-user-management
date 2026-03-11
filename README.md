# User Management Laravel

## Architecture Overview

Project ini menggunakan arsitektur **Repository-Service Pattern** untuk memisahkan logika bisnis dan akses data, sehingga kode lebih terstruktur, mudah diuji, dan mudah dikembangkan.

### Struktur Utama

-   `app/Repositories/`  
    Berisi kelas repository yang bertanggung jawab untuk interaksi dengan database (misal: `UserRepository.php`, `AuthRepository.php`). Repository menyediakan abstraksi untuk query dan operasi data.

-   `app/Services/`  
    Berisi kelas service yang mengelola logika bisnis aplikasi (misal: `UserService.php`, `AuthService.php`). Service memanfaatkan repository untuk mengambil atau memanipulasi data, dan digunakan oleh controller.

-   `app/Http/Controllers/`  
    Controller menerima request dari user, memanggil service, dan mengembalikan response.

### Alur Kerja

1. **Controller** menerima request dari user.
2. **Service** dipanggil oleh controller untuk menjalankan logika bisnis.
3. **Repository** digunakan oleh service untuk berinteraksi dengan database.

Contoh:

-   Controller → Service → Repository → Database

## Cara Menjalankan Project

### Tanpa Docker

1. **Install PHP & Composer**

    - Pastikan PHP >= 8.2 dan Composer sudah terinstall.

2. **Install Dependencies**

    ```bash
    composer install
    npm install
    npm run build
    ```

3. **Konfigurasi Environment**

    - Copy `.env.example` menjadi `.env` dan sesuaikan konfigurasi database.

    ```bash
    cp .env.example .env
    ```

4. **Migrasi Database**

    ```bash
    php artisan migrate --seed
    ```

5. **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Akses aplikasi di `http://localhost:8000`

### Dengan Docker

1. **Build dan Jalankan Container**

    ```bash
    docker-compose up --build
    ```

2. **Akses aplikasi**
    - Buka browser ke `http://localhost:8000`
