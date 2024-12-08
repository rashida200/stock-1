<x-base>
    @section('title', 'Admin Dashboard')
    <div class="row mb-4">
        @for ($i = 0; $i <= 3; $i++)
            <x-product-statistics-card></x-product-statistics-card>
        @endfor
    </div>
    <x-shart></x-shart>

</x-base>
