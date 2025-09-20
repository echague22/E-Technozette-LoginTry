# E-Technozette Database Setup Guide

## 🗄️ **How the Database Works**

The E-Technozette website uses a **MySQL database** with **PHP backend** to handle user authentication and data storage. Here's how it works:

### **Architecture Overview:**
```
Frontend (React) → Backend (PHP) → Database (MySQL)
     ↓                ↓                ↓
  Login Form → login.php → Users Table
```

## 🚀 **Step-by-Step Setup**

### **Step 1: Install XAMPP**
1. Download XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Install XAMPP on your computer
3. Start **Apache** and **MySQL** services from XAMPP Control Panel

### **Step 2: Access phpMyAdmin**
1. Open your web browser
2. Go to `http://localhost/phpmyadmin`
3. You should see the phpMyAdmin interface

### **Step 3: Create the Database**
1. Click **"New"** in the left sidebar
2. Enter database name: `etechnozette`
3. Click **"Create"**

### **Step 4: Import Database Structure**
1. Click on the `etechnozette` database (left sidebar)
2. Click the **"Import"** tab
3. Click **"Choose File"** and select: `E-Technozette/backend/database_setup.sql`
4. Click **"Go"** to import

### **Step 5: Verify Database Setup**
After import, you should see these tables:
- ✅ `users` - User accounts and roles
- ✅ `articles` - Publication articles
- ✅ `categories` - Article categories
- ✅ `comments` - User comments

## 🔧 **How It Works**

### **1. User Authentication Flow:**
```
User enters credentials → React sends to PHP → PHP checks database → Returns success/failure
```

### **2. Database Tables:**

#### **Users Table:**
```sql
- id (Primary Key)
- username (Unique)
- email (Unique)
- password (Hashed)
- role (Editor-In-Chief, Managing Editor, etc.)
- birthdate
- first_name, last_name
- session_token
- last_login
```

#### **Articles Table:**
```sql
- id (Primary Key)
- title, content
- author_id (Links to users)
- status (draft, review, published)
- category, tags
- published_at
```

### **3. Login Process:**
1. User fills login form
2. React sends data to `http://localhost/backend/login.php`
3. PHP validates credentials against database
4. If valid: returns success + user data
5. If invalid: returns error message

## 📁 **File Structure**

```
E-Technozette/
├── backend/
│   ├── login.php          # Authentication API
│   └── database_setup.sql # Database structure
├── src/
│   ├── components/Login/
│   │   ├── LoginForm.jsx  # Login form component
│   │   └── LoginForm.css  # Form styling
│   └── pages/Login/
│       ├── LoginPage.jsx  # Login page
│       └── LoginPage.css  # Page styling
```

## 🔐 **Default Users (After Import)**

| Username | Password | Role | Birthdate |
|----------|----------|------|-----------|
| Kate | 67890 | Managing Editor | 02-02-02 |
| editor | 12345 | Editor-In-Chief | 01-01-95 |
| news_editor | 12345 | News Editor | 03-03-03 |
| feature_writer | 12345 | Feature Writer | 04-04-04 |
| layout_artist | 12345 | Layout Artist | 05-05-05 |
| sports_writer | 12345 | Sports Writer | 06-06-06 |

## 🚀 **Running the Application**

### **1. Start XAMPP Services:**
- ✅ Apache (for PHP backend)
- ✅ MySQL (for database)

### **2. Start React Development Server:**
```bash
cd E-Technozette
npm run dev
```

### **3. Access the Application:**
- **Frontend:** `http://localhost:5173`
- **Backend API:** `http://localhost/backend/login.php`
- **Database:** `http://localhost/phpmyadmin`

## 🔧 **Backend Configuration**

### **Database Connection (login.php):**
```php
$host = 'localhost';
$dbname = 'etechnozette';
$username = 'root';
$password = ''; // Default XAMPP setup
```

### **API Endpoint:**
- **URL:** `http://localhost/backend/login.php`
- **Method:** POST
- **Content-Type:** application/json

### **Request Format:**
```json
{
  "username": "Kate",
  "password": "67890",
  "role": "Managing Editor",
  "birthdate": "02-02-02"
}
```

### **Response Format:**
```json
{
  "success": true,
  "message": "Login successful",
  "token": "session_token_here",
  "user": {
    "id": 1,
    "username": "Kate",
    "role": "Managing Editor",
    "email": "kate@etechnozette.com"
  }
}
```

## 🛠️ **Troubleshooting**

### **Common Issues:**

1. **"Database connection failed"**
   - Check if MySQL is running in XAMPP
   - Verify database name is `etechnozette`

2. **"Login failed: Invalid credentials"**
   - Check username/password combination
   - Verify role matches exactly

3. **"Backend not available"**
   - Check if Apache is running in XAMPP
   - Verify `backend` folder is in `htdocs`

4. **"CORS errors"**
   - Backend includes CORS headers
   - Make sure you're using `http://localhost/backend/`

### **File Locations:**
- **XAMPP htdocs:** `C:\xampp\htdocs\`
- **Backend files:** Copy `backend` folder to `htdocs/backend/`

## 📊 **Database Management**

### **Adding New Users:**
1. Go to phpMyAdmin
2. Select `etechnozette` database
3. Click `users` table
4. Click "Insert" tab
5. Add new user with hashed password

### **Password Hashing:**
Passwords are hashed using PHP's `password_hash()` function. To create a new user:
```php
$hashed_password = password_hash('your_password', PASSWORD_DEFAULT);
```

### **Viewing Data:**
- **Users:** `SELECT * FROM users;`
- **Articles:** `SELECT * FROM articles;`
- **Categories:** `SELECT * FROM categories;`

## 🎯 **Next Steps**

1. **Set up XAMPP** and import the database
2. **Test login** with default credentials
3. **Add more users** as needed
4. **Customize roles** if required
5. **Deploy to production** when ready

The database system is now ready to handle user authentication and can be extended for article management, comments, and other features!
