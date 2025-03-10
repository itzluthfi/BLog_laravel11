@extends('layout.app')

@section('title_page', 'Post Detail')

@push('styles')
<style>
    /* Tambahkan di file CSS */
    .reply-container {
        overflow: hidden;
        transition: all 0.3s ease-in-out;
        height: 0;
    }
    
    .reply-container.active {
        height: auto;
        padding-top: 1rem; /* Sesuaikan dengan desain */
    }
    </style>
@endpush
@section('content')
<section class="w-full bg-base-200 py-20 sm:py-10 mt-12">
    <div class="container max-w-screen-xl mx-auto px-4 sm:px-6 md:px-8">

        <!-- Title with badge -->
        <div class="text-center mb-12" data-aos="fade-up">
            <div class="badge badge-primary mb-4 p-3 font-medium">{{ e($blog->category->name, ENT_QUOTES, 'UTF-8') }}</div>
            <h1 class="text-4xl md:text-5xl font-bold text-center mb-6 text-primary">
                {{ e($blog->title, ENT_QUOTES, 'UTF-8') }}
            </h1>
            <div class="flex justify-center items-center gap-4 text-sm opacity-75">
                <div class="avatar">
                    <div class="w-10 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                        <img src="https://i.pravatar.cc/150?u={{ $blog->author->id }}" alt="{{ e($blog->author->username, ENT_QUOTES, 'UTF-8') }}">
                    </div>
                </div>
                <span class="font-semibold">{{ e($blog->author->username, ENT_QUOTES, 'UTF-8') }}</span>
                <div class="divider divider-horizontal"></div>
                <span><i class="far fa-calendar-alt text-primary mr-1"></i> {{ $blog->published_at->format('F j, Y') }}</span>
                <div class="divider divider-horizontal"></div>
                <span><i class="far fa-clock text-primary mr-1"></i> 5 min read</span>
            </div>
        </div>

        <!-- Gambar Landscape in Card -->
        <div class="card bg-base-100 shadow-xl mb-12 overflow-hidden" data-aos="fade-up">
            <figure class="relative h-96 w-full">
                <img src="{{ asset(e($blog->landscape_image, ENT_QUOTES, 'UTF-8')) }}" 
                     alt="{{ e($blog->title, ENT_QUOTES, 'UTF-8') }}" 
                     class="w-full h-full object-cover transform hover:scale-105 transition duration-700">
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-8">
                    <p class="text-white text-xl font-medium">{{ e($blog->description, ENT_QUOTES, 'UTF-8') }}</p>
                </div>
            </figure>
        </div>

        <!-- Social Share Buttons -->
        <div class="flex justify-center gap-3 mb-8" data-aos="fade-up">
            <button class="btn btn-circle btn-primary">
                <i class="fab fa-facebook-f"></i>
            </button>
            <button class="btn btn-circle btn-primary">
                <i class="fab fa-twitter"></i>
            </button>
            <button class="btn btn-circle btn-primary">
                <i class="fab fa-linkedin-in"></i>
            </button>
            <button class="btn btn-circle btn-primary">
                <i class="fab fa-pinterest-p"></i>
            </button>
            <button class="btn btn-circle btn-primary">
                <i class="far fa-envelope"></i>
            </button>
        </div>

        <!-- Content Tabs -->
        <div class="tabs tabs-boxed justify-center mb-8 p-1 bg-base-300 rounded-box" data-aos="fade-up">
            <a class="tab tab-active font-medium" id="tab-content">Article Content</a>
            <a class="tab font-medium" id="tab-comments">Discussion ({{ count($comments) }})</a>
        </div>

        <!-- Konten Detail -->
        <div id="content-section" class="card bg-base-100 shadow-xl mb-12" data-aos="fade-up">
            <div class="card-body p-6 md:p-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="lg:w-3/5 w-full prose max-w-none">
                        <h2 class="text-2xl font-semibold mb-4 text-primary">Full Content</h2>
                        <div class="divider"></div>
                        <div class="text-base-content">{!! $blog->full_content !!}</div>
                        
                        <!-- Static Additional Content -->
                        <h3 class="text-xl font-semibold mt-8 mb-4 text-primary">Key Takeaways</h3>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>Understanding the fundamentals is crucial for mastering any subject</li>
                            <li>Regular practice leads to consistent improvement over time</li>
                            <li>Collaboration with peers can provide new perspectives and insights</li>
                            <li>Staying updated with the latest trends keeps your knowledge relevant</li>
                        </ul>
                        
                        <div class="bg-base-200 p-6 rounded-lg my-8 border-l-4 border-primary">
                            <h4 class="font-bold text-lg mb-2">Expert Opinion</h4>
                            <p class="italic">
                                "This article provides valuable insights that can help both beginners and experienced professionals.
                                The practical examples make complex concepts easier to understand and implement."
                            </p>
                            <div class="flex items-center mt-4 gap-3">
                                <div class="avatar">
                                    <div class="w-10 rounded-full">
                                        <img src="https://i.pravatar.cc/150?u=expert123" alt="Expert">
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold">Dr. Jane Smith</p>
                                    <p class="text-sm opacity-70">Industry Expert</p>
                                </div>
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-semibold mt-8 mb-4 text-primary">Frequently Asked Questions</h3>
                        <div class="space-y-4">
                            <div class="collapse collapse-plus bg-base-200">
                                <input type="radio" name="faq-accordion" checked="checked" /> 
                                <div class="collapse-title font-medium">
                                    How can I apply these concepts in real-world scenarios?
                                </div>
                                <div class="collapse-content"> 
                                    <p>Start by identifying specific challenges in your current projects where these principles could be applied. Begin with small implementations and gradually expand as you become more comfortable with the concepts.</p>
                                </div>
                            </div>
                            <div class="collapse collapse-plus bg-base-200">
                                <input type="radio" name="faq-accordion" /> 
                                <div class="collapse-title font-medium">
                                    Are there any prerequisites I should know before diving deeper?
                                </div>
                                <div class="collapse-content"> 
                                    <p>A basic understanding of the field is helpful but not required. This article is designed to be accessible to beginners while still providing value to experienced practitioners.</p>
                                </div>
                            </div>
                            <div class="collapse collapse-plus bg-base-200">
                                <input type="radio" name="faq-accordion" /> 
                                <div class="collapse-title font-medium">
                                    Where can I find additional resources on this topic?
                                </div>
                                <div class="collapse-content"> 
                                    <p>Check out our recommended reading section below for books, online courses, and other resources that expand on the concepts discussed in this article.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Author Bio -->
                        <div class="card bg-base-200 p-6 mt-8">
                            <div class="flex flex-col sm:flex-row gap-4 items-center sm:items-start">
                                <div class="avatar">
                                    <div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                        <img src="https://i.pravatar.cc/150?u={{ $blog->author->id }}" alt="{{ e($blog->author->username, ENT_QUOTES, 'UTF-8') }}">
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold mb-2">About the Author</h3>
                                    <h4 class="font-semibold text-primary">{{ e($blog->author->username, ENT_QUOTES, 'UTF-8') }}</h4>
                                    <p class="my-2">Professional writer and industry expert with over 10 years of experience. Specializes in creating comprehensive guides and tutorials that make complex topics accessible to everyone.</p>
                                    <div class="flex gap-2 mt-3">
                                        <a href="#" class="btn btn-sm btn-circle btn-outline">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-circle btn-outline">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-circle btn-outline">
                                            <i class="fas fa-globe"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tags -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-3">Related Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                <span class="badge badge-lg">{{ e($blog->category->name, ENT_QUOTES, 'UTF-8') }}</span>
                                <span class="badge badge-lg">Technology</span>
                                <span class="badge badge-lg">Innovation</span>
                                <span class="badge badge-lg">Best Practices</span>
                                <span class="badge badge-lg">Tutorial</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:w-2/5 w-full">
                        <!-- Featured Image -->
                        <div class="card bg-base-200 shadow-md mb-8">
                            <figure class="px-4 pt-4">
                                <img src="{{ asset(e($blog->portrait_image, ENT_QUOTES, 'UTF-8')) }}" 
                                    alt="{{ e($blog->title, ENT_QUOTES, 'UTF-8') }} - Portrait" 
                                    class="rounded-xl w-full h-auto object-cover shadow-lg transform hover:scale-105 transition duration-500">
                            </figure>
                            <div class="card-body">
                                <h3 class="card-title">Featured Image</h3>
                                <p class="text-sm opacity-70">{{ e($blog->title, ENT_QUOTES, 'UTF-8') }}</p>
                            </div>
                        </div>
                        
                        <!-- Table of Contents -->
                        <div class="card bg-base-200 shadow-md mb-8">
                            <div class="card-body">
                                <h3 class="card-title flex items-center gap-2">
                                    <i class="fas fa-list-ul text-primary"></i> Table of Contents
                                </h3>
                                <div class="divider mt-0 mb-2"></div>
                                <ul class="menu bg-base-200 rounded-box">
                                    <li><a href="#introduction">Introduction</a></li>
                                    <li><a href="#main-content">Main Content</a></li>
                                    <li>
                                        <details>
                                            <summary>Key Concepts</summary>
                                            <ul>
                                                <li><a href="#concept-1">Concept 1</a></li>
                                                <li><a href="#concept-2">Concept 2</a></li>
                                                <li><a href="#concept-3">Concept 3</a></li>
                                            </ul>
                                        </details>
                                    </li>
                                    <li><a href="#key-takeaways">Key Takeaways</a></li>
                                    <li><a href="#expert-opinion">Expert Opinion</a></li>
                                    <li><a href="#faq">Frequently Asked Questions</a></li>
                                    <li><a href="#about-author">About the Author</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Related Articles -->
                        <div class="card bg-base-200 shadow-md mb-8">
                            <div class="card-body">
                                <h3 class="card-title flex items-center gap-2">
                                    <i class="fas fa-newspaper text-primary"></i> Related Articles
                                </h3>
                                <div class="divider mt-0 mb-2"></div>
                                <ul class="space-y-4">
                                    <li>
                                        <a href="#" class="flex gap-3 items-center hover:bg-base-300 p-2 rounded-lg transition-colors">
                                            <div class="avatar">
                                                <div class="w-16 rounded">
                                                    <img src="https://picsum.photos/id/237/200/200" alt="Related Article">
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="font-medium">10 Tips for Better Productivity</h4>
                                                <p class="text-xs opacity-70">3 days ago</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="flex gap-3 items-center hover:bg-base-300 p-2 rounded-lg transition-colors">
                                            <div class="avatar">
                                                <div class="w-16 rounded">
                                                    <img src="https://picsum.photos/id/238/200/200" alt="Related Article">
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="font-medium">Understanding Advanced Concepts</h4>
                                                <p class="text-xs opacity-70">1 week ago</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="flex gap-3 items-center hover:bg-base-300 p-2 rounded-lg transition-colors">
                                            <div class="avatar">
                                                <div class="w-16 rounded">
                                                    <img src="https://picsum.photos/id/239/200/200" alt="Related Article">
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="font-medium">Beginner's Guide to Success</h4>
                                                <p class="text-xs opacity-70">2 weeks ago</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <div class="card-actions justify-center mt-4">
                                    <a href="#" class="btn btn-sm btn-outline btn-primary">View All Articles</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Newsletter Signup -->
                        <div class="card bg-primary text-primary-content shadow-md">
                            <div class="card-body">
                                <h3 class="card-title flex items-center gap-2">
                                    <i class="fas fa-envelope"></i> Subscribe to Our Newsletter
                                </h3>
                                <p class="text-sm mb-4">Get the latest articles and resources delivered straight to your inbox.</p>
                                <div class="form-control">
                                    <div class="input-group">
                                        <input type="email" placeholder="your-email@example.com" class="input input-bordered w-full text-base-content" />
                                        <button class="btn btn-square bg-white text-primary">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
                                <p class="text-xs mt-2 opacity-80">We respect your privacy. Unsubscribe at any time.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div id="comments-section" class="hidden">
            <div class="card bg-base-100 shadow-xl mb-12" data-aos="fade-up">
                <div class="card-body p-6 md:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-primary flex items-center gap-2">
                            <i class="fas fa-comments"></i> Discussion
                        </h3>
                        <div class="badge badge-lg p-3">{{ count($comments) }} Comments</div>
                    </div>

                    <div class="divider"></div>

                    <!-- Form Tambah Komentar -->
                    <div class="card bg-base-200 shadow-md mb-8">
                        <div class="card-body">
                            <h4 class="card-title flex items-center gap-2">
                                <i class="fas fa-pen"></i> Join the Discussion
                            </h4>
                            <form id="comment-form" action="{{ route('comments.store', $blog) }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" id="parent-id" name="parent_id" value="">
                                <div id="reply-indicator" class="alert alert-info mb-3 hidden">
                                    <i class="fas fa-reply"></i>
                                    <span>Replying to <span id="reply-to-username" class="font-bold"></span></span>
                                    <button type="button" id="cancel-reply" class="btn btn-xs btn-ghost">Cancel</button>
                                </div>

                                <textarea id="comment-content" name="content" 
                                        class="textarea textarea-bordered w-full" 
                                        rows="3" placeholder="Share your thoughts..." required></textarea>

                                <div class="card-actions justify-end mt-4">
                                    <button type="submit" 
                                            class="btn btn-primary" 
                                            id="submit-comment" disabled>
                                        <i class="fas fa-paper-plane mr-2"></i> Post Comment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Comments List -->
                    <div id="comments-list" class="space-y-6 max-h-[800px] overflow-y-auto pr-4">
                        @forelse ($comments as $comment)
                            <div class="card bg-base-200 shadow-md transition-all hover:shadow-lg relative">
                                <!-- Tombol Edit & Delete -->
                                @if (Auth::check() && Auth::user()->id == $comment->user->id)
                                <div class="absolute top-3 right-3 flex items-center gap-2">
                                    <button class="edit-btn btn btn-circle btn-xs btn-ghost" 
                                        data-comment-id="{{ $comment->id }}" data-content="{{ e($comment->content) }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('comments.destroy', ['comment' => $comment->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn btn btn-circle btn-xs btn-ghost text-error">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                                
                                <div class="card-body p-5" id="comment-{{ $comment->id }}">
                                    <div class="flex items-start gap-4">
                                        <div class="avatar">
                                            <div class="w-12 h-12 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                                <img src="https://i.pravatar.cc/150?u={{ $comment->user->id }}" 
                                                    alt="{{ e($comment->user->username) }}">
                                            </div>
                                        </div>
                                        
                                        <div class="flex-grow">
                                            <div class="flex flex-wrap justify-between items-center gap-2 mb-2">
                                                <h4 class="text-lg font-semibold">{{ e($comment->user->username) }}</h4>
                                                <span class="text-xs opacity-70">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="comment-content mb-4">{{ e($comment->content) }}</p>

                                            <div class="flex flex-wrap items-center gap-3">
                                                <button class="reply-btn btn btn-xs btn-outline btn-primary" 
                                                        data-comment-id="{{ $comment->id }}"
                                                        data-username="{{ e($comment->user->username) }}">
                                                    <i class="fas fa-reply mr-1"></i> Reply
                                                </button>
                                                <span class="text-xs opacity-70">
                                                    <i class="fas fa-comment-dots text-primary"></i> 
                                                    {{ $comment->replies->count() }} {{ $comment->replies->count() == 1 ? 'Reply' : 'Replies' }}
                                                </span>
                                            </div>

                                            <!-- Tombol Toggle Replies -->
        @if($comment->replies->count() > 0)
        <div class="mt-4">
            <button class="toggle-replies btn btn-xs btn-ghost text-primary"
                    data-target="#replies-{{ $comment->id }}">
                <i class="fas fa-chevron-down mr-1"></i> 
                Show {{ $comment->replies->count() }} {{ $comment->replies->count() == 1 ? 'Reply' : 'Replies' }}
            </button>
        </div>
        @endif
                                            <!-- Replies - Always visible -->
                                            @if($comment->replies->count() > 0)
                                                <div class="mt-6 space-y-4 border-l-4 border-primary pl-4 " id="replies-{{ $comment->id }}">
                                                    @foreach ($comment->replies as $reply)
                                                        <div id="comment-{{ $reply->id }}" class="card bg-base-100 shadow-sm">
                                                            <div class="card-body p-4">
                                                                <div class="flex items-start gap-3">
                                                                    <div class="avatar">
                                                                        <div class="w-8 h-8 rounded-full">
                                                                            <img src="https://i.pravatar.cc/150?u={{ $reply->user->id }}" 
                                                                                alt="{{ e($reply->user->username) }}">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="flex-grow">
                                                                        <div class="flex flex-wrap justify-between items-center gap-2 mb-1">
                                                                            <h5 class="font-medium">{{ e($reply->user->username) }}</h5>
                                                                            <span class="text-xs opacity-70">{{ $reply->created_at->diffForHumans() }}</span>
                                                                        </div>
                                                                        <p class="text-sm opacity-70 mb-1">
                                                                            Replying to <span class="font-semibold text-primary">{{ e($comment->user->username) }}</span>
                                                                        </p>
                                                                        <p class="text-sm mb-2">{{ e($reply->content) }}</p>
                                                            
                                                                        <div class="flex items-center gap-3">
                                                                            <button class="reply-btn btn btn-xs btn-ghost" 
                                                                                    data-comment-id="{{ $comment->id }}"
                                                                                    data-username="{{ e($reply->user->username) }}">
                                                                                <i class="fas fa-reply mr-1"></i> Reply
                                                                            </button>
                                                                            
                                                                            @if (Auth::check() && Auth::user()->id == $reply->user->id)
                                                                            <div class="flex ml-auto gap-2">
                                                                                <button class="edit-btn btn btn-xs btn-ghost" 
                                                                                    data-comment-id="{{ $reply->id }}" data-content="{{ e($reply->content) }}">
                                                                                    <i class="fas fa-edit"></i>
                                                                                </button>
                                                                                <form action="{{ route('comments.destroy', ['comment' => $reply->id]) }}" method="POST">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="delete-btn btn btn-xs btn-ghost text-error">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>No comments yet. Be the first to join the discussion!</span>
                            </div>
                        @endforelse
                    </div>

                    <!-- Comment Guidelines -->
                    <div class="alert alert-warning mt-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <div>
                            <h3 class="font-bold">Community Guidelines</h3>
                            <div class="text-xs">Please keep discussions respectful and on-topic. Inappropriate comments may be removed.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Posts -->
        <div class="mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-center mb-8 text-primary">You May Also Like</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Related Post 1 -->
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all">
                    <figure class="h-48">
                        <img src="https://picsum.photos/id/240/800/600" alt="Related Post" class="w-full h-full object-cover">
                    </figure>
                    <div class="card-body">
                        <div class="badge badge-primary mb-2">Technology</div>
                        <h3 class="card-title">Understanding Modern Web Development</h3>
                        <p class="line-clamp-2">A comprehensive guide to the latest trends and technologies in web development.</p>
                        <div class="card-actions justify-between items-center mt-4">
                            <div class="flex items-center gap-2">
                                <div class="avatar">
                                    <div class="w-8 rounded-full">
                                        <img src="https://i.pravatar.cc/150?u=user1" alt="Author">
                                    </div>
                                </div>
                                <span class="text-sm">John Doe</span>
                            </div>
                            <a href="#" class="btn btn-sm btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
                
                <!-- Related Post 2 -->
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all">
                    <figure class="h-48">
                        <img src="https://picsum.photos/id/241/800/600" alt="Related Post" class="w-full h-full object-cover">
                    </figure>
                    <div class="card-body">
                        <div class="badge badge-primary mb-2">Design</div>
                        <h3 class="card-title">UI/UX Best Practices for 2023</h3>
                        <p class="line-clamp-2">Learn the latest design principles that enhance user experience and engagement.</p>
                        <div class="card-actions justify-between items-center mt-4">
                            <div class="flex items-center gap-2">
                                <div class="avatar">
                                    <div class="w-8 rounded-full">
                                        <img src="https://i.pravatar.cc/150?u=user2" alt="Author">
                                    </div>
                                </div>
                                <span class="text-sm">Jane Smith</span>
                            </div>
                            <a href="#" class="btn btn-sm btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
                
                
                <!-- AOS Animation Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Custom JavaScript for the page -->
