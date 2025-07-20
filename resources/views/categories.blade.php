@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="mb-4">Category Management</h3>
                    <form id="createCategoryForm" class="mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control" id="categoryName" placeholder="New Category Name" required>
                            <button class="btn btn-success" type="submit">Add Category</button>
                        </div>
                    </form>
                    <div id="categoryError" class="alert alert-danger d-none"></div>
                    <ul class="list-group" id="categoryList"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
const apiToken = localStorage.getItem('api_token');
if (!apiToken) {
    document.querySelector('.container').innerHTML = '<div class="alert alert-warning text-center">You must be logged in to manage categories.</div>';
} else {
    const categoryList = document.getElementById('categoryList');
    const categoryError = document.getElementById('categoryError');
    const createCategoryForm = document.getElementById('createCategoryForm');
    const categoryNameInput = document.getElementById('categoryName');

    function showError(msg) {
        categoryError.textContent = msg;
        categoryError.classList.remove('d-none');
    }
    function clearError() {
        categoryError.textContent = '';
        categoryError.classList.add('d-none');
    }
    function renderCategories(categories) {
        categoryList.innerHTML = '';
        categories.forEach(cat => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                <span>
                    <input type="text" value="${cat.name}" class="form-control form-control-sm d-inline-block w-auto me-2" style="width: 200px; display: inline-block;" data-id="${cat.id}" />
                    <span class="badge bg-secondary">${cat.slug}</span>
                </span>
                <span>
                    <button class="btn btn-primary btn-sm me-2 update-btn" data-id="${cat.id}">Update</button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="${cat.id}">Delete</button>
                </span>
            `;
            categoryList.appendChild(li);
        });
    }
    function fetchCategories() {
        fetch('/api/categories', {
            headers: { 'Authorization': `Bearer ${apiToken}` }
        })
        .then(res => res.json())
        .then(renderCategories)
        .catch(() => showError('Failed to load categories.'));
    }
    createCategoryForm.addEventListener('submit', function(e) {
        e.preventDefault();
        clearError();
        fetch('/api/categories', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${apiToken}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ name: categoryNameInput.value })
        })
        .then(res => res.ok ? res.json() : res.json().then(err => Promise.reject(err)))
        .then(() => {
            categoryNameInput.value = '';
            fetchCategories();
        })
        .catch(err => showError(err.message || 'Failed to create category.'));
    });
    categoryList.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-btn')) {
            const id = e.target.getAttribute('data-id');
            clearError();
            fetch(`/api/categories/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${apiToken}`,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(res => res.ok ? fetchCategories() : res.json().then(err => Promise.reject(err)))
            .catch(err => showError(err.message || 'Failed to delete category.'));
        }
        if (e.target.classList.contains('update-btn')) {
            const id = e.target.getAttribute('data-id');
            const input = categoryList.querySelector(`input[data-id='${id}']`);
            clearError();
            fetch(`/api/categories/${id}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${apiToken}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ name: input.value })
            })
            .then(res => res.ok ? fetchCategories() : res.json().then(err => Promise.reject(err)))
            .catch(err => showError(err.message || 'Failed to update category.'));
        }
    });
    fetchCategories();
}
</script>
@endsection 