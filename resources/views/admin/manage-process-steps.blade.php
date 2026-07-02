@extends('layouts.admin')
@section('title', 'Manage Process Steps')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Manage Process Steps</h4>
            <p class="text-muted mb-0">Edit the "How It Works" steps shown on homepage</p>
        </div>
        <button class="btn btn-primary" onclick="openModal()">
            <i class="bi bi-plus-lg me-2"></i>Add Step
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:80px">Step #</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th style="width:120px">Icon</th>
                        <th style="width:100px">Status</th>
                        <th style="width:140px">Actions</th>
                    </tr>
                </thead>
                <tbody id="stepsBody">
                    <tr><td colspan="6" class="text-center py-4 text-muted">Loading...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="alert alert-info mt-3 border-0">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Icon:</strong> Use Bootstrap Icons class names (e.g. <code>bi-calendar-check</code>, <code>bi-activity</code>, <code>bi-heart-pulse</code>).
        Browse at <a href="https://icons.getbootstrap.com" target="_blank">icons.getbootstrap.com</a>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="stepModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Process Step</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="stepId">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Step Number *</label>
                        <input type="number" class="form-control" id="step_number" min="1" value="1">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-semibold">Step Title *</label>
                        <input type="text" class="form-control" id="title" placeholder="e.g. Book an Appointment">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description *</label>
                    <textarea class="form-control" id="description" rows="3" placeholder="Brief description of this step..."></textarea>
                </div>
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-semibold">Bootstrap Icon Class</label>
                        <div class="input-group">
                            <span class="input-group-text"><i id="iconPreview" class="bi bi-calendar-check"></i></span>
                            <input type="text" class="form-control" id="icon" value="bi-calendar-check"
                                   placeholder="bi-calendar-check"
                                   oninput="document.getElementById('iconPreview').className = 'bi ' + this.value">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="is_active">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveStep()">
                    <i class="bi bi-check-lg me-1"></i>Save Step
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let steps = [];

async function loadSteps() {
    const res  = await fetch('{{ route("admin.processsteps.get") }}');
    const json = await res.json();
    steps = json.data;
    renderTable();
}

function renderTable() {
    const tbody = document.getElementById('stepsBody');
    if (!steps.length) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No steps found. Add process steps!</td></tr>';
        return;
    }
    tbody.innerHTML = steps.map(s => `
        <tr>
            <td><span class="badge bg-primary fs-6">${s.step_number}</span></td>
            <td class="fw-semibold">${s.title}</td>
            <td class="text-muted small">${s.description.substring(0, 80)}...</td>
            <td><i class="bi ${s.icon} me-1 text-primary"></i><code class="small">${s.icon}</code></td>
            <td><span class="badge ${s.is_active ? 'bg-success' : 'bg-secondary'}">${s.is_active ? 'Active' : 'Inactive'}</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary me-1" onclick="editStep(${s.id})"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteStep(${s.id})"><i class="bi bi-trash"></i></button>
            </td>
        </tr>
    `).join('');
}

function openModal(clear = true) {
    if (clear) {
        document.getElementById('stepId').value = '';
        document.getElementById('step_number').value = (steps.length + 1);
        document.getElementById('title').value = '';
        document.getElementById('description').value = '';
        document.getElementById('icon').value = 'bi-calendar-check';
        document.getElementById('iconPreview').className = 'bi bi-calendar-check';
        document.getElementById('is_active').value = '1';
        document.getElementById('modalTitle').textContent = 'Add Process Step';
    }
    new bootstrap.Modal(document.getElementById('stepModal')).show();
}

function editStep(id) {
    const s = steps.find(x => x.id === id);
    if (!s) return;
    document.getElementById('stepId').value = s.id;
    document.getElementById('step_number').value = s.step_number;
    document.getElementById('title').value = s.title;
    document.getElementById('description').value = s.description;
    document.getElementById('icon').value = s.icon;
    document.getElementById('iconPreview').className = 'bi ' + s.icon;
    document.getElementById('is_active').value = s.is_active ? '1' : '0';
    document.getElementById('modalTitle').textContent = 'Edit Step';
    new bootstrap.Modal(document.getElementById('stepModal')).show();
}

async function saveStep() {
    const id = document.getElementById('stepId').value;
    const data = {
        step_number: document.getElementById('step_number').value,
        title:       document.getElementById('title').value.trim(),
        description: document.getElementById('description').value.trim(),
        icon:        document.getElementById('icon').value.trim(),
        is_active:   document.getElementById('is_active').value,
        _token:      '{{ csrf_token() }}'
    };
    if (!data.title || !data.description) { alert('Title and Description required!'); return; }

    const url = id ? `/update-process-step/${id}` : '{{ route("admin.processsteps.store") }}';
    const res  = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });
    const json = await res.json();
    if (json.success) {
        bootstrap.Modal.getInstance(document.getElementById('stepModal')).hide();
        loadSteps();
        showToast(json.message);
    }
}

async function deleteStep(id) {
    if (!confirm('Delete this step?')) return;
    const res  = await fetch(`/delete-process-step/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });
    const json = await res.json();
    if (json.success) { loadSteps(); showToast(json.message); }
}

function showToast(msg) {
    const t = document.createElement('div');
    t.className = 'position-fixed bottom-0 end-0 p-3';
    t.style.zIndex = 9999;
    t.innerHTML = `<div class="toast show align-items-center text-white bg-success border-0"><div class="d-flex"><div class="toast-body">${msg}</div></div></div>`;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 3000);
}

loadSteps();
</script>
@endpush
