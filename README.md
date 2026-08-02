# Laravel 13 & Livewire 4 Starter Kit

A modern, robust, and full-featured Laravel starter kit powered by **PHP 8.5**, **Laravel 13**, **Livewire 4**, **TallStackUI**, **Tailwind CSS v4**, and **r2luna/brain** workflow architecture.

---

## 🌟 Overview

This starter kit provides a complete foundation for building scalable Laravel web applications with reactive Livewire components, administrative Role-Based Access Control (RBAC), and strict software engineering standards (100% Type Coverage, static analysis, and comprehensive Pest 5 testing).

## ✨ Key Features

- **Authentication & Security (Laravel Fortify)**
  - Registration, Login, Email Verification, and Password Reset.
  - Two-Factor Authentication (2FA) with TOTP QR codes and Recovery Codes.
  - Passkey / WebAuthn support via `@laravel/passkeys`.
  - Password confirmation middleware for sensitive settings routes.
- **User Management (CRUD)**
  - Manage users with pagination, search filtering, column sorting, and modal forms.
  - Assign single or multiple roles to users.
  - Authorized via `UserPolicy`.
- **Role Management (CRUD)**
  - Create, edit, and delete application roles using Spatie Laravel Permission.
  - Multi-select assignment of permissions to roles.
  - Authorized via `RolePolicy`.
- **Permission Management (CRUD)**
  - Create, edit, and manage system permissions.
  - Authorized via `PermissionPolicy`.
- **User Settings & Preferences**
  - **Profile:** Update account details, email address, and profile information.
  - **Security:** Manage password changes, 2FA, and passkey registration.
  - **Appearance:** Toggle system appearance (Light / Dark mode).
- **Domain-Driven Workflow Architecture (`r2luna/brain`)**
  - Clean separation of business logic into **Workflows** (transactional orchestration), **Actions** (state mutation units), and **Queries** (read-only data fetching).
- **High-Performance UI Stack**
  - **Livewire 4** with **Livewire Blaze** for optimized blade component rendering strategies.
  - **TallStackUI 3.x** component library for sleek tables, modals, inputs, and alerts.
  - **Tailwind CSS v4** styling bundle powered by Vite Plus (`vite-plus`).

---

## 🛠️ Tech Stack

| Technology / Package | Version | Description |
| --- | --- | --- |
| **PHP** | `^8.5` | Next-generation PHP runtime |
| **Laravel Framework** | `^13.23` | Core PHP framework |
| **Livewire** | `^4.3.4` | Server-driven reactive component framework |
| **Livewire Blaze** | `^1.0.13` | Blade rendering optimization engine |
| **TallStackUI** | `^3.5.14` | Component framework for TALL stack |
| **Laravel Fortify** | `^1.37.3` | Headless authentication backend |
| **r2luna/brain** | `^4.1.3` | Workflow, Action & Query architecture |
| **Spatie Laravel Permission** | `^8.3` | Role and permission RBAC management |
| **Tailwind CSS** | `^4.3.3` | Utility-first CSS framework (v4) |
| **Vite Plus** | `@latest` | Fast frontend bundling engine |
| **Pest PHP** | `^5.0.2` | Elegant PHP testing framework |

---

## 🏗️ Architecture (`r2luna/brain`)

Business logic is organized using `r2luna/brain` into three core building blocks:

- **Workflows (`app/Brain/Workflows`)**: Wrap multi-step operations in database transactions.
  - Examples: `CreateUserWorkflow`, `UpdateRoleWorkflow`, `ResetUserPasswordWorkflow`.
- **Actions (`app/Brain/Actions`)**: Perform single, decoupled units of state mutation.
  - Examples: `CreateUser`, `UpdateRole`, `DeletePermission`, `UpdateUserPassword`.
- **Queries (`app/Brain/Queries`)**: Encapsulate read-only queries.
  - Examples: `GetUserById`, `GetUserByEmail`.

---

## 🚀 Requirements

- **PHP**: `>= 8.5`
- **Composer**: `>= 2.x`
- **Node.js**: `>= 20.x` or **Bun**: `>= 1.1`
- **Database**: SQLite (default), MySQL, PostgreSQL, or MariaDB

---

## 📥 Getting Started

### 1. Clone & Install Dependencies

```bash
git clone https://github.com/brennoluan/livewire-starter-kit.git
cd livewire-starter-kit

# Run automated project setup script
composer run setup
```

The `setup` script will automatically:
1. Install PHP dependencies (`composer install`)
2. Create `.env` file from `.env.example`
3. Generate application key (`php artisan key:generate`)
4. Run database migrations (`php artisan migrate --force`)
5. Install frontend dependencies (`bun install` / `npm install`)
6. Build asset bundle (`bun run build`)

---

## 🖥️ Running Locally

Start the unified development server:

```bash
composer run dev
```

Or run frontend and backend processes separately:

```bash
# Backend (Artisan)
php artisan dev

# Frontend (Vite)
bun run dev
# or: npm run dev
```

---

## 🧪 Testing & Code Quality

This project maintains **100% Type Coverage**, maximum PHPStan analysis compliance, and full test automation.

### Available Quality Commands

```bash
# Run complete test suite (lint check, type coverage check, phpstan, unit/feature tests)
composer test

# Run code linter & formatter (Laravel Pint & Rector)
composer run lint

# Dry-run check for linter and coding standards
composer run lint:check

# Run static analysis (PHPStan)
composer run types:check

# Check for 100% type coverage
composer run type-coverage:check

# Run unit and feature tests with Pest
composer run unit:check

# Run tests in parallel
php artisan test --parallel
```

---

## 📂 Project Structure

```text
app/
├── Brain/               # Domain architecture (Workflows, Actions, Queries)
│   ├── Actions/         # Single-responsibility state mutation units
│   ├── Queries/         # Read-only database query classes
│   └── Workflows/       # Transaction-wrapped action orchestrators
├── Enums/               # App Enums (RolesEnum, PermissionsEnum)
├── Http/                # Controllers, Requests, Middleware
├── Livewire/            # Reactive Livewire 4 components
│   ├── Permissions/     # Permission management CRUD components
│   ├── Roles/           # Role management CRUD components
│   ├── Settings/        # Profile, Security, Appearance, Delete User
│   └── Users/           # User management CRUD components
├── Models/              # Eloquent models (User, Role, Permission)
├── Policies/            # Authorization policies (UserPolicy, RolePolicy, PermissionPolicy)
└── Providers/           # App and Fortify service providers

routes/
├── web.php              # Dashboard, User, Role, and Permission routes
└── settings.php         # Profile, Security, and Appearance settings routes

tests/
├── ArchTest.php         # Architectural testing rules
├── Browser/             # Pest Browser / Dusk end-to-end browser tests
├── Feature/             # Feature & Livewire component tests
└── Unit/                # Unit tests
```

---

## 📄 License

The Laravel framework and this starter kit are open-sourced software licensed under the [MIT license](LICENSE).
