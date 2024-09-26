@extends('layouts.dosen.main')

@section('content')
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><a href="/profil">Profil User</a></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Profil User</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<h3><a href="" class="btn btn-info"> Segera Lakukan Perubahan Password </a></h3>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Form Update Password</h3>
                    </div>
                    <!-- form start -->
                    <form action="/profil/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Password Lama</label>
                                <div class="input-group">
                                    <input type="password" name="current_password" id="current_password" placeholder="Masukkan Password Lama"
                                           class="form-control @error('current_password') is-invalid @enderror">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('current_password')">
                                            <i class="fa fa-eye" id="toggleCurrentPasswordIcon"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Password Baru</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Password Baru" oninput="updatePasswordStrength()">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password')">
                                            <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                        </button>
                                    </div>
                                </div>
                                <small id="password-strength-indicator" style="display: block; margin-top: 5px;"></small>
                                @error('password')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password Baru"
                                           class="form-control @error('password_confirmation') is-invalid @enderror">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password_confirmation')">
                                            <i class="fa fa-eye" id="togglePasswordConfirmationIcon"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Update</button>
                            <button type="reset" class="btn btn-danger"><i class="fa fa-undo"></i> Batal</button>
                        </div>
                    </form>
                </div>
            </div>



   
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Profil</h3>
                    </div>
                    <form action="/foto-profil/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" value="{{ old('name', $profil->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama" required>
                                @error('name')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" value="{{ old('email', $profil->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Nama" required>
                                @error('email')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <label>Foto</label>
                                <input type="file" name="profile_photo_path" value="{{ old('profile_photo_path') }}" class="form-control @error('profile_photo_path') is-invalid @enderror">
                                <p></p>
                                <img src="{{ Storage::url('public/staff/'.Auth::user()->profile_photo_path.'') }}" class="img-thumbnail" alt="{{ Auth::user()->name }}"/>
                                @error('profile_photo_path')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> --}}
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Update</button>
                            <button type="reset" class="btn btn-danger"><i class="fa fa-undo"></i> Batal</button>
                        </div>
                    </form>
                </div>
            </div>

</section>

<script>
    function updatePasswordStrength() {
        var passwordInput = document.getElementById("password");
        var passwordStrengthIndicator = document.getElementById("password-strength-indicator");
        var password = passwordInput.value;

        var hasLowerCase = /[a-z]/.test(password);
        var hasUpperCase = /[A-Z]/.test(password);
        var hasNumbers = /\d/.test(password);
        var hasSymbols = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(password);

        var strength = 0;
        if (password.length >= 8) strength++;
        if (hasLowerCase) strength++;
        if (hasUpperCase) strength++;
        if (hasNumbers) strength++;
        if (hasSymbols) strength++;

        var strengthText = "";
        if (strength === 0) {
            strengthText = "Lemah";
        } else if (strength < 4) {
            strengthText = "Sedang";
        } else {
            strengthText = "Kuat";
        }

        passwordStrengthIndicator.textContent = "Kekuatan Password: " + strengthText;
    }

    function togglePasswordVisibility(inputId) {
        var passwordInput = document.getElementById(inputId);
        var passwordIcon = document.getElementById("toggle" + inputId.charAt(0).toUpperCase() + inputId.slice(1) + "Icon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordIcon.classList.remove("fa-eye");
            passwordIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            passwordIcon.classList.remove("fa-eye-slash");
            passwordIcon.classList.add("fa-eye");
        }
    }
</script>
@endsection
