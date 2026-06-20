# Complete Setup Guide - Laravel Company Dashboard

## System Requirements
- PHP 8.1 or higher
- MySQL 8.0 or higher
- Composer & Node.js 16+

## Installation Steps

### 1. Clone & Install
```bash
git clone https://github.com/sami2006rabie-dotcom/laravel-company-dashboard.git
cd laravel-company-dashboard
composer install
npm install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Configuration
Edit `.env`:
```env
DB_DATABASE=company_dashboard
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Create Database
```bash
mysql -u root -p -e "CREATE DATABASE company_dashboard;"
```

### 5. Run Migrations & Seeds
```bash
php artisan migrate --seed
```

### 6. Google OAuth Setup
1. Go to https://console.cloud.google.com
2. Create OAuth 2.0 credentials
3. Add redirect: http://localhost:8000/auth/google/callback
4. Update .env with Client ID and Secret

### 7. Twilio WhatsApp Setup
1. Sign up at https://www.twilio.com
2. Get Account SID, Token, and WhatsApp number
3. Update .env

### 8. Email Setup (Mailtrap)
1. Sign up at https://mailtrap.io
2. Get SMTP credentials
3. Update .env

### 9. Create Storage Link
```bash
php artisan storage:link
```

### 10. Start Server
```bash
php artisan serve
npm run dev
```

Access: http://localhost:8000

## Default Accounts
- Admin: admin@company.com / password123
- User: john@company.com / password123
- User: mary@company.com / password123
- User: david@company.com / password123