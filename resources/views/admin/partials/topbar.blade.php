<div class="bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
    <strong>Welcome, {{ auth()->user()->name }}</strong>
    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button class="btn btn-sm btn-outline-danger">Logout</button>
    </form>
</div>
