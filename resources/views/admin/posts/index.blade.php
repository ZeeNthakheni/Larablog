@extends('admin.layouts.app')

@section('title', 'Posts Management')
@section('page-title', 'Posts Management')
@section('page-description', 'Manage all blog posts')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">All Posts</h5>
                <div>
                    <a href="/posts/create" class="btn btn-primary">
                        <i class="bi bi-plus"></i> Create Post
                    </a>
                    <span class="badge bg-primary ms-2">{{ $posts->total() }} total posts</span>
                </div>
            </div>
            <div class="card-body p-0">
                @if($posts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Post</th>
                                    <th>Author</th>
                                    <th>Created</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-start">
                                            <div class="me-3">
                                                @if($post->cover_image)
                                                    <img src="/storage/cover_images/{{ $post->cover_image }}" 
                                                         alt="Cover" 
                                                         style="width: 60px; height: 45px; object-fit: cover; border-radius: 0.375rem;">
                                                @else
                                                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 45px;">
                                                        <i class="bi bi-file-text"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ Str::limit($post->title, 50) }}</h6>
                                                <p class="text-muted mb-0 small">{{ Str::limit($post->body ?? 'No content', 80) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                    {{ strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <span class="fw-medium">{{ $post->user->name ?? 'Unknown' }}</span>
                                                <br>
                                                <small class="text-muted">{{ $post->user->email ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $post->created_at->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="/posts/{{ $post->id }}" class="btn btn-sm btn-outline-primary btn-icon" title="View Post" target="_blank">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="/posts/{{ $post->id }}/edit" class="btn btn-sm btn-outline-secondary btn-icon" title="Edit Post">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger btn-icon" title="Delete Post" 
                                                    onclick="confirmDelete({{ $post->id }}, '{{ addslashes($post->title) }}')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($posts->hasPages())
                        <div class="card-footer">
                            {{ $posts->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-file-text text-muted" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mt-3">No posts found</h5>
                        <p class="text-muted">No blog posts have been created yet.</p>
                        <a href="/posts/create" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Create First Post
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the post <strong id="deletePostTitle"></strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Post</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(postId, postTitle) {
        document.getElementById('deletePostTitle').textContent = postTitle;
        document.getElementById('deleteForm').action = '/posts/' + postId;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>
@endpush