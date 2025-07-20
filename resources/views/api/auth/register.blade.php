@extends('layouts.guest')
@section('content')
    <h2 class="mb-4 text-center">User Registration</h2>
    <form id="registerForm">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required placeholder="Your Name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Confirm Password">
        </div>
        <button type="submit" class="btn btn-success w-100">Register</button>
        <a href="{{ route('api.login') }}">Login here</a>
    </form>
    <div id="error" class="alert alert-danger mt-4 d-none">
        <strong>Registration Failed</strong>
        <div id="errorMessage"></div>
    </div>
<script>
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = {
        name: formData.get('name'),
        email: formData.get('email'),
        password: formData.get('password'),
        password_confirmation: formData.get('password_confirmation')
    };
    try {
        const response = await fetch('/api/auth/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (response.ok) {
            window.location.href = '/api/login';
        } else {
            document.getElementById('error').classList.remove('d-none');
            document.getElementById('errorMessage').textContent = result.message || 'Registration failed';
        }
    } catch (error) {
        document.getElementById('error').classList.remove('d-none');
        document.getElementById('errorMessage').textContent = 'Network error occurred';
    }
});
</script>
@endsection
