@extends('layouts.admin')
@section('title', 'Manage FAQs')

@section('content')
<div class="container-fluid py-4">

    <!-- Section Heading Editor -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">FAQ Section Heading <span class="text-muted small">(shown above the FAQ list on the website)</span></h6>
            <form id="faqSectionForm" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small">Sub Title</label>
                    <input type="text" class="form-control" id="faqSubTitle" placeholder="e.g. Got Questions?" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Main Title</label>
                    <input type="text" class="form-control" id="faqMainTitle" placeholder="e.g. Frequently Asked &lt;span&gt;Questions&lt;/span&gt;" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Manage FAQs</h4>
            <p class="text-muted mb-0">Add, edit, or remove FAQ questions shown on homepage</p>
        </div>
        <button class="btn btn-primary" onclick="openModal()">
            <i class="bi bi-plus-lg me-2"></i>Add FAQ
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0" id="faqTable">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px">#</th>
                        <th>Question</th>
                        <th style="width:100px">Order</th>
                        <th style="width:100px">Status</th>
                        <th style="width:140px">Actions</th>
                    </tr>
                </thead>
                <tbody id="faqBody">
                    <tr><td colspan="5" class="text-center py-4 text-muted">Loading...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="faqModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="faqId">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Question *</label>
                    <input type="text" class="form-control" id="question" placeholder="Enter FAQ question">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Answer *</label>
                    <textarea class="form-control" id="answer" rows="4" placeholder="Enter detailed answer"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" class="form-control" id="sort_order" value="0" min="0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="is_active">
                            <option value="1">Active (Visible)</option>
                            <option value="0">Inactive (Hidden)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveFaq()">
                    <i class="bi bi-check-lg me-1"></i>Save FAQ
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let faqs = [];

async function loadFaqs() {
    const res = await fetch('{{ route("admin.faqs.get") }}');
    const json = await res.json();
    faqs = json.data;
    renderTable();
}

function renderTable() {
    const tbody = document.getElementById('faqBody');
    if (!faqs.length) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-muted">No FAQs found. Add your first FAQ!</td></tr>';
        return;
    }
    tbody.innerHTML = faqs.map((f, i) => `
        <tr>
            <td class="text-muted">${i + 1}</td>
            <td><span class="fw-semibold">${f.question}</span>
                <div class="text-muted small mt-1">${f.answer.substring(0, 80)}...</div>
            </td>
            <td><span class="badge bg-light text-dark border">${f.sort_order}</span></td>
            <td>
                <span class="badge ${f.is_active ? 'bg-success' : 'bg-secondary'}">
                    ${f.is_active ? 'Active' : 'Inactive'}
                </span>
            </td>
            <td>
                <button class="btn btn-sm btn-outline-primary me-1" onclick="editFaq(${f.id})">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteFaq(${f.id})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

function openModal(clear = true) {
    if (clear) {
        document.getElementById('faqId').value = '';
        document.getElementById('question').value = '';
        document.getElementById('answer').value = '';
        document.getElementById('sort_order').value = faqs.length;
        document.getElementById('is_active').value = '1';
        document.getElementById('modalTitle').textContent = 'Add FAQ';
    }
    new bootstrap.Modal(document.getElementById('faqModal')).show();
}

function editFaq(id) {
    const f = faqs.find(x => x.id === id);
    if (!f) return;
    document.getElementById('faqId').value = f.id;
    document.getElementById('question').value = f.question;
    document.getElementById('answer').value = f.answer;
    document.getElementById('sort_order').value = f.sort_order;
    document.getElementById('is_active').value = f.is_active ? '1' : '0';
    document.getElementById('modalTitle').textContent = 'Edit FAQ';
    new bootstrap.Modal(document.getElementById('faqModal')).show();
}

async function saveFaq() {
    const id = document.getElementById('faqId').value;
    const data = {
        question:   document.getElementById('question').value.trim(),
        answer:     document.getElementById('answer').value.trim(),
        sort_order: document.getElementById('sort_order').value,
        is_active:  document.getElementById('is_active').value,
        _token:     '{{ csrf_token() }}'
    };

    if (!data.question || !data.answer) {
        alert('Question and Answer are required!'); return;
    }

    const url = id
        ? `/update-faq/${id}`
        : '{{ route("admin.faqs.store") }}';

    const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });

    const json = await res.json();
    if (json.success) {
        bootstrap.Modal.getInstance(document.getElementById('faqModal')).hide();
        loadFaqs();
        showToast(json.message);
    }
}

async function deleteFaq(id) {
    if (!confirm('Delete this FAQ? This cannot be undone.')) return;
    const res = await fetch(`/delete-faq/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
    });
    const json = await res.json();
    if (json.success) { loadFaqs(); showToast(json.message); }
}

function showToast(msg) {
    const t = document.createElement('div');
    t.className = 'position-fixed bottom-0 end-0 p-3';
    t.style.zIndex = 9999;
    t.innerHTML = `<div class="toast show align-items-center text-white bg-success border-0">
        <div class="d-flex"><div class="toast-body">${msg}</div></div></div>`;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 3000);
}

async function loadFaqSection() {
    const res = await fetch('{{ route("admin.faq-section.get") }}');
    const json = await res.json();
    if (json.success && json.data) {
        document.getElementById('faqSubTitle').value = json.data.sub_title || '';
        document.getElementById('faqMainTitle').value = json.data.main_title || '';
    } else {
        document.getElementById('faqSubTitle').value = 'Got Questions?';
        document.getElementById('faqMainTitle').value = 'Frequently Asked Questions';
    }
}

document.getElementById('faqSectionForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const res = await fetch('{{ route("admin.faq-section.update") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
        body: JSON.stringify({
            sub_title: document.getElementById('faqSubTitle').value,
            main_title: document.getElementById('faqMainTitle').value,
        })
    });
    const json = await res.json();
    if (json.success) showToast(json.message);
});

loadFaqSection();
loadFaqs();
</script>
@endpush
