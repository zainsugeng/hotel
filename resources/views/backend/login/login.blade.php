<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Login Page - Modern Blue</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">


    <style>
        /* === LATAR BELAKANG GRADASI BIRU (VERSI PERBAIKAN) === */
        body {
            /* Dimulai dari biru gelap di atas, ke biru terang di bawah */
            background: linear-gradient(to bottom, #2D5AB8, #83c3e5);
            font-family: 'Poppins', sans-serif;
            background-attachment: fixed;
        }

        /* Kartu Login Putih dengan Shadow Halus */
        .card {
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        /* Tombol Login dengan Warna Aksen Biru Terang */
        .btn-primary-custom {
            background-color: #5B94E8;
            /* Menggunakan warna biru terang sebagai aksen */
            border-color: #5B94E8;
            color: #ffffff;
            font-weight: 600;
        }

        .btn-primary-custom:hover {
            background-color: #3B78E3;
            border-color: #3B78E3;
        }

        .link-muted {
            color: #6c757d;
            text-decoration: none;
            transition: color 0.2s ease-in-out;
        }

        .link-muted:hover {
            color: #5B94E8;
        }

        .input-custom-height {
            padding-top: 0.6rem;
            padding-bottom: 0.6rem;
            font-size: 0.9rem;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="card rounded-3 shadow-lg" style="max-width: 28rem; width: 100%;">
        <div class="card-body p-4 p-md-5">

            <div class="d-flex justify-content-center align-items-center mb-4">
                {{-- Ikon utama menggunakan warna biru terang sebagai aksen --}}
                <i class="bi bi-building me-3" style="font-size: 2.5rem; color: #5B94E8;"></i>
                <h3 class="fw-bolder mb-0 text-dark">
                    <span class="fst-italic">{{ $judul}}</span> {{$subjudul}}</h3>
            </div>

            @if(session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('backend.login') }}" method="post" novalidate>
                @csrf
                <div class="mb-3">

                    <div class="input-group">
                        <span class="input-group-text input-custom-height bg-white">
                            <i class="bi bi-envelope-fill" style="color: #5B94E8;"></i>
                        </span>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="form-control input-custom-height @error('email') is-invalid @enderror"
                            placeholder="name@example.com" required>
                    </div>
                </div>

                <div class="mb-4">

                    <div class="input-group">
                        <span class="input-group-text input-custom-height bg-white">
                            <i class="bi bi-lock-fill" style="color: #6c757d;"></i>
                        </span>
                        <input type="password" name="password" id="password"
                            class="form-control input-custom-height @error('password') is-invalid @enderror"
                            placeholder="Masukan Password" required>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button class="btn btn-primary-custom input-custom-height" type="submit">Login</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>