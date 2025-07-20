@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="mb-4">Public Articles</h3>
                    <form id="filterForm" class="mb-4 row g-2 align-items-end">
                        <div class="col-md-3">
                            <select class="form-select" id="filterCategory">
                                <option value="">All Categories</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterUser">
                                <option value="">All Users</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">Filter</button>
                        </div>
                    </form>
                    <ul class="list-group" id="publicArticleList"></ul>
                    <div id="publicArticleDetail" class="mt-4 d-none"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const publicArticleList = document.getElementById('publicArticleList');
    const publicArticleDetail = document.getElementById('publicArticleDetail');
    const filterForm = document.getElementById('filterForm');
    const filterCategory = document.getElementById('filterCategory');
    const filterUser = document.getElementById('filterUser');

    function renderArticles(articles) {
        publicArticleList.innerHTML = '';
        if (!articles.length) {
            publicArticleList.innerHTML = '<li class="list-group-item text-center">No articles found.</li>';
            return;
        }
        articles.forEach(article => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                <span>
                    <strong>${article.title}</strong> <span class="badge bg-secondary">${article.slug}</span>
                    <span class="badge bg-info ms-2">Category: ${article.category_name}</span>
                    <span class="badge bg-light text-dark ms-2">User: ${article.user_name}</span>
                </span>
                <button class="btn btn-outline-primary btn-sm view-btn" data-id="${article.id}">View</button>
            `;
            publicArticleList.appendChild(li);
        });
    }

    function fetchArticles() {
        let url = '/api/articles?';
        if (filterCategory.value) url += `category=${encodeURIComponent(filterCategory.value)}&`;
        if (filterUser.value) url += `user_id=${encodeURIComponent(filterUser.value)}&`;
        fetch(url)
            .then(res => res.json())
            .then(renderArticles)
            .catch(() => { publicArticleList.innerHTML = '<li class="list-group-item text-danger">Failed to load articles.</li>'; });
    }

    function fetchCategoriesAndUsers() {
        Promise.all([
            fetch('/api/categories').then(res => res.json()),
            fetch('/api/users-list').then(res => res.json())
        ]).then(([categories, users]) => {

            filterCategory.innerHTML = '<option value="">All Categories</option>';
            categories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.name;
                option.textContent = cat.name;
                filterCategory.appendChild(option);
            });
            filterCategory.disabled = false;

            
            filterUser.innerHTML = '<option value="">All Users</option>';
            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = user.name;
                filterUser.appendChild(option);
            });
            filterUser.disabled = false;

            fetchArticles();
        }).catch(() => {
            filterCategory.innerHTML = '<option value="">All Categories</option>';
            filterUser.innerHTML = '<option value="">All Users</option>';
            fetchArticles();
        });
    }

    publicArticleList.addEventListener('click', function(e) {
        if (e.target.classList.contains('view-btn')) {
            const id = e.target.getAttribute('data-id');
            fetch(`/api/articles/public/${id}`)
                .then(res => res.json())
                .then(article => {
                    publicArticleDetail.classList.remove('d-none');
                    publicArticleDetail.innerHTML = `
                        <div class="card">
                            <div class="card-body">
                                <h4>${article.title} <span class="badge bg-secondary">${article.slug}</span></h4>
                                <div class="mb-2"><strong>Status:</strong> ${article.status}</div>
                                <div class="mb-2"><strong>Category:</strong> ${article.category_name}</div>
                                <div class="mb-2"><strong>User:</strong> ${article.user_name}</div>
                                <div class="mb-2"><strong>Body:</strong><br>${article.body}</div>
                            </div>
                        </div>
                    `;
                    window.scrollTo({ top: publicArticleDetail.offsetTop, behavior: 'smooth' });
                })
                .catch(() => {
                    publicArticleDetail.classList.remove('d-none');
                    publicArticleDetail.innerHTML = '<div class="alert alert-danger">Failed to load article details.</div>';
                });
        }
    });
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        fetchArticles();
    });
    filterCategory.addEventListener('change', fetchArticles);
    filterUser.addEventListener('change', fetchArticles);
    fetchCategoriesAndUsers();
});
</script>
@endsection
