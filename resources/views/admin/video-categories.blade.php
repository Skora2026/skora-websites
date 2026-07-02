@extends('layouts.admin')

@section('title','Manage Video Categories')
@section('page','Video Categories')

@section('content')
<div class="container-fluid">

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Video Categories List</h5>
            <button class="btn btn-primary btn-sm" id="addCategoryBtn"><i class="bi bi-plus"></i> Add Category</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped w-100" id="categoriesTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Videos</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="categoryForm">
                    @csrf
                    <input type="hidden" id="categoryId">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            <div class="invalid-feedback name-error"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status *</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    let table = $('#categoriesTable').DataTable({
        ajax: { url: '{{ route("admin.video-categories.get") }}', dataSrc: 'data' },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'videos_count', defaultContent: 0 },
            {
                data: 'status',
                render: data => `<span class="badge ${data === 'active' ? 'bg-success' : 'bg-secondary'}">${data.charAt(0).toUpperCase()+data.slice(1)}</span>`
            },
            {
                data: null,
                orderable: false,
                render: function(d){
                    return `
                        <button class="btn btn-sm btn-success editCategory" data-id="${d.id}"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn btn-sm btn-danger deleteCategory" data-id="${d.id}"><i class="bi bi-trash"></i></button>
                    `;
                }
            }
        ]
    });

    $('#addCategoryBtn').click(function(){
        resetForm();
        $('#categoryModal .modal-title').text('Add Category');
        $('#categoryModal').modal('show');
    });

    $('#categoryForm').submit(function(e){
        e.preventDefault();
        let id = $('#categoryId').val();
        let url = id ? `/admin/video-categories/update/${id}` : '{{ route("admin.video-categories.store") }}';
        $.ajax({
            url, method: 'POST', data: $(this).serialize(),
            success: function(res){
                if(res.success){
                    $('#categoryModal').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Success', res.message, 'success');
                }
            },
            error: function(xhr){
                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    clearErrors();
                    $.each(errors, (field, msgs) => {
                        $(`[name="${field}"]`).addClass('is-invalid');
                        $(`.${field.replace(/_/g,'-')}-error`).text(msgs[0]);
                    });
                } else {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            }
        });
    });

    $('#categoriesTable').on('click','.editCategory', function(){
        let id = $(this).data('id');
        $.get('{{ route("admin.video-categories.get") }}', function(res){
            let category = res.data.find(c => c.id == id);
            if(category){
                resetForm();
                $('#categoryId').val(category.id);
                $('#name').val(category.name);
                $('#sort_order').val(category.sort_order);
                $('#status').val(category.status);
                $('#categoryModal .modal-title').text('Edit Category');
                $('#categoryModal').modal('show');
            }
        });
    });

    $('#categoriesTable').on('click','.deleteCategory', function(){
        let id = $(this).data('id');
        Swal.fire({
            title: 'Delete this category?', icon: 'warning', showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then(result => {
            if(result.isConfirmed){
                $.ajax({
                    url: `/admin/video-categories/destroy/${id}`,
                    type: 'DELETE',
                    data: { _token: csrfToken },
                    success: function(res){
                        if(res.success){ table.ajax.reload(); Swal.fire('Deleted!', res.message, 'success'); }
                        else Swal.fire('Cannot Delete', res.message, 'warning');
                    },
                    error: function(xhr){
                        Swal.fire('Cannot Delete', xhr.responseJSON?.message || 'Something went wrong', 'warning');
                    }
                });
            }
        });
    });

    function resetForm(){
        $('#categoryForm')[0].reset();
        $('#categoryId').val('');
        clearErrors();
    }

    function clearErrors(){
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    }
});
</script>
@endpush
