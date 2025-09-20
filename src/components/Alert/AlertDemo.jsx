import React from 'react'

const AlertDemo = () => {
  const showSuccessAlert = () => {
    if (window.showAlert) {
      window.showAlert({
        type: 'success',
        message: 'This is a success alert! Everything is working perfectly.',
        duration: 4000
      })
    }
  }

  const showErrorAlert = () => {
    if (window.showAlert) {
      window.showAlert({
        type: 'error',
        message: 'This is an error alert! Something went wrong.',
        duration: 5000
      })
    }
  }

  const showWarningAlert = () => {
    if (window.showAlert) {
      window.showAlert({
        type: 'warning',
        message: 'This is a warning alert! Please be careful.',
        duration: 4000
      })
    }
  }

  const showInfoAlert = () => {
    if (window.showAlert) {
      window.showAlert({
        type: 'info',
        message: 'This is an info alert! Here is some useful information.',
        duration: 4000
      })
    }
  }

  const showCustomAlert = () => {
    if (window.showAlert) {
      window.showAlert({
        type: 'e-technozette',
        message: 'Welcome to E-Technozette! This is a custom themed alert.',
        duration: 5000
      })
    }
  }

  const showMultipleAlerts = () => {
    if (window.showAlert) {
      window.showAlert({
        type: 'success',
        message: 'First alert - Success!',
        duration: 3000
      })
      
      setTimeout(() => {
        window.showAlert({
          type: 'info',
          message: 'Second alert - Info!',
          duration: 3000
        })
      }, 500)
      
      setTimeout(() => {
        window.showAlert({
          type: 'warning',
          message: 'Third alert - Warning!',
          duration: 3000
        })
      }, 1000)
    }
  }

  return (
    <div style={{ 
      position: 'fixed', 
      bottom: '20px', 
      left: '20px', 
      zIndex: 999,
      display: 'flex',
      flexDirection: 'column',
      gap: '10px'
    }}>
      <button onClick={showSuccessAlert} style={{ padding: '8px 16px', backgroundColor: '#4CAF50', color: 'white', border: 'none', borderRadius: '4px', cursor: 'pointer' }}>
        Success Alert
      </button>
      <button onClick={showErrorAlert} style={{ padding: '8px 16px', backgroundColor: '#f44336', color: 'white', border: 'none', borderRadius: '4px', cursor: 'pointer' }}>
        Error Alert
      </button>
      <button onClick={showWarningAlert} style={{ padding: '8px 16px', backgroundColor: '#ff9800', color: 'white', border: 'none', borderRadius: '4px', cursor: 'pointer' }}>
        Warning Alert
      </button>
      <button onClick={showInfoAlert} style={{ padding: '8px 16px', backgroundColor: '#2196F3', color: 'white', border: 'none', borderRadius: '4px', cursor: 'pointer' }}>
        Info Alert
      </button>
      <button onClick={showCustomAlert} style={{ padding: '8px 16px', backgroundColor: '#8B0000', color: 'white', border: 'none', borderRadius: '4px', cursor: 'pointer' }}>
        Custom Alert
      </button>
      <button onClick={showMultipleAlerts} style={{ padding: '8px 16px', backgroundColor: '#9C27B0', color: 'white', border: 'none', borderRadius: '4px', cursor: 'pointer' }}>
        Multiple Alerts
      </button>
    </div>
  )
}

export default AlertDemo
