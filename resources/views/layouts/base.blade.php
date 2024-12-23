@props(['class' => 'bg-light'])

<x-parent-layout :class="$class">
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    <div class="d-flex">
        <div class="sidebar bg-white p-3" id="sidebar">
            <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                {{-- <i class="fas fa-box-open text-primary me-2 fs-4"></i> --}}
                <h5 class="m-0">AGRI IRRIGATION
                    <br> AIT OUFKIR FRERES</h5>
            </div>
            <x-sidebar></x-sidebar>
        </div>
        <div class="flex-grow-1 main-content">
            <x-profile-dropdown></x-profile-dropdown>
            <div class="p-4">
                {{ $slot }}
            </div>
        </div>
    </div>
    @stack('scripts') <!-- Add this line to include scripts -->
</x-parent-layout>
