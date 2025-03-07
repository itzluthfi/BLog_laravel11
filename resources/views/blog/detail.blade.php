@extends('layout.app')

@section('title_page', 'Post Detail')

@section('content')
<section class="w-full bg-gray-50 py-20 sm:py-10">
    <div class="container max-w-screen mx-auto px-4 sm:px-6 md:px-8">

        <!-- Title -->
        <h1 class="text-4xl font-bold text-center mb-12 gradient-text" data-aos="fade-up">
            {{ e($blog->title, ENT_QUOTES, 'UTF-8') }}
        </h1>

        <!-- Gambar Landscape -->
        <div class="bg-white rounded-lg overflow-hidden shadow-lg mb-8" data-aos="fade-up">
            <img src="{{ asset(e($blog->landscape_image, ENT_QUOTES, 'UTF-8')) }}" 
                 alt="{{ e($blog->title, ENT_QUOTES, 'UTF-8') }}" 
                 class="w-full h-80 object-cover transform hover:scale-105 transition duration-500">
            <div class="p-6">
                <p class="text-gray-600 mb-4">{{ e($blog->description, ENT_QUOTES, 'UTF-8') }}</p>
                <p class="text-sm text-gray-500 flex items-center gap-2">
                    <i class="fas fa-user text-indigo-500"></i> 
                    <span class="font-semibold">{{ e($blog->author->username, ENT_QUOTES, 'UTF-8') }}</span> | 
                    <i class="far fa-calendar-alt text-indigo-500"></i> {{ $blog->published_at->format('F j, Y') }}
                </p>
            </div>
        </div>

        <!-- Konten Detail -->
        <div class="flex flex-col lg:flex-row bg-white p-8 rounded-lg shadow-lg gap-8 max-h-[600px] overflow-hidden overflow-y-auto" data-aos="fade-up">
            <div class="lg:w-3/5 w-full">
                <h2 class="text-2xl font-semibold mb-4 text-indigo-600">Full Content</h2>
                <div class="text-gray-700 mb-4">{!! $blog->full_content !!}</div>
            </div>
            
            <div class="lg:w-2/5 w-full">
                <img src="{{ asset(e($blog->portrait_image, ENT_QUOTES, 'UTF-8')) }}" 
                     alt="{{ e($blog->title, ENT_QUOTES, 'UTF-8') }} - Portrait" 
                     class="w-full h-auto object-cover rounded-lg shadow-lg transform hover:scale-105 transition duration-500">
            </div>
        </div>

