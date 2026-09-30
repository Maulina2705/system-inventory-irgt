<div class="nav-logo" style="overflow:hidden; display:flex; align-items:center; justify-content:center;">
    @if(file_exists(public_path('images/logo.png')))
        <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" style="width:100%; height:100%; object-fit:contain; border-radius:inherit;">
    @elseif(file_exists(public_path('images/logo.jpg')))
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo Sekolah" style="width:100%; height:100%; object-fit:contain; border-radius:inherit;">
    @elseif(file_exists(public_path('images/logo.jpeg')))
        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Sekolah" style="width:100%; height:100%; object-fit:contain; border-radius:inherit;">
    @elseif(file_exists(public_path('images/logo.svg')))
        <img src="{{ asset('images/logo.svg') }}" alt="Logo Sekolah" style="width:100%; height:100%; object-fit:contain; border-radius:inherit;">
    @else
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
    @endif
</div>
