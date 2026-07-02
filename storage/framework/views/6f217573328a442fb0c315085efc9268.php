<?php $__env->startSection('title', 'Admin || Manage Gallery Images'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<style>
    .gallery-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; }
    .image-preview { max-width: 220px; max-height: 160px; object-fit: cover; border-radius: 4px; }
    .spinner-container { display:flex;justify-content:center;align-items:center;height:200px; }
    .spinner { width:3rem;height:3rem;border:3px solid #f3f3f3;border-top:3px solid #3498db;border-radius:50%;animation:spin 1s linear infinite; }
    @keyframes spin { 0%{transform:rotate(0deg);} 100%{transform:rotate(360deg);} }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('page', 'Manage Gallery Images'); ?>

<div class="container pt-3 card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0 fw-semibold">Gallery Images List</h6>
            <button class="btn btn-primary btn-sm" id="addImageBtn"><i class="bi bi-plus"></i> Add Image</button>
        </div>

        <div class="table-responsive">
            <table id="imagesTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Preview</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div id="imagesLoading" class="spinner-container" style="display:none;"><div class="spinner"></div></div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Gallery Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="imageForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" id="imageId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">No Category</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <div class="invalid-feedback category-id-error"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title (optional)</label>
                        <input type="text" name="title" id="title" class="form-control">
                        <div class="invalid-feedback title-error"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image *</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <div class="invalid-feedback image-error"></div>
                        <div id="imagePreviewContainer" class="mt-2"></div>
                        <div class="form-text">Max size: 4MB. Allowed: jpg, jpeg, png, webp</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status *</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="imageSubmitBtn">
                        <span class="btn-text">Save Image</span>
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
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let csrfToken = $('meta[name="csrf-token"]').attr('content');
let imagesTable;

$(document).ready(function () {
    initializeDataTable();
    loadImages();

    $('#addImageBtn').click(function () {
        resetForm();
        $('#imageModal .modal-title').text('Add Gallery Image');
        $('#imageSubmitBtn .btn-text').text('Save Image');
        $('#imageModal').modal('show');
    });

    $('#image').change(function () { previewImage(this); });
    $('#imageForm').submit(function (e) { e.preventDefault(); saveImage($(this)); });
    $('#imagesTable').on('click', '.editImage', function () { loadImageForEdit($(this).data('id')); });
    $('#imagesTable').on('click', '.deleteImage', function () { deleteImage($(this).data('id')); });
    $('#imageModal').on('hidden.bs.modal', resetForm);
});

function resetForm() {
    $('#imageForm')[0].reset();
    $('#imageId').val('');
    $('#imagePreviewContainer').empty();
    clearValidationErrors();
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = e => { $('#imagePreviewContainer').html(`<img src="${e.target.result}" class="image-preview" alt="Preview">`); };
        reader.readAsDataURL(input.files[0]);
    }
}

function initializeDataTable() {
    imagesTable = $('#imagesTable').DataTable({
        paging: true, searching: true, ordering: true, info: true, pageLength: 10,
        columns: [
            { data: 'id' },
            { data: 'image', render: data => `<img src="/storage/${data}" class="gallery-thumb">` },
            { data: 'title', defaultContent: '—' },
            { data: 'category.name', defaultContent: '—' },
            { data: 'status', render: data => `<span class="badge ${data==='active'?'bg-success':'bg-secondary'}">${data.charAt(0).toUpperCase()+data.slice(1)}</span>` },
            {
                data: null, orderable: false,
                render: d => `
                    <button class="btn btn-sm btn-success editImage" data-id="${d.id}"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-sm btn-danger deleteImage" data-id="${d.id}"><i class="bi bi-trash"></i></button>
                `
            }
        ]
    });
}

function loadImages() {
    $('#imagesLoading').show();
    $.get('<?php echo e(route("admin.gallery-images.get")); ?>', res => {
        $('#imagesLoading').hide();
        if (res.success && res.data) imagesTable.clear().rows.add(res.data).draw();
    }).fail(() => { $('#imagesLoading').hide(); Swal.fire('Error', 'Could not load images', 'error'); });
}

function saveImage(form) {
    let id = $('#imageId').val();
    let url = id ? `/admin/gallery-images/update/${id}` : '<?php echo e(route("admin.gallery-images.store")); ?>';
    let formData = new FormData(form[0]);
    if (id) formData.append('_method', 'PUT');

    let btn = $('#imageSubmitBtn');
    btn.find('.btn-text').text(id ? 'Updating...' : 'Saving...');
    btn.find('.spinner-border').removeClass('d-none'); btn.prop('disabled', true);

    $.ajax({
        url, type: 'POST', data: formData, processData: false, contentType: false, headers: { 'X-CSRF-TOKEN': csrfToken },
        success: res => {
            if (res.success) { $('#imageModal').modal('hide'); loadImages(); Swal.fire('Success', res.message, 'success'); }
            else Swal.fire('Error', res.message || 'Failed to save', 'error');
        },
        error: xhr => {
            if (xhr.status === 422) { showValidationErrors(xhr.responseJSON.errors); Swal.fire('Validation Error', 'Please check the form', 'warning'); }
            else Swal.fire('Error', 'Server error occurred', 'error');
        },
        complete: () => { btn.find('.btn-text').text(id ? 'Update Image' : 'Save Image'); btn.find('.spinner-border').addClass('d-none'); btn.prop('disabled', false); }
    });
}

function loadImageForEdit(id) {
    $.get('<?php echo e(route("admin.gallery-images.get")); ?>', res => {
        if (res.success) {
            let item = res.data.find(i => i.id == id);
            if (item) {
                resetForm();
                $('#imageId').val(item.id);
                $('#category_id').val(item.category_id);
                $('#title').val(item.title);
                $('#sort_order').val(item.sort_order);
                $('#status').val(item.status);
                $('#imagePreviewContainer').html(`<p class="mb-1">Current Image:</p><img src="/storage/${item.image}" class="image-preview">`);
                $('#imageModal .modal-title').text('Edit Gallery Image');
                $('#imageSubmitBtn .btn-text').text('Update Image');
                $('#imageModal').modal('show');
            }
        }
    });
}

function deleteImage(id) {
    Swal.fire({ title: 'Delete Image?', text: 'This action cannot be undone!', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Yes, delete it!' })
        .then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/gallery-images/destroy/${id}`,
                    type: 'POST',
                    data: { _method: 'DELETE', _token: csrfToken },
                    success: res => { if (res.success) { loadImages(); Swal.fire('Deleted!', res.message, 'success'); } },
                    error: () => { Swal.fire('Error', 'Could not delete image', 'error'); }
                });
            }
        });
}

function clearValidationErrors() {
    $('#imageForm').find('.is-invalid').removeClass('is-invalid');
    $('#imageForm').find('.invalid-feedback').text('');
}

function showValidationErrors(errors) {
    clearValidationErrors();
    $.each(errors, (field, msgArr) => {
        let input = $(`#imageForm [name="${field}"]`);
        let errDiv = $(`.${field.replace(/_/g, '-')}-error`);
        if (input.length) input.addClass('is-invalid');
        if (errDiv.length) errDiv.text(msgArr[0]);
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\p2gh-main\resources\views/admin/gallery-images.blade.php ENDPATH**/ ?>