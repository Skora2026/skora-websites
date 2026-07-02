<?php $__env->startSection('title', 'Admin || Management Blogs'); ?>
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <style>
        .spinner-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
        }
        .spinner {
            width: 3rem;
            height: 3rem;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .project-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .image-preview {
            max-width: 200px;
            max-height: 150px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('page', 'Management Blogs'); ?>

<div class="container pt-3 card">
    <div class="blogs-section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0 fw-semi-bold">Blogs List</h6>
            <button class="btn btn-primary btn-3d btn-sm" onclick="showAddModal()">
                <i class="fas fa-plus"></i> Add Blog
            </button>
        </div>

        <div class="mb-3 col-md-6">
            <input type="text" class="form-control" id="titleSearch" placeholder="Search blogs by title...">
        </div>

        <div class="table-responsive">
            <table id="blogsTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th width="20%"> ID</th>
                        <th width="10%">Image</th>
                        <th width="5%">Title</th>
                        <th width="20%">Publish Date</th>
                        <th width="5%">Short Description</th>
                        <th width="10%">Status</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div id="blogsLoading" class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
</div>

<!-- Add Blog Modal -->
<div class="modal fade" id="addBlogModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Blog</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>            </div>
            <form id="addBlogForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Blog Title" required>
                            <div class="invalid-feedback title-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Publish Date *</label>
                            <input type="date" class="form-control" name="publish_date" required>
                            <div class="invalid-feedback publish-date-error"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status *</label>
                            <select class="form-control" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div class="invalid-feedback status-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                            <div class="invalid-feedback image-error"></div>
                            <div id="addImagePreview" class="mt-2"></div>
                            <div class="form-text">Max size: 2MB. Allowed: jpeg, png, jpg, gif</div>
                        </div>
                    </div>


                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Short Description *</label>
                            <textarea class="form-control" name="short_description" placeholder="Enter a short summary (shown on blog cards/listings)"></textarea>
                            <div class="invalid-feedback short-description-error"></div>
                        </div>
                    </div>

                      <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Long Description *</label>
                            <textarea class="form-control tinymce-editor" id="addLongDescription" name="long_description" placeholder="Enter the full blog article content"></textarea>
                            <div class="invalid-feedback long-description-error"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="addSubmitBtn">
                        <span class="btn-text">Save Blog</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Blog Modal -->
<div class="modal fade" id="editBlogModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Blog</h5>
                    <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>            </div>
            <form id="editBlogForm">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input type="hidden" name="id" id="editBlogId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control" name="title" id="editBlogTitle" required>
                            <div class="invalid-feedback title-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Publish Date *</label>
                            <input type="date" class="form-control" name="publish_date" id="editBlogPublishDate" required>
                            <div class="invalid-feedback publish-date-error"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status *</label>
                            <select class="form-control" name="status" id="editBlogStatus" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div class="invalid-feedback status-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                            <div class="invalid-feedback image-error"></div>
                            <div id="editImagePreview" class="mt-2"></div>
                            <div class="form-text">Upload new image to replace current one</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Short Description *</label>
                            <textarea class="form-control" name="short_description" id="editShortDescription" placeholder="Enter a short summary (shown on blog cards/listings)"></textarea>
                            <div class="invalid-feedback short-description-error"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Long Description *</label>
                            <textarea class="form-control tinymce-editor" id="editLongDescription" name="long_description"></textarea>
                            <div class="invalid-feedback long-description-error"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editSubmitBtn">
                        <span class="btn-text">Update Blog</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?php echo e(asset('tiny/vendor/tinymce/tinymce.min.js')); ?>"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let blogsTable = null;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let addTinyMCE = null;
        let editTinyMCE = null;
        let searchTimeout;

        $(document).ready(function() {
            initializeDataTable();
            loadBlogs();
            initializeTinyMCE();
            bindFormEvents();
            bindModalEvents();
            bindDeleteEvents();
            bindSearchEvents();
            bindImagePreview();
        });

        function initializeTinyMCE() {
            tinymce.init({
                selector: '#addLongDescription, #editLongDescription',
                height: 300,
                menubar: false,
                plugins: 'link lists image code',
                toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
                branding: false,
                setup: function(editor) {
                    editor.on('init', function() {
                        if (editor.id === 'addLongDescription') {
                            addTinyMCE = editor;
                        } else if (editor.id === 'editLongDescription') {
                            editTinyMCE = editor;
                        }
                    });
                }
            });
        }

        function bindSearchEvents() {
            $('#titleSearch').on('keyup', function() {
                clearTimeout(searchTimeout);
                const query = $(this).val().trim();
                searchTimeout = setTimeout(() => {
                    if (query.length >= 2 || query.length === 0) {
                        searchBlogs(query);
                    }
                }, 300);
            });
        }

        function searchBlogs(query) {
            $('#blogsLoading').show();
            $.ajax({
                url: "<?php echo e(route('admin.blogs.search')); ?>",
                type: "GET",
                data: { query: query },
                dataType: 'json',
                success: function(response) {
                    $('#blogsLoading').hide();
                    blogsTable.clear();
                    if (response.success && response.data) {
                        blogsTable.rows.add(response.data);
                    }
                    blogsTable.draw();
                },
                error: function(xhr) {
                    $('#blogsLoading').hide();
                    console.error('Search error:', xhr);
                    showAlert('Error searching blogs!', 'error');
                }
            });
        }

        function bindImagePreview() {
            $(document).on('change', '#addBlogForm input[name="image"], #editBlogForm input[name="image"]', function() {
                const previewDiv = $(this).closest('.col-md-6').find('.image-preview-div');
                previewImage(this.files[0], previewDiv);
            });
        }

        function previewImage(file, previewDiv) {
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewDiv.html(`<img src="${e.target.result}" alt="Preview" class="image-preview">`);
                };
                reader.readAsDataURL(file);
            } else {
                previewDiv.empty();
            }
        }

        function bindFormEvents() {
            $('#addBlogForm').on('submit', function(e) {
                e.preventDefault();
                addBlogHandler($(this));
            });

            // Edit form submission
            $('#editBlogForm').on('submit', function(e) {
                e.preventDefault();
                updateBlogHandler($(this));
            });
        }

        function bindModalEvents() {
            // Reset add modal when closed
            $('#addBlogModal').on('hidden.bs.modal', function() {
                $('#addBlogForm')[0].reset();
                clearValidationErrors('#addBlogForm');
                $('#addImagePreview').empty();
                if (addTinyMCE) {
                    addTinyMCE.setContent('');
                }
            });

            // Reset edit modal when closed
            $('#editBlogModal').on('hidden.bs.modal', function() {
                $('#editBlogForm')[0].reset();
                clearValidationErrors('#editBlogForm');
                $('#currentImageContainer').empty();
                $('#editImagePreview').empty();
                if (editTinyMCE) {
                    editTinyMCE.setContent('');
                }
            });
        }

        function bindDeleteEvents() {
            $(document).on('click', '.delete-blog', function() {
                const id = $(this).data('id');
                deleteBlog(id);
            });
        }

        function clearValidationErrors(formSelector) {
            $(formSelector).find('.is-invalid').removeClass('is-invalid');
            $(formSelector).find('.invalid-feedback').text('').hide();
        }

        function showValidationErrors(form, errors) {
            clearValidationErrors(form);
            
            $.each(errors, function(field, messages) {
                const input = form.find(`[name="${field}"]`);
                const errorDiv = form.find(`.${field}-error`);
                
                if (input.length) {
                    input.addClass('is-invalid');
                }
                
                if (errorDiv.length) {
                    errorDiv.text(messages[0]).show();
                }
            });
        }

        function initializeDataTable() {
            blogsTable = $('#blogsTable').DataTable({
                paging: true,
                searching: false,
                ordering: true,
                info: true,
                lengthChange: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search blogs...",
                    paginate: {
                        next: '<i class="bi bi-chevron-right"></i>',
                        previous: '<i class="bi bi-chevron-left"></i>'
                    }
                },
                columns: [
                    { data: 'id' },
                    { 
                        data: 'image',
                        orderable: false,
                        render: function(data) {
                            if (data) {
                                return `<img src="/${data}" class="project-image" alt="Blog Image">`;
                            }
                            return '<span class="text-muted">No Image</span>';
                        }
                    },
                    { data: 'title' },
                    { 
                        data: 'publish_date',
                        render: function(data) {
                            return new Date(data).toLocaleDateString('en-US', { 
                                year: 'numeric', 
                                month: 'short', 
                                day: 'numeric' 
                            });
                        }
                    },
                    { 
                        data: 'short_description',
                        render: function(data) {
                            const plainText = data ? data.replace(/<[^>]*>/g, '').trim() : '';
                            return plainText.length > 50 ? plainText.substring(0, 50) + '...' : plainText;
                        }
                    },
                    { 
                        data: 'status',
                        render: function(data) {
                            const badgeClass = data === 'active' ? 'badge bg-success' : 'badge bg-secondary';
                            const statusText = data === 'active' ? 'Active' : 'Inactive';
                            return `<span class="${badgeClass}">${statusText}</span>`;
                        }
                    },
                    { 
                        data: null,
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-success me-1" onclick="editBlog(${row.id})" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-blog" data-id="${row.id}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ]
            });
        }

        function loadBlogs() {
            $('#blogsLoading').show();
            
            $.ajax({
                url: "<?php echo e(route('admin.blogs.get')); ?>",
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    $('#blogsLoading').hide();
                    
                    if (response.success) {
                        blogsTable.clear();
                        if (response.data && response.data.length > 0) {
                            blogsTable.rows.add(response.data);
                        }
                        blogsTable.draw();
                    } else {
                        blogsTable.clear();
                        blogsTable.draw();
                        showAlert('Error loading blogs!', 'error');
                    }
                },
                error: function(xhr) {
                    $('#blogsLoading').hide();
                    console.error('Load blogs error:', xhr);
                    showAlert('Error loading blogs!', 'error');
                }
            });
        }

        function showAddModal() {
            clearValidationErrors('#addBlogForm');
            $('#addBlogModal').modal('show');
        }

        function addBlogHandler(form) {
            const formData = new FormData(form[0]);
            if (addTinyMCE) {
                formData.set('long_description', addTinyMCE.getContent());
            }
            
            const submitBtn = $('#addSubmitBtn');
            const btnText = submitBtn.find('.btn-text');
            const spinner = submitBtn.find('.spinner-border');
            
            btnText.text('Saving...');
            spinner.removeClass('d-none');
            submitBtn.prop('disabled', true);
            
            $.ajax({
                url: "<?php echo e(route('admin.blogs.store')); ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        $('#addBlogModal').modal('hide');
                        loadBlogs();
                        showAlert(response.message, 'success');
                    } else {
                        showAlert(response.message || 'Error saving blog!', 'error');
                    }
                },
                error: function(xhr) {
                    console.error('Add blog error:', xhr);
                    
                    if (xhr.status === 422) {
                        showValidationErrors(form, xhr.responseJSON.errors);
                        showAlert('Please fix validation errors', 'error');
                    } else {
                        let errorMsg = 'Error saving blog!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showAlert(errorMsg, 'error');
                    }
                },
                complete: function() {
                    btnText.text('Save Blog');
                    spinner.addClass('d-none');
                    submitBtn.prop('disabled', false);
                }
            });
        }

        function editBlog(id) {
            $.ajax({
                url: "<?php echo e(route('admin.blogs.get')); ?>",
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const blog = response.data.find(b => parseInt(b.id) === parseInt(id));
                        if (blog) {
                            populateEditForm(blog);
                            $('#editBlogModal').modal('show');
                        } else {
                            showAlert('Blog not found!', 'error');
                        }
                    } else {
                        showAlert('Error loading blog!', 'error');
                    }
                },
                error: function(xhr) {
                    console.error('Edit blog load error:', xhr);
                    showAlert('Error loading blog!', 'error');
                }
            });
        }

        function populateEditForm(blog) {
            clearValidationErrors('#editBlogForm');
            
            $('#editBlogId').val(blog.id);
            $('#editBlogTitle').val(blog.title);
            $('#editBlogPublishDate').val(blog.publish_date.split('T')[0]);
            $('#editBlogStatus').val(blog.status);
            $('#editShortDescription').val(blog.short_description);
            if (editTinyMCE) {
                editTinyMCE.setContent(blog.long_description || '');
            }
            let imageHtml = '';
            if (blog.image) {
                imageHtml = `
                    <div class="mb-2">
                        <p class="mb-1">Current Image:</p>
                        <img src="/${blog.image}" class="img-thumbnail image-preview" alt="Current Image" style="max-width: 200px;">
                    </div>
                `;
            }
            $('#currentImageContainer').html(imageHtml);
        }

        function updateBlogHandler(form) {
            const formData = new FormData(form[0]);
            const id = $('#editBlogId').val();
            if (editTinyMCE) {
                formData.set('long_description', editTinyMCE.getContent());
            }
            
            const submitBtn = $('#editSubmitBtn');
            const btnText = submitBtn.find('.btn-text');
            const spinner = submitBtn.find('.spinner-border');
            
            btnText.text('Updating...');
            spinner.removeClass('d-none');
            submitBtn.prop('disabled', true);
            
            $.ajax({
                url: "<?php echo e(route('admin.blogs.update', ':id')); ?>".replace(':id', id),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        $('#editBlogModal').modal('hide');
                        loadBlogs();
                        showAlert(response.message, 'success');
                    } else {
                        showAlert(response.message || 'Error updating blog!', 'error');
                    }
                },
                error: function(xhr) {
                    console.error('Update blog error:', xhr);
                    
                    if (xhr.status === 422) {
                        showValidationErrors(form, xhr.responseJSON.errors);
                        showAlert('Please fix validation errors', 'error');
                    } else {
                        let errorMsg = 'Error updating blog!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showAlert(errorMsg, 'error');
                    }
                },
                complete: function() {
                    btnText.text('Update Blog');
                    spinner.addClass('d-none');
                    submitBtn.prop('disabled', false);
                }
            });
        }

        function deleteBlog(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo e(route('admin.blogs.destroy', ':id')); ?>".replace(':id', id),
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: csrfToken
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                loadBlogs();
                                showAlert(response.message, 'success');
                            } else {
                                showAlert(response.message || 'Error deleting blog!', 'error');
                            }
                        },
                        error: function(xhr) {
                            console.error('Delete error:', xhr);
                            showAlert('Error deleting blog!', 'error');
                        }
                    });
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\p2gh-main\resources\views/admin/manage-blogs.blade.php ENDPATH**/ ?>