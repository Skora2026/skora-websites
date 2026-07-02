<?php $__env->startSection('title', 'Admin || Manage Videos'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<style>
    .video-thumb { width: 70px; height: 50px; object-fit: cover; border-radius: 4px; }
    .image-preview { max-width: 220px; max-height: 140px; object-fit: cover; border-radius: 4px; }
    .spinner-container { display:flex;justify-content:center;align-items:center;height:200px; }
    .spinner { width:3rem;height:3rem;border:3px solid #f3f3f3;border-top:3px solid #3498db;border-radius:50%;animation:spin 1s linear infinite; }
    @keyframes spin { 0%{transform:rotate(0deg);} 100%{transform:rotate(360deg);} }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('page', 'Manage Videos'); ?>

<div class="container pt-3 card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0 fw-semibold">Videos List</h6>
            <button class="btn btn-primary btn-sm" id="addVideoBtn"><i class="bi bi-plus"></i> Add Video</button>
        </div>

        <div class="table-responsive">
            <table id="videosTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Thumbnail</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div id="videosLoading" class="spinner-container" style="display:none;"><div class="spinner"></div></div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="videoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="videoForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" id="videoId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" id="title" class="form-control">
                            <div class="invalid-feedback title-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">No Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="invalid-feedback category-id-error"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Video Source *</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="video_type" id="typeYoutube" value="youtube" checked>
                                <label class="form-check-label" for="typeYoutube">YouTube Link</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="video_type" id="typeUpload" value="upload">
                                <label class="form-check-label" for="typeUpload">Upload Video File</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" id="youtubeField">
                        <label class="form-label">YouTube URL *</label>
                        <input type="url" name="youtube_url" id="youtube_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                        <div class="invalid-feedback youtube-url-error"></div>
                    </div>

                    <div class="mb-3 d-none" id="uploadField">
                        <label class="form-label">Video File *</label>
                        <input type="file" name="video_file" id="video_file" class="form-control" accept="video/mp4,video/quicktime,video/webm">
                        <div class="invalid-feedback video-file-error"></div>
                        <div class="form-text">Max size: 50MB. Allowed: mp4, mov, webm</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thumbnail Image</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*">
                        <div class="invalid-feedback thumbnail-error"></div>
                        <div id="thumbPreviewContainer" class="mt-2"></div>
                        <div class="form-text">Optional but recommended. Max size: 4MB.</div>
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
                    <button type="submit" class="btn btn-primary" id="videoSubmitBtn">
                        <span class="btn-text">Save Video</span>
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
let videosTable;

$(document).ready(function () {
    initializeDataTable();
    loadVideos();
    toggleVideoTypeFields();

    $('#addVideoBtn').click(function () {
        resetForm();
        $('#videoModal .modal-title').text('Add Video');
        $('#videoSubmitBtn .btn-text').text('Save Video');
        $('#videoModal').modal('show');
    });

    $('input[name="video_type"]').change(toggleVideoTypeFields);
    $('#thumbnail').change(function () { previewThumb(this); });
    $('#videoForm').submit(function (e) { e.preventDefault(); saveVideo($(this)); });
    $('#videosTable').on('click', '.editVideo', function () { loadVideoForEdit($(this).data('id')); });
    $('#videosTable').on('click', '.deleteVideo', function () { deleteVideo($(this).data('id')); });
    $('#videoModal').on('hidden.bs.modal', resetForm);
});

function toggleVideoTypeFields() {
    let type = $('input[name="video_type"]:checked').val();
    if (type === 'youtube') {
        $('#youtubeField').removeClass('d-none');
        $('#uploadField').addClass('d-none');
    } else {
        $('#youtubeField').addClass('d-none');
        $('#uploadField').removeClass('d-none');
    }
}

function resetForm() {
    $('#videoForm')[0].reset();
    $('#videoId').val('');
    $('#thumbPreviewContainer').empty();
    $('#typeYoutube').prop('checked', true);
    toggleVideoTypeFields();
    clearValidationErrors();
}

function previewThumb(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = e => { $('#thumbPreviewContainer').html(`<img src="${e.target.result}" class="image-preview" alt="Preview">`); };
        reader.readAsDataURL(input.files[0]);
    }
}

function initializeDataTable() {
    videosTable = $('#videosTable').DataTable({
        paging: true, searching: true, ordering: true, info: true, pageLength: 10,
        columns: [
            { data: 'id' },
            {
                data: 'thumbnail',
                render: data => data ? `<img src="/storage/${data}" class="video-thumb">` : '<i class="bi bi-camera-video text-muted"></i>'
            },
            { data: 'title' },
            { data: 'category.name', defaultContent: '—' },
            { data: 'video_type', render: data => data === 'youtube' ? '<span class="badge bg-danger">YouTube</span>' : '<span class="badge bg-info">Uploaded</span>' },
            { data: 'status', render: data => `<span class="badge ${data==='active'?'bg-success':'bg-secondary'}">${data.charAt(0).toUpperCase()+data.slice(1)}</span>` },
            {
                data: null, orderable: false,
                render: d => `
                    <button class="btn btn-sm btn-success editVideo" data-id="${d.id}"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-sm btn-danger deleteVideo" data-id="${d.id}"><i class="bi bi-trash"></i></button>
                `
            }
        ]
    });
}

function loadVideos() {
    $('#videosLoading').show();
    $.get('<?php echo e(route("admin.videos.get")); ?>', res => {
        $('#videosLoading').hide();
        if (res.success && res.data) videosTable.clear().rows.add(res.data).draw();
    }).fail(() => { $('#videosLoading').hide(); Swal.fire('Error', 'Could not load videos', 'error'); });
}

function saveVideo(form) {
    let id = $('#videoId').val();
    let url = id ? `/admin/videos/update/${id}` : '<?php echo e(route("admin.videos.store")); ?>';
    let formData = new FormData(form[0]);
    if (id) formData.append('_method', 'PUT');

    let btn = $('#videoSubmitBtn');
    btn.find('.btn-text').text(id ? 'Updating...' : 'Saving...');
    btn.find('.spinner-border').removeClass('d-none'); btn.prop('disabled', true);

    $.ajax({
        url, type: 'POST', data: formData, processData: false, contentType: false, headers: { 'X-CSRF-TOKEN': csrfToken },
        success: res => {
            if (res.success) { $('#videoModal').modal('hide'); loadVideos(); Swal.fire('Success', res.message, 'success'); }
            else Swal.fire('Error', res.message || 'Failed to save', 'error');
        },
        error: xhr => {
            if (xhr.status === 422) { showValidationErrors(xhr.responseJSON.errors); Swal.fire('Validation Error', 'Please check the form', 'warning'); }
            else Swal.fire('Error', 'Server error occurred', 'error');
        },
        complete: () => { btn.find('.btn-text').text(id ? 'Update Video' : 'Save Video'); btn.find('.spinner-border').addClass('d-none'); btn.prop('disabled', false); }
    });
}

function loadVideoForEdit(id) {
    $.get('<?php echo e(route("admin.videos.get")); ?>', res => {
        if (res.success) {
            let video = res.data.find(v => v.id == id);
            if (video) {
                resetForm();
                $('#videoId').val(video.id);
                $('#title').val(video.title);
                $('#category_id').val(video.category_id);
                $(`input[name="video_type"][value="${video.video_type}"]`).prop('checked', true);
                toggleVideoTypeFields();
                $('#youtube_url').val(video.youtube_url);
                $('#sort_order').val(video.sort_order);
                $('#status').val(video.status);
                if (video.thumbnail) {
                    $('#thumbPreviewContainer').html(`<p class="mb-1">Current Thumbnail:</p><img src="/storage/${video.thumbnail}" class="image-preview">`);
                }
                $('#videoModal .modal-title').text('Edit Video');
                $('#videoSubmitBtn .btn-text').text('Update Video');
                $('#videoModal').modal('show');
            }
        }
    });
}

function deleteVideo(id) {
    Swal.fire({ title: 'Delete Video?', text: 'This action cannot be undone!', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Yes, delete it!' })
        .then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/videos/destroy/${id}`,
                    type: 'POST',
                    data: { _method: 'DELETE', _token: csrfToken },
                    success: res => { if (res.success) { loadVideos(); Swal.fire('Deleted!', res.message, 'success'); } },
                    error: () => { Swal.fire('Error', 'Could not delete video', 'error'); }
                });
            }
        });
}

function clearValidationErrors() {
    $('#videoForm').find('.is-invalid').removeClass('is-invalid');
    $('#videoForm').find('.invalid-feedback').text('');
}

function showValidationErrors(errors) {
    clearValidationErrors();
    $.each(errors, (field, msgArr) => {
        let input = $(`#videoForm [name="${field}"]`);
        let errDiv = $(`.${field.replace(/_/g, '-')}-error`);
        if (input.length) input.addClass('is-invalid');
        if (errDiv.length) errDiv.text(msgArr[0]);
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\p2gh-main\resources\views/admin/videos.blade.php ENDPATH**/ ?>