<!-- Wrapper -->
<div class="flex flex-col lg:flex-row lg:items-start gap-8 mt-12 px-4 sm:px-6 lg:px-0">
    <!-- Section Komentar -->
    <div class="bg-white rounded-xl shadow-md p-6 sm:p-8 max-w-screen w-full lg:w-3/5 " data-aos="fade-up">
        <h3 class="text-2xl sm:text-3xl font-bold text-indigo-700 mb-4 sm:mb-6 flex items-center gap-2">
            <i class="fas fa-comments"></i> Comments
        </h3>

        <div id="comments-list" class="space-y-6 max-h-[600px] overflow-y-auto pr-4">
            @forelse ($comments as $comment)
                <div class="bg-gray-50 p-5 sm:p-6 rounded-xl shadow-lg border border-gray-200 transition hover:shadow-2xl relative">
                    <!-- Tombol Edit & Delete -->
                    @if (Auth::check() && Auth::user()->id == $comment->user->id)
                    <div class="absolute top-3 right-3 flex items-center gap-2">
                        <button class="edit-btn text-gray-600 hover:text-blue-500 transition" 
                            data-comment-id="{{ $comment->id }}" data-content="{{ e($comment->content) }}">
                            <i class="fas fa-edit text-lg"></i>
                        </button>
                        <form action="{{ route('comments.destroy', ['comment' => $comment->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn text-gray-600 hover:text-red-500 transition">
                                <i class="fas fa-trash text-lg"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                    
                    <div class="flex flex-col sm:flex-row items-start gap-4" id="comment-{{ $comment->id }}">
                        <img src="https://i.pravatar.cc/50?u={{ $comment->user->id }}" 
                            alt="{{ e($comment->user->username) }}" 
                            class="rounded-full w-12 h-12 sm:w-14 sm:h-14 border-2 border-indigo-300 shadow-md">
                        
                        <div class="flex-grow">
                            <div class="flex justify-between items-center">
                                <p class="text-gray-900 font-semibold text-lg sm:text-xl">{{ e($comment->user->username) }}</p>
                            </div>
                            <p class="text-gray-700 mt-2 leading-relaxed comment-content text-sm sm:text-base">{{ e($comment->content) }}</p>
                            <p class="text-gray-500 text-xs sm:text-sm italic mt-1">{{ $comment->created_at->diffForHumans() }}</p>

                            <div class="flex items-center gap-3 sm:gap-5 mt-4 text-sm text-gray-600">
                                <button class="reply-btn text-indigo-500 font-medium flex items-center gap-1 hover:text-indigo-700 transition" data-comment-id="{{ $comment->id }}">
                                    <i class="fas fa-reply"></i> Reply
                                </button>
                                <button class="toggle-replies text-gray-500 font-medium flex items-center gap-1 hover:text-gray-700 transition" data-comment-id="{{ $comment->id }}">
                                    <i class="fas fa-comment"></i> {{ $comment->replies->count() }} Replies
                                </button>
                            </div>

                            <div class="replies hidden mt-4 sm:mt-5 space-y-3 border-l-4 border-indigo-400 pl-4 sm:pl-6" id="replies-{{ $comment->id }}">
                                @foreach ($comment->replies as $reply)
                                    <div id="comment-{{ $comment->id }}" 
                                        class="bg-white p-4 sm:p-5 rounded-lg shadow-sm border border-gray-200 flex flex-col sm:flex-row items-start gap-3" >
                                        <img src="https://i.pravatar.cc/50?u={{ $reply->user->id }}" 
                                            alt="{{ e($reply->user->username) }}" 
                                            class="rounded-full w-10 h-10 sm:w-12 sm:h-12 border-2 border-gray-300">
                                        
                                        <div class="flex-grow">
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                                <p class="text-gray-800 font-semibold text-sm sm:text-base">{{ e($reply->user->username) }}</p>
                                                <p class="text-xs sm:text-sm text-gray-500 mt-1 sm:mt-0">
                                                    Replying to <span class="font-semibold text-indigo-600">{{ e($comment->user->username) }}</span>
                                                </p>
                                            </div>
                            
                                            <p class="text-gray-500 text-xs sm:text-sm italic">{{ $reply->created_at->diffForHumans() }}</p>
                                            <p class="text-gray-700 mt-2 leading-relaxed text-sm sm:text-base">{{ e($reply->content) }}</p>
                            
                                            @if (Auth::check() && Auth::user()->id == $reply->user->id)
                                            <div class="mt-4 flex justify-end gap-2">
                                                <button class="edit-btn text-gray-600 hover:text-blue-500 transition" 
                                                    data-comment-id="{{ $reply->id }}" data-content="{{ e($reply->content) }}">
                                                    <i class="fas fa-edit text-lg"></i>
                                                </button>
                                                <form action="{{ route('comments.destroy', ['comment' => $reply->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete-btn text-gray-600 hover:text-red-500 transition">
                                                        <i class="fas fa-trash text-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center">No comments yet. Be the first to comment!</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Edit Komentar -->
<div id="edit-modal" class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center px-4">
    <div class="bg-white p-5 sm:p-6 rounded-lg shadow-lg w-full max-w-md">
        <h4 class="text-lg font-bold mb-4">Edit Comment</h4>
        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')
            <textarea id="edit-content" name="content" class="w-full p-2 border rounded-lg"></textarea>
            <div class="flex justify-end mt-4">
                <button type="button" id="cancel-edit" class="px-4 py-2 bg-gray-400 text-white rounded-lg mr-2">Cancel</button>
                <button type="submit" id="save-edit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Save</button>
            </div>
        </form>
    </div>
</div>






<!-- Form Tambah Komentar -->
<div class="mt-6">
    <h4 class="text-lg font-semibold text-gray-800">Add a Comment</h4>
    <form id="comment-form" action="{{ route('comments.store', $blog) }}" method="POST" class="mt-3">
        @csrf
        <input type="hidden" id="parent-id" name="parent_id" value="">

        <textarea id="comment-content" name="content" 
                  class="w-full p-3 border rounded-lg focus:ring focus:ring-indigo-300" 
                  rows="3" placeholder="Write your comment here..." required></textarea>

        <button type="submit" 
                class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition duration-300 disabled:opacity-50" 
                id="submit-comment" disabled>
            Post Comment
        </button>
    </form>
</div>