<script>
    // Initialize AOS animation library
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

    // DOM Elements
    const tabContent = document.getElementById('tab-content');
    const tabComments = document.getElementById('tab-comments');
    const contentSection = document.getElementById('content-section');
    const commentsSection = document.getElementById('comments-section');
    const commentForm = document.getElementById('comment-form');
    const commentContent = document.getElementById('comment-content');
    const submitComment = document.getElementById('submit-comment');
    const parentIdInput = document.getElementById('parent-id');
    const replyIndicator = document.getElementById('reply-indicator');
    const replyToUsername = document.getElementById('reply-to-username');
    const cancelReply = document.getElementById('cancel-reply');
    const replyButtons = document.querySelectorAll('.reply-btn');
    const editButtons = document.querySelectorAll('.edit-btn');

    // Tab switching functionality
    tabContent.addEventListener('click', function() {
        tabContent.classList.add('tab-active');
        tabComments.classList.remove('tab-active');
        contentSection.classList.remove('hidden');
        commentsSection.classList.add('hidden');
    });

    tabComments.addEventListener('click', function() {
        tabComments.classList.add('tab-active');
        tabContent.classList.remove('tab-active');
        commentsSection.classList.remove('hidden');
        contentSection.classList.add('hidden');
    });

    // Enable submit button when comment has content
    commentContent.addEventListener('input', function() {
        submitComment.disabled = commentContent.value.trim() === '';
    });

    // Reply functionality
    replyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const username = this.getAttribute('data-username');
            
            // Set the parent ID for the reply
            parentIdInput.value = commentId;
            
            // Show the reply indicator
            replyIndicator.classList.remove('hidden');
            replyToUsername.textContent = username;
            
            // Focus on the comment textarea
            commentContent.focus();
            
            // Scroll to the comment form
            commentForm.scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Cancel reply
    cancelReply.addEventListener('click', function() {
        parentIdInput.value = '';
        replyIndicator.classList.add('hidden');
        commentContent.focus();
    });

    //toggle show reply
    document.querySelectorAll('.toggle-replies').forEach(button => {
    button.addEventListener('click', function() {
        const target = document.querySelector(this.getAttribute('data-target'));
        const icon = this.querySelector('i');
        const isVisible = !target.classList.contains('hidden');
        
        // Toggle visibility with animation
        if (isVisible) {
            target.style.height = target.scrollHeight + 'px';
            setTimeout(() => {
                target.style.height = '0';
            }, 10);
        } else {
            target.style.height = target.scrollHeight + 'px';
        }
        
        target.addEventListener('transitionend', () => {
            target.classList.toggle('hidden');
            target.style.height = '';
        }, { once: true });

        // Update button text and icon
        this.innerHTML = `
            <i class="fas ${isVisible ? 'fa-chevron-down' : 'fa-chevron-up'} mr-1"></i>
            ${isVisible ? 'Show' : 'Hide'} ${target.querySelectorAll('.card').length} 
            ${target.querySelectorAll('.card').length == 1 ? 'Reply' : 'Replies'}
        `;
    });
});

    // Edit comment functionality
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const content = this.getAttribute('data-content');
            
            // Fill the comment form with the existing content
            commentContent.value = content;
            
            // Change the submit button text to indicate editing
            submitComment.innerHTML = '<i class="fas fa-save mr-2"></i> Update Comment';
            
            // Add a data attribute to the form to indicate which comment is being edited
            commentForm.setAttribute('data-editing', commentId);
            
            // Scroll to the comment form
            commentForm.scrollIntoView({ behavior: 'smooth' });
            
            // Focus on the textarea
            commentContent.focus();
        });
    });

   // Handle form submission
commentForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const content = commentContent.value.trim();
    if (content === '') return;

    const isEditing = commentForm.hasAttribute('data-editing');
    const url = isEditing 
        ? `/comments/${commentForm.getAttribute('data-editing')}` 
        : commentForm.getAttribute('action');
    
    const method = isEditing ? 'PUT' : 'POST';
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                content: content,
                parent_id: parentIdInput.value
            })
        });

        if (response.ok) {
            const data = await response.json();
            
            // Reset form
            commentContent.value = '';
            submitComment.disabled = true;
            if (parentIdInput.value) {
                parentIdInput.value = '';
                replyIndicator.classList.add('hidden');
            }

            // Hapus mode edit jika ada
            if (isEditing) {
                commentForm.removeAttribute('data-editing');
                submitComment.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Post Comment';
                return;
            }

            // Tambahkan komentar baru ke DOM
            addCommentToDOM(data);
            alert('Komentar berhasil ditambahkan!');

        } else {
            alert('Error submitting comment');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Coba lagi nanti.');
    }
});

function addCommentToDOM(comment) {
    const commentsList = document.getElementById('comments-list');
    
    // Template komentar baru
    const newComment = `
        <div class="card bg-base-200 shadow-md transition-all hover:shadow-lg relative" id="comment-${comment.id}">
            <div class="card-body p-5">
                <div class="flex items-start gap-4">
                    <div class="avatar">
                        <div class="w-12 h-12 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                            <img src="https://i.pravatar.cc/150?u=${comment.user_id}" alt="${comment.username}">
                        </div>
                    </div>
                    <div class="flex-grow">
                        <div class="flex flex-wrap justify-between items-center gap-2 mb-2">
                            <h4 class="text-lg font-semibold">${comment.username}</h4>
                            <span class="text-xs opacity-70">${comment.created_at}</span>
                        </div>
                        <p class="comment-content mb-4">${comment.content}</p>
                        <div class="flex flex-wrap items-center gap-3">
                            <button class="reply-btn btn btn-xs btn-outline btn-primary" 
                                    data-comment-id="${comment.id}"
                                    data-username="${comment.username}">
                                <i class="fas fa-reply mr-1"></i> Reply
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    if (comment.parent_id) {
        // Cari container replies
        let repliesContainer = document.querySelector(`#replies-${comment.parent_id}`);
        
        // Jika tidak ada, buat container baru
        if (!repliesContainer) {
            const parentComment = document.querySelector(`#comment-${comment.parent_id}`);
            if (parentComment) {
                // Buat container replies di dalam card-body komentar induk
                const repliesHtml = `
                    <div class="mt-6 space-y-4 border-l-4 border-primary pl-4" id="replies-${comment.parent_id}">
                        ${newComment}
                    </div>
                `;
                parentComment.querySelector('.card-body').insertAdjacentHTML('beforeend', repliesHtml);
                
                // Tambahkan badge jumlah reply
                const replyCountBadge = document.createElement('span');
                replyCountBadge.className = "text-xs opacity-70 ml-3";
                replyCountBadge.innerHTML = `<i class="fas fa-comment-dots text-primary"></i> 1 Reply`;
                const actionContainer = parentComment.querySelector('.flex-wrap.items-center');
                if (actionContainer) {
                    actionContainer.appendChild(replyCountBadge);
                }
                return;
            }
        }
        
        // Jika container sudah ada
        if (repliesContainer) {
            // Pastikan replies tidak hidden
            const parentComment = repliesContainer.closest('.card');
            const toggleButton = parentComment.querySelector('.toggle-replies');
            
            if (toggleButton && repliesContainer.classList.contains('hidden')) {
                toggleButton.click(); // Auto-expand saat ada reply baru
            }
        }
    } else {
        // Komentar utama
        commentsList.insertAdjacentHTML('afterbegin', newComment);
        
        // Perbarui total komentar di tab
        const commentCountBadge = document.querySelector('#tab-comments .badge');
        if (commentCountBadge) {
            const currentTotal = parseInt(commentCountBadge.textContent) || 0;
            commentCountBadge.textContent = currentTotal + 1;
        }
    }
}

    // Initialize the page with the content tab active
    tabContent.click();
</script>
@endsection
