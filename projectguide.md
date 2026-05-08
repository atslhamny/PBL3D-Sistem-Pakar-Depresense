<p align="center">
  <h1 align="center">DepreSense</h1>
  <p align="center"><strong>Sistem Pakar Deteksi Dini Depresi Mahasiswa</strong></p>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20.svg?style=flat&logo=laravel" alt="Laravel 11.x">
  <img src="https://img.shields.io/badge/PHP-8.3+-777BB4.svg?style=flat&logo=php" alt="PHP 8.3">
  <img src="https://img.shields.io/badge/Status-Confidential-red.svg" alt="Status Confidential">
</p>

## 1. Tentang DepreSense

DepreSense adalah aplikasi web berbasis sistem pakar yang dirancang untuk membantu deteksi dini depresi pada mahasiswa Indonesia. Aplikasi ini menggabungkan instrumen klinis terstandarisasi Beck Depression Inventory-II (BDI-II) dengan mesin inferensi Logika Fuzzy Mamdani untuk menghasilkan asesmen yang akurat, empatik, dan dapat diandalkan sebagai alat screening awal.

**Pernyataan Misi:**  
"Memberikan akses screening kesehatan mental yang mudah, anonim, dan berbasis bukti ilmiah kepada seluruh mahasiswa Indonesia, sehingga mereka dapat mengenali tanda-tanda depresi lebih awal dan mendapatkan bantuan yang tepat sebelum kondisi memburuk."

---

## 2. Stack Teknologi

Sistem ini dibangun menggunakan arsitektur *Monolithic* MVC dengan rendering *server-side*.

*   **Framework Backend:** Laravel 11.x (PHP 8.3+).
*   **Templating & UI:** Laravel Blade, TailwindCSS 3.x (via Vite), dan Alpine.js 3.x.
*   **Database:** PostgreSQL 16.x (Primer).
*   **Cache, Session, & Queue:** Redis 7.x.
*   **Auth:** Laravel Breeze / Fortify.
*   **Testing:** Pest PHP 2.x.
*   **Charts:** Chart.js 4.x.

---

## 3. Struktur Folder Sistem (Laravel)

Berikut adalah struktur direktori utama untuk komponen sistem DepreSense:

```text
depresense/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/               # Dashboard, Question CRUD, Fuzzy Rule Editor
│   │   │   ├── Auth/                # Autentikasi Laravel Breeze
│   │   │   ├── Screening/           # Alur kuesioner, Answer (AJAX), Emergency
│   │   │   └── User/                # Dashboard mahasiswa, History, Analytics
│   │   ├── Middleware/              # RoleMiddleware, EnsureConsentGiven, AuditLogMiddleware
│   │   └── Requests/                # Form Requests (StartScreeningRequest, SaveAnswerRequest)
│   ├── Models/                      # BdiQuestion, FuzzyRule, ScreeningSession, SessionAnswer, AuditLog
│   ├── Services/                    # Layer logika bisnis (ScreeningService, SafetyService)
│   ├── Repositories/                # Layer akses data (ScreeningRepository, QuestionRepository)
│   ├── Enums/                       # PHP 8.1+ Enums (DepressionLevel, SessionStatus, UserRole)
│   └── Fuzzy/                       # Modul Fuzzy Mamdani (Fuzzification, RuleEvaluator, Aggregator, Defuzzifier, FuzzyEngine)
├── config/
│   └── depresense.php               # Konfigurasi khusus: safety_item=9, hotline, k_anonymity
├── database/
│   ├── migrations/                  # Skema untuk users, sessions, answers, questions, fuzzy_rules, audit_logs
│   └── seeders/                     # BdiQuestionSeeder, FuzzyRuleSeeder, FuzzyMembershipSeeder
├── resources/
│   ├── views/                       
│   │   ├── layouts/                 # app.blade.php, admin.blade.php, guest.blade.php
│   │   ├── components/              # ui/, screening/, results/, dashboard/
│   │   ├── screening/               # start, consent, questionnaire, emergency (CRITICAL), result
│   │   ├── app/                     # Halaman user terautentikasi
│   │   └── admin/                   # Halaman dashboard admin
├── routes/
│   ├── web.php                      # Routing web publik, auth, user (/app), dan admin (/admin)
├── tests/
│   ├── Feature/                     # HTTP Tests (SafetyBypassTest WAJIB 100% coverage)
│   └── Unit/                        # Test untuk layanan internal dan FuzzyEngine