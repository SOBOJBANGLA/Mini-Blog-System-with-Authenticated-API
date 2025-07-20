@extends('layouts.guest')
@section('content')
    <h2 class="mb-4 text-center">User Login</h2>
    <form id="loginForm">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <a href="{{ route('api.register') }}">Register here</a>
    </form>
    <div id="error" class="alert alert-danger mt-4 d-none">
        <strong>Login Failed</strong>
        <div id="errorMessage"></div>
    </div>
<script>
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = {
        email: formData.get('email'),
        password: formData.get('password')
    };
    try {
        const response = await fetch('/api/auth/login', {
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
            localStorage.setItem('api_token', result.token);
            window.location.href = '/';
        } else {
            document.getElementById('error').classList.remove('d-none');
            document.getElementById('errorMessage').textContent = result.message || 'Login failed';
        }
    } catch (error) {
        document.getElementById('error').classList.remove('d-none');
        document.getElementById('errorMessage').textContent = 'Network error occurred';
    }
});
</script>
@endsection
