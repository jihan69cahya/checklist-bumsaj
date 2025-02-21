@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<h1 class="text-2xl font-bold mb-4">Beranda</h1>
        
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-yellow-500 text-white p-4 rounded-lg flex flex-col items-center">
                <span class="text-2xl font-bold">✅ 1</span>
                <p class="text-sm">Checklist sudah diisi</p>
            </div>
            <div class="bg-yellow-500 text-white p-4 rounded-lg flex flex-col items-center">
                <span class="text-2xl font-bold">⭕ 2</span>
                <p class="text-sm">Checklist belum diisi</p>
            </div>
            <div class="bg-yellow-500 text-white p-4 rounded-lg flex flex-col items-center">
                <span class="text-2xl font-bold">⏳ 17 <span class="text-sm">menit</span></span>
                <p class="text-sm">Menuju periode berikutnya</p>
            </div>
        </div>
        
        <p class="font-bold mb-2">Kamis, 13 Februari 2025</p>
        
        <div class="space-y-2">
            <div class="flex items-center justify-between bg-white border p-3 rounded-lg">
                <span>Fasilitas Terminal</span>
                <span>59%</span>
            </div>
            <div class="flex items-center justify-between bg-white border p-3 rounded-lg">
                <span>Kebersihan Terminal</span>
                <span>59%</span>
            </div>
            <div class="flex items-center justify-between bg-white border p-3 rounded-lg">
                <span>Curbside Area</span>
                <span>59%</span>
            </div>
        </div>
@endsection
