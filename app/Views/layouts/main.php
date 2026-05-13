<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Nemesis Dashboard' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #64748b;
            --dark: #0f172a;
            --darker: #020617;
            --light: #f8fafc;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --card-bg: rgba(30, 41, 59, 0.7);
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--darker);
            color: var(--light);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Sidebar */
        aside {
            width: var(--sidebar-width);
            background: var(--dark);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            z-index: 999; /* Pastikan di atas segalanya */
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
        }

        nav ul {
            list-style: none;
        }

        nav ul li {
            margin-bottom: 0.5rem;
        }

        nav ul li a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--secondary);
            text-decoration: none;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        nav ul li a:hover, nav ul li a.active {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
        }

        /* Main Content */
        main {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 2rem;
            max-width: calc(100vw - var(--sidebar-width));
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: var(--dark);
            padding: 0.5rem 1.25rem;
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-info span {
            display: block;
            font-size: 0.875rem;
        }

        .user-info .role {
            color: var(--secondary);
            font-size: 0.75rem;
        }

        /* Cards */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 1.25rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            font-size: 0.875rem;
            color: var(--secondary);
            margin-bottom: 0.5rem;
        }

        .card .value {
            font-size: 1.75rem;
            font-weight: 700;
        }

        .card .trend {
            margin-top: 0.5rem;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .trend.up { color: var(--success); }
        .trend.down { color: var(--danger); }

        /* Tables */
        .table-container {
            background: var(--dark);
            border-radius: 1.25rem;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: rgba(255, 255, 255, 0.02);
            text-align: left;
            padding: 1rem;
            font-size: 0.875rem;
            color: var(--secondary);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        td {
            padding: 1rem;
            font-size: 0.875rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.01);
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-priority { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
        .badge-danger { background: rgba(239, 68, 68, 0.1); color: var(--danger); }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade {
            animation: fadeIn 0.5s ease forwards;
        }

        /* Glassmorphism scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--darker); }
        ::-webkit-scrollbar-thumb {
            background: rgba(99, 102, 241, 0.2);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary); }
    </style>
</head>
<body>
    <aside>
        <div class="logo">
            <i class="fas fa-shield-halved"></i>
            <span>NEMESIS</span>
        </div>
        <nav>
            <ul>
                <li><a href="<?= base_url('dashboard') ?>" class="<?= url_is('dashboard*') || url_is('/') ? 'active' : '' ?>"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
                <li><a href="javascript:void(0)" onclick="alert('Fitur Paket Pengadaan segera hadir!')"><i class="fas fa-box"></i> Paket Pengadaan</a></li>
                <?php if(session()->get('role') == 'superadmin'): ?>
                <li><a href="javascript:void(0)" onclick="alert('Fitur Manajemen User segera hadir!')"><i class="fas fa-users"></i> Manajemen User</a></li>
                <li><a href="javascript:void(0)" onclick="alert('Fitur Pengaturan segera hadir!')"><i class="fas fa-gears"></i> Pengaturan</a></li>
                <?php endif; ?>
                <li style="margin-top: 2rem;">
                    <a href="<?= base_url('logout') ?>" style="color: var(--danger);">
                        <i class="fas fa-right-from-bracket"></i> Keluar
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <main>
        <header>
            <h1><?= $title ?></h1>
            <div class="user-profile">
                <div class="user-info">
                    <span><?= session()->get('username') ?></span>
                    <span class="role"><?= ucfirst(session()->get('role')) ?></span>
                </div>
                <img src="https://ui-avatars.com/api/?name=<?= session()->get('username') ?>&background=6366f1&color=fff" alt="Avatar" style="width: 32px; height: 32px; border-radius: 50%;">
            </div>
        </header>

        <?= $this->renderSection('content') ?>
    </main>
</body>
</html>
