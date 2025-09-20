# E-Technozette

**The Official Publication of Eulogio "Amang" Rodriguez Institute of Science and Technology**

A modern web application built with React.js and PHP backend, designed for managing the official publication of EARIST.

## 🎯 Features

- **Modern Login System**: Secure authentication with role-based access
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile devices
- **Dashboard Interface**: Clean and intuitive admin dashboard
- **Database Integration**: MySQL database with PHP backend
- **XAMPP Compatible**: Easy local development setup

## 🚀 Quick Start

### Prerequisites

- Node.js (v16 or higher)
- XAMPP (for local development)
- Modern web browser

### Installation

1. **Clone or download the project**
   ```bash
   cd E-Technozette
   ```

2. **Install dependencies**
   ```bash
   npm install
   ```

3. **Set up XAMPP**
   - Start Apache and MySQL services
   - Import the database using `backend/database_setup.sql`
   - Copy backend files to `htdocs/backend/`

4. **Start development server**
   ```bash
   npm run dev
   ```

5. **Access the application**
   - Frontend: `http://localhost:5173`
   - Backend API: `http://localhost/backend/login.php`

## 🔐 Default Login Credentials

| Username | Password | Role | Birthdate |
|----------|----------|------|-----------|
| Kate | 67890 | Managing Editor | 02-02-02 |
| editor | 12345 | Editor-In-Chief | 01-01-95 |
| news_editor | 12345 | News Editor | 03-03-03 |
| feature_writer | 12345 | Feature Writer | 04-04-04 |
| layout_artist | 12345 | Layout Artist | 05-05-05 |
| sports_writer | 12345 | Sports Writer | 06-06-06 |

## 🎨 Design Features

- **Color Scheme**: Dark red (#8B0000) and white theme matching EARIST branding
- **Typography**: Inter font family for modern readability
- **Icons**: Font Awesome icons for enhanced UI
- **Responsive**: Mobile-first design approach
- **Accessibility**: WCAG compliant design elements

## 🏗️ Architecture

### Frontend (React.js)
- **App.jsx**: Main application component with login and dashboard
- **App.css**: Comprehensive styling with responsive design
- **State Management**: React hooks for form and authentication state

### Backend (PHP)
- **login.php**: RESTful API endpoint for authentication
- **database_setup.sql**: Complete database schema with sample data
- **Security**: Password hashing, prepared statements, CORS headers

### Database Schema
- **users**: User accounts with roles and authentication
- **articles**: Publication articles with status management
- **categories**: Article categorization system
- **comments**: User comments on articles

## 📱 Responsive Design

The application is fully responsive and optimized for:
- **Desktop**: Full-featured interface with sidebar navigation
- **Tablet**: Adapted layout with touch-friendly controls
- **Mobile**: Streamlined interface with collapsible elements

## 🔧 Development

### Available Scripts

```bash
npm run dev      # Start development server
npm run build    # Create production build
npm run preview  # Preview production build
npm run lint     # Run ESLint
```

### File Structure

```
E-Technozette/
├── src/
│   ├── App.jsx          # Main React component
│   ├── App.css          # Styling and responsive design
│   └── main.jsx         # Application entry point
├── backend/
│   ├── login.php        # Authentication API
│   └── database_setup.sql # Database schema
├── public/              # Static assets
├── XAMPP_SETUP.md      # Detailed XAMPP setup guide
└── README.md           # This file
```

## 🚀 Deployment

### Local Development (XAMPP)
1. Follow the detailed guide in `XAMPP_SETUP.md`
2. Ensure Apache and MySQL are running
3. Import database and configure backend

### Production Deployment
1. Build the React application: `npm run build`
2. Deploy the `dist` folder to your web server
3. Configure PHP backend on your server
4. Set up MySQL database with production credentials
5. Update API endpoints in the React app

## 🔒 Security Features

- **Password Hashing**: bcrypt encryption for user passwords
- **SQL Injection Protection**: Prepared statements in PHP
- **CORS Configuration**: Proper cross-origin resource sharing
- **Input Validation**: Client and server-side validation
- **Session Management**: Secure token-based authentication

## 🎯 User Roles

- **Admin**: Full system access and user management
- **Editor-In-Chief**: Article approval and editorial control
- **Editor**: Article editing and review capabilities
- **Writer**: Article creation and submission

## 📊 Database Features

- **User Management**: Complete user account system
- **Article System**: Draft, review, and publish workflow
- **Category Management**: Organized content categorization
- **Comment System**: User engagement and feedback
- **Audit Trail**: Created and updated timestamps

## 🛠️ Customization

### Styling
- Modify `src/App.css` for design changes
- Update color variables for different themes
- Add new CSS classes for additional components

### Functionality
- Extend `src/App.jsx` for new features
- Add new API endpoints in the backend
- Modify database schema as needed

## 📞 Support

For technical support or questions:
- Check the `XAMPP_SETUP.md` for detailed setup instructions
- Review the database schema in `backend/database_setup.sql`
- Examine the API documentation in `backend/login.php`

## 📄 License

This project is developed for Eulogio "Amang" Rodriguez Institute of Science and Technology.

## 🙏 Acknowledgments

- **EARIST**: For providing the institutional context and requirements
- **React.js**: For the powerful frontend framework
- **XAMPP**: For the local development environment
- **Font Awesome**: For the comprehensive icon library

---

**E-Technozette** - *Silence, Spoils, Freedom*