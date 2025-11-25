// Fungsi Validasi Login dengan Struktur Percabangan If
function validateLogin(event) {
    event.preventDefault();
    
    // Ambil nilai dari form
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    
    // Container untuk menampilkan error
    const errorDiv = document.getElementById('error-message');
    errorDiv.innerHTML = '';
    errorDiv.className = 'alert d-none';
    
    // Validasi Email
    if (email === '') {
        showError('Email tidak boleh kosong!');
        return false;
    }
    
    // Validasi format email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showError('Format email tidak valid!');
        return false;
    }
    
    // Validasi Password
    if (password === '') {
        showError('Password tidak boleh kosong!');
        return false;
    }
    
    if (password.length < 6) {
        showError('Password minimal 6 karakter!');
        return false;
    }
    
    // Jika semua validasi lolos, lanjutkan submit form
    document.getElementById('loginForm').submit();
}

// Fungsi untuk menampilkan pesan error
function showError(message) {
    const errorDiv = document.getElementById('error-message');
    errorDiv.innerHTML = `<i class="bi bi-exclamation-triangle"></i> ${message}`;
    errorDiv.className = 'alert alert-danger';
    
    // Auto hide setelah 5 detik
    setTimeout(() => {
        errorDiv.className = 'alert alert-danger d-none';
    }, 5000);
}

// Fungsi untuk menampilkan pesan sukses
function showSuccess(message) {
    const errorDiv = document.getElementById('error-message');
    errorDiv.innerHTML = `<i class="bi bi-check-circle"></i> ${message}`;
    errorDiv.className = 'alert alert-success';
}

// Validasi Register
function validateRegister(event) {
    event.preventDefault();
    
    const fullname = document.getElementById('fullname').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const confirmPassword = document.getElementById('confirm_password').value.trim();
    
    const errorDiv = document.getElementById('error-message');
    errorDiv.innerHTML = '';
    errorDiv.className = 'alert d-none';
    
    // Validasi Nama Lengkap
    if (fullname === '') {
        showError('Nama lengkap tidak boleh kosong!');
        return false;
    }
    
    if (fullname.length < 3) {
        showError('Nama lengkap minimal 3 karakter!');
        return false;
    }
    
    // Validasi Email
    if (email === '') {
        showError('Email tidak boleh kosong!');
        return false;
    }
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showError('Format email tidak valid!');
        return false;
    }
    
    // Validasi Password
    if (password === '') {
        showError('Password tidak boleh kosong!');
        return false;
    }
    
    if (password.length < 6) {
        showError('Password minimal 6 karakter!');
        return false;
    }
    
    // Validasi Konfirmasi Password
    if (confirmPassword === '') {
        showError('Konfirmasi password tidak boleh kosong!');
        return false;
    }
    
    if (password !== confirmPassword) {
        showError('Password dan konfirmasi password tidak cocok!');
        return false;
    }
    
    // Submit form jika validasi lolos
    document.getElementById('registerForm').submit();
}

// Real-time validation feedback
document.addEventListener('DOMContentLoaded', function() {
    // Email validation on blur
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const email = this.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email !== '' && !emailRegex.test(email)) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else if (email !== '') {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            }
        });
    }
    
    // Password strength indicator
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            
            if (password.length < 6) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            }
        });
    }
    
    // Confirm password match validation
    const confirmPasswordInput = document.getElementById('confirm_password');
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword !== '' && password !== confirmPassword) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else if (confirmPassword !== '' && password === confirmPassword) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            }
        });
    }
});