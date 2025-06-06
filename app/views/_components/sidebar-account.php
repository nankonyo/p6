     <style>
        .sidebar {
            padding-top: 2rem;
            padding-left: 1rem;
            padding-right: 1rem;
            font-family: Arial, sans-serif;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            margin-bottom: 4px;
            border-radius: 20px;
            text-decoration: none;
            transition: background-color 0.2s;
            font-size: 14px;
        }

        .sidebar a.active {
            background-color: #e8f0fe;
            font-weight: 500;
        }

        .sidebar a i {
            margin-right: 12px;
            font-size: 18px;
        }
    </style>

    <div class="sticky-top"> 
        <nav class="sidebar d-none d-sm-none d-md-none d-lg-block sticky-top" style="min-width:300px;padding-top:5rem;" id="sidebar">
            <a href="#" class="active"><i class="bi bi-house-door"></i> Beranda</a>
            <a href="#"><i class="bi bi-person-badge"></i> Data Account</a>
            <a href="#"><i class="bi bi-display"></i> Data Perangkat</a>
        </nav>
    </div>