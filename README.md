# Barangay Sun Valley Incident Report System

## Overview
The Barangay Sun Valley Incident Report System is a digital platform designed to streamline the reporting, tracking, and management of incidents within the Barangay. It aims to enhance communication, ensure timely responses, and maintain accurate records of incidents for better governance and community safety.

## Features
- **User Registration & Authentication**: Secure login for barangay officials and authorized users.
- **Incident Reporting**: Allows residents and officials to file incident reports with relevant details.
- **Incident Tracking**: Enables monitoring of reported incidents and their resolution status.
- **Real-time Notifications**: Alerts officials of new reports and updates.
- **Data Management & Analytics**: Provides insights through reports and analytics for decision-making.
- **Admin Dashboard**: Centralized interface for managing users, reports, and system settings.

## Technologies Used
- **Frontend**: React.js with Tailwind CSS
- **Backend**: Laravel (PHP)
- **Database**: SQLite / MySQL (configurable)
- **Authentication**: JWT-based security
- **Hosting**: Local server or cloud-based deployment

## Installation
1. **Clone the Repository**
   ```sh
   git clone https://github.com/your-repo/barangay-sunvalley-irs.git
   cd barangay-sunvalley-irs
   ```
2. **Backend Setup**
   - Install PHP, Composer, and Laravel
   - Configure `.env` for database connection:
     - Use MySQL or SQLite by setting `DB_CONNECTION=mysql` or `DB_CONNECTION=sqlite`
     - If using SQLite, create the database file:
       ```sh
       touch database/database.sqlite
       ```
   - Install dependencies:
     ```sh
     composer install
     ```
   - Run database migrations:
     ```sh
     php artisan migrate
     ```
   - Start the Laravel development server:
     ```sh
     php artisan serve
     ```
3. **Frontend Setup** (React.js with Tailwind CSS)
   - Install dependencies:
     ```sh
     npm install
     ```
   - Install Tailwind CSS:
     ```sh
     npm install -D tailwindcss postcss autoprefixer
     npx tailwindcss init -p
     ```
   - Configure `tailwind.config.js` and include Tailwind in `index.css`:
     ```js
     module.exports = {
       content: ["./src/**/*.{js,jsx,ts,tsx}"],
       theme: {
         extend: {},
       },
       plugins: [],
     };
     ```
   - Start the development server:
     ```sh
     npm start
     ```

## Usage
1. Register or log in as a barangay official.
2. Submit incident reports with location, description, and supporting media.
3. Monitor reported incidents and update statuses as necessary.
4. Generate reports for insights and decision-making.

## Contributing
Contributions are welcome! Feel free to submit issues or pull requests to improve the system.

## License
This project is licensed under the MIT License.

## Contact
For inquiries or support, contact the development team at `support@barangaysunvalley.com`.

