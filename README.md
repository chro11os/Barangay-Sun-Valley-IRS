# Barangay Sun Valley Incident Report System

## Overview
The **Barangay Sun Valley Incident Report System** is a digital platform designed to streamline the reporting, tracking, and management of incidents within Barangay Sun Valley. This system enhances **communication**, ensures **timely responses**, and maintains **accurate incident records** to improve governance and community safety.

## Features
- 🛡️ **User Registration & Authentication**: Secure login and role-based access for barangay officials and authorized users.
- 🗙️ **Incident Reporting**: Allows residents and officials to submit incident reports with detailed descriptions, categories, and supporting evidence.
- 📊 **Incident Tracking**: Enables officials to monitor reported incidents, assign responders, and update resolution statuses.
- 🔔 **Real-time Notifications**: Alerts authorized users when new incidents are reported or statuses are updated.
- 📈 **Data Management & Analytics**: Provides analytics and reports for data-driven decision-making.
- 🎧 **Admin Dashboard**: Centralized control panel for managing users, reports, and system settings.

---

## Technologies Used

| Layer | Technology |
|---|---|
| **Frontend** | React.js with Vite + Tailwind CSS |
| **Backend** | Laravel (PHP 8+) |
| **Database** | PostgreSQL (recommended) - Configurable for SQLite in local development |
| **Authentication** | JWT (via Laravel Sanctum) |
| **Hosting** | Local server (XAMPP/LAMP) or cloud-based deployment (AWS, DigitalOcean, etc.) |

---

## Installation Guide

### 1. Clone the Repository
```sh
git clone https://github.com/your-repo/barangay-sunvalley-irs.git
cd barangay-sunvalley-irs
```

---

### 2. Backend Setup (Laravel)

#### 2.1 Install Laravel Dependencies
Ensure **PHP**, **Composer**, and **PostgreSQL** are installed, then run:
```sh
cd backend
composer install
```

#### 2.2 Configure Environment
Create a `.env` file and set PostgreSQL credentials:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=barangay_reports
DB_USERNAME=your_pgsql_user
DB_PASSWORD=your_pgsql_password
```

> For quick local testing, you can set `DB_CONNECTION=sqlite` and create a file:
```sh
touch database/database.sqlite
```

#### 2.3 Run Migrations & Seeder (Optional)
```sh
php artisan migrate --seed
```

#### 2.4 Start Laravel Development Server
```sh
php artisan serve
```
Access Laravel at: **http://localhost:8000**

---

### 3. Frontend Setup (React + Vite)

#### 3.1 Install Frontend Dependencies
```sh
cd ../frontend
npm install
```

#### 3.2 Tailwind CSS Configuration
Ensure `tailwind.config.js` looks like this:
```js
module.exports = {
    content: ["./src/**/*.{js,jsx,ts,tsx}"],
    theme: {
        extend: {},
    },
    plugins: [],
};
```

Ensure your `index.css` (or `App.css`) includes:
```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

#### 3.3 Start Frontend Development Server
```sh
npm run dev
```
Access frontend at: **http://localhost:5173**

---

## Usage

1. **Login/Register** as a barangay official.
2. **Submit Incident Reports** including type, location, description, and optional evidence files.
3. **Monitor & Update Incident Statuses**, e.g., Pending → Investigating → Resolved.
4. **Generate Reports** to identify recurring incidents and improve barangay safety.
5. **Receive Real-time Notifications** for new incidents and updates.

---

## Project Structure

```
/backend (Laravel Backend)
    /app
    /database
    /routes
    /storage
    /public/uploads (for uploaded evidence files)
    .env (configured for PostgreSQL)

 /frontend (React + Vite)
    /src
        /components
        /pages
        /services (axios service to talk to Laravel API)
    tailwind.config.js
    vite.config.js
```

---

## Contributing

🚀 Contributions are welcome!  
Submit issues or pull requests to help improve this project.

---

## License

This project is licensed under the **MIT License**.

---

## Contact

For inquiries, support, or collaborations, contact the development team:  
📧 **support@barangaysunvalley.com**

---

## Quick Notes

- ✅ **Laravel Sanctum** secures API access.
- ✅ **PostgreSQL recommended** for production.
- ✅ **SQLite supported for local development.**
- ✅ **Vite for faster frontend builds.**
- ✅ **Tailwind CSS ensures responsive UI.**

---

## Future Enhancements

- 📍 **PostGIS Support** for geotagging incidents.
- 📱 **Mobile-optimized UI** for barangay officials on the go.
- 📊 **Advanced Analytics Dashboard** for incident trends and response times.

