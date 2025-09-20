import React from 'react'
import LoginForm from '../../components/Login/LoginForm'
import './LoginPage.css'

function LoginPage() {
  return (
    <div className="login-page">
      {/* Header */}
      <header className="header">
        <div className="header-content">
          <div className="logo-section">
            <div className="logo">
              <img src="/logo.svg" alt="EARIST Logo" className="logo-image" />
              <h1 className="logo-text">Technozette</h1>
            </div>
          </div>
        </div>
        <div className="header-title">
          <h2>SILENCE, SPOILS, FREEDOM</h2>
          <p>THE OFFICIAL PUBLICATION OF EULOGIO "AMANG" RODRIGUEZ INSTITUTE OF SCIENCE AND TECHNOLOGY</p>
        </div>
      </header>

      {/* Main Content */}
      <main className="main-content">
        <div className="background-patterns">
          <div className="pattern-left"></div>
          <div className="pattern-right"></div>
          <div className="faded-text">
            <span className="earist-text">EARIST</span>
            <span className="technozette-text">Technozette</span>
          </div>
          <div className="background-icons">
            <i className="fas fa-fist-raised"></i>
            <i className="fas fa-lightbulb"></i>
          </div>
        </div>

        {/* Login Form */}
        <LoginForm />
        
        {/* Additional Content for Scrolling */}
        <div className="additional-content">
          <div className="content-section">
            <h3>About E-Technozette</h3>
            <p>Welcome to the official publication of Eulogio "Amang" Rodriguez Institute of Science and Technology. Our publication serves as a platform for academic discourse, technological innovation, and institutional communication.</p>
          </div>
          
          <div className="content-section">
            <h3>Our Mission</h3>
            <p>To provide a comprehensive platform for sharing knowledge, research findings, and institutional updates within the EARIST community and beyond.</p>
          </div>
          
          <div className="content-section">
            <h3>Publication Guidelines</h3>
            <p>All submissions must adhere to our editorial standards and academic integrity policies. For more information, please contact our editorial team.</p>
          </div>
          
          <div className="content-section">
            <h3>Contact Information</h3>
            <p>For inquiries and submissions, please reach out to our editorial team through the official channels provided by the institute.</p>
          </div>
        </div>
      </main>
    </div>
  )
}

export default LoginPage
