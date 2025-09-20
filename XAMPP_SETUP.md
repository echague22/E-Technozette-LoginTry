# E-Technozette XAMPP Setup Guide

This guide will help you set up the E-Technozette website using XAMPP for local development.

## Prerequisites

1. Download and install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Make sure you have the latest version of Node.js installed

## Setup Instructions

### 1. Start XAMPP Services

1. Open XAMPP Control Panel
2. Start **Apache** and **MySQL** services
3. Make sure both services are running (green status)

### 2. Database Setup

1. Open your web browser and go to `http://localhost/phpmyadmin`
2. Click on "New" to create a new database
3. Name the database: `etechnozette`
4. Click "Create"
5. Import the database structure:
   - Click on the `etechnozette` database
   - Go to the "Import" tab
   - Click "Choose File" and select `backend/database_setup.sql`
   - Click "Go" to import

### 3. Configure Database Connection

1. Open `backend/login.php`
2. Update the database credentials if needed:
   ```php
   $host = 'localhost';
   $dbname = 'etechnozette';
   $username = 'root';
   $password = ''; // Leave empty for default XAMPP setup
   ```

### 4. Deploy Backend Files

1. Copy the `backend` folder to your XAMPP htdocs directory:
   - Windows: `C:\xampp\htdocs\`
   - Mac: `/Applications/XAMPP/htdocs/`
   - Linux: `/opt/lampp/htdocs/`

2. Your backend files should be accessible at:
   - `http://localhost/backend/login.php`

### 5. Frontend Development

1. Open terminal/command prompt in the E-Technozette project directory
2. Install dependencies:
   ```bash
   npm install
   ```
3. Start the development server:
   ```bash
   npm run dev
   ```
4. The React app will be available at `http://localhost:5173`

### 6. Production Build (Optional)

To create a production build:

1. Build the React app:
   ```bash
   npm run build
   ```
2. Copy the `dist` folder contents to your XAMPP htdocs directory
3. Your website will be available at `http://localhost/`

## Default Login Credentials

The following test accounts are available:

| Username | Password | Role | Birthdate |
|----------|----------|------|-----------|
| admin | 12345 | Admin | 01-01-90 |
| editor | 12345 | Editor-In-Chief | 01-01-95 |
| writer1 | 12345 | Writer | 01-01-98 |
| Juan123 | 12345 | Editor-In-Chief | 01-01-01 |

## File Structure

```
E-Technozette/
├── src/                    # React frontend source
│   ├── App.jsx            # Main application component
│   ├── App.css            # Styling
│   └── main.jsx           # Entry point
├── backend/               # PHP backend
│   ├── login.php          # Login API endpoint
│   └── database_setup.sql # Database structure
├── public/                # Static assets
├── package.json           # Node.js dependencies
└── XAMPP_SETUP.md        # This file
```

## API Endpoints

### Login
- **URL**: `http://localhost/backend/login.php`
- **Method**: POST
- **Content-Type**: application/json
- **Body**:
  ```json
  {
    "username": "Juan123",
    "password": "12345",
    "role": "Editor-In-Chief",
    "birthdate": "01-01-01"
  }
  ```

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Make sure MySQL is running in XAMPP
   - Check database credentials in `login.php`
   - Verify database `etechnozette` exists

2. **CORS Errors**
   - The backend includes CORS headers
   - Make sure you're accessing the backend via `http://localhost/backend/`

3. **Port Conflicts**
   - If port 80 is busy, change Apache port in XAMPP
   - Update backend URLs accordingly

4. **File Permissions**
   - Make sure XAMPP has read/write permissions to htdocs folder

### Development Tips

1. **Hot Reload**: The React development server supports hot reloading
2. **Database Management**: Use phpMyAdmin for database management
3. **Logs**: Check XAMPP logs in the `logs` folder if issues occur
4. **Backup**: Regularly backup your database through phpMyAdmin

## Security Notes

- Change default passwords in production
- Use HTTPS in production
- Implement proper session management
- Add input validation and sanitization
- Use prepared statements (already implemented)

## Next Steps

1. Customize the design and content
2. Add more API endpoints for articles, users, etc.
3. Implement user registration
4. Add file upload functionality
5. Deploy to a production server

For more information, visit the [XAMPP Documentation](https://www.apachefriends.org/docs/).
