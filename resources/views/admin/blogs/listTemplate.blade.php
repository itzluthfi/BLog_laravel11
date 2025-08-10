@extends('layout.template')

@section('title')
    Admin - Blogs
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/notifier.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/uikit.css') }}" />
@endsection

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- Breadcrumb -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Daftar Blogs</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-body">
                            <div class="text-end p-4 pb-sm-2">
                                <a class="btn btn-primary d-inline-flex align-items-center gap-2 text-white" data-bs-toggle="modal" data-bs-target="#blog-add-modal">
                                    <i class="ti ti-plus f-18"></i> Tambah Blog
                                </a>
                            </div>
                            <div class="table-responsive mx-4 mb-4">
                                <table class="table table-hover" id="blog-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th>Judul Blog</th>
                                            <th>Kategori</th>
                                            <th>Penulis</th>
                                            <th>Terbit</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- DataTables akan mengisi ini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Blog --}}
    <div class="modal fade" id="blog-add-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="mb-0">Tambah Blog</h5>
                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto" data-bs-dismiss="modal">
                        <i class="ti ti-x f-20"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Blog</label>
                        <input id="add-title" type="text" class="form-control" placeholder="Masukkan Judul Blog" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select id="add-category" class="form-select">
                            {{-- @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Singkat</label>
                        <textarea id="add-description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi Lengkap</label>
                        <textarea id="add-content" class="form-control" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-link-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="save-blog">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Blog --}}
    <div class="modal fade" id="blog-edit-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="mb-0">Edit Blog</h5>
                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto" data-bs-dismiss="modal">
                        <i class="ti ti-x f-20"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id">
                    <div class="mb-3">
                        <label class="form-label">Judul Blog</label>
                        <input id="edit-title" type="text" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select id="edit-category" class="form-select">
                            {{-- @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Singkat</label>
                        <textarea id="edit-description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi Lengkap</label>
                        <textarea id="edit-content" class="form-control" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="save-edit-blog">Update</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus blog ini?</p>
                    <input type="hidden" id="delete-blog-id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col my-1">
                    <p class="m-0">Blog Web &#9829; crafted with Zoltraak</p>
                </div>
            </div>
        </div>
    </footer>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            const _token = $('meta[name="csrf-token"]').attr("content");

            // Inisialisasi DataTable
            let table = $('#blog-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('profile.blog.data') }}",
                type: "GET",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'category',
                        name: 'category.name',
                        defaultContent: '-'
                    },
                    {
                        data: 'author',
                        name: 'author.username',
                        defaultContent: '-'
                    },
                    {
                        data: 'published_at',
                        name: 'published_at',
                        render: function(data) {
                            if (!data) return '-';
                            let date = new Date(data);
                            return new Intl.DateTimeFormat('id-ID', {
                                timeZone: 'Asia/Jakarta',
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric'
                            }).format(date);
                        }

                    },
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        class: 'text-center',
                        render: function(id) {
                            return `
                                <ul class="list-inline me-auto mb-0">
                                    <li class="list-inline-item" data-bs-toggle="tooltip" title="Edit">
                                        <a href="#" class="btn btn-sm btn-light-warning edit-blog-btn"
                                           data-id="${id}" data-bs-toggle="modal" data-bs-target="#blog-edit-modal">
                                            <i class="ti ti-edit-circle f-18"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item" data-bs-toggle="tooltip" title="Hapus">
                                        <a href="#" class="btn btn-sm btn-light-danger delete-blog-btn"
                                           data-id="${id}" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                                            <i class="ti ti-trash f-18"></i>
                                        </a>
                                    </li>
                                </ul>
                            `;
                        }
                    }
                ],
                order: [
                    [4, 'desc']
                ] // Urutkan berdasarkan published_at
            });

            // Tambah Blog
            $('#save-blog').on('click', function() {
                const title = $('#add-title').val();
                const category_id = $('#add-category').val();
                const description = $('#add-description').val();
                const full_content = $('#add-content').val();

                $.ajax({
                    url: "{{ route('profile.blog.store') }}",
                    method: 'POST',
                    data: {
                        _token,
                        title,
                        category_id,
                        description,
                        full_content,
                        author_id: {{ auth()->id() }},
                        published_at: new Date().toISOString()
                    },
                    success: function(res) {
                        notifier.show(res.label, res.message, res.type);
                        $('#blog-add-modal').modal('hide');
                        $('#add-title, #add-description, #add-content').val('');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON?.errors;
                        let msg = 'Terjadi kesalahan:\n';
                        if (errors) {
                            $.each(errors, (k, v) => {
                                msg += v[0] + '\n';
                            });
                        } else {
                            msg = xhr.responseJSON?.message || 'Gagal menyimpan.';
                        }
                        alert(msg);
                    }
                });
            });

            // Isi data ke modal edit
            $(document).on('click', '.edit-blog-btn', function() {
                const id = $(this).data('id');
                $.get(`{{ url('admin/blog') }}/${id}/edit`, function(blog) {
                    $('#edit-id').val(blog.id);
                    $('#edit-title').val(blog.title);
                    $('#edit-category').val(blog.category_id);
                    $('#edit-description').val(blog.description);
                    $('#edit-content').val(blog.full_content);
                });
            });

            // Simpan perubahan edit
            $('#save-edit-blog').on('click', function() {
                const id = $('#edit-id').val();
                const title = $('#edit-title').val();
                const category_id = $('#edit-category').val();
                const description = $('#edit-description').val();
                const full_content = $('#edit-content').val();

                $.ajax({
                    url: `{{ url('admin/blog') }}/${id}`,
                    method: 'PUT',
                    data: {
                        _token,
                        title,
                        category_id,
                        description,
                        full_content
                    },
                    success: function(res) {
                        notifier.show(res.label, res.message, res.type);
                        $('#blog-edit-modal').modal('hide');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Gagal memperbarui: ' + xhr.responseJSON?.message);
                    }
                });
            });

            // Hapus: isi ID ke modal
            $(document).on('click', '.delete-blog-btn', function() {
                $('#delete-blog-id').val($(this).data('id'));
            });

            // Konfirmasi hapus
            $('#confirm-delete').on('click', function() {
                const id = $('#delete-blog-id').val();
                $.ajax({
                    url: `{{ url('admin/blog') }}/${id}`,
                    method: 'DELETE',
                    data: {
                        _token
                    },
                    success: function(res) {
                        notifier.show(res.label, res.message, res.type);
                        $('#confirmDeleteModal').modal('hide');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Gagal menghapus: ' + xhr.responseJSON?.message);
                    }
                });
            });
        });
    </script>
@endsection
