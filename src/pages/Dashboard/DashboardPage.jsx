import React, { useState, useEffect } from 'react'
import Swal from 'sweetalert2'
import './DashboardPage.css'

function DashboardPage() {
  const [userData, setUserData] = useState({})
  const [userPermissions, setUserPermissions] = useState([])
  const [isLoading, setIsLoading] = useState(true)

  useEffect(() => {
    // Load user data and permissions
    const storedUserData = JSON.parse(localStorage.getItem('userData') || '{}')
    const storedPermissions = JSON.parse(localStorage.getItem('userPermissions') || '[]')
    
    setUserData(storedUserData)
    setUserPermissions(storedPermissions)
    setIsLoading(false)
    
    // Validate session with backend
    validateSession()
  }, [])

  const validateSession = async () => {
    const token = localStorage.getItem('authToken')
    if (!token) {
      handleLogout()
      return
    }

    try {
      // Try the correct backend path first
      let response = await fetch(`http://localhost/E-Technozette/backend/login.php?token=${token}`)
      
      // If that fails, try alternative path
      if (!response.ok) {
        response = await fetch(`http://localhost/backend/login.php?token=${token}`)
      }
      
      const data = await response.json()
      
      if (!data.valid) {
        handleLogout()
      }
    } catch (error) {
      console.error('Session validation error:', error)
      // Don't logout on network errors, just log the error
    }
  }

  const handleLogout = () => {
    // Show logout confirmation with SweetAlert
    Swal.fire({
      title: 'Logout',
      text: 'Are you sure you want to logout?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, Logout',
      cancelButtonText: 'Cancel',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // Show logout message with proper loading spinner
        Swal.fire({
          title: 'LOGGING OUT...',
          text: 'See you next time!',
          allowOutsideClick: false,
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading()
          }
        }).then(() => {
          // Clear localStorage and redirect
          localStorage.removeItem('authToken')
          localStorage.removeItem('userData')
          localStorage.removeItem('userPermissions')
          window.location.href = '/'
        })
      }
    })
  }

  const hasPermission = (permission) => {
    return userPermissions.includes('all') || userPermissions.includes(permission)
  }

  if (isLoading) {
    return (
      <div className="dashboard-page">
        <div className="loading-container">
          <h2>Loading...</h2>
        </div>
      </div>
    )
  }

  return (
    <div className="dashboard-page">
      <header className="dashboard-header">
        <div className="header-content">
          <div className="logo-section">
            <div className="logo">
              <img src="/logo.svg" alt="EARIST Logo" className="logo-image" />
              <h1 className="logo-text">Technozette</h1>
            </div>
          </div>
          <div className="user-info">
            <div className="user-details">
              <span className="welcome-text">Welcome, {userData.first_name || userData.username || 'User'}</span>
              <span className="role-text">Role: {userData.role || 'Unknown'}</span>
            </div>
            <button onClick={handleLogout} className="logout-btn">Logout</button>
          </div>
        </div>
      </header>
      
      <main className="dashboard-main">
        <div className="dashboard-content">
          <h2>Dashboard - E-Technozette</h2>
          <p className="dashboard-subtitle">Access your authorized features based on your role</p>
          
          <div className="dashboard-grid">
            {hasPermission('articles') && (
              <div className="dashboard-card">
                <h3>Articles</h3>
                <p>Manage publication articles</p>
                <button className="card-btn">View Articles</button>
              </div>
            )}
            
            {hasPermission('users') && (
              <div className="dashboard-card">
                <h3>Users</h3>
                <p>Manage user accounts</p>
                <button className="card-btn">View Users</button>
              </div>
            )}
            
            {hasPermission('settings') && (
              <div className="dashboard-card">
                <h3>Settings</h3>
                <p>System configuration</p>
                <button className="card-btn">Settings</button>
              </div>
            )}
            
            {hasPermission('reports') && (
              <div className="dashboard-card">
                <h3>Reports</h3>
                <p>View system reports</p>
                <button className="card-btn">View Reports</button>
              </div>
            )}
          </div>
          
          {userPermissions.length === 0 && (
            <div className="no-permissions">
              <h3>No Permissions Assigned</h3>
              <p>Your account doesn't have any specific permissions assigned. Please contact your administrator.</p>
            </div>
          )}
        </div>
      </main>
    </div>
  )
}

export default DashboardPage
