@extends('layout.app') 


@section('title_page', 'Contact Page')

@section('content')
            
            <!-- Blog Content -->
            <main class="flex-grow pt-24 pb-16">
                <div class="container mx-auto px-4">
                    <!-- Hero Section -->
                    <div class="hero bg-base-200 rounded-box mb-12" data-aos="fade-up">
                        <div class="hero-content flex-col lg:flex-row-reverse py-12">
                            <img src="https://picsum.photos/id/325/800/600" class="max-w-sm rounded-lg shadow-2xl" alt="Blog Hero" />
                            <div>
                                <h1 class="text-5xl font-bold">Explore Our Blog</h1>
                                <p class="py-6">Discover insightful articles, tutorials, and stories from our community of writers. Stay updated with the latest trends and learn something new every day.</p>
                                <div class="join">
                                    <input class="input input-bordered join-item" placeholder="Search articles..."/>
                                    <button class="btn btn-primary join-item">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Categories -->
                    <div class="mb-8" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="text-2xl font-bold mb-4">Categories</h2>
                        <div class="flex flex-wrap gap-2">
                            <button class="btn btn-sm btn-primary">All</button>
                            <button class="btn btn-sm btn-outline">Technology</button>
                            <button class="btn btn-sm btn-outline">Lifestyle</button>
                            <button class="btn btn-sm btn-outline">Travel</button>
                            <button class="btn btn-sm btn-outline">Food</button>
                            <button class="btn btn-sm btn-outline">Health</button>
                        </div>
                    </div>
                    
                    <!-- Featured Posts -->
                    <div class="mb-12" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="text-2xl font-bold mb-6">Featured Posts</h2>
                        <div class="carousel w-full rounded-box">
                            <div id="slide1" class="carousel-item relative w-full">
                                <div class="hero min-h-[400px]" style="background-image: url(https://picsum.photos/id/1011/1200/600);">
                                    <div class="hero-overlay bg-opacity-60"></div>
                                    <div class="hero-content text-center text-neutral-content">
                                        <div class="max-w-md">
                                            <h1 class="mb-5 text-4xl font-bold">10 Tips for Better Productivity</h1>
                                            <p class="mb-5">Discover how to maximize your daily productivity with these proven strategies.</p>
                                            <button class="btn btn-primary">Read More</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                    <a href="#slide3" class="btn btn-circle">❮</a> 
                                    <a href="#slide2" class="btn btn-circle">❯</a>
                                </div>
                            </div> 
                            <div id="slide2" class="carousel-item relative w-full">
                                <div class="hero min-h-[400px]" style="background-image: url(https://picsum.photos/id/1015/1200/600);">
                                    <div class="hero-overlay bg-opacity-60"></div>
                                    <div class="hero-content text-center text-neutral-content">
                                        <div class="max-w-md">
                                            <h1 class="mb-5 text-4xl font-bold">The Future of AI in 2023</h1>
                                            <p class="mb-5">Explore how artificial intelligence is transforming industries and our daily lives.</p>
                                            <button class="btn btn-primary">Read More</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                    <a href="#slide1" class="btn btn-circle">❮</a> 
                                    <a href="#slide3" class="btn btn-circle">❯</a>
                                </div>
                            </div> 
                            <div id="slide3" class="carousel-item relative w-full">
                                <div class="hero min-h-[400px]" style="background-image: url(https://picsum.photos/id/1019/1200/600);">
                                    <div class="hero-overlay bg-opacity-60"></div>
                                    <div class="hero-content text-center text-neutral-content">
                                        <div class="max-w-md">
                                            <h1 class="mb-5 text-4xl font-bold">Sustainable Living Guide</h1>
                                            <p class="mb-5">Learn practical ways to reduce your carbon footprint and live more sustainably.</p>
                                            <button class="btn btn-primary">Read More</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                    <a href="#slide2" class="btn btn-circle">❮</a> 
                                    <a href="#slide1" class="btn btn-circle">❯</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Latest Posts -->
                    <div class="mb-12" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="text-2xl font-bold mb-6">Latest Posts</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Post 1 -->
                            <div class="card bg-base-100 shadow-xl" data-aos="fade-up" data-aos-delay="100">
                                <figure><img src="https://picsum.photos/id/237/600/400" alt="Blog Post" /></figure>
                                <div class="card-body">
                                    <div class="badge badge-secondary mb-2">Technology</div>
                                    <h2 class="card-title">The Rise of No-Code Platforms</h2>
                                    <p>How no-code platforms are democratizing software development and enabling non-technical users to build applications.</p>
                                    <div class="flex items-center mt-4">
                                        <div class="avatar">
                                            <div class="w-10 rounded-full">
                                                <img src="https://api.dicebear.com/6.x/initials/svg?seed=John%20Doe" alt="Author" />
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium">John Doe</p>
                                            <p class="text-xs opacity-70">May 15, 2023</p>
                                        </div>
                                    </div>
                                    <div class="card-actions justify-end mt-4">
                                        <button class="btn btn-primary btn-sm">Read More</button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Post 2 -->
                            <div class="card bg-base-100 shadow-xl" data-aos="fade-up" data-aos-delay="200">
                                <figure><img src="https://picsum.photos/id/1005/600/400" alt="Blog Post" /></figure>
                                <div class="card-body">
                                    <div class="badge badge-accent mb-2">Lifestyle</div>
                                    <h2 class="card-title">Mindfulness in the Digital Age</h2>
                                    <p>Practical strategies for maintaining mindfulness and mental well-being in our increasingly digital world.</p>
                                    <div class="flex items-center mt-4">
                                        <div class="avatar">
                                            <div class="w-10 rounded-full">
                                                <img src="https://api.dicebear.com/6.x/initials/svg?seed=Jane%20Smith" alt="Author" />
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium">Jane Smith</p>
                                            <p class="text-xs opacity-70">May 10, 2023</p>
                                        </div>
                                    </div>
                                    <div class="card-actions justify-end mt-4">
                                        <button class="btn btn-primary btn-sm">Read More</button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Post 3 -->
                            <div class="card bg-base-100 shadow-xl" data-aos="fade-up" data-aos-delay="300">
                                <figure><img src="https://picsum.photos/id/1006/600/400" alt="Blog Post" /></figure>
                                <div class="card-body">
                                    <div class="badge badge-primary mb-2">Travel</div>
                                    <h2 class="card-title">Hidden Gems of Southeast Asia</h2>
                                    <p>Discover lesser-known but breathtaking destinations across Southeast Asia that should be on your travel bucket list.</p>
                                    <div class="flex items-center mt-4">
                                        <div class="avatar">
                                            <div class="w-10 rounded-full">
                                                <img src="https://api.dicebear.com/6.x/initials/svg?seed=Mark%20Johnson" alt="Author" />
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium">Mark Johnson</p>
                                            <p class="text-xs opacity-70">May 5, 2023</p>
                                        </div>
                                    </div>
                                    <div class="card-actions justify-end mt-4">
                                        <button class="btn btn-primary btn-sm">Read More</button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Post 4 -->
                            <div class="card bg-base-100 shadow-xl" data-aos="fade-up" data-aos-delay="400">
                                <figure><img src="https://picsum.photos/id/102/600/400" alt="Blog Post" /></figure>
                                <div class="card-body">
                                    <div class="badge badge-secondary mb-2">Technology</div>
                                    <h2 class="card-title">Web3 and the Future of the Internet</h2>
                                    <p>An exploration of Web3 technologies and how they might reshape our online experiences in the coming years.</p>
                                    <div class="flex items-center mt-4">
                                        <div class="avatar">
                                            <div class="w-10 rounded-full">
                                                <img src="https://api.dicebear.com/6.x/initials/svg?seed=Sarah%20Lee" alt="Author" />
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium">Sarah Lee</p>
                                            <p class="text-xs opacity-70">April 28, 2023</p>
                                        </div>
                                    </div>
                                    <div class="card-actions justify-end mt-4">
                                        <button class="btn btn-primary btn-sm">Read More</button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Post 5 -->
                            <div class="card bg-base-100 shadow-xl" data-aos="fade-up" data-aos-delay="500">
                                <figure><img src="https://picsum.photos/id/1025/600/400" alt="Blog Post" /></figure>
                                <div class="card-body">
                                    <div class="badge badge-warning mb-2">Food</div>
                                    <h2 class="card-title">Plant-Based Cooking for Beginners</h2>
                                    <p>Simple and delicious plant-based recipes that anyone can make, regardless of cooking experience.</p>
                                    <div class="flex items-center mt-4">
                                        <div class="avatar">
                                            <div class="w-10 rounded-full">
                                                <img src="https://api.dicebear.com/6.x/initials/svg?seed=David%20Chen" alt="Author" />
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium">David Chen</p>
                                            <p class="text-xs opacity-70">April 22, 2023</p>
                                        </div>
                                    </div>
                                    <div class="card-actions justify-end mt-4">
                                        <button class="btn btn-primary btn-sm">Read More</button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Post 6 -->
                            <div class="card bg-base-100 shadow-xl" data-aos="fade-up" data-aos-delay="600">
                                <figure><img src="https://picsum.photos/id/1035/600/400" alt="Blog Post" /></figure>
                                <div class="card-body">
                                    <div class="badge badge-error mb-2">Health</div>
                                    <h2 class="card-title">The Science of Better Sleep</h2>
                                    <p>Evidence-based strategies to improve your sleep quality and wake up feeling more refreshed and energized.</p>
                                    <div class="flex items-center mt-4">
                                        <div class="avatar">
                                            <div class="w-10 rounded-full">
                                                <img src="https://api.dicebear.com/6.x/initials/svg?seed=Emily%20Wilson" alt="Author" />
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium">Emily Wilson</p>
                                            <p class="text-xs opacity-70">April 18, 2023</p>
                                        </div>
                                    </div>
                                    <div class="card-actions justify-end mt-4">
                                        <button class="btn btn-primary btn-sm">Read More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="flex justify-center mt-10">
                            <div class="join">
                                <button class="join-item btn">«</button>
                                <button class="join-item btn btn-active">1</button>
                                <button class="join-item btn">2</button>
                                <button class="join-item btn">3</button>
                                <button class="join-item btn">4</button>
                                <button class="join-item btn">»</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Newsletter -->
                    <div class="card bg-primary text-primary-content shadow-xl" data-aos="fade-up">
                        <div class="card-body text-center">
                            <h2 class="card-title text-2xl font-bold mx-auto mb-2">Subscribe to Our Newsletter</h2>
                            <p class="mb-6">Get the latest articles, tutorials, and updates delivered straight to your inbox.</p>
                            <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                                <input type="email" placeholder="your-email@example.com" class="input input-bordered w-full" />
                                <button class="btn bg-white text-primary hover:bg-gray-200">Subscribe</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            
          
