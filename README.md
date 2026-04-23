# Faith Connect Web App

A clean, modern PHP-based web application for church member management, built to provide a hub for accessing sermons, news, giving options, daily devotions, prayer requests, and gospel music.

## Features

- **Authentication System:** Secure registration and login flow for church members.
- **Dashboard:** A central navigation grid giving quick access to all core features.
- **Sermons:** Browse and stream the latest teachings from church pastors.
- **News:** Stay updated with the latest church announcements and events.
- **Generous Giving:** A simple form to submit offertory, tithes, and seed donations.
- **Prayer Requests:** Submit categorized prayer requests, with an option to remain anonymous.
- **Daily Devotions:** Read daily scriptures and inspirational messages to start the day.
- **Gospel Music:** Discover and play the latest praise and worship releases.

## Technologies Used

- **Frontend:** HTML5, CSS3, Google Fonts (Roboto), FontAwesome Icons.
- **Backend:** PHP 8+
- **Database:** MySQL (using PDO for secure database access).

## Installation & Setup Guide

Since this application uses PHP and a MySQL database, you need a local server environment (like Laragon, XAMPP, or WAMP) to run it on your computer.

### 1. Set Up Your Local Server (Recommended: Laragon)

1. Download **Laragon Full** from [laragon.org/download](https://laragon.org/download/).
2. Install Laragon on your Windows machine (usually to `C:\laragon\`).
3. Start the Laragon application and click the **"Start All"** button to launch Apache and MySQL.

### 2. Install the Project

1. Move the `faith connect web app` folder into your server's web root directory:
   - For Laragon: `C:\laragon\www\`
   - For XAMPP: `C:\xampp\htdocs\`
2. The folder path should look something like `C:\laragon\www\faith connect web app`.

### 3. Database Configuration

1. Open your database manager (like phpMyAdmin or Laragon's built-in HeidiSQL/database tool).
   - *If using Laragon, click the "Database" button to open HeidiSQL.*
2. Create a new database named exactly: `faith_connect`
3. Import the database structure and dummy data by running the provided SQL script:
   - Locate the `database.sql` file in the root of the project folder.
   - Run this script inside your database manager against the `faith_connect` database.

### 4. Running the App

1. Open your web browser.
2. Navigate to your local server address. This is typically:
   - `http://localhost/faith connect web app`
3. If using Laragon with Auto Virtual Hosts enabled, you might also be able to visit:
   - `http://faith-connect-web-app.test`
4. Register a new account or browse the login page to get started!

## Project Structure

```
faith connect web app/
│
├── assets/
│   └── css/
│       └── style.css       # Global stylesheet and UI design
│
├── auth.php                # Backend authentication logic (login/register)
├── config.php              # Database connection settings
├── database.sql            # MySQL schema and dummy data insertion script
│
├── index.php               # Entry point (redirects to login)
├── login.php               # Login page layout
├── register.php            # Registration page layout
├── dashboard.php           # Main user dashboard grid
│
├── sermons.php             # Teachings listing page
├── news.php                # Announcements and news feed
├── giving.php              # Donation and tithing form
├── prayers.php             # Prayer request submission form
├── devotions.php           # Daily Devotion page
└── music.php               # Gospel music discovery page
```

---
*Developed for the Faith Connect community.*
