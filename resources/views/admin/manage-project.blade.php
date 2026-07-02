@extends('layouts.admin')
@section('title', 'Admin || Management Projects')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
 @section('page', 'Management Projects ')

<div class="container pt-3 card">
    <div class="projects-section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0 fw-semi-bold"></h6>
            <button class="btn cu" onclick="showAddModal()">
                <i class="fas fa-plus"></i> Add Projects
            </button>
        </div>

        <div class="table-responsive">
            <table id="projectsTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Image</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div id="projectsLoading" class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
</div>

<!-- Add Project Modal -->
<div class="modal fade" id="addProjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Project</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="addProjectForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Project Type(Title) *</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter Project Type Name" required>
                        <div class="invalid-feedback">Please enter project title</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status *</label>
                        <select class="form-control" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <div class="invalid-feedback">Please select status</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <div class="form-text">Upload project image (optional)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Project</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Project Modal -->
<div class="modal fade" id="editProjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Project</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="editProjectForm">
                <input type="hidden" name="id" id="editProjectId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title *</label>
                        <input type="text" class="form-control" name="title" id="editProjectTitle" required>
                        <div class="invalid-feedback">Please enter project title</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status *</label>
                        <select class="form-control" name="status" id="editProjectStatus" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <div class="invalid-feedback">Please select status</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <div id="currentImageContainer" class="mt-2"></div>
                        <div class="form-text">Upload new image to replace current one</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Project</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let projectsTable = null;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $(document).ready(function() {
            initializeDataTable();
            loadProjects();
            $('#addProjectForm').submit(addProject);
            $('#editProjectForm').submit(updateProject);
        });

        function initializeDataTable() {
            projectsTable = $('#projectsTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: false,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search projects..."
                },
                columns: [
                    { data: 'id' },
                    { 
                        data: 'image',
                        orderable: false,
                        render: function(data) {
                            if (data) {
                                return `<img src="/${data}" class="project-image" alt="Project Image">`;
                            }
                            return '<span class="text-muted">No Image</span>';
                        }
                    },
                    { data: 'title' },
                    { 
                        data: 'status',
                        render: function(data) {
                            const badgeClass = data === 'active' ? 'status-active' : 'status-inactive';
                            const statusText = data === 'active' ? 'Active' : 'Inactive';
                            return `<span class="status-badge ${badgeClass}">${statusText}</span>`;
                        }
                    },
                    { 
                        data: null,
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-success" onclick="editProject(${row.id})" title="Edit">
                                      <i class="bi bi-pencil-square"></i>

                                    </button>
                                    <button class="btn btn-sm btn-danger delete-project" data-id="${row.id}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ]
            });
        }

        // Load Projects
        function loadProjects() {
            $('#projectsLoading').show();
            
            $.ajax({
                url: "{{ route('admin.projects.get') }}",
                type: "GET",
                success: function(response) {
                    $('#projectsLoading').hide();
                    
                    if (response.success && response.data.length > 0) {
                        projectsTable.clear();
                        projectsTable.rows.add(response.data);
                        projectsTable.draw();
                    } else {
                        projectsTable.clear();
                        projectsTable.draw();
                        projectsTable.row.add({
                            'id': '',
                            'image': '',
                            'title': '<div class="text-center text-muted">No projects found</div>',
                            'slug': '',
                            'status': '',
                            'null': ''
                        }).draw();
                    }
                },
                error: function() {
                    $('#projectsLoading').hide();
                    showAlert('Error loading projects!', 'error');
                }
            });
        }

        function showAddModal() {
            $('#addProjectForm')[0].reset();
            $('#addProjectForm .invalid-feedback').hide();
            $('#addProjectModal').modal('show');
        }
        function addProject(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
            $.ajax({
                url: "{{ route('admin.projects.save') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        $('#addProjectModal').modal('hide');
                        loadProjects();
                        showAlert(response.message, 'success');
                    } else {
                        showAlert(response.message, 'error');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $('#addProjectForm .invalid-feedback').hide();
                        for (const field in errors) {
                            $(`#addProjectForm [name="${field}"]`).addClass('is-invalid')
                                .next('.invalid-feedback').text(errors[field][0]).show();
                        }
                    } else {
                        showAlert('Error saving project!', 'error');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        }
        function editProject(id) {
            $.ajax({
                url: "{{ route('admin.projects.get') }}",
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        const project = response.data.find(p => p.id == id);
                        if (project) {
                            $('#editProjectId').val(project.id);
                            $('#editProjectTitle').val(project.title);
                            $('#editProjectStatus').val(project.status);
                            
                            // Show current image
                            let imageHtml = '';
                            if (project.image) {
                                imageHtml = `
                                    <div>
                                        <p class="mb-1">Current Image:</p>
                                        <img src="/${project.image}" class="project-image" alt="Current Image">
                                    </div>
                                `;
                            } else {
                                imageHtml = '<p class="text-muted">No current image</p>';
                            }
                            $('#currentImageContainer').html(imageHtml);
                            
                            $('#editProjectForm .invalid-feedback').hide();
                            $('#editProjectModal').modal('show');
                        }
                    }
                }
            });
        }

        // Update Project
        function updateProject(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = $('#editProjectId').val();
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
            
            $.ajax({
                url: `/update-project/${id}`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        $('#editProjectModal').modal('hide');
                        loadProjects();
                        showAlert(response.message, 'success');
                    } else {
                        showAlert(response.message, 'error');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        // Handle validation errors
                        $('#editProjectForm .invalid-feedback').hide();
                        for (const field in errors) {
                            $(`#editProjectForm [name="${field}"]`).addClass('is-invalid')
                                .next('.invalid-feedback').text(errors[field][0]).show();
                        }
                    } else {
                        showAlert('Error updating project!', 'error');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        }

        // Delete Project
        function deleteProject(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the project permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            if (response.success) {
                                loadProjects();
                                showAlert(response.message, 'success');
                            } else {
                                showAlert(response.message, 'error');
                            }
                        },
                        error: function() {
                            showAlert('Error deleting project!', 'error');
                        }
                    });
                }
            });
        }

           
            $(document).on('click', '.delete-project', function() {
                if (confirm('Are you sure you want to delete this project?')) {
                    const id = $(this).data('id');
                    $.ajax({
                       url: "/delete-project/" + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        beforeSend: function() {
                            showAlert('Deleting project...', 'info');
                        },
                        success: function(response) {
                            loadProjects();
                            showAlert(response.message);
                        },
                        error: function(xhr) {
                            showAlert('Error deleting project!', 'danger');
                        }
                    });
                }
            });

    </script>
@endpush