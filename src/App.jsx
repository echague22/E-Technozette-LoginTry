import { useState, useEffect } from 'react'
import LoginPage from './pages/Login/LoginPage'
import DashboardPage from './pages/Dashboard/DashboardPage'

function App() {
  const [isLoggedIn, setIsLoggedIn] = useState(false)

  // Check for existing login session on page load
  useEffect(() => {
    const token = localStorage.getItem('authToken')
    const userData = localStorage.getItem('userData')
    
    if (token && userData) {
      setIsLoggedIn(true)
    }
  }, [])

  // Handle route changes
  useEffect(() => {
    const handleRouteChange = () => {
      const token = localStorage.getItem('authToken')
      const userData = localStorage.getItem('userData')
      setIsLoggedIn(!!(token && userData))
    }

    // Listen for storage changes (logout from other tabs)
    window.addEventListener('storage', handleRouteChange)
    
    // Check current route
    const currentPath = window.location.pathname
    if (currentPath === '/dashboard') {
      handleRouteChange()
    } else if (currentPath === '/') {
      setIsLoggedIn(false)
    }

    return () => {
      window.removeEventListener('storage', handleRouteChange)
    }
  }, [])

  // Simple routing based on current path
  const currentPath = window.location.pathname

  if (currentPath === '/dashboard' || isLoggedIn) {
    return <DashboardPage />
  }

  return <LoginPage />
}

export default App
