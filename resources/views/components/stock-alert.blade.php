<!-- Add this to your blade template -->
<div class="stock-alerts-wrapper mb-4">
    <div class="dropdown-container" id="stockAlertsDropdown">
        <!-- Fancy Header Button -->
        <button class="btn btn-lg btn-light w-100 d-flex justify-content-between align-items-center shadow-sm position-relative overflow-hidden"
                onclick="toggleDropdown()"
                id="dropdownButton">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-bell fa-bounce text-warning"></i>
                <span class="fw-bold">Alertes de Stock</span>
                <span class="badge bg-danger rounded-pill alert-count"></span>
            </div>
            <i class="fas fa-chevron-down transition-icon"></i>
        </button>

        <!-- Fancy Dropdown Content -->
        <div class="dropdown-content shadow rounded-3 mt-2" style="display: none;">
            @php $hasAlerts = false; @endphp

            @foreach ($produits as $produit)
                @php
                    $stockLevel = $produit->quantite_initial > 0
                        ? ($produit->quantity / $produit->quantite_initial) * 100
                        : 0;
                @endphp

                @if ($produit->quantite_initial <= 0)
                    @php $hasAlerts = true; @endphp
                    <div class="alert alert-danger m-2 border-start border-danger border-5 shadow-sm slide-in-alert">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-exclamation-circle fa-lg"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Erreur Critique</h6>
                                <p class="mb-0">La quantité initiale pour <strong>{{ $produit->designation }}</strong> est nulle ou non définie.</p>
                            </div>
                        </div>
                    </div>
                @elseif ($stockLevel <= 20)
                    @php $hasAlerts = true; @endphp
                    <div class="alert alert-danger m-2 border-start border-danger border-5 shadow-sm slide-in-alert">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-exclamation-triangle fa-lg"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Stock Critique</h6>
                                <p class="mb-0">Le stock pour <strong>{{ $produit->designation }}</strong> est à {{ round($stockLevel) }}%</p>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $stockLevel }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($stockLevel <= 50)
                    @php $hasAlerts = true; @endphp
                    <div class="alert alert-warning m-2 border-start border-warning border-5 shadow-sm slide-in-alert">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-exclamation fa-lg"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Stock Faible</h6>
                                <p class="mb-0">Le stock pour <strong>{{ $produit->designation }}</strong> est à {{ round($stockLevel) }}%</p>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $stockLevel }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @if (!$hasAlerts)
                <div class="alert alert-success m-2 border-start border-success border-5 shadow-sm slide-in-alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-check-circle fa-lg"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Tout va bien!</h6>
                            <p class="mb-0">Aucune alerte de stock à signaler.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add this to your CSS -->
<style>
.stock-alerts-wrapper {
    max-width: 600px;
    margin: 0 auto;
}

.dropdown-container {
    position: relative;
}

.dropdown-content {
    position: absolute;
    width: 100%;
    z-index: 1000;
    background: white;
    border-radius: 8px;
    max-height: 400px;
    overflow-y: auto;
}

.transition-icon {
    transition: transform 0.3s ease;
}

.rotate-icon {
    transform: rotate(180deg);
}

.slide-in-alert {
    animation: slideIn 0.3s ease forwards;
    opacity: 0;
    transform: translateY(-10px);
}

@keyframes slideIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Stagger animation for multiple alerts */
.slide-in-alert:nth-child(1) { animation-delay: 0.1s; }
.slide-in-alert:nth-child(2) { animation-delay: 0.2s; }
.slide-in-alert:nth-child(3) { animation-delay: 0.3s; }

/* Custom scrollbar for dropdown */
.dropdown-content::-webkit-scrollbar {
    width: 8px;
}

.dropdown-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.dropdown-content::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.dropdown-content::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Progress bar animation */
.progress-bar {
    transition: width 1s ease-in-out;
}
</style>

<!-- Add this to your JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Count alerts and update badge
    const alertCount = document.querySelectorAll('.alert').length;
    const alertBadge = document.querySelector('.alert-count');
    if (alertCount > 0) {
        alertBadge.textContent = alertCount;
    } else {
        alertBadge.style.display = 'none';
    }
});

function toggleDropdown() {
    const dropdownContent = document.querySelector('.dropdown-content');
    const icon = document.querySelector('.transition-icon');

    // Toggle dropdown
    if (dropdownContent.style.display === 'none') {
        dropdownContent.style.display = 'block';
        icon.classList.add('rotate-icon');

        // Reset animations
        const alerts = document.querySelectorAll('.slide-in-alert');
        alerts.forEach(alert => {
            alert.style.animation = 'none';
            alert.offsetHeight; // Trigger reflow
            alert.style.animation = null;
        });
    } else {
        dropdownContent.style.display = 'none';
        icon.classList.remove('rotate-icon');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('stockAlertsDropdown');
    const dropdownContent = document.querySelector('.dropdown-content');
    const button = document.getElementById('dropdownButton');

    if (!dropdown.contains(event.target) && dropdownContent.style.display !== 'none') {
        dropdownContent.style.display = 'none';
        document.querySelector('.transition-icon').classList.remove('rotate-icon');
    }
});
</script>
