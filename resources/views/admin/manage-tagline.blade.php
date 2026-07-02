@extends('layouts.admin')
@section('title', 'Admin || Manage Call to Action Section')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
@section('page', 'Manage Tagline Section')

<div class="container pt-3 card">
    <div class="card-body">
        <form id="updateCtaForm" class="row g-4">
            @csrf

            <div class="col-12">
                <label class="form-label">Main Heading *</label>
                <input type="text" class="form-control" name="heading" id="heading" required>
            </div>

            <div class="col-12">
                <label class="form-label">Description *</label>
                <textarea class="form-control" name="description" id="description" rows="5" required></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Button Text</label>
                <input type="text" class="form-control" name="button_text" id="button_text" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Button Link</label>
                <input type="text" class="form-control" name="button_link" id="button_link" placeholder="e.g. /about or https://..." required>
            </div>

            <div class="col-12">
                <label class="form-label">Current Background Image</label>
                <div id="currentBgPreview" class="mb-3"></div>
                <input type="file" class="form-control" name="background_image" accept="image/*">
                <small class="text-muted">Upload new background image (optional)</small>
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary btn-lg">
                    Update Section
                </button>
            </div>
        </form>

        <div id="ctaLoading" class="spinner-container mt-4">
            <div class="spinner"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function() {
        loadCta();
        $('#updateCtaForm').submit(updateCta);
    });

    function loadCta() {
        $('#ctaLoading').show();
        $.ajax({
            url: "{{ route('admin.cta.get') }}",
            type: "GET",
            success: function(res) {
                $('#ctaLoading').hide();
                if (res.success && res.data) {
                    let cta = res.data;
                    $('#heading').val(cta.heading);
                    $('#description').val(cta.description);
                    $('#button_text').val(cta.button_text);
                    $('#button_link').val(cta.button_link);

                    let imgHtml = cta.background_image 
                        ? `<img src="/storage/${cta.background_image}" class="img-fluid rounded" style="max-height:400px; width:100%; object-fit:cover;">`
                        : '<p class="text-muted">No background image uploaded</p>';
                    $('#currentBgPreview').html(imgHtml);
                } else {
                    showAlert('No data found. Fill and save to create one.', 'info');
                }
            },
            error: function() {
                $('#ctaLoading').hide();
                showAlert('Error loading data!', 'error');
            }
        });
    }

    function updateCta(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let btn = $(this).find('button[type="submit"]');
        let original = btn.html();
        btn.prop('disabled', true).html('Updating...');

        $.ajax({
            url: "{{ route('admin.cta.update') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(res) {
                if (res.success) {
                    loadCta();
                    showAlert(res.message, 'success');
                }
            },
            error: function() {
                showAlert('Error updating section!', 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html(original);
            }
        });
    }
</script>
@endpush