@extends('layouts.admin')

@section('title', 'Admin || Manage Services')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .service-image {
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
@endpush

@section('content')
@section('page', 'Manage Services')

    <div class="container pt-3 card">
        <div class="services-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="m-0 fw-semi-bold">Services List</h6>
                <button class="btn btn-primary btn-3d btn-sm" id="addServiceBtn"><i class="fas fa-plus"></i> Add
                    Service</button>
            </div>

            <div class="mb-3 col-md-6">
                <input type="text" class="form-control" id="nameSearch" placeholder="Search services by name...">
            </div>

            <div class="table-responsive">
                <table id="servicesTable" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="15%">Category</th>
                            <th width="20%">Name</th>
                            <th width="20%">Short Description</th>
                            <th width="10%">Image</th>
                            <th width="10%">Status</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div id="servicesLoading" class="spinner-container" style="display:none;">
                <div class="spinner"></div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Service Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Service</h5>
                    <button type="button"
                        class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3"
                        style="width: 25px; height: 25px; display:flex; align-items:center; justify-content:center;"
                        data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
                </div>
                <form id="serviceForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="serviceId">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category *</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback category-error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" name="name" id="name" class="form-control">
                                <div class="invalid-feedback name-error"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <div class="invalid-feedback status-error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                <div class="invalid-feedback image-error"></div>
                                <div id="imagePreviewContainer" class="mt-2"></div>
                                <div class="form-text">Max size: 2MB. Allowed: jpeg, png, jpg, gif</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Short Description *</label>
                                <textarea class="form-control tinymce-editor" name="short_description"
                                    id="shortDescription"></textarea>
                                <div class="invalid-feedback short-description-error"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Full Description</label>
                                <textarea class="form-control tinymce-editor" name="description" id="description"
                                    rows="5"></textarea>
                                <div class="invalid-feedback description-error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="serviceSubmitBtn">
                            <span class="btn-text">Save Service</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('tiny/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let servicesTable = null;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let shortDescEditor = null;
        let fullDescEditor = null;
        let searchTimeout;

        $(document).ready(function () {
            initializeDataTable();
            loadServices();
            initializeTinyMCE();
            bindEvents();
        });

        function initializeTinyMCE() {
            tinymce.init({ selector: '#shortDescription', height: 280, menubar: false, plugins: 'link lists image code', toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code', branding: false, setup: function (editor) { editor.on('init', () => shortDescEditor = editor); } });
            tinymce.init({ selector: '#description', height: 350, menubar: false, plugins: 'link lists image code', toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code', branding: false, setup: function (editor) { editor.on('init', () => fullDescEditor = editor); } });
        }

        function bindEvents() {
            $('#nameSearch').on('keyup', function () {
                clearTimeout(searchTimeout);
                let query = $(this).val().trim();
                searchTimeout = setTimeout(() => { if (query.length >= 2 || query.length === 0) searchServices(query); }, 350);
            });

            $('#addServiceBtn').click(function () { resetForm(); $('#serviceModal .modal-title').text('Add New Service'); $('#serviceSubmitBtn .btn-text').text('Save Service'); $('#serviceModal').modal('show'); });
            $('#image').change(function () { previewImage(this); });
            $('#serviceForm').submit(function (e) { e.preventDefault(); saveService($(this)); });
            $('#servicesTable').on('click', '.editService', function () { loadServiceForEdit($(this).data('id')); });
            $('#servicesTable').on('click', '.deleteService', function () { deleteService($(this).data('id')); });
            $('#serviceModal').on('hidden.bs.modal', resetForm);
        }

        function resetForm() {
            $('#serviceForm')[0].reset();
            $('#serviceId').val('');
            $('#imagePreviewContainer').empty();
            if (shortDescEditor) shortDescEditor.setContent('');
            if (fullDescEditor) fullDescEditor.setContent('');
            clearValidationErrors('#serviceForm');
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = e => { $('#imagePreviewContainer').html(`<img src="${e.target.result}" class="image-preview" alt="Preview">`); }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function initializeDataTable() {
            servicesTable = $('#servicesTable').DataTable({
                paging: true,
                searching: false,
                ordering: true,
                info: true,
                lengthChange: true,
                pageLength: 10,
                columns: [
                    { data: 'id' },
                    { data: 'category.name', defaultContent: '—' },
                    { data: 'name' },
                    {
                        data: 'short_description',
                        render: data => {
                            let text = (data || '').replace(/<[^>]*>/g, '').trim();
                            return text.length > 60 ? text.substring(0, 60) + '...' : text;
                        }
                    },
                    {
                        data: 'image',
                        render: data =>
                            data ? `<img src="/storage/${data}" class="service-image">` : '—'
                    },
                    {
                        data: 'status',
                        render: data =>
                            `<span class="badge ${data === 'active' ? 'bg-success' : 'bg-secondary'}">
                            ${data.charAt(0).toUpperCase() + data.slice(1)}
                         </span>`
                    },
                    {
                        data: null,
                        orderable: false,
                        render: data => `
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-success me-1 editService"
                                    data-id="${data.id}" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-danger deleteService"
                                    data-id="${data.id}" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `
                    }
                ]
            });
        }


        function loadServices() {
            $('#servicesLoading').show();
            $.get('{{ route("admin.services.get") }}', res => {
                $('#servicesLoading').hide();
                if (res.success && res.data) servicesTable.clear().rows.add(res.data).draw();
            }).fail(() => { $('#servicesLoading').hide(); Swal.fire('Error', 'Could not load services', 'error'); });
        }

        function searchServices(query) {
            $('#servicesLoading').show();
            $.get('{{ route("admin.services.search") }}', { query }, res => {
                $('#servicesLoading').hide();
                if (res.success && res.data) servicesTable.clear().rows.add(res.data).draw();
            }).fail(() => { $('#servicesLoading').hide(); });
        }

        function saveService(form) {
            let id = $('#serviceId').val();
            let url = id ? `/admin/services/update/${id}` : '{{ route("admin.services.store") }}';
            if (shortDescEditor) form.find('[name="short_description"]').val(shortDescEditor.getContent());
            if (fullDescEditor) form.find('[name="description"]').val(fullDescEditor.getContent());
            let formData = new FormData(form[0]);
            if (id) formData.append('_method', 'PUT');

            let btn = $('#serviceSubmitBtn');
            btn.find('.btn-text').text(id ? 'Updating...' : 'Saving...');
            btn.find('.spinner-border').removeClass('d-none'); btn.prop('disabled', true);

            $.ajax({
                url, type: 'POST', data: formData, processData: false, contentType: false, headers: { 'X-CSRF-TOKEN': csrfToken },
                success: res => {
                    if (res.success) { $('#serviceModal').modal('hide'); loadServices(); Swal.fire('Success', res.message, 'success'); }
                    else Swal.fire('Error', res.message || 'Failed to save', 'error');
                },
                error: xhr => {
                    if (xhr.status === 422) { showValidationErrors('#serviceForm', xhr.responseJSON.errors); Swal.fire('Validation Error', 'Please check the form', 'warning'); }
                    else Swal.fire('Error', 'Server error occurred', 'error');
                },
                complete: () => { btn.find('.btn-text').text(id ? 'Update Service' : 'Save Service'); btn.find('.spinner-border').addClass('d-none'); btn.prop('disabled', false); }
            });
        }

        function loadServiceForEdit(id) {
            $.get('{{ route("admin.services.get") }}', res => {
                if (res.success) {
                    let service = res.data.find(s => s.id == id);
                    if (service) {
                        $('#serviceId').val(service.id);
                        $('#category_id').val(service.category_id);
                        $('#name').val(service.name);
                        $('#status').val(service.status);
                        if (shortDescEditor) shortDescEditor.setContent(service.short_description || '');
                        if (fullDescEditor) fullDescEditor.setContent(service.description || '');
                        let imgHtml = service.image ? `<p class="mb-1">Current Image:</p><img src="/storage/${service.image}" class="image-preview">` : '';
                        $('#imagePreviewContainer').html(imgHtml);
                        $('#serviceModal .modal-title').text('Edit Service');
                        $('#serviceSubmitBtn .btn-text').text('Update Service');
                        $('#serviceModal').modal('show');
                    }
                }
            });
        }

        function deleteService(id) {
            Swal.fire({ title: 'Delete Service?', text: "This action cannot be undone!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6', confirmButtonText: 'Yes, delete it!' })
                .then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/services/destroy/${id}`,
                            type: 'POST',
                            data: { _method: 'DELETE', _token: csrfToken },
                            success: res => { if (res.success) { loadServices(); Swal.fire('Deleted!', res.message, 'success'); } },
                            error: () => { Swal.fire('Error', 'Could not delete service', 'error'); }
                        });
                    }
                });
        }

        function clearValidationErrors(form) {
            $(form).find('.is-invalid').removeClass('is-invalid');
            $(form).find('.invalid-feedback').text('').hide();
        }

        function showValidationErrors(form, errors) {
            clearValidationErrors(form);
            $.each(errors, (field, msgArr) => {
                let input = $(form).find(`[name="${field}"]`);
                let errDiv = $(form).find(`.${field.replace(/_/g, '-')}-error`);
                if (input.length) input.addClass('is-invalid');
                if (errDiv.length) errDiv.text(msgArr[0]).show();
            });
        }
    </script>
@endpush