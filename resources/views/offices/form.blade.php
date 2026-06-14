<div class="mb-3">
    <label>Office Code</label>
    <input type="text"
           name="office_code"
           class="form-control"
           value="{{ old('office_code', $office->office_code ?? '') }}">
</div>

<div class="mb-3">
    <label>Office Name</label>
    <input type="text"
           name="office_name"
           class="form-control"
           value="{{ old('office_name', $office->office_name ?? '') }}">
</div>

<div class="mb-3">
    <label>Office Type</label>
    <select name="office_type" class="form-control">
        <option value="">Select</option>
        <option value="central">Central</option>
        <option value="regional">Regional</option>
        <option value="division">Division</option>
        <option value="section">Section</option>
    </select>
</div>

<div class="mb-3">
    <label>Parent Office</label>
    <select name="parent_office_id" class="form-control">
        <option value="">None</option>

        @foreach($parentOffices as $parent)
            <option value="{{ $parent->id }}">
                {{ $parent->office_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-check">
    <input type="checkbox"
           name="is_active"
           value="1"
           class="form-check-input"
           checked>

    <label class="form-check-label">
        Active
    </label>
</div>