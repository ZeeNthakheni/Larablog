@extends('admin.layouts.app')

@section('title', 'User Details')
@section('page-title', 'User Details')
@section('page-description', 'View user information and posts')

@section('content')
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                @if($user->is_admin)
                    <span class="badge bg-warning text-dark">Administrator</span>
                @else
                    <span class="badge bg-secondary">User</span>
                @endif
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">User Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h3 class="text-primary">{{ $user->posts->count() }}</h3>
                        <p class="text-muted mb-0">Posts</p>
                    </div>
                    <div class="col-6">
                        <h3 class="text-success">{{ $user->created_at->diffInDays() }}</h3>
                        <p class="text-muted mb-0">Days Active</p>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <p class="mb-1"><strong>Joined:</strong> {{ $user->created_at->format('F d, Y') }}</p>
                    <p class="mb-0"><strong>Last Updated:</strong> {{ $user->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Posts by {{ $user->name }}</h5>
                <span class="badge bg-primary">{{ $user->posts->count() }} posts</span>
            </div>
            <div class="card-body p-0">
                @if($user->posts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Created</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->posts as $post)
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">{{ $post->title }}</h6>
                                            <p class="text-muted mb-0 small">{{ Str::limit($post->body ?? 'No content', 100) }}</p>
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
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-file-text text-muted" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mt-3">No posts yet</h5>
                        <p class="text-muted">This user hasn't created any posts.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Users
        </a>
        @if(!$user->is_admin && $user->id !== Auth::id())
            <button class="btn btn-danger ms-2" onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                <i class="bi bi-trash"></i> Delete User
            </button>
        @endif
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
                <p>Are you sure you want to delete user <strong id="deleteUserName"></strong>?</p>
                <p class="text-danger"><small>This action will also delete all posts created by this user and cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(userId, userName) {
        document.getElementById('deleteUserName').textContent = userName;
        document.getElementById('deleteForm').action = '/admin/users/' + userId;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>
@endpush