@extends('layouts.auth')

@section('title', 'SeaPass - Welcome')

@section('styles')
<style>
    @keyframes fadeInScale {
        0% {
            opacity: 0;
            transform: scale(0.8);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    @keyframes wave {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
    }
    
    .fade-in-scale {
        animation: fadeInScale 1.5s ease-out forwards;
    }
    
    .wave {
        animation: wave 2s ease-in-out infinite;
    }
    
    .bg-overlay {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.9) 0%, rgba(5, 150, 105, 0.95) 100%);
    }
</style>
@endsection

@section('content')
<div class="min-h-screen relative overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/bgLogin.png') }}" alt="Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-overlay"></div>
    </div>
    
    <!-- Content -->
    <div class="relative z-10 min-h-screen flex flex-col items-center justify-center px-4">
        <!-- Logo dengan animasi -->
        <div class="fade-in-scale text-center">
            <div class="mb-8 wave">
                <img src="{{ asset('images/logo.png') }}" alt="SeaPass Logo" class="h-32 w-auto mx-auto drop-shadow-2xl">
            </div>
            
            
            <p class="text-2xl text-white/90 font-light tracking-wide drop-shadow-md">Book Ship Tickets Easily & Quickly</p>
            
            <!-- Loading indicator -->
            <div class="mt-12 flex justify-center">
                <div class="flex space-x-2">
                    <div class="w-3 h-3 bg-white rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                    <div class="w-3 h-3 bg-white rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                    <div class="w-3 h-3 bg-white rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto redirect ke halaman login setelah 4 detik
    setTimeout(function() {
        window.location.href = "{{ route('login') }}";
    }, 4000);
</script>
@endsection