@extends('layouts.dosen.main')

@section('content')

<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info">
                        <h4 class="m-b-0 text-white">Form Edit User Mahasiswa</h4>
                    </div>
                    <div class="card-body">
                        <form action="/std/update/baak/{{ $user->id }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                
                               <h3> {{ old('name', $user->username) }} - 
                                    {{ old('name', $user->kode) }} </h3>
                                

                            </div>

                             <div class="form-group">
                                
                                <label>NAMA USER</label>
                                <input type="text" name="username" value="{{ old('name', $user->username) }}"
                                    placeholder="Masukkan Nama User"
                                    class="form-control @error('username') is-invalid @enderror">
    
                                @error('username')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror

                                
                            </div>

                            <div class="form-group">
                                
                                <label>NAMA USER</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    placeholder="Masukkan Nama User"
                                    class="form-control @error('name') is-invalid @enderror">
    
                                @error('name')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror

                                
                            </div>
                            <div class="form-group">
                                
                                <label>Kode Kelas</label>
                                <input type="text" name="kode" value="{{ old('kode', $user->kode) }}"
                                    placeholder="Masukkan Kode Kelas"
                                    class="form-control @error('kode') is-invalid @enderror">
    
                                @error('kode')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror

                                
                            </div>
    
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    placeholder="Masukkan Nama User"
                                    class="form-control @error('email') is-invalid @enderror">
    
                                @error('email')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                               
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PASSWORD *Minimal 8 Karakter</label>
                                        <input type="password" name="password" value="{{ old('password') }}"
                                            placeholder="Masukkan Password"
                                            class="form-control @error('password') is-invalid @enderror">
    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PASSWORD *Minimal 8 Karakter</label>
                                        <input type="password" name="password_confirmation"
                                            value="{{ old('password_confirmation') }}"
                                            placeholder="Masukkan Konfirmasi Password" class="form-control">
                                    </div>
                                </div>
                            </div>
    
                            
    
                            <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                                UPDATE</button>
                            {{-- <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button> --}}
    
                        </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    </section>


   
    @endsection