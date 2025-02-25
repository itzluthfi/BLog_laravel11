@props(['blog', 'comments'])

<div class="bg-white rounded-lg shadow-lg p-6 mt-12" data-aos="fade-up">
    <h3 class="text-2xl font-semibold text-indigo-600 mb-4">Comments</h3>

    <!-- List Komentar -->
    <div id="comments-list" class="space-y-3">
        @forelse ($comments as $comment)
        <div class="bg-gray-50 p-4 rounded-lg shadow flex flex-col sm:flex-row gap-4">
            <div class="flex-shrink-0">
                <img src="https://i.pravatar.cc/50?u={{ $comment->user->id }}" 
                     alt="{{ $comment->user->name }}" 
                     class="rounded-full w-12 h-12">
            </div>
            <div class="flex-grow">
                <p class="text-gray-800 font-semibold">{{ $comment->user->name }}</p>
                <p class="text-gray-600 text-sm">{{ $comment->content }}</p>
                <div class="mt-2 flex items-center gap-4 text-sm text-gray-500">
                    <button class="flex items-center gap-1 hover:text-indigo-600">
                        <i class="far fa-thumbs-up"></i> Like
                    </button>
                    <button class="flex items-center gap-1 hover:text-indigo-600">
                        <i class="fas fa-reply"></i> Reply
                    </button>
                </div>
            </div>
        </div>
        @empty
        <p class="text-gray-500">No comments yet. Be the first to comment!</p>
        @endforelse
    </div>

    <!-- Form Tambah Komentar -->
    <div class="mt-6">
        <h4 class="text-lg font-semibold text-gray-800">Add a Comment</h4>
        <form id="comment-form" action="{{ route('comments.store', $blog->id) }}" method="POST" class="mt-3">
            @csrf
            <textarea id="comment-content" name="content" 
                      class="w-full p-3 border rounded-lg focus:ring focus:ring-indigo-300" 
                      rows="3" placeholder="Write your comment here..."></textarea>
            <button type="submit" 
                    class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition duration-300">
                Post Comment
            </button>
        </form>
    </div>
</div>

<!-- JavaScript untuk AJAX -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("comment-form");
        const commentContent = document.getElementById("comment-content");
        const commentsList = document.getElementById("comments-list");

        form.addEventListener("submit", function (event) {
            event.preventDefault();

            let content = commentContent.value.trim();
            if (content === "") {
                alert("Komentar tidak boleh kosong!");
                return;
            }

            fetch(form.action, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({ content })
            })
            .then(response => response.json())
            .then(data => {
                // Tambahkan komentar baru ke daftar
                commentsList.innerHTML = `
                    <div class="bg-gray-50 p-4 rounded-lg shadow flex flex-col sm:flex-row gap-4">
                        <div class="flex-shrink-0">
                            <img src="https://i.pravatar.cc/50?u=${data.user_id}" class="rounded-full w-12 h-12">
                        </div>
                        <div class="flex-grow">
                            <p class="text-gray-800 font-semibold">${data.user_name}</p>
                            <p class="text-gray-600 text-sm">${data.content}</p>
                            <div class="mt-2 flex items-center gap-4 text-sm text-gray-500">
                                <button class="flex items-center gap-1 hover:text-indigo-600">
                                    <i class="far fa-thumbs-up"></i> Like
                                </button>
                                <button class="flex items-center gap-1 hover:text-indigo-600">
                                    <i class="fas fa-reply"></i> Reply
                                </button>
                            </div>
                        </div>
                    </div>
                ` + commentsList.innerHTML;
                
                // Bersihkan form
                commentContent.value = "";
            })
            .catch(error => console.error("Error:", error));
        });
    });
</script>
