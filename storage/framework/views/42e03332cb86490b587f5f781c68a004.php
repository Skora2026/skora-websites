<?php $__env->startSection('title', 'Manage Hero Banner'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Hero Banner</h4>
            <p class="text-muted mb-0">Manage the main homepage banner content</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form id="bannerForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Main Heading *</label>
                        <input type="text" class="form-control" name="heading" id="heading"
                               placeholder="e.g. Move Without Pain." required>
                        <small class="text-muted">First line of hero heading</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Sub Heading</label>
                        <input type="text" class="form-control" name="subheading" id="subheading"
                               placeholder="e.g. Live Without Limits.">
                        <small class="text-muted">Second line (shown in brand color)</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"
                                  placeholder="Short description shown below the heading..."></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Top Badge Text <small class="text-muted">(small pill above the heading)</small></label>
                        <input type="text" class="form-control" name="badge_text" id="badge_text"
                               placeholder="e.g. P2GH — 24×7 Physiotherapy">
                        <small class="text-muted">Leave blank to use "[Company Short Name] — 24×7 Physiotherapy".</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Floating Card — Title <small class="text-muted">(card on the right side of the banner)</small></label>
                        <input type="text" class="form-control" name="floating_title" id="floating_title"
                               placeholder="e.g. Expert Therapists">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Floating Card — Subtitle</label>
                        <input type="text" class="form-control" name="floating_subtitle" id="floating_subtitle"
                               placeholder="e.g. BPT · MPT · COMT certified">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Primary Button Text</label>
                        <input type="text" class="form-control" name="btn_text" id="btn_text"
                               placeholder="Book Appointment">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Secondary Button Text</label>
                        <input type="text" class="form-control" name="btn2_text" id="btn2_text"
                               placeholder="Explore Services">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Ticker Text <small class="text-muted">(separate with ||)</small></label>
                        <input type="text" class="form-control" name="move_text" id="move_text"
                               placeholder="Sports Injury || Post-Surgery Recovery || Neurological Therapy">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Background Image</label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*"
                               onchange="previewImg(this)">
                        <small class="text-muted">Recommended: 1920x1080px, JPG/PNG/WebP</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Current Image</label>
                        <div id="imgPreview" class="border rounded p-2 text-center" style="min-height:80px;">
                            <span class="text-muted small">Loading...</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-2"></i>Update Banner
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('imgPreview').innerHTML =
                `<img src="${e.target.result}" class="img-fluid rounded" style="max-height:120px;">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

async function loadBanner() {
    const res  = await fetch('<?php echo e(route("admin.herobanners.get")); ?>');
    const json = await res.json();
    if (json.success && json.data) {
        const b = json.data;
        document.getElementById('heading').value     = b.heading    || b.title || '';
        document.getElementById('subheading').value  = b.subheading || '';
        document.getElementById('description').value = b.description|| '';
        document.getElementById('badge_text').value   = b.badge_text || '';
        document.getElementById('floating_title').value    = b.floating_title || '';
        document.getElementById('floating_subtitle').value = b.floating_subtitle || '';
        document.getElementById('btn_text').value    = b.btn_text   || 'Book Appointment';
        document.getElementById('btn2_text').value   = b.btn2_text  || 'Explore Services';
        document.getElementById('move_text').value   = b.move_text  || '';
        document.getElementById('imgPreview').innerHTML = b.image
            ? `<img src="/storage/${b.image}" class="img-fluid rounded" style="max-height:120px;">`
            : '<span class="text-muted small">No image uploaded</span>';
    }
}

document.getElementById('bannerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Saving...';

    const formData = new FormData(this);
    const res = await fetch('<?php echo e(route("admin.herobanners.update")); ?>', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
        body: formData
    });
    const json = await res.json();

    btn.disabled = false;
    btn.innerHTML = '<i class="bi bi-save me-2"></i>Update Banner';

    if (json.success) {
        loadBanner();
        showToast(json.message, 'success');
    } else {
        showToast(json.message || 'Error updating banner!', 'danger');
    }
});

function showToast(msg, type = 'success') {
    const t = document.createElement('div');
    t.className = 'position-fixed bottom-0 end-0 p-3';
    t.style.zIndex = 9999;
    t.innerHTML = `<div class="toast show text-white bg-${type} border-0 rounded">
        <div class="d-flex"><div class="toast-body">${msg}</div></div></div>`;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 3000);
}

loadBanner();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dr_deepak_pal\resources\views/admin/manage-herosection.blade.php ENDPATH**/ ?>