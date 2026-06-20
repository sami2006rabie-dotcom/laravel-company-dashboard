# Laravel Company Dashboard

A comprehensive Laravel dashboard system for managing companies with employee, department, and blog functionalities.

## Features

✅ **Admin Dashboard**
- User management
- Department management  
- Statistics overview
- Blog moderation

✅ **User Dashboard**
- Profile management
- Department colleagues view
- Blog posting
- Phone verification

✅ **Authentication**
- Traditional email/password login
- Google OAuth 2.0 integration
- Email OTP verification
- WhatsApp OTP verification via Twilio

✅ **Blog System**
- Create, read, update, delete blog posts
- Comment system
- Post views tracking
- Featured images

✅ **Employee & Department Management**
- Department CRUD
- Employee assignment
- Department statistics

## Quick Start

```bash
git clone https://github.com/sami2006rabie-dotcom/laravel-company-dashboard.git
cd laravel-company-dashboard
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Default Credentials

**Admin:** admin@company.com / password123
**User:** john@company.com / password123

See SETUP.md for detailed installation instructions.
