import React from 'react'
import Swal from 'sweetalert2'

const SweetAlertDemo = () => {
  const showSuccessAlert = () => {
    Swal.fire({
      title: 'Success!',
      text: 'Everything is working perfectly!',
      icon: 'success',
      confirmButtonText: 'Great!',
      confirmButtonColor: '#8B0000'
    })
  }

  const showErrorAlert = () => {
    Swal.fire({
      title: 'Error!',
      text: 'Something went wrong!',
      icon: 'error',
      confirmButtonText: 'OK',
      confirmButtonColor: '#8B0000'
    })
  }

  const showWarningAlert = () => {
    Swal.fire({
      title: 'Warning!',
      text: 'Please be careful!',
      icon: 'warning',
      confirmButtonText: 'I Understand',
      confirmButtonColor: '#8B0000'
    })
  }

  const showInfoAlert = () => {
    Swal.fire({
      title: 'Information',
      text: 'Here is some useful information.',
      icon: 'info',
      confirmButtonText: 'Got it!',
      confirmButtonColor: '#8B0000'
    })
  }

  const showQuestionAlert = () => {
    Swal.fire({
      title: 'Are you sure?',
      text: 'This action cannot be undone!',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, do it!',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#8B0000',
      cancelButtonColor: '#6c757d'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire('Done!', 'Action completed successfully.', 'success')
      }
    })
  }

  const showCustomAlert = () => {
    Swal.fire({
      title: 'Welcome to E-Technozette!',
      text: 'This is a custom themed alert with your brand colors.',
      icon: 'success',
      confirmButtonText: 'Awesome!',
      confirmButtonColor: '#8B0000',
      background: '#f8f9fa',
      customClass: {
        popup: 'swal2-popup-custom'
      }
    })
  }

  const showTimerAlert = () => {
    Swal.fire({
      title: 'Auto Close Alert',
      text: 'This alert will close automatically in 3 seconds!',
      icon: 'info',
      timer: 3000,
      timerProgressBar: true,
      showConfirmButton: false,
      allowOutsideClick: false
    })
  }

  const showLoadingAlert = () => {
    Swal.fire({
      title: 'Loading...',
      text: 'Please wait while we process your request.',
      allowOutsideClick: false,
      showConfirmButton: false,
      didOpen: () => {
        Swal.showLoading()
      }
    })

    // Simulate loading
    setTimeout(() => {
      Swal.fire({
        title: 'Complete!',
        text: 'Your request has been processed successfully.',
        icon: 'success',
        confirmButtonText: 'Great!',
        confirmButtonColor: '#8B0000'
      })
    }, 3000)
  }

  return (
    <div style={{ 
      position: 'fixed', 
      bottom: '20px', 
      left: '20px', 
      zIndex: 999,
      display: 'flex',
      flexDirection: 'column',
      gap: '10px',
      maxWidth: '200px'
    }}>
      <button onClick={showSuccessAlert} style={{ 
        padding: '8px 16px', 
        backgroundColor: '#4CAF50', 
        color: 'white', 
        border: 'none', 
        borderRadius: '4px', 
        cursor: 'pointer',
        fontSize: '12px'
      }}>
        Success Alert
      </button>
      <button onClick={showErrorAlert} style={{ 
        padding: '8px 16px', 
        backgroundColor: '#f44336', 
        color: 'white', 
        border: 'none', 
        borderRadius: '4px', 
        cursor: 'pointer',
        fontSize: '12px'
      }}>
        Error Alert
      </button>
      <button onClick={showWarningAlert} style={{ 
        padding: '8px 16px', 
        backgroundColor: '#ff9800', 
        color: 'white', 
        border: 'none', 
        borderRadius: '4px', 
        cursor: 'pointer',
        fontSize: '12px'
      }}>
        Warning Alert
      </button>
      <button onClick={showInfoAlert} style={{ 
        padding: '8px 16px', 
        backgroundColor: '#2196F3', 
        color: 'white', 
        border: 'none', 
        borderRadius: '4px', 
        cursor: 'pointer',
        fontSize: '12px'
      }}>
        Info Alert
      </button>
      <button onClick={showQuestionAlert} style={{ 
        padding: '8px 16px', 
        backgroundColor: '#9C27B0', 
        color: 'white', 
        border: 'none', 
        borderRadius: '4px', 
        cursor: 'pointer',
        fontSize: '12px'
      }}>
        Question Alert
      </button>
      <button onClick={showCustomAlert} style={{ 
        padding: '8px 16px', 
        backgroundColor: '#8B0000', 
        color: 'white', 
        border: 'none', 
        borderRadius: '4px', 
        cursor: 'pointer',
        fontSize: '12px'
      }}>
        Custom Alert
      </button>
      <button onClick={showTimerAlert} style={{ 
        padding: '8px 16px', 
        backgroundColor: '#607D8B', 
        color: 'white', 
        border: 'none', 
        borderRadius: '4px', 
        cursor: 'pointer',
        fontSize: '12px'
      }}>
        Timer Alert
      </button>
      <button onClick={showLoadingAlert} style={{ 
        padding: '8px 16px', 
        backgroundColor: '#795548', 
        color: 'white', 
        border: 'none', 
        borderRadius: '4px', 
        cursor: 'pointer',
        fontSize: '12px'
      }}>
        Loading Alert
      </button>
    </div>
  )
}

export default SweetAlertDemo
