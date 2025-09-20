import { useState, useEffect } from 'react'
import './Alert.css'

const Alert = ({ type = 'info', message, onClose, duration = 5000, show = true }) => {
  const [isVisible, setIsVisible] = useState(show)

  useEffect(() => {
    setIsVisible(show)
    
    if (show && duration > 0) {
      const timer = setTimeout(() => {
        handleClose()
      }, duration)
      
      return () => clearTimeout(timer)
    }
  }, [show, duration])

  const handleClose = () => {
    setIsVisible(false)
    if (onClose) {
      setTimeout(onClose, 300) // Wait for animation to complete
    }
  }

  if (!isVisible) return null

  const getIcon = () => {
    switch (type) {
      case 'success':
        return '✅'
      case 'error':
        return '❌'
      case 'warning':
        return '⚠️'
      case 'info':
      default:
        return 'ℹ️'
    }
  }

  return (
    <div className={`alert alert-${type} ${isVisible ? 'alert-show' : 'alert-hide'}`}>
      <div className="alert-content">
        <div className="alert-icon">
          {getIcon()}
        </div>
        <div className="alert-message">
          {message}
        </div>
        <button 
          className="alert-close" 
          onClick={handleClose}
          aria-label="Close alert"
        >
          ×
        </button>
      </div>
    </div>
  )
}

export default Alert
