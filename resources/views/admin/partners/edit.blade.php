@extends('layouts.admin')

@section('title', 'Edit Partner - Admin')
@section('page_title', 'Edit Partner')
@section('page_subtitle', 'Ubah detail partner.')

@section('content')

<div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm max-w-3xl">

    <form action="{{ route('admin.partners.update', $partner->id) }}"
        method="POST"
        class="space-y-6">

        @csrf
        @method('PUT')

        <div>

            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Nama Partner
            </label>

            <input type="text"
                name="name"
                value="{{ old('name', $partner->name) }}"
                placeholder="Masukkan nama partner"
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                required>

            @error('name')

            <span class="text-red-500 text-sm mt-1">
                {{ $message }}
            </span>

            @enderror

        </div>

        <div>

            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                URL Logo
            </label>

            <input type="text"
                name="logo_url"
                value="{{ old('logo_url', $partner->logo_url) }}"
                placeholder="https://placehold.co/200x200"
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                required>

            @error('logo_url')

            <span class="text-red-500 text-sm mt-1">
                {{ $message }}
            </span>

            @enderror

        </div>

        <div>

            <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide">
                Preview Logo
            </label>

            <img src="{{ $partner->logo_url }}"
                alt="{{ $partner->name }}"
                class="w-28 h-28 rounded-2xl object-cover border border-slate-200 shadow-sm">

        </div>

        <div class="pt-4 flex justify-end gap-4 border-t border-slate-100">

            <a href="{{ route('admin.partners.index') }}"
                class="px-6 py-4 text-slate-500 font-bold hover:text-slate-800 transition">

                Batal

            </a>

            <button type="submit"
                class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">

                Simpan Perubahan

            </button>

        </div>

    </form>

</div>

@endsection