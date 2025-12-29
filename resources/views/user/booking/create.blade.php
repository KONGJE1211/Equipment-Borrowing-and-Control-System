@extends('user.layouts.app')

@section('content')
<style>
    .booking-card{
        max-width:850px;margin:auto;background:#fff;padding:25px;border-radius:12px;
        box-shadow:0 4px 12px rgba(0,0,0,0.1);color:#333;font-family:Poppins, sans-serif;
    }
    .booking-card h2{margin-bottom:20px;border-bottom:2px solid #007bff;padding-bottom:10px;}
    .booking-card label{display:block;font-weight:600;margin-bottom:5px;}
    .booking-card input, .booking-card select{
        width:100%;padding:10px;border:1px solid #ccc;border-radius:8px;margin-bottom:15px;
    }
    .submit-btn{
        background:#007bff;color:#fff;border:none;padding:12px 20px;border-radius:8px;
        cursor:pointer;font-weight:600;width:100%;transition:.3s;
    }
    .submit-btn:hover{background:#0056b3;}
</style>

<div class="booking-card">
<h2>📌 Create Booking (Only 1 Day Allowed)</h2>

@if(session('error')) <div style="color:red;margin-bottom:10px">{{ session('error') }}</div> @endif
@if(session('success')) <div style="color:green;margin-bottom:10px">{{ session('success') }}</div> @endif

<form method="POST" action="{{ url('/booking') }}">
  @csrf

  <label>Name:</label>
  <input type="text" value="{{ $user->name }}" readonly>

  <label>Email:</label>
  <input type="text" value="{{ $user->email }}" readonly>

  <label>Student ID:</label>
  <input type="text" value="{{ $user->student_id }}" readonly>

  <label>Equipment:</label>
  <select name="equipment_id" required>
      <option value="">-- Select equipment --</option>
      @foreach($equipments as $eq)
      <option value="{{ $eq->id }}" {{ (old('equipment_id',$selectedEquipmentId)==$eq->id) ? 'selected' : '' }}>
          {{ $eq->name }} - RM {{ number_format($eq->value,2) }} [{{ $eq->status }}]
      </option>
      @endforeach
  </select>

  <label>Borrow Date (Start):</label>
  <input type="date" id="start_date" name="start_date"
       min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}"
       value="{{ old('start_date') }}"
       required>

  <label>Return Date (End):</label>
  <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" readonly required>

  <button type="submit" class="submit-btn">Submit Booking Request</button>
</form>

@if($errors->any())
  <div style="color:red;margin-top:10px">
    <ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
  </div>
@endif
</div>
@endsection

@section('scripts')
<script>
 document.getElementById('start_date').addEventListener('change', function () {
    let start = new Date(this.value);
    if(!this.value) return;

    let nextDay = new Date(start);
    nextDay.setDate(start.getDate() + 1);

    let formatted = nextDay.toISOString().split('T')[0];

    let endInput = document.getElementById('end_date');
    endInput.value = formatted;
    endInput.min = formatted;
    endInput.max = formatted;
 });
</script>
@endsection
