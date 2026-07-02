@extends('layouts.admin')
@section('title', 'Admin || Manage Testimonials')

@push('styles')
<style>
    .testimonial-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 8px; background: #f9f9f9; }
    .sortable { min-height: 100px; }
</style>
@endpush

@section('content')
<div class="container pt-3 card">
    <div class="card-body">

        <!-- Background Image -->
        <div class="mb-5 p-4 border rounded bg-light">
            <h5>Testimonial Section Background Image</h5>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img id="bgPreview" src="{{ asset('assets-front/img/choose.jpg') }}" class="img-fluid rounded shadow" style="max-height:300px;">
                </div>
                <div class="col-md-6">
                    <input type="file" id="bgInput" class="form-control" accept="image/*">
                    <button class="btn btn-success mt-2" onclick="uploadBg()">Update Background</button>
                </div>
            </div>
        </div>

        <!-- Add Button & List -->
        <div class="d-flex justify-content-between mb-4">
            <h5>All Testimonials</h5>
            <button class="btn btn-primary" onclick="addNewTestimonial()">
                <i class="fas fa-plus"></i> Add New Testimonial
            </button>
        </div>

        <div id="testimonialsContainer" class="sortable">
            <!-- Testimonials load here -->
        </div>

        <div id="loader" class="text-center my-5" style="display:none;">
            <div class="spinner-border text-primary"></div>
        </div>

    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    const csrf = '{{ csrf_token() }}';

    $(document).ready(function() {
        loadAll();
    });

    function loadAll() {
        $('#loader').show();
        $.get('{{ route("admin.testimonials.data") }}', function(res) {
            $('#loader').hide();
            if (res.success) {
                renderTestimonials(res.testimonials);
                if (res.background_image) {
                    $('#bgPreview').attr('src', '/storage/' + res.background_image);
                }
                initDragSort();
            }
        }).fail(() => {
            $('#loader').hide();
            showAlert('Failed to load data', 'error');
        });
    }

    function renderTestimonials(list) {
        let html = '';
        if (list.length === 0) {
            html = '<p class="text-center text-muted">No testimonials yet.</p>';
        } else {
            list.forEach(t => {
                const stars = '★'.repeat(t.rating) + '☆'.repeat(5 - t.rating);
                const img = t.client_image ? '/storage/' + t.client_image : 'https://cdn-icons-png.flaticon.com/512/149/149071.png';

                html += `
                <div class="testimonial-card" data-id="${t.id}">
                    <div class="row align-items-start">
                        <div class="col-md-2 text-center">
                            <img src="${img}" class="rounded-circle mb-2 client-img" style="width:100px; height:100px; object-fit:cover;">
                            <input type="file" class="form-control form-control-sm mt-2" accept="image/*" onchange="uploadImage(${t.id}, this)">
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control mb-2" value="${t.client_name}" id="name_${t.id}" placeholder="Client Name">
                            <textarea class="form-control mb-2" rows="3" id="message_${t.id}" placeholder="Message">${t.message}</textarea>
                            <select class="form-select mb-2" id="rating_${t.id}">
                                ${[1,2,3,4,5].map(n => `<option ${n==t.rating?'selected':''}>${n}</option>`).join('')}
                            </select>
                            <small class="text-warning d-block mb-2">${stars}</small>
                            
                            <button class="btn btn-success btn-sm" onclick="updateTestimonial(${t.id})">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-danger btn-sm" onclick="deleteTestimonial(${t.id})">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>`;
            });
        }
        $('#testimonialsContainer').html(html);
    }

    // ADD NEW TESTIMONIAL
    function addNewTestimonial() {
        $('#testimonialsContainer').prepend(`
        <div class="testimonial-card border-primary border-3" data-id="new">
            <div class="row align-items-start">
                <div class="col-md-2 text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="rounded-circle mb-2" style="width:100px; height:100px; object-fit:cover;">
                    <input type="file" class="form-control form-control-sm mt-2" accept="image/*" id="new_image">
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control mb-2" id="new_name" placeholder="Client Name">
                    <textarea class="form-control mb-2" rows="3" id="new_message" placeholder="Message"></textarea>
                    <select class="form-select mb-2" id="new_rating">
                        <option value="5" selected>5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <button class="btn btn-success btn-sm" onclick="saveNewTestimonial()">
                        <i class="fas fa-save"></i> Save New
                    </button>
                </div>
            </div>
        </div>`);
    }

    // SAVE NEW TESTIMONIAL
    function saveNewTestimonial() {
        const name = $('#new_name').val().trim();
        const message = $('#new_message').val().trim();
        const rating = $('#new_rating').val();
        const imageFile = $('#new_image')[0].files[0];

        if (!name || !message) {
            showAlert('Please fill client name and message', 'warning');
            return;
        }

        const formData = new FormData();
        formData.append('client_name', name);
        formData.append('message', message);
        formData.append('rating', rating);
        formData.append('_token', csrf);
        if (imageFile) formData.append('client_image', imageFile);

        $.ajax({
            url: '/admin/testimonials',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                showAlert('Testimonial added successfully!', 'success');
                loadAll();
            },
            error: function() {
                showAlert('Failed to add testimonial', 'error');
            }
        });
    }

    function updateTestimonial(id) {
        const name = $(`#name_${id}`).val().trim();
        const message = $(`#message_${id}`).val().trim();
        const rating = $(`#rating_${id}`).val();

        if (!name || !message) {
            showAlert('Please fill client name and message', 'warning');
            return;
        }

        const formData = new FormData();
        formData.append('client_name', name);
        formData.append('message', message);
        formData.append('rating', rating);
        formData.append('_token', csrf);

        $.ajax({
            url: `/admin/testimonials/${id}`,
            type: 'POST', // Just POST
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                showAlert('Testimonial updated!', 'success');
                loadAll();
            },
            error: function() {
                showAlert('Update failed', 'error');
            }
        });
    }

    function uploadImage(id, input) {
        if (!input.files[0]) return;
        
        const formData = new FormData();
        formData.append('client_image', input.files[0]);
        formData.append('_token', csrf);
        // REMOVE: formData.append('_method', 'PUT');

        $.ajax({
            url: `/admin/testimonials/${id}`,
            type: 'POST', // Just POST
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                showAlert('Image updated!', 'success');
                loadAll();
            },
            error: function() {
                showAlert('Failed to update image', 'error');
            }
        });
    }

    function uploadImage(id, input) {
        if (!input.files[0]) return;
        
        const formData = new FormData();
        formData.append('client_image', input.files[0]);
        formData.append('_token', csrf);
        // REMOVE THIS LINE: formData.append('_method', 'PUT');
        
        // Also send other required fields to avoid validation errors
        // Get current values from the form
        const name = $(`#name_${id}`).val().trim();
        const message = $(`#message_${id}`).val().trim();
        const rating = $(`#rating_${id}`).val();
        
        formData.append('client_name', name);
        formData.append('message', message);
        formData.append('rating', rating);

        $.ajax({
            url: `/admin/testimonials/${id}`,
            type: 'POST', // Just POST, no PUT
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                showAlert('Image updated successfully!', 'success');
                loadAll(); // Reload to show new image
            },
            error: function(xhr) {
                console.error(xhr);
                showAlert('Failed to update image', 'error');
            }
        });
    }

    function deleteTestimonial(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the testimonial permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/testimonials/${id}`,
                    type: 'DELETE',
                    data: { _token: csrf },
                    success: () => {
                        showAlert('Deleted successfully!', 'success');
                        loadAll();
                    }
                });
            }
        });
    }

    function uploadBg() {
        const file = $('#bgInput')[0].files[0];
        if (!file) {
            showAlert('Please select an image', 'warning');
            return;
        }

        const formData = new FormData();
        formData.append('background_image', file);
        formData.append('_token', csrf);

        $.ajax({
            url: '{{ route("admin.testimonials.background") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: () => {
                showAlert('Background updated!', 'success');
                loadAll();
            },
            error: () => showAlert('Failed to update background', 'error')
        });
    }

    function initDragSort() {
        if (document.getElementById('testimonialsContainer')._sortable) {
            document.getElementById('testimonialsContainer')._sortable.destroy();
        }
        
        Sortable.create(document.getElementById('testimonialsContainer'), {
            animation: 200,
            onEnd: () => {
                let order = [];
                $('.testimonial-card').each(function() {
                    const id = $(this).data('id');
                    if (id !== 'new') order.push(id);
                });
                
                $.post('{{ route("admin.testimonials.reorder") }}', {
                    order: order,
                    _token: csrf
                });
            }
        });
    }

</script>

@endpush