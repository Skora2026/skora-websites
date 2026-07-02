@extends('layouts.admin')

@section('title','Manage Service Categories')
@section('page','Service Categories')

@section('content')
<div class="container-fluid">

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Service Categories List</h5>
            <button class="btn btn-primary btn-sm" id="addCategoryBtn">Add Category</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="categoriesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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
                            <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){

    let table = $('#categoriesTable').DataTable({
        ajax: '{{ route("admin.service-categories.get") }}',
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'status' },
            { 
                data: null,
                render: function(d){
                    return `
                        <button class="btn btn-sm btn-primary editCategory" data-id="${d.id}">Edit</button>
                        <button class="btn btn-sm btn-danger deleteCategory" data-id="${d.id}">Delete</button>
                    `;
                }
            }
        ]
    });

    // Add Category
    $('#addCategoryBtn').click(function(){
        $('#categoryForm')[0].reset();
        $('#categoryId').val('');
        $('#categoryModal .modal-title').text('Add Category');
        $('#categoryModal').modal('show');
    });

    // Submit Form
    $('#categoryForm').submit(function(e){
        e.preventDefault();
        let id = $('#categoryId').val();
        let url = id ? `/admin/service-categories/update/${id}` : '{{ route("admin.service-categories.store") }}';
        $.ajax({
            url: url,
            method: 'POST',
            data: $(this).serialize(),
            success:function(res){
                if(res.success){
                    $('#categoryModal').modal('hide');
                    table.ajax.reload();
                    alert(res.message);
                } else {
                    alert('Validation error');
                }
            }
        });
    });

    // Edit Category
    $('#categoriesTable').on('click','.editCategory', function(){
        let id = $(this).data('id');
        $.get(`/admin/service-categories/get`, function(res){
            let category = res.data.find(c => c.id == id);
            if(category){
                $('#categoryId').val(category.id);
                $('#name').val(category.name);
                $('#status').val(category.status);
                $('#categoryModal .modal-title').text('Edit Category');
                $('#categoryModal').modal('show');
            }
        });
    });

    // Delete Category
    $('#categoriesTable').on('click','.deleteCategory', function(){
        if(confirm('Are you sure?')){
            let id = $(this).data('id');
            $.ajax({
                url:`/admin/service-categories/destroy/${id}`,
                type:'DELETE',
                data:{ _token: '{{ csrf_token() }}' },
                success:function(res){
                    if(res.success){
                        table.ajax.reload();
                        alert(res.message);
                    }
                }
            });
        }
    });

});
</script>
@endpush
