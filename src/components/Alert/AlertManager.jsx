import { useState, useCallback } from 'react'
import Alert from './Alert'

const AlertManager = () => {
  const [alerts, setAlerts] = useState([])

  const addAlert = useCallback((alert) => {
    const id = Date.now() + Math.random()
    const newAlert = {
      id,
      type: alert.type || 'info',
      message: alert.message,
      duration: alert.duration || 5000,
      show: true
    }
    
    setAlerts(prev => [...prev, newAlert])
    return id
  }, [])

  const removeAlert = useCallback((id) => {
    setAlerts(prev => prev.filter(alert => alert.id !== id))
  }, [])

  const clearAllAlerts = useCallback(() => {
    setAlerts([])
  }, [])

  // Expose methods globally for easy access
  window.showAlert = addAlert
  window.clearAlerts = clearAllAlerts

  return (
    <div className="alert-manager">
      {alerts.map((alert) => (
        <Alert
          key={alert.id}
          type={alert.type}
          message={alert.message}
          duration={alert.duration}
          show={alert.show}
          onClose={() => removeAlert(alert.id)}
        />
      ))}
    </div>
  )
}

export default AlertManager
