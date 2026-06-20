@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Welcome, {{ Auth::user()->name }}! 👋</h1>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-blue-100 p-6 rounded-lg">
            <h3 class="text-gray-700 font-semibold">My Posts</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total_posts'] }}</p>
        </div>
        <div class="bg-green-100 p-6 rounded-lg">
            <h3 class="text-gray-700 font-semibold">Total Views</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['total_views'] }}</p>
        </div>
        <div class="bg-purple-100 p-6 rounded-lg">
            <h3 class="text-gray-700 font-semibold">Comments</h3>
            <p class="text-3xl font-bold text-purple-600">{{ $stats['total_comments'] }}</p>
        </div>
    </div>

    <!-- User Profile Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex items-center mb-6">
            @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" class="w-20 h-20 rounded-full mr-4 object-cover">
            @else
                <div class="w-20 h-20 rounded-full mr-4 bg-gray-300 flex items-center justify-center">
                    <span class="text-gray-600 text-2xl">{{ substr($user->name, 0, 1) }}</span>
                </div>
            @endif
            <div>
                <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                <p class="text-gray-600">{{ $user->position ?? 'Employee' }}</p>
                <p class="text-gray-600">{{ $user->department?->name ?? 'No Department' }}</p>
            </div>
        </div>

        <!-- OTP Verification -->
        <div class="border-t pt-6">
            <h3 class="font-bold mb-4">📱 Phone Verification</h3>
            @if(!$user->phone_verified)
                <div class="flex gap-2">
                    <button onclick="sendEmailOtp()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Send Email OTP</button>
                    <button onclick="showWhatsappModal()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Send WhatsApp OTP</button>
                </div>
            @else
                <p class="text-green-600 font-semibold">✓ Phone Verified</p>
            @endif
        </div>
    </div>

    <!-- Department Colleagues -->
    @if($departmentUsers->count() > 0)
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-2xl font-bold mb-4">👥 Your Department Colleagues</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($departmentUsers as $colleague)
                @if($colleague->id !== $user->id)
                <div class="border border-gray-200 rounded p-4 hover:shadow-lg transition">
                    <p class="font-semibold">{{ $colleague->name }}</p>
                    <p class="text-sm text-gray-600">{{ $colleague->position ?? 'Employee' }}</p>
                    <p class="text-sm text-gray-600">{{ $colleague->email }}</p>
                    @if($colleague->phone)
                    <p class="text-sm text-gray-600">{{ $colleague->phone }}</p>
                    @endif
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    <!-- My Blog Posts -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold">📝 My Blog Posts</h3>
            <a href="{{ route('blog.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">+ Create Post</a>
        </div>

        @forelse($posts as $post)
            <div class="border-b border-gray-200 pb-4 mb-4 last:border-b-0 hover:bg-gray-50 p-3 rounded transition">
                <h4 class="font-bold text-lg">{{ $post->title }}</h4>
                <p class="text-gray-600 text-sm my-2">{{ $post->excerpt ?? substr(strip_tags($post->content), 0, 100) }}</p>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span>👁️ {{ $post->views }} views</span>
                    <span>💬 {{ $post->comments->count() }} comments</span>
                    <span>{{ $post->published ? '✅ Published' : '📌 Draft' }}</span>
                </div>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-500 hover:underline text-sm">View</a>
                    <a href="{{ route('blog.edit', $post) }}" class="text-blue-500 hover:underline text-sm">Edit</a>
                    <form method="POST" action="{{ route('blog.destroy', $post) }}" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline text-sm" onclick="return confirm('Delete this post?')">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-600 text-center py-8">No blog posts yet. <a href="{{ route('blog.create') }}" class="text-blue-500 hover:underline font-semibold">Create one now!</a></p>
        @endforelse

        <div class="mt-4">{{ $posts->links() }}</div>
    </div>
</div>

<!-- WhatsApp Modal -->
<div id="whatsappModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-xl font-bold mb-4">Send WhatsApp OTP</h3>
        <input type="text" id="whatsappPhone" placeholder="Enter WhatsApp number (+1234567890)" class="w-full border rounded px-3 py-2 mb-4">
        <div class="flex gap-2 justify-end">
            <button onclick="closeWhatsappModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">Cancel</button>
            <button onclick="sendWhatsappOtp()" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Send OTP</button>
        </div>
    </div>
</div>

<script>
function sendEmailOtp() {
    fetch('/auth/send-email-otp', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
        body: JSON.stringify({email: '{{ $user->email }}'})
    })
    .then(r => r.json())
    .then(d => {
        alert(d.message || d.error);
        if(d.message) {
            const otp = prompt('Enter OTP received:');
            if(otp) verifyOtp(otp, 'email');
        }
    });
}

function showWhatsappModal() {
    document.getElementById('whatsappModal').classList.remove('hidden');
}

function closeWhatsappModal() {
    document.getElementById('whatsappModal').classList.add('hidden');
}

function sendWhatsappOtp() {
    const phone = document.getElementById('whatsappPhone').value;
    if(!phone) return alert('Please enter phone number');
    
    fetch('/auth/send-whatsapp-otp', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
        body: JSON.stringify({phone})
    })
    .then(r => r.json())
    .then(d => {
        alert(d.message || d.error);
        if(d.message) {
            closeWhatsappModal();
            const otp = prompt('Enter OTP received:');
            if(otp) verifyOtp(otp, 'whatsapp');
        }
    });
}

function verifyOtp(otp, type) {
    fetch('/auth/verify-otp', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
        body: JSON.stringify({otp, type})
    })
    .then(r => r.json())
    .then(d => {
        alert(d.message || d.error);
        if(d.message) location.reload();
    });
}
</script>
@endsection