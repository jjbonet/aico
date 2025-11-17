<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'AICO')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 vía CDN (para desarrollo; después lo podés pasar a Vite) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Iconos (Bootstrap Icons) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --aico-bg: #F8FAFC;
            --aico-card-bg: #FFFFFF;
            --aico-border: #E2E8F0;
            --aico-text: #0F172A;
            --aico-primary: #0EA5E9;
            --aico-primary-d: #0369A1;
            --aico-success: #10B981;
            --aico-warning: #F59E0B;
            --aico-danger: #EF4444;
        }

        body {
            background-color: var(--aico-bg);
            color: var(--aico-text);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .aico-sidebar {
            width: 260px;
            min-height: 100vh;
            background-color: #FFFFFF;
            border-right: 1px solid var(--aico-border);
            transition: width 0.2s ease;
        }

        .aico-sidebar-collapsed {
            width: 70px;
        }

        .aico-sidebar .nav-link {
            color: #64748B;
            font-weight: 500;
            border-radius: .75rem;
            padding: .60rem .90rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .aico-sidebar .nav-link.active {
            background-color: rgba(14, 165, 233, 0.12);
            color: var(--aico-primary-d);
        }

        .aico-sidebar .nav-link i {
            font-size: 1.2rem;
        }

        .aico-logo {
            font-weight: 700;
            color: var(--aico-primary-d);
            letter-spacing: .03em;
        }

        .aico-main {
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .aico-topbar {
            height: 64px;
            background-color: #FFFFFF;
            border-bottom: 1px solid var(--aico-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
        }

        .aico-content {
            padding: 1.5rem;
        }

        .aico-card {
            background-color: var(--aico-card-bg);
            border-radius: 1rem;
            border: 1px solid var(--aico-border);
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
            padding: 1.5rem;
        }

        .btn-aico-primary {
            background-color: var(--aico-primary);
            border-color: var(--aico-primary);
            color: #fff;
        }

        .btn-aico-primary:hover {
            background-color: var(--aico-primary-d);
            border-color: var(--aico-primary-d);
        }

        .table thead {
            background-color: #EFF6FF;
        }

        .table thead th {
            border-bottom-color: var(--aico-border);
        }

        .aico-badge-pill {
            border-radius: 999px;
            padding: .15rem .75rem;
            font-size: .75rem;
        }

        @media (max-width: 768px) {
            .aico-sidebar {
                position: fixed;
                z-index: 1040;
            }

            .aico-main {
                margin-left: 70px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="d-flex">
        {{-- SIDEBAR --}}
        <nav id="aicoSidebar" class="aico-sidebar d-flex flex-column p-3">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <span class="aico-logo d-flex align-items-center gap-2">
                    <i class="bi bi-activity"></i>
                    <span class="aico-sidebar-label">AICO</span>
                </span>
                <button id="aicoToggleSidebar" class="btn btn-sm btn-outline-secondary d-md-inline d-none">
                    <i class="bi bi-chevron-double-left"></i>
                </button>
            </div>

            <ul class="nav nav-pills flex-column gap-1 mb-auto">
                <li class="nav-item">
                    <a href="{{ route('pacientes.index') }}"
                        class="nav-link {{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span class="aico-sidebar-label">Pacientes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link disabled">
                        <i class="bi bi-journal-medical"></i>
                        <span class="aico-sidebar-label">Historias</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link disabled">
                        <i class="bi bi-calendar3"></i>
                        <span class="aico-sidebar-label">Turnos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link disabled">
                        <i class="bi bi-file-earmark-medical"></i>
                        <span class="aico-sidebar-label">Estudios</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a href="#" class="nav-link disabled">
                        <i class="bi bi-person-badge"></i>
                        <span class="aico-sidebar-label">Usuarios</span>
                    </a>
                </li>
            </ul>

            <div class="mt-4 small text-muted">
                <span class="d-flex align-items-center gap-2">
                    <i class="bi bi-shield-check"></i>
                    <span class="aico-sidebar-label">Modo clínico</span>
                </span>
            </div>
        </nav>

        {{-- MAIN --}}
        <div class="aico-main">
            {{-- TOPBAR --}}
            <header class="aico-topbar">
                <div class="d-flex align-items-center gap-2">
                    <button id="aicoToggleSidebarMobile" class="btn btn-sm btn-outline-secondary d-md-none">
                        <i class="bi bi-list"></i>
                    </button>
                    <h1 class="h5 mb-0">@yield('header', 'Panel AICO')</h1>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small d-none d-sm-inline">
                        {{ now()->format('d/m/Y H:i') }}
                    </span>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name ?? 'Profesional' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="#">Cerrar sesión</a></li>
                        </ul>
                    </div>
                </div>
            </header>

            {{-- CONTENIDO --}}
            <main class="aico-content">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('aicoSidebar');
        const btnToggle = document.getElementById('aicoToggleSidebar');
        const btnToggleMb = document.getElementById('aicoToggleSidebarMobile');

        function toggleSidebar() {
            sidebar.classList.toggle('aico-sidebar-collapsed');

            const labels = document.querySelectorAll('.aico-sidebar-label');
            labels.forEach(label => {
                label.style.display = sidebar.classList.contains('aico-sidebar-collapsed') ? 'none' : 'inline';
            });

            if (btnToggle) {
                btnToggle.innerHTML = sidebar.classList.contains('aico-sidebar-collapsed') ?
                    '<i class="bi bi-chevron-double-right"></i>' :
                    '<i class="bi bi-chevron-double-left"></i>';
            }
        }

        if (btnToggle) btnToggle.addEventListener('click', toggleSidebar);
        if (btnToggleMb) btnToggleMb.addEventListener('click', toggleSidebar);
    </script>

    @stack('scripts')
</body>

</html>
