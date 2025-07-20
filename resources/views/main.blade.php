@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3 class="mb-4" id="welcomeMsg">Welcome!</h3>
                    <form id="logoutForm" style="display:none;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                    <div id="guestContent" class="mt-4">
                        <h5>This is public content. Anyone can see this.</h5>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
let mainToken = localStorage.getItem('api_token');
if(mainToken) {
    fetch('/api/auth/me', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${mainToken}`,
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.user && data.user.name) {
            document.getElementById('welcomeMsg').textContent = 'Welcome, ' + data.user.name + '!';
            document.getElementById('logoutForm').style.display = 'block';
            document.getElementById('guestContent').style.display = 'none';
        }
    });
}
document.getElementById('logoutForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    try {
        await fetch('/api/auth/logout', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${mainToken}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        localStorage.removeItem('api_token');
        window.location.reload();
    } catch (error) {
        window.location.reload();
    }
});
</script>
@endsection
