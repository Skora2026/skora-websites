@extends('layouts.admin')
@section('title', 'Admin || Manage Why Choose Us Section')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
@section('page', 'Manage Why Choose Us Section')

<div class="container pt-3 card">
    <div class="card-body">
        <form id="updateWhyForm">
            @csrf
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Sub Title</label>
                    <input type="text" class="form-control" name="sub_title" id="sub_title" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Main Title</label>
                    <input type="text" class="form-control" name="main_title" id="main_title" required>
                </div>
            </div>

            <h6 class="mb-3">Features (Add up to 10)</h6>
            <div id="featuresContainer">
                <!-- Dynamic features will be loaded here -->
            </div>

            <div class="text-end mb-3">
                <button type="button" class="btn btn-sm btn-secondary" onclick="addFeature()">+ Add Feature</button>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <label class="form-label">Current Right Side Image</label>
                    <div id="currentImagePreview" class="mb-3"></div>
                    <input type="file" class="form-control" name="right_image" accept="image/*">
                    <small class="text-muted">Upload new image (optional)</small>
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary btn-lg">Update Section</button>
                </div>
            </div>
        </form>

        <div id="sectionLoading" class="spinner-container mt-4">
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
    let features = [];
    let featureIndex = 0; // To ensure unique indices

    $(document).ready(function() {
        loadSection();
        $('#updateWhyForm').submit(updateSection);
    });

    function loadSection() {
        $('#sectionLoading').show();
        $.ajax({
            url: "{{ route('admin.whychooseus.get') }}",
            type: "GET",
            success: function(res) {
                $('#sectionLoading').hide();
                if (res.success && res.data) {
                    let section = res.data;
                    $('#sub_title').val(section.sub_title);
                    $('#main_title').val(section.main_title);
                    features = section.features || [];

                    featureIndex = features.length;
                    renderFeatures();

                    let imgHtml = section.right_image 
                        ? `<img src="/storage/${section.right_image}" class="img-fluid rounded shadow" style="max-height:500px;">`
                        : '<p class="text-muted">No image uploaded</p>';
                    $('#currentImagePreview').html(imgHtml);
                } else {
                    features = [];
                    renderFeatures();
                    showAlert('No data found. Fill and update to create.', 'info');
                }
            },
            error: function() {
                $('#sectionLoading').hide();
                showAlert('Error loading section!', 'error');
            }
        });
    }

    function renderFeatures() {
        let html = '';
        features.forEach((feature, index) => {
            html += `
                <div class="row g-3 mb-3 feature-row" data-index="${index}">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="features[${index}][title]" value="${feature.title || ''}" placeholder="Feature Title" required>
                    </div>
                    <div class="col-md-6">
                        <textarea class="form-control" name="features[${index}][description]" rows="2" placeholder="Description" required>${feature.description || ''}</textarea>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeFeature(${index})">Remove</button>
                    </div>
                </div>`;
        });
        $('#featuresContainer').html(html);
    }

    function collectFeatures() {
        let newFeatures = [];
        $('.feature-row').each(function() {
            let title = $(this).find('input[name^="features"][name$="[title]"]').val();
            let desc = $(this).find('textarea[name^="features"][name$="[description]"]').val();
            newFeatures.push({ title, description: desc });
        });
        features = newFeatures;
    }

    function addFeature() {
        collectFeatures();

        if (features.length >= 10) {
            showAlert('Maximum 10 features allowed!', 'warning');
            return;
        }

        features.push({ title: '', description: '' });
        featureIndex++;
        renderFeatures();
    }

    function removeFeature(index) {
        collectFeatures();

        features.splice(index, 1);
        renderFeatures();
    }

    function updateSection(e) {
        e.preventDefault();
        collectFeatures();

        let formData = new FormData(this);

        let btn = $(this).find('button[type="submit"]');
        let original = btn.html();
        btn.prop('disabled', true).html('Updating...');

        $.ajax({
            url: "{{ route('admin.whychooseus.update') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(res) {
                if (res.success) {
                    loadSection();
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