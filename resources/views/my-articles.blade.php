@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="mb-4">My Articles</h3>
                   
                    <form id="createArticleForm" class="mb-4">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="articleTitle" placeholder="Title" required>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="articleCategory" required></select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="articleStatus" required>
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="articleSlug" placeholder="Slug (auto)" readonly>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success w-100" type="submit">Add Article</button>
                            </div>
                        </div>
                        <div class="mt-2">
                            <textarea class="form-control" id="articleBody" rows="2" placeholder="Body" required></textarea>
                        </div>
                    </form>
                    <div id="articleError" class="alert alert-danger d-none"></div>
                    <ul class="list-group" id="articleList"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
const apiToken = localStorage.getItem('api_token');
let categoriesMap = {};
let categoriesSlugToId = {};
let categoriesIdToName = {};
if (!apiToken) {
    document.querySelector('.container').innerHTML = '<div class="alert alert-warning text-center">You must be logged in to manage your articles.</div>';
} else {
    const articleList = document.getElementById('articleList');
    const articleError = document.getElementById('articleError');
    const createArticleForm = document.getElementById('createArticleForm');
    const articleTitle = document.getElementById('articleTitle');
    const articleSlug = document.getElementById('articleSlug');
    const articleBody = document.getElementById('articleBody');
    const articleStatus = document.getElementById('articleStatus');
    const articleCategory = document.getElementById('articleCategory');

    function slugify(text) {
        return text.toString().toLowerCase().replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }
    articleTitle.addEventListener('input', function() {
        articleSlug.value = slugify(articleTitle.value);
    });
    function showError(msg) {
        articleError.textContent = msg;
        articleError.classList.remove('d-none');
    }
    function clearError() {
        articleError.textContent = '';
        articleError.classList.add('d-none');
    }
    function renderArticles(articles) {
        articleList.innerHTML = '';
        articles.forEach(article => {
            const li = document.createElement('li');
            li.className = 'list-group-item';
            li.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <input type="text" value="${article.title}" class="form-control form-control-sm d-inline-block w-auto me-2" style="width: 180px; display: inline-block;" data-id="${article.id}" data-field="title" />
                        <span class="badge bg-secondary">${article.slug}</span>
                        <select class="form-select form-select-sm d-inline-block w-auto ms-2" data-id="${article.id}" data-field="status">
                            <option value="draft" ${article.status === 'draft' ? 'selected' : ''}>Draft</option>
                            <option value="published" ${article.status === 'published' ? 'selected' : ''}>Published</option>
                        </select>
                        <select class="form-select form-select-sm d-inline-block w-auto ms-2" data-id="${article.id}" data-field="category_id"></select>
                        <span class="badge bg-info ms-2">${categoriesIdToName[article.category_id] || article.category_id}</span>
                    </div>
                    <div>
                        <button class="btn btn-primary btn-sm me-2 update-btn" data-id="${article.id}">Update</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${article.id}">Delete</button>
                    </div>
                </div>
                <textarea class="form-control form-control-sm mt-2" rows="2" data-id="${article.id}" data-field="body">${article.body}</textarea>
            `;
            articleList.appendChild(li);
        });
        // Populate category selects for each article
        document.querySelectorAll('select[data-field="category_id"]').forEach(select => {
            const articleId = select.getAttribute('data-id');
            select.innerHTML = '';
            Object.entries(categoriesIdToName).forEach(([id, name]) => {
                const option = document.createElement('option');
                option.value = id;
                option.textContent = name;
                if (id == articles.find(a => a.id == articleId).category_id) option.selected = true;
                select.appendChild(option);
            });
        });
    }
    function fetchArticles() {
        let url = '/api/articles/mine?';
        fetch(url, {
            headers: { 'Authorization': `Bearer ${apiToken}` }
        })
        .then(res => res.json())
        .then(renderArticles)
        .catch(() => showError('Failed to load articles.'));
    }
    function fetchCategoriesForForm() {
        fetch('/api/categories')
            .then(res => res.json())
            .then(categories => {
                articleCategory.innerHTML = '';
                categories.forEach(cat => {
                    categoriesMap[cat.slug] = cat;
                    categoriesSlugToId[cat.slug] = cat.id;
                    categoriesIdToName[cat.id] = cat.name;
                    const option1 = document.createElement('option');
                    option1.value = cat.id;
                    option1.textContent = cat.name;
                    articleCategory.appendChild(option1);
                });
                fetchArticles(); // Fetch articles after categories are loaded
            });
    }
    createArticleForm.addEventListener('submit', function(e) {
        e.preventDefault();
        clearError();
        fetch('/api/articles', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${apiToken}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                title: articleTitle.value,
                body: articleBody.value,
                status: articleStatus.value,
                category_id: articleCategory.value
            })
        })
        .then(res => res.ok ? res.json() : res.json().then(err => Promise.reject(err)))
        .then(() => {
            articleTitle.value = '';
            articleSlug.value = '';
            articleBody.value = '';
            fetchArticles();
        })
        .catch(err => showError(err.message || 'Failed to create article.'));
    });
    articleList.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-btn')) {
            const id = e.target.getAttribute('data-id');
            clearError();
            fetch(`/api/articles/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${apiToken}`,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(res => res.ok ? fetchArticles() : res.json().then(err => Promise.reject(err)))
            .catch(err => showError(err.message || 'Failed to delete article.'));
        }
        if (e.target.classList.contains('update-btn')) {
            const id = e.target.getAttribute('data-id');
            const title = articleList.querySelector(`input[data-id='${id}'][data-field='title']`).value;
            const body = articleList.querySelector(`textarea[data-id='${id}'][data-field='body']`).value;
            const status = articleList.querySelector(`select[data-id='${id}'][data-field='status']`).value;
            const category_id = articleList.querySelector(`select[data-id='${id}'][data-field='category_id']`).value;
            clearError();
            fetch(`/api/articles/${id}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${apiToken}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ title, body, status, category_id })
            })
            .then(res => res.ok ? fetchArticles() : res.json().then(err => Promise.reject(err)))
            .catch(err => showError(err.message || 'Failed to update article.'));
        }
    });
    fetchCategoriesForForm();
}
</script>
@endsection
