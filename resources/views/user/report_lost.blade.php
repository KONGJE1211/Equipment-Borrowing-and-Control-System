@extends('user.layouts.app')

@section('content')
<style>
/* Main card styling */
.report-card {
    max-width: 700px;
    margin: 0 auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Form labels */
.report-card label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

/* Input & textarea styling */
.report-card select, .report-card textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #bbb;
    border-radius: 8px;
    margin-bottom: 15px;
}

/* Submit Button */
.btn-submit {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(135deg,#007BFF,#0048BA);
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.btn-submit:hover {
    background: linear-gradient(135deg,#0048BA,#002c73);
}

/* Preview image box */
#equipPreview {
    display: none;
    width: 200px;
    border-radius: 10px;
    margin-bottom: 15px;
    border: 2px solid #333;
}
</style>

<h2 style="text-align:center; font-weight:bold; margin-bottom:20px;">
    📢 Report Lost Equipment
</h2>

<div class="report-card">

    <form action="{{ route('user.submitLostReport') }}" method="POST">
        @csrf

        <label>🛠 Select Equipment:</label>
        <select name="equipment_id" class="form-control" required>
    <option value="">-- Select Equipment --</option>
    @foreach ($equipments as $eq)
        @php
            $disabled = in_array($eq->id, $reportedEquipmentIds);
        @endphp
        <option value="{{ $eq->id }}" {{ $disabled ? 'disabled' : '' }}>
            {{ $eq->name }}
            @if($disabled) (Already Reported) @endif
        </option>
    @endforeach
</select>


        <img id="equipPreview" alt="Equipment Preview">

        <label>📝 Description (What happened?):</label>
        <textarea name="description" rows="4" required placeholder="Describe how you lost the equipment..."></textarea>

        <button type="submit" class="btn-submit">🚀 Submit Lost Report</button>
    </form>
</div>

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    title: 'Report Submitted!',
    text: '{{ session('success') }}',
    icon: 'success',
    confirmButtonColor: '#007BFF'
});
</script>
@endif

<script>
document.getElementById('equipmentSelect').addEventListener('change', function() {
    let imgUrl = this.options[this.selectedIndex].getAttribute('data-img');
    const preview = document.getElementById('equipPreview');

    if(imgUrl){
        preview.src = imgUrl;
        preview.style.display = "block";
    } else {
        preview.style.display = "none";
    }
});
</script>

@endsection