<div class="mt-8 text-center">
    <a href="{{ route('blog.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition duration-300 transform hover:scale-105">
        Back to Blog
    </a>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Toggle Replies
    document.querySelectorAll(".toggle-replies").forEach(button => {
        button.addEventListener("click", function () {
            const commentId = this.dataset.commentId;
            document.getElementById(`replies-${commentId}`).classList.toggle("hidden");
        });
    });

    // Tombol Edit
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            const commentId = this.dataset.commentId;
            const content = this.dataset.content;

            document.getElementById("edit-content").value = content;
            document.getElementById("edit-form").action = `/comments/${commentId}`;

            // Simpan ID komentar di localStorage agar setelah refresh bisa scroll ke sini
            localStorage.setItem("scrollToComment", `comment-${commentId}`);

            // Tampilkan modal edit
            document.getElementById("edit-modal").classList.remove("hidden");
        });
    });

    // Tutup modal edit
    document.getElementById("cancel-edit").addEventListener("click", function () {
        document.getElementById("edit-modal").classList.add("hidden");
    });

    // document.getElementById("edit-form").addEventListener("submit", function () {
    // const commentId = this.action.split("/").pop(); // Ambil ID komentar dari action form
    // localStorage.setItem("scrollToComment", `comment-${commentId}`);
    // }); 


    // Setelah halaman selesai dimuat, cek apakah ada komentar yang harus di-scroll
   const commentToScroll = localStorage.getItem("scrollToComment");

    if (commentToScroll) {
        requestAnimationFrame(() => {
            const targetComment = document.getElementById(commentToScroll);
            if (targetComment) {
                targetComment.scrollIntoView({ behavior: "smooth", block: "center" });
            }
        });

        // Hapus dari localStorage setelah scroll agar tidak scroll terus-menerus
        localStorage.removeItem("scrollToComment");
    }

});






</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("comment-form");
    const commentContent = document.getElementById("comment-content");
    const submitButton = document.getElementById("submit-comment");
    const parentIdInput = document.getElementById("parent-id");
    const commentsList = document.getElementById("comments-list");

    commentContent.addEventListener("input", function () {
        submitButton.disabled = commentContent.value.trim() === "";
    });

    document.querySelectorAll(".reply-btn").forEach(button => {
        button.addEventListener("click", function () {
            const commentId = this.dataset.commentId;
            parentIdInput.value = commentId;
            commentContent.focus();
            commentContent.placeholder = "Reply to this comment...";
        });
    });

    form.addEventListener("submit", async function (event) {
        event.preventDefault();

        let content = commentContent.value.trim();
        let parent_id = parentIdInput.value || null;

        if (content.length < 5) {
            alert("Komentar harus memiliki setidaknya 5 karakter!");
            return;
        }

        submitButton.disabled = true;
        submitButton.textContent = "Posting...";

        try {
    const response = await fetch(form.action, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: JSON.stringify({ content, parent_id })
    });

    const data = await response.json();

    if (!data.success) {
        throw new Error(data.message || "Gagal menambahkan komentar!");
    }

    // Buat elemen komentar baru
    const newComment = document.createElement("div");
    newComment.id = `comment-${data.comment_id}`; // Tambahkan ID unik
    newComment.classList.add("bg-white", "p-4", "rounded-lg", "shadow-sm", "border", "border-gray-200", "flex", "items-start", "gap-4");
    newComment.innerHTML = `
        <img src="https://i.pravatar.cc/50?u=${data.user_id}" alt="${data.username}" class="rounded-full w-12 h-12 border-2 border-gray-300">
        <div class="flex-grow">
            <p class="text-gray-800 font-semibold">${data.username}</p>
            <p class="text-gray-500 text-xs italic">${data.created_at}</p>
            <p class="text-gray-700 mt-2">${data.content}</p>
        </div>
    `;

    if (parent_id) {
        let replyContainer = document.getElementById(`replies-${parent_id}`);

        if (!replyContainer) {
            replyContainer = document.createElement("div");
            replyContainer.id = `replies-${parent_id}`;
            replyContainer.classList.add("mt-5", "space-y-3", "border-l-4", "border-indigo-400", "pl-6");
            const parentComment = document.querySelector(`button[data-comment-id="${parent_id}"]`).closest(".flex");
            parentComment.appendChild(replyContainer);
        }

        replyContainer.classList.remove("hidden");
        replyContainer.appendChild(newComment);
    } else {
        commentsList.prepend(newComment);
    }

    // 🔥 Scroll ke komentar baru setelah ditambahkan ke DOM
    requestAnimationFrame(() => {
        newComment.scrollIntoView({ behavior: "smooth", block: "center" });
    });


    // Reset form
    commentContent.value = "";
    parentIdInput.value = "";
    submitButton.disabled = true;
    submitButton.textContent = "Post Comment";
    commentContent.placeholder = "Write your comment here...";
} catch (error) {
    console.error("Error:", error);
    alert(error.message || "Gagal menambahkan komentar!");
    submitButton.disabled = false;
    submitButton.textContent = "Post Comment";
}
    });
});

</script>


@endsection
