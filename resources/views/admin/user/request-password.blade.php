@extends('layouts.dosen.main')

@section('content')
<div class="container">
    <h3>Masukkan Password untuk Mengakses Edit</h3>
    <form method="POST" action="{{ route('check-password') }}">
        @csrf
        <!-- Input hidden untuk mengirim user_id -->
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
