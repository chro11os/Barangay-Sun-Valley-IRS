# 📝 Sun-Valley Incident Reporting System

## 🌟 Overview
The **Sun-Valley Incident Reporting System** is a web-based platform designed to streamline the reporting and management of incidents within Barangay Sun Valley. The system allows users to submit reports, track incidents, and facilitate communication between residents and authorities.

## 🚀 Features
- 🔐 User authentication and role-based access control
- 📸 Incident reporting with file uploads (images, documents, etc.)
- 📊 Incident status tracking and updates
- 🛠️ Admin dashboard for managing reports
- 📱 Responsive UI for mobile and desktop

## 🏗️ Tech Stack
### Backend:
- 🐘 Laravel (PHP)
- 🖥️ Blade (Templating Engine)
- 🗄️ PostgreSQL (Supabase for cloud database)

### Frontend:
- ⚛️ React (Primary UI Framework)
- 🔮 Vue.js (For specific interactive components)
- 🎨 Tailwind CSS (Styling and UI components)

## ⚙️ Installation
### 📌 Prerequisites:
- 🐘 PHP 8+
- 📦 Composer
- 🟢 Node.js & npm
- 🗄️ PostgreSQL (Supabase configuration required)
- 🎛️ Laravel CLI

### 🔧 Setup Steps:
1. **Clone the repository:**
   ```sh
   git clone https://github.com/your-repo/sun-valley-irs.git
   cd sun-valley-irs
   ```
2. **Install backend dependencies:**
   ```sh
   composer install
   ```
3. **Setup environment variables:**
   ```sh
   cp .env.example .env
   ```
   - Configure database settings in `.env`
4. **Generate application key:**
   ```sh
   php artisan key:generate
   ```
5. **Run database migrations:**
   ```sh
   php artisan migrate --seed
   ```
6. **Start Laravel backend:**
   ```sh
   php artisan serve
   ```

### 🎨 Frontend Setup:
1. **Navigate to frontend directory:**
   ```sh
   cd frontend
   ```
2. **Install frontend dependencies:**
   ```sh
   npm install
   ```
3. **Start frontend development server:**
   ```sh
   npm run dev
   ```

## 🔍 Usage
- 🌐 Access the system via `http://localhost:8000` for backend or `http://localhost:3000` for frontend.
- 📝 Register and log in to submit and track incidents.
- 🏛️ Admin users can manage incident reports through the dashboard.

## 🤝 Contributing
1. 🍴 Fork the repository
2. 🌱 Create a new branch (`git checkout -b feature-branch`)
3. 💾 Commit changes (`git commit -m 'Add new feature'`)
4. 🚀 Push to branch (`git push origin feature-branch`)
5. 🔄 Create a Pull Request

## 📜 License
This project is licensed under the MIT License.

