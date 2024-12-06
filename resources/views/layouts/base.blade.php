<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventory Management Dashboard</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body class="bg-light">
    <!-- Sidebar Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <div class="d-flex">
      <!-- Sidebar -->
      <div class="sidebar bg-white p-3" id="sidebar">
            <!-- Sidebar Logo -->
            <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                <i class="fas fa-box-open text-primary me-2 fs-4"></i>
                <h4 class="m-0">Inventory</h4>
            </div>
            <!-- Navigation -->
            <x-sidebar></x-sidebar>
      </div>

      <!-- Main Content -->
      <div class="flex-grow-1 main-content">
        <!-- Top Bar -->
        <x-profile-dropdown></x-profile-dropdown>
        <!-- Dashboard Content -->
        <div class="p-4">
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                @for ($i = 0; $i < 4; $i++)
                <x-product-statistics-card></x-product-statistics-card>
                @endfor
            </div>
            <x-shart></x-shart>
        </div>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
  </body>
</html>
