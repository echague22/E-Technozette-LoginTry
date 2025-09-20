import { useState } from 'react'
import Swal from 'sweetalert2'
import './LoginForm.css'

function LoginForm() {
  const [formData, setFormData] = useState({
    role: 'Managing Editor',
    username: 'Kate',
    birthdate: '02-02-02',
    password: '67890'
  })
  const [showPassword, setShowPassword] = useState(false)
  const [errors, setErrors] = useState({})
  const [isSubmitting, setIsSubmitting] = useState(false)

  const handleInputChange = (e) => {
    const { name, value } = e.target
    setFormData(prev => ({
      ...prev,
      [name]: value
    }))
    
    // Clear error when user starts typing
    if (errors[name]) {
      setErrors(prev => ({
        ...prev,
        [name]: ''
      }))
    }
  }

  const validateForm = () => {
    const newErrors = {}
    
    if (!formData.username.trim()) {
      newErrors.username = 'Username is required'
    }
    
    if (!formData.password.trim()) {
      newErrors.password = 'Password is required'
    }
    
    if (!formData.birthdate.trim()) {
      newErrors.birthdate = 'Birthdate is required'
    } else if (!/^\d{2}-\d{2}-\d{2}$/.test(formData.birthdate)) {
      newErrors.birthdate = 'Please enter date in MM-DD-YY format'
    }
    
    if (!formData.role) {
      newErrors.role = 'Please select a role'
    }
    
    setErrors(newErrors)
    return Object.keys(newErrors).length === 0
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    
    // Validate form before submitting
    if (!validateForm()) {
      return
    }
    
    setIsSubmitting(true)
    
    try {
      console.log('Attempting login with:', formData)
      
      // Try the correct backend path
      const response = await fetch('http://localhost/E-Technozette/backend/login.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
      })
      
      console.log('Response status:', response.status)
      
      const data = await response.json()
      
      if (data.success) {
        // Store token and user data in localStorage
        localStorage.setItem('authToken', data.token)
        localStorage.setItem('userData', JSON.stringify(data.user))
        localStorage.setItem('userPermissions', JSON.stringify(data.user.permissions))
        
        // Show success message with SweetAlert
        Swal.fire({
          title: 'Welcome!',
          text: `Welcome, ${data.user.first_name} ${data.user.last_name}! Role: ${data.user.role}`,
          icon: 'success',
          confirmButtonText: 'Continue',
          timer: 3000,
          timerProgressBar: true,
          showConfirmButton: true,
          allowOutsideClick: false
        }).then(() => {
          window.location.href = '/dashboard'
        })
        console.log('Login successful:', data)
      } else {
        // Show specific error message with SweetAlert
        let errorTitle = 'Login Failed'
        let errorText = data.error || 'Invalid credentials'
        
        // Customize error messages based on the error type
        if (data.error && data.error.includes('Invalid credentials')) {
          errorTitle = 'Invalid Credentials'
          errorText = 'Please check your username, password, role, and birthdate.'
        } else if (data.error && data.error.includes('Invalid birthdate')) {
          errorTitle = 'Invalid Birthdate'
          errorText = 'Please check your birthdate format (MM-DD-YY).'
        } else if (data.error && data.error.includes('All fields are required')) {
          errorTitle = 'Missing Information'
          errorText = 'Please fill in all required fields.'
        }
        
        Swal.fire({
          title: errorTitle,
          text: errorText,
          icon: 'error',
          confirmButtonText: 'Try Again',
          allowOutsideClick: false
        })
      }
    } catch (error) {
      console.error('Login error:', error)
      // Show connection error with SweetAlert
      Swal.fire({
        title: 'Connection Error',
        text: 'Unable to connect to server. Please check if XAMPP is running and the backend is accessible.',
        icon: 'error',
        confirmButtonText: 'OK',
        allowOutsideClick: false
      })
    } finally {
      setIsSubmitting(false)
    }
  }

  return (
    <div className="login-container">
      <form className="login-form" onSubmit={handleSubmit}>
        <div className="form-header">
          <h3>LOGIN ACCESS</h3>
        </div>
        
        <div className="form-group">
          <label>Role:</label>
          <select 
            name="role" 
            value={formData.role} 
            onChange={handleInputChange}
            className={`form-select ${errors.role ? 'error' : ''}`}
          >
            <option value="Editor-In-Chief">Editor-In-Chief</option>
            <optgroup label="Editorial Boards">
              <option value="Managing Editor">Managing Editor</option>
              <option value="Associate Editor - Internal">Associate Editor - Internal</option>
              <option value="Associate Editor - External">Associate Editor - External</option>
              <option value="Proofreader (Editorial Board)">Proofreader (Editorial Board)</option>
            </optgroup>
            <optgroup label="Head Editors">
              <option value="News Editor">News Editor</option>
              <option value="Editorial Editor">Editorial Editor</option>
              <option value="Feature Editor">Feature Editor</option>
              <option value="Literary Editor">Literary Editor</option>
              <option value="Sports Editor">Sports Editor</option>
              <option value="Head Layout Artist">Head Layout Artist</option>
              <option value="Head Cartoonist">Head Cartoonist</option>
              <option value="Head Photojournalist">Head Photojournalist</option>
            </optgroup>
            <optgroup label="Writers">
              <option value="News Writer">News Writer</option>
              <option value="Editorial Writer">Editorial Writer</option>
              <option value="Feature Writer">Feature Writer</option>
              <option value="Literary Writer">Literary Writer</option>
              <option value="Sports Writer">Sports Writer</option>
            </optgroup>
            <optgroup label="Creative Team">
              <option value="Layout Artist">Layout Artist</option>
              <option value="Cartoonist">Cartoonist</option>
              <option value="Photojournalist">Photojournalist</option>
            </optgroup>
          </select>
          {errors.role && <div className="error-message">{errors.role}</div>}
        </div>

        <div className="form-group">
          <label>Username:</label>
          <input
            type="text"
            name="username"
            value={formData.username}
            onChange={handleInputChange}
            className={`form-input ${errors.username ? 'error' : ''}`}
            placeholder="Enter your username"
            required
          />
          {errors.username && <div className="error-message">{errors.username}</div>}
        </div>

        <div className="form-group">
          <label>Birthdate:</label>
          <input
            type="text"
            name="birthdate"
            value={formData.birthdate}
            onChange={handleInputChange}
            className={`form-input ${errors.birthdate ? 'error' : ''}`}
            placeholder="MM-DD-YY (e.g., 02-02-02)"
            pattern="[0-9]{2}-[0-9]{2}-[0-9]{2}"
            title="Please enter date in MM-DD-YY format"
            required
          />
          {errors.birthdate && <div className="error-message">{errors.birthdate}</div>}
        </div>

        <div className="form-group">
          <label>Password:</label>
          <div className="password-input-container">
            <input
              type={showPassword ? "text" : "password"}
              name="password"
              value={formData.password}
              onChange={handleInputChange}
              className={`form-input ${errors.password ? 'error' : ''}`}
              placeholder="Enter your password"
              required
            />
            <button
              type="button"
              className="password-toggle"
              onClick={() => setShowPassword(!showPassword)}
            >
              <i className={`fas fa-eye${showPassword ? '-slash' : ''}`}></i>
            </button>
          </div>
          {errors.password && <div className="error-message">{errors.password}</div>}
        </div>

        <div className="form-footer">
          <a href="#" className="forgot-password">Forgot your password?</a>
          <button 
            type="submit" 
            className="submit-btn"
            disabled={isSubmitting}
          >
            {isSubmitting ? 'Logging in...' : 'Submit'}
          </button>
        </div>
      </form>
    </div>
  )
}

export default LoginForm
