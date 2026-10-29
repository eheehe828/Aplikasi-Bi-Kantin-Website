@extends('layouts.app')

@section('title', ($menu->exists ? 'Edit' : 'Tambah') . ' Menu | Bi-Kantin')

@section('content')
    <main class="dashboard">
        <section class="dash-panel">
            <p class="eyebrow">Panel pengelola</p>
            <h1>{{ $menu->exists ? 'Edit Menu' : 'Tambah Menu' }}</h1>

            <form method="POST" enctype="multipart/form-data"
                  action="{{ $menu->exists ? route('admin.menu.update', $menu) : route('admin.menu.store') }}">
                @csrf
                @if ($menu->exists)
                    @method('PUT')
                @endif

                <label class="field">
                    Nama menu
                    <input name="nama_menu" type="text" value="{{ old('nama_menu', $menu->nama_menu) }}" required>
                    @error('nama_menu') <span class="error">{{ $message }}</span> @enderror
                </label>

                <label class="field">
                    Harga (Rp)
                    <input name="harga" type="number" min="0" value="{{ old('harga', $menu->harga) }}" required>
                    @error('harga') <span class="error">{{ $message }}</span> @enderror
                </label>

                <label class="field">
                    Kategori
                    <select name="kategori" required>
                        @foreach (['Makanan', 'Minuman'] as $k)
                            <option value="{{ $k }}" @selected(old('kategori', $menu->kategori) === $k)>{{ $k }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <span class="error">{{ $message }}</span> @enderror
                </label>

                <label class="field">
                    Deskripsi
                    <textarea name="deskripsi" rows="3">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                    @error('deskripsi') <span class="error">{{ $message }}</span> @enderror
                </label>

                <label class="field">
                    Foto (maks 2 MB)
                    <input name="foto" type="file" accept="image/*">
                    @error('foto') <span class="error">{{ $message }}</span> @enderror
                </label>

                @if ($menu->foto)
                    <img class="thumb" src="{{ asset('storage/' . $menu->foto) }}" alt="Foto saat ini">
                @endif

                <div class="dash-actions">
                    <button class="button" type="submit">Simpan</button>
                    <a class="logout-button" href="{{ route('admin.menu.index') }}">Batal</a>
                </div>
            </form>
        </section>
    </main>
@endsection