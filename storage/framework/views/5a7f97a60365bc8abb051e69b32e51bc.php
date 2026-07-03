<?php $__env->startSection('title', 'Admin || Manage About Us Section'); ?>
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <style>
        .spinner-container { display:flex;justify-content:center;align-items:center;height:120px; }
        .spinner { width:3rem;height:3rem;border:3px solid #f3f3f3;border-top:3px solid #3498db;border-radius:50%;animation:spin 1s linear infinite; }
        @keyframes spin { 0%{transform:rotate(0deg);} 100%{transform:rotate(360deg);} }
        .value-card-box { border:1px solid #dee2e6;border-radius:8px;padding:16px;margin-bottom:12px;background:#f8f9fa; }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('page', 'Manage About Us Section'); ?>

<div class="container pt-3 card">
    <div class="card-body">
        <form id="updateAboutForm" class="row g-4">
            <?php echo csrf_field(); ?>
            <div class="col-md-4">
                <label class="form-label">Sub Title</label>
                <input type="text" class="form-control" name="sub_title" id="sub_title" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Title Line 1</label>
                <input type="text" class="form-control" name="title_line1" id="title_line1" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Title Line 2</label>
                <input type="text" class="form-control" name="title_line2" id="title_line2" required>
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="6" required></textarea>
            </div>

            <div class="col-12">
                <label class="form-label">Quote Text (shown as an italic highlighted quote on the About page)</label>
                <textarea class="form-control" name="quote_text" id="quote_text" rows="2" maxlength="500" placeholder="e.g. True healing comes from more than treatments — it is built on trust, patience, and compassion."></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Doctor / Therapist Name</label>
                <input type="text" class="form-control" name="doctor_name" id="doctor_name" placeholder="e.g. Dr. Ankit Agrawal PT">
                <small class="text-muted">Shown next to the signature image. Leave blank to use the short company name instead.</small>
            </div>
            <div class="col-md-6">
                <label class="form-label">Qualification / Credentials</label>
                <input type="text" class="form-control" name="doctor_qualification" id="doctor_qualification" placeholder="e.g. BPT · MPT · COMT · CKT">
            </div>

            <div class="col-md-4">
                <label class="form-label">Button Text</label>
                <input type="text" class="form-control" name="button_text" id="button_text" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Button Link</label>
                <input type="text" class="form-control" name="button_link" id="button_link" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Current Logo Image</label>
                <div id="currentLogoPreview" class="mb-2"></div>
                <input type="file" class="form-control" name="logo_image" accept="image/*">
                <small class="text-muted">Optional. Shown next to the doctor signature.</small>
            </div>

            <div class="col-md-4">
                <label class="form-label">Current Main Image</label>
                <div id="currentCenterPreview" class="mb-2"></div>
                <input type="file" class="form-control" name="center_image" accept="image/*">
                <small class="text-muted">Optional. Large image on the About page.</small>
            </div>

            <div class="col-md-4">
                <label class="form-label">Current Small (Overlay) Image</label>
                <div id="currentSmallPreview" class="mb-2"></div>
                <input type="file" class="form-control" name="small_image" accept="image/*">
                <small class="text-muted">Optional. Small overlapping image next to the main image.</small>
            </div>

            <div class="col-12">
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Our Values (Mission / Vision / Approach — up to 3 cards)</label>
                </div>
                <div id="valuesContainer"></div>
                <small class="text-muted">Used on the About page's "Our Values" section. Leave a card's title blank to skip it.</small>
            </div>

            <div class="col-12">
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Feature Boxes (the 4 small icon boxes on the homepage About section)</label>
                </div>
                <div id="featuresContainer"></div>
                <small class="text-muted">Leave a box's title blank to skip it.</small>
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary btn-lg">
                    Update About Section
                </button>
            </div>
        </form>

        <div id="aboutLoading" class="spinner-container mt-4" style="display:none;">
            <div class="spinner"></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    const valueDefaults = [
        { icon: 'bullseye', title: 'Our Mission', description: '' },
        { icon: 'lightbulb', title: 'Our Vision', description: '' },
        { icon: 'compass', title: 'Our Approach', description: '' },
    ];

    const featureDefaults = [
        { icon: 'shield-check', title: 'Certified Therapists', description: 'BPT, MPT, COMT qualified professionals' },
        { icon: 'clock', title: '24×7 Availability', description: 'Always here when you need us most' },
        { icon: 'heart-pulse', title: 'Personalized Plans', description: 'Treatment tailored to your condition' },
        { icon: 'cpu', title: 'Modern Equipment', description: 'Advanced tools for precise care' },
    ];

    $(document).ready(function() {
        renderValueCards(valueDefaults);
        renderFeatureCards(featureDefaults);
        loadAbout();
        $('#updateAboutForm').submit(updateAbout);
    });

    function renderValueCards(values) {
        let html = '';
        for (let i = 0; i < 3; i++) {
            let v = values[i] || { icon: '', title: '', description: '' };
            html += `
                <div class="value-card-box">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="form-label small">Icon (Bootstrap Icon name)</label>
                            <input type="text" class="form-control form-control-sm" name="values[${i}][icon]" value="${escapeHtml(v.icon || '')}" placeholder="e.g. bullseye">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Title</label>
                            <input type="text" class="form-control form-control-sm" name="values[${i}][title]" value="${escapeHtml(v.title || '')}" placeholder="e.g. Our Mission">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Description</label>
                            <input type="text" class="form-control form-control-sm" name="values[${i}][description]" value="${escapeHtml(v.description || '')}" placeholder="Short description">
                        </div>
                    </div>
                </div>
            `;
        }
        $('#valuesContainer').html(html);
    }

    function renderFeatureCards(features) {
        let html = '';
        for (let i = 0; i < 4; i++) {
            let f = features[i] || { icon: '', title: '', description: '' };
            html += `
                <div class="value-card-box">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="form-label small">Icon (Bootstrap Icon name)</label>
                            <input type="text" class="form-control form-control-sm" name="features[${i}][icon]" value="${escapeHtml(f.icon || '')}" placeholder="e.g. shield-check">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Title</label>
                            <input type="text" class="form-control form-control-sm" name="features[${i}][title]" value="${escapeHtml(f.title || '')}" placeholder="e.g. Certified Therapists">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Description</label>
                            <input type="text" class="form-control form-control-sm" name="features[${i}][description]" value="${escapeHtml(f.description || '')}" placeholder="Short description">
                        </div>
                    </div>
                </div>
            `;
        }
        $('#featuresContainer').html(html);
    }

    function escapeHtml(str) {
        return $('<div>').text(str).html();
    }

    function loadAbout() {
        $('#aboutLoading').show();
        $.ajax({
            url: "<?php echo e(route('admin.about.get')); ?>",
            type: "GET",
            success: function(res) {
                $('#aboutLoading').hide();
                if (res.success && res.data) {
                    let about = res.data;
                    $('#sub_title').val(about.sub_title);
                    $('#title_line1').val(about.title_line1);
                    $('#title_line2').val(about.title_line2);
                    $('#description').val(about.description);
                    $('#quote_text').val(about.quote_text);
                    $('#doctor_name').val(about.doctor_name);
                    $('#doctor_qualification').val(about.doctor_qualification);
                    $('#button_text').val(about.button_text);
                    $('#button_link').val(about.button_link);

                    renderValueCards((about.values && about.values.length) ? about.values : valueDefaults);
                    renderFeatureCards((about.features && about.features.length) ? about.features : featureDefaults);

                    // Preview images
                    let logoHtml = about.logo_image
                        ? `<img src="/storage/${about.logo_image}" class="img-fluid rounded" style="max-height:140px;">`
                        : '<p class="text-muted mb-0">No logo uploaded</p>';
                    $('#currentLogoPreview').html(logoHtml);

                    let centerHtml = about.center_image
                        ? `<img src="/storage/${about.center_image}" class="img-fluid rounded" style="max-height:200px;">`
                        : '<p class="text-muted mb-0">No main image uploaded</p>';
                    $('#currentCenterPreview').html(centerHtml);

                    let smallHtml = about.small_image
                        ? `<img src="/storage/${about.small_image}" class="img-fluid rounded" style="max-height:140px;">`
                        : '<p class="text-muted mb-0">No small image uploaded</p>';
                    $('#currentSmallPreview').html(smallHtml);
                } else {
                    Swal.fire('No data found', 'Fill the form and update to create the About section.', 'info');
                }
            },
            error: function() {
                $('#aboutLoading').hide();
                Swal.fire('Error', 'Could not load About section data', 'error');
            }
        });
    }

    function updateAbout(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let btn = $(this).find('button[type="submit"]');
        let original = btn.html();
        btn.prop('disabled', true).html('Updating...');

        $.ajax({
            url: "<?php echo e(route('admin.about.update')); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(res) {
                if (res.success) {
                    loadAbout();
                    Swal.fire('Success', res.message, 'success');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    Swal.fire('Validation Error', 'Please check the form fields', 'warning');
                } else {
                    Swal.fire('Error', 'Error updating section!', 'error');
                }
            },
            complete: function() {
                btn.prop('disabled', false).html(original);
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dr_deepak_pal\resources\views/admin/manage-homeabout-sections.blade.php ENDPATH**/ ?>