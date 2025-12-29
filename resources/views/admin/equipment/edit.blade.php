@extends('admin.layouts.app')
@section('content')

<h2 style="color:#05355c;">✏️ Edit Equipment</h2>

<form method="POST" action="{{ route('admin.updateEquipment', $equipment->id) }}" enctype="multipart/form-data" 
      style="background:#fff;padding:20px;border-radius:10px;max-width:500px;box-shadow:0 3px 12px rgba(0,0,0,0.1);">
    @csrf

    <p><label><strong>Name:</strong></label><br>
    <input type="text" name="name" value="{{ $equipment->name }}" style="width:100%;padding:8px;border-radius:6px;border:1px solid #ccc;"></p>

    <p><label><strong>Information:</strong></label><br>
    <textarea name="information" style="width:100%;height:80px;padding:8px;border-radius:6px;border:1px solid #ccc;">{{ $equipment->information }}</textarea></p>

    <p><label><strong>Value (RM):</strong></label><br>
    <input type="number" step="0.01" name="value" value="{{ $equipment->value }}" style="width:100%;padding:8px;border-radius:6px;border:1px solid #ccc;"></p>

    <p><label><strong>Status:</strong></label><br>
    <select name="status" style="width:100%;padding:8px;border-radius:6px;border:1px solid #ccc;">
        <option value="available" {{ $equipment->status=='available'?'selected':'' }}>Available</option>
        <option value="borrowed" {{ $equipment->status=='borrowed'?'selected':'' }}>Borrowed</option>
        <option value="damaged" {{ $equipment->status=='damaged'?'selected':'' }}>Damaged</option>
        <option value="maintenance" {{ $equipment->status=='maintenance'?'selected':'' }}>Maintenance</option>
    </select></p>

    <p><label><strong>Expired Date:</strong></label><br>
    <input type="date" name="expired_date" value="{{ $equipment->expired_date }}" 
           style="width:100%;padding:8px;border-radius:6px;border:1px solid #ccc;"></p>

    <p><label><strong>Change Image:</strong></label><br>
    <input type="file" name="image" accept="image/*"></p>

    @if($equipment->image)
    <p><strong>Current Image:</strong><br><img src="{{ asset('storage/'.$equipment->image) }}" width="90" style="border-radius:6px;border:1px solid #ddd;"></p>
    @endif

    <button type="submit" style="background:#007bff;color:white;padding:10px 18px;border:none;border-radius:6px;font-weight:bold;cursor:pointer;">
        Update Equipment
    </button>

    <a href="{{ route('admin.manageEquipment') }}" 
       style="margin-left:10px;color:#d62828;font-weight:bold;text-decoration:none;">
        Cancel
    </a>
</form>

@endsection
