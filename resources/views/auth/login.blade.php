@extends('layouts.layouts')
@section('container')
<div class="row justify-content-center mb-3">
    <!-- Kolom Login. col-lg-5 agar ukurannya proporsional dan diletakkan di tengah dengan justify-content-center -->
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <h1 class="auth-title text-center">MRP System</h1>
            <p class="auth-subtitle mb-5 text-center">Log in with your data Sytem MRP that you entered.</p>

            <!-- Form login -->
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <!-- Username Field (ditambah mb-3) -->
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="email" name="email" class="form-control form-control-xl" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>

                <!-- Password Field (ditambah mb-3) -->
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="password" name="password" class="form-control form-control-xl" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>

                <!-- Checkbox -->
                <div class="form-check form-check-lg d-flex align-items-end mb-3">
                    <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label text-gray-600" for="flexCheckDefault">
                        Keep me logged in
                    </label>
                </div>

                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
            </form>

            <!-- Link Bawah -->
            {{-- <div class="text-center mt-5 text-lg fs-4"> --}}
                {{-- <p class="text-gray-600">Don't have an account?
                    <a href="auth-register.html" class="font-bold">Sign up</a>.
                </p> --}}
                {{-- <p>
                    <a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.
                </p> --}}
            {{-- </div> --}}
        </div>
    </div>
    <!-- Bagian col-lg-7 yang tadinya ada di kanan (jika tidak diperlukan lagi untuk tampilan centered) telah dihapus -->
</div>
@endsection
