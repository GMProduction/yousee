<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart Billboard Dashboard</title>
    
    <!-- Tailwind CSS (Desain) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js (Grafik) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.11.11/html-to-image.min.js"></script>
    
    <!-- FontAwesome (Ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
    

        
        /* Animasi Halus */
        .fade-in { animation: fadeIn 0.4s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

        /* Card Hover Effect */
        .stats-card { transition: all 0.3s ease; }
        .stats-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); }

        /* Indikator Live Berdenyut */
        .pulse-dot {
            width: 8px; height: 8px; background-color: #ef4444; border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            animation: pulse-red 2s infinite;
        }
        @keyframes pulse-red {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        /* Navigasi Aktif */
        .nav-item.active { background-color: #EFF6FF; color: #1D4ED8; }
        .nav-item.active i { color: #1D4ED8; }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }
        
        /* Hide sections by default */
        .view-section { display: none; }
        .view-section.active { display: block; }
    </style>

</head>
<body class="flex h-screen overflow-hidden text-slate-800">

    <style>
        /* SKELETON LOADER ANIMATIONS */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        
        .skeleton {
            animation: shimmer 2s infinite linear;
            background: linear-gradient(to right, #f1f5f9 4%, #e2e8f0 25%, #f1f5f9 36%);
            background-size: 1000px 100%;
        }

        .skeleton-text { height: 12px; margin-bottom: 8px; border-radius: 4px; }
        .skeleton-rect { width: 100%; height: 100%; border-radius: 8px; }
        .skeleton-circle { width: 100%; height: 100%; border-radius: 50%; }

        /* Hide sections by default */
        .view-section { display: none; }
        .view-section.active { display: block; }
    </style>

    <!-- 1. SIDEBAR NAVIGATION -->
    <aside id="main-sidebar" class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col z-10">
        <div class="p-6 flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold shadow-lg shadow-blue-500/30">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <span class="text-xl font-bold tracking-tight text-slate-900">Geospasial</span>
        </div>

        <nav class="flex-1 px-4 space-y-2 mt-4">
            <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">MENU UTAMA</p>
            
            <button onclick="switchView('dashboard')" id="nav-dashboard" class="nav-item active w-full flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl font-medium transition-colors text-left">
                <i class="fa-solid fa-chart-pie w-5"></i> Dashboard
            </button>
            <button onclick="switchView('map')" id="nav-map" class="nav-item w-full flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl font-medium transition-colors text-left">
                <i class="fa-solid fa-map-location-dot w-5"></i> Peta Lokasi
            </button>
            <!-- Hidden temporarily as per request
            <button onclick="switchView('reports')" id="nav-reports" class="nav-item w-full flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl font-medium transition-colors text-left">
                <i class="fa-solid fa-file-invoice w-5"></i> Laporan
            </button>
            -->
        </nav>

        <div class="p-4 border-t border-slate-100">
            <a href="/admin" class="flex items-center gap-3 p-2 bg-slate-50 rounded-xl border border-slate-100 cursor-pointer hover:bg-slate-100 transition text-decoration-none">
                <div class="w-9 h-9 rounded-full bg-slate-200 flex items-center justify-center text-slate-500">
                    <i class="fa-solid fa-arrow-left"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-slate-700">Kembali ke Admin</p>
                    <p class="text-[10px] text-slate-400">Dashboard Utama</p>
                </div>
            </a>
        </div>
    </aside>

    <!-- 2. MAIN CONTENT WRAPPER -->
    <main class="flex-1 flex flex-col overflow-y-auto bg-[#F8FAFC]">
        
        <!-- Top Bar -->
        <header class="bg-white/80 backdrop-blur-md sticky top-0 z-20 border-b border-slate-200 px-8 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-800" id="page-title">Smart Billboard Dashboard</h1>
                <p class="text-sm text-slate-500 flex items-center gap-2">
                    <!-- Removed Live Monitoring -->
                </p>
            </div>
            <div class="flex gap-3">

                <!-- Buttons removed as per request -->
            </div>
        </header>

        <!-- VIEW 1: DASHBOARD (Default) -->
        <div id="view-dashboard" class="view-section active p-8 max-w-[1600px] mx-auto w-full fade-in space-y-8">
            
            <!-- KPI CARDS (Hidden by default, shown via 'Lihat Analisis') -->
            <!-- KPI CARDS (Hidden by default, shown via 'Lihat Analisis') -->
            <div id="analysis-panel" class="grid grid-cols-1 md:grid-cols-3 gap-6 fade-in" style="display: none;">
                <!-- Card 1: Traffic -->
                <div class="stats-card bg-white p-6 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-car text-6xl text-blue-600"></i>
                    </div>
                    <p class="text-sm font-semibold text-slate-400 uppercase tracking-wide">TRAFFIC VIEW</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2" id="kpi-volume">0 View/Day</h3>
                    <div class="flex items-center gap-2 mt-4 text-sm">
                        <span id="kpi-trend-badge" class="bg-green-100 text-green-600 px-2 py-0.5 rounded-full font-bold text-xs"><i class="fa-solid fa-arrow-up"></i> 12%</span>
                        <span class="text-slate-400 text-xs" id="kpi-trend-text">Update Hari Ini</span>
                    </div>
                </div>

                <!-- Card 2: AI Score -->
                <div class="stats-card bg-gradient-to-br from-indigo-600 to-purple-700 p-6 rounded-2xl shadow-lg shadow-indigo-500/20 text-white relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                    <div class="flex justify-between items-start z-10 relative">
                        <div>
                            <p class="text-xs font-bold text-indigo-100 uppercase tracking-wide">AI SCORE</p>
                            <h3 class="text-4xl font-bold mt-1" id="kpi-score">9.2<span class="text-lg font-normal text-indigo-200">/10</span></h3>
                        </div>
                        <i class="fa-solid fa-wand-magic-sparkles text-yellow-300 text-xl"></i>
                    </div>
                    <p class="text-xs text-indigo-100 mt-4 bg-white/10 inline-block px-2 py-1 rounded">Lokasi Sangat Strategis</p>
                </div>
                <!-- Card 3: Audience -->
                <div class="stats-card bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-sm font-semibold text-slate-400 uppercase tracking-wide">DOMINASI AUDIENCE</p>
                    <div class="mt-3 flex items-center gap-3">
                        <!-- Icon User -->
                        <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center border-2 border-white shadow-sm">
                            <i class="fa-solid fa-user-group text-indigo-600 text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">RENTANG USIA</p>
                            <h4 class="font-bold text-slate-900 text-lg leading-tight" id="kpi-audience">25 - 40 Tahun</h4>
                        </div>
                    </div>
                    <div class="w-full bg-slate-100 h-1.5 mt-4 rounded-full overflow-hidden">
                        <div class="bg-slate-800 h-full rounded-full" style="width: 75%"></div>
                    </div>
                    <p class="text-xs text-right text-slate-400 mt-1">75% Kecocokan Profile</p>
                </div>
            </div>

            <!-- CHARTS SECTION -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Chart -->
                <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-trophy text-yellow-500"></i> Top 5 Lokasi Potensial
                        </h3>
                        <div class="flex items-center gap-2">
                             <select id="filter-province" onchange="applyProvinceFilter()" class="text-xs bg-slate-50 border border-slate-200 text-slate-600 rounded-lg px-2 py-1 font-bold focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                                <option value="all">Semua Provinsi</option>
                            </select>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-slate-400 uppercase bg-slate-50 rounded-lg">
                                <tr>
                                    <th class="px-3 py-2 rounded-l-lg">Lokasi</th>
                                    <th class="px-3 py-2">TRAFFIC VIEW</th>
                                    <th class="px-3 py-2 text-center">AI SCORE</th>
                                    <th class="px-3 py-2 rounded-r-lg text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="top-spots-table" class="divide-y divide-slate-100">
                                <!-- Skeleton Loading State -->
                                <tr class="animate-pulse"><td colspan="4" class="p-4">
                                    <div class="flex flex-col gap-4">
                                        <div class="flex justify-between">
                                            <div class="h-4 bg-slate-100 rounded w-1/3 skeleton"></div>
                                            <div class="h-4 bg-slate-100 rounded w-1/4 skeleton"></div>
                                        </div>
                                        <div class="flex justify-between">
                                            <div class="h-4 bg-slate-100 rounded w-1/3 skeleton"></div>
                                            <div class="h-4 bg-slate-100 rounded w-1/4 skeleton"></div>
                                        </div>
                                        <div class="flex justify-between">
                                            <div class="h-4 bg-slate-100 rounded w-1/3 skeleton"></div>
                                            <div class="h-4 bg-slate-100 rounded w-1/4 skeleton"></div>
                                        </div>
                                         <div class="flex justify-between">
                                            <div class="h-4 bg-slate-100 rounded w-1/3 skeleton"></div>
                                            <div class="h-4 bg-slate-100 rounded w-1/4 skeleton"></div>
                                        </div>
                                         <div class="flex justify-between">
                                            <div class="h-4 bg-slate-100 rounded w-1/3 skeleton"></div>
                                            <div class="h-4 bg-slate-100 rounded w-1/4 skeleton"></div>
                                        </div>
                                    </div>
                                </td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Right Column -->
                <div class="space-y-6">

                    <!-- Vehicle Chart -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm h-fit">
                        <h3 class="font-bold text-slate-800 mb-4 text-sm">Jenis Kendaraan</h3>
                        <div class="relative h-[180px] flex justify-center items-center">
                            <!-- Skeleton Overlay -->
                            <div id="vehicleChart-skeleton" class="absolute inset-0 z-10 bg-white flex items-center justify-center">
                                <div class="w-32 h-32 rounded-full border-4 border-slate-100 skeleton"></div>
                            </div>
                            <canvas id="vehicleChart"></canvas>
                            <div class="absolute text-center pointer-events-none">
                                <span class="block text-2xl font-bold text-slate-800">Total</span>
                                <span class="text-xs text-slate-500">Kendaraan</span>
                            </div>
                        </div>
                        <!-- Custom Legend with Percentages -->
                        <div id="vehicle-legend" class="mt-4 space-y-2">
                             <!-- Populated by JS -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- ANALYTICS SECTION 2: TOP SPOTS & GEOGRAPHIC -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pb-8">
                
                <!-- WIDGET 1: TOP 5 POTENTIAL SPOTS -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="font-bold text-lg text-slate-800">Grafik Keramaian Lokasi</h3>
                            <p class="text-sm text-slate-500">Statistik Top 5 Spot</p>
                        </div>
                    </div>
                    <div class="h-[300px] w-full relative">
                        <!-- Skeleton Overlay -->
                         <div id="trafficChart-skeleton" class="absolute inset-0 z-10 bg-white flex items-end gap-4 p-4">
                            <div class="w-full h-[30%] bg-slate-100 rounded-t-lg skeleton"></div>
                            <div class="w-full h-[60%] bg-slate-100 rounded-t-lg skeleton"></div>
                            <div class="w-full h-[40%] bg-slate-100 rounded-t-lg skeleton"></div>
                            <div class="w-full h-[80%] bg-slate-100 rounded-t-lg skeleton"></div>
                            <div class="w-full h-[50%] bg-slate-100 rounded-t-lg skeleton"></div>
                        </div>
                        <canvas id="trafficChart"></canvas>
                    </div>
                </div>

                <!-- WIDGET 2: GEOGRAPHIC DISTRIBUTION -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                    <h3 class="font-bold text-lg text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-map-marked-alt text-blue-500"></i> Sebaran Titik
                    </h3>
                    <div class="h-[250px] w-full relative">
                        <!-- Skeleton Overlay -->
                        <div id="geoChart-skeleton" class="absolute inset-0 z-10 bg-white flex flex-col gap-3 p-4">
                             <div class="w-full h-8 bg-slate-100 rounded skeleton"></div>
                             <div class="w-3/4 h-8 bg-slate-100 rounded skeleton"></div>
                             <div class="w-5/6 h-8 bg-slate-100 rounded skeleton"></div>
                             <div class="w-2/4 h-8 bg-slate-100 rounded skeleton"></div>
                             <div class="w-full h-8 bg-slate-100 rounded skeleton"></div>
                        </div>
                        <canvas id="geoChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- VIEW 2: PETA LOKASI -->
        <div id="view-map" class="view-section h-full relative fade-in">
            
            <!-- FLOATING SEARCH BAR & FILTERS (REVISED V2: Top Header Bar) -->
            <!-- Adjusted position to sit right of Google Maps Type Control (approx 180px) -->
            <div class="absolute top-3 left-[180px] right-14 z-[550] flex flex-col md:flex-row items-start md:items-center gap-2 pointer-events-none max-w-full overflow-x-auto no-scrollbar pr-2">
                
                <!-- SEARCH INPUT -->
                <div class="relative group pointer-events-auto rounded-lg shadow-sm min-w-[280px] md:w-[320px]">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                    </div>
                    <input type="text" id="map-search-input" 
                        onkeyup="handleMapSearch()"
                        class="block w-full pl-9 pr-8 py-2.5 border-0 rounded-lg bg-white/95 backdrop-blur-sm text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-100 transition-all shadow-sm" 
                        placeholder="Cari lokasi, jalan..."
                        autocomplete="off">
                    
                    <!-- Clear Button -->
                    <button id="map-search-clear" onclick="clearMapSearch()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-300 hover:text-red-500 hidden cursor-pointer transition-colors">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>

                     <!-- Results Dropdown -->
                    <div id="map-search-results" class="hidden absolute top-full left-0 mt-2 w-full bg-white rounded-xl shadow-[0_10px_40px_rgb(0,0,0,0.12)] overflow-hidden border border-slate-100 max-h-[400px] overflow-y-auto custom-scrollbar pointer-events-auto z-[1000]">
                        <!-- Results List -->
                    </div>
                </div>

                <!-- FILTERS ROW (Horizontal Scroll on Mobile) -->
                <div class="flex items-center gap-2 pointer-events-auto pb-1 md:pb-0">
                    
                    <!-- PROVINCE FILTER -->
                    <div class="relative group rounded-lg bg-white/95 backdrop-blur-sm shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                            <i class="fa-solid fa-map text-slate-400 group-focus-within:text-blue-500 text-xs"></i>
                        </div>
                        <select id="filter-map-province" onchange="handleMapFilterChange()" class="block w-[140px] pl-8 pr-6 py-2.5 border-0 rounded-lg bg-transparent text-xs font-bold text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-100 cursor-pointer appearance-none truncate">
                            <option value="">Semua Provinsi</option>
                            <!-- Populated by JS -->
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                        </div>
                    </div>

                    <!-- CITY FILTER -->
                    <div class="relative group rounded-lg bg-white/95 backdrop-blur-sm shadow-sm">
                         <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                            <i class="fa-solid fa-city text-slate-400 group-focus-within:text-blue-500 text-xs"></i>
                        </div>
                        <select id="filter-map-city" onchange="handleMapFilterChange()" class="block w-[130px] pl-8 pr-6 py-2.5 border-0 rounded-lg bg-transparent text-xs font-bold text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-100 cursor-pointer appearance-none truncate disabled:opacity-50 disabled:cursor-not-allowed">
                            <option value="">Semua Kota</option>
                             <!-- Populated by JS -->
                        </select>
                         <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                        </div>
                    </div>

                    <!-- TYPE FILTER -->
                    <div class="relative group rounded-lg bg-white/95 backdrop-blur-sm shadow-sm">
                         <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                            <i class="fa-solid fa-layer-group text-slate-400 group-focus-within:text-blue-500 text-xs"></i>
                        </div>
                        <select id="filter-map-type" onchange="handleMapFilterChange()" class="block w-[130px] pl-8 pr-6 py-2.5 border-0 rounded-lg bg-transparent text-xs font-bold text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-100 cursor-pointer appearance-none truncate">
                            <option value="">Semua Tipe</option>
                             <!-- Populated by JS -->
                        </select>
                         <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                        </div>
                    </div>

                    <!-- POSITION FILTER -->
                    <div class="relative group rounded-lg bg-white/95 backdrop-blur-sm shadow-sm">
                         <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                            <i class="fa-solid fa-arrows-up-down-left-right text-slate-400 group-focus-within:text-blue-500 text-xs"></i>
                        </div>
                        <select id="filter-map-position" onchange="handleMapFilterChange()" class="block w-[130px] pl-8 pr-6 py-2.5 border-0 rounded-lg bg-transparent text-xs font-bold text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-100 cursor-pointer appearance-none truncate">
                            <option value="">Semua Posisi</option>
                             <!-- Populated by JS -->
                        </select>
                         <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Map Container -->
            <div id="map-container" class="w-full h-full bg-slate-200 relative"></div>
            
            <!-- Loading Overlay -->
            <div id="map-loading" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-[500] flex flex-col items-center justify-center pointer-events-none transition-opacity duration-500">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-3"></div>
                <p class="text-sm font-semibold text-slate-600 animate-pulse">Memuat Peta...</p>
            </div>
        </div>

        <!-- FLOATING SEARCH RESULTS PANEL (NEW APPROACH) -->
        <div id="floating-search-results" style="display:none; position:fixed; top:140px; left:200px; width:400px; max-height:500px; background:white; border-radius:16px; box-shadow:0 20px 60px rgba(0,0,0,0.2); z-index:10000; overflow-y:auto; border:2px solid #3b82f6;">
            <!-- Results will be injected here -->
        </div>

        <!-- FLOATING ANALYSIS CARD (Map View) -->
        <div id="map-analysis-card" class="absolute top-24 right-4 bottom-4 w-[350px] bg-white rounded-xl shadow-2xl z-[600] transform translate-x-[120%] transition-transform duration-300 flex flex-col pointer-events-auto border border-slate-200">
            <!-- Header -->
            <div class="p-4 border-b border-slate-100 flex justify-between items-start bg-slate-50 rounded-t-xl">
                <div>
                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider bg-blue-50 px-2 py-0.5 rounded border border-blue-100 mb-3 inline-block">ANALYSIS MODE</span>
                    <h3 class="font-bold text-slate-800 leading-tight text-sm" id="map-card-title">Billboard A88</h3>
                    <p class="text-[10px] text-slate-500 truncate w-[220px]" id="map-card-address">Jl. Jend. Sudirman No. 1</p>
                </div>
                <button onclick="closeMapAnalysis()" class="w-7 h-7 flex items-center justify-center rounded-full bg-slate-200 text-slate-500 hover:bg-red-50 hover:text-red-500 transition shadow-sm">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
            
            <!-- Floating Action Button for Report -->
            <div class="absolute top-4 right-14">
                <button id="btn-generate-report" class="bg-gray-900 hover:bg-black text-white text-[10px] font-bold px-3 py-1.5 rounded-lg shadow-md flex items-center gap-2 transition-transform hover:scale-105">
                    <i class="fa-solid fa-image"></i> Lihat Detail
                </button>
            </div>
            
            <!-- Content (Scrollable) -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4 custom-scrollbar">
                
                <!-- KPI 1: Traffic -->
                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-[10px] text-blue-600 font-bold uppercase">AVG. VIEWS</span>
                        <i class="fa-solid fa-eye text-blue-400"></i>
                    </div>
                    <p class="text-2xl font-bold text-slate-800" id="map-card-traffic">12,500</p>
                    <div class="flex items-center gap-2 mt-1">
                         <span class="text-[10px] bg-white px-1.5 py-0.5 rounded border border-blue-100 text-slate-500" id="map-card-updated-box">
                            <i class="fa-regular fa-clock mr-1"></i><span id="map-card-updated-text">Updated</span>
                         </span>
                    </div>
                </div>

                <!-- KPI Group -->
                <div class="grid grid-cols-2 gap-3">
                    <!-- KPI 2: AI Score -->
                    <div class="bg-indigo-50 p-3 rounded-xl border border-indigo-100">
                         <span class="text-[10px] text-indigo-600 font-bold uppercase block mb-1">{{ __('geospasial.kpi.ai_score') }}</span>
                         <p class="text-xl font-bold text-slate-800" id="map-card-score">8.5</p>
                         <div class="flex text-[8px] text-yellow-500 mt-1">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                         </div>
                    </div>
                     <!-- KPI 3: Audience -->
                    <div class="bg-purple-50 p-3 rounded-xl border border-purple-100">
                         <span class="text-[10px] text-purple-600 font-bold uppercase block mb-1">Audience</span>
                         <p class="text-sm font-bold text-slate-800" id="map-card-audience">25-34 Thn</p>
                         <p class="text-[10px] text-slate-500 mt-0.5">Dominasi</p>
                    </div>
                </div>

                <!-- Chart: Vehicle Types -->
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <h4 class="text-[10px] font-bold text-slate-700 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-car-side text-slate-400"></i> Jenis Kendaraan
                    </h4>
                    <div class="h-[140px] relative w-full">
                         <canvas id="mapVehicleChart"></canvas>
                    </div>
                     <!-- Micro Legend -->
                    <div class="flex justify-center gap-3 mt-3 text-[10px] text-slate-500" id="vehicle-legend-map">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <!-- Action Removed -->

            </div>
        </div>


        <!-- VIEW 4: DETAILED ANALYSIS (Replica of User Image) -->
        <div id="view-analysis" class="view-section p-6 max-w-[1600px] mx-auto w-full fade-in pb-20">
                <!-- Detail Lokasi Intelligence Header Removed to Avoid Duplication with Main Header -->

            <!-- Back Button -->
            <button onclick="switchView('map')" class="mb-6 flex items-center gap-2 text-slate-500 hover:text-slate-800 transition font-medium text-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Peta
            </button>

            <!-- DOUBLE POSTER CONTAINER -->
            <div class="flex flex-wrap justify-center gap-6 pb-20 items-stretch">
                
                <!-- 1. LEFT POSTER: VISUALS (Reconstructed Reference Style - Image Only) -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 p-6 w-full lg:w-[48%] max-w-[700px] flex flex-col relative overflow-hidden h-full">
                    
                    <!-- DOWNLOAD BUTTON: Left -->
                    <button onclick="downloadVisual()" data-html2canvas-ignore="true" class="absolute top-6 right-6 z-50 bg-black hover:bg-slate-800 text-white text-[10px] font-bold py-2 px-3 rounded-lg transition shadow-lg flex items-center gap-2">
                        <i class="fa-solid fa-download"></i> Download Image
                    </button>

                    <!-- Main Image (SCROLLABLE HEIGHT) -->
                    <div class="relative w-full h-full bg-slate-50 rounded-lg overflow-hidden border border-slate-100 mt-8 overflow-y-auto custom-scrollbar">
                        <img id="poster-image" src="" class="w-full h-auto object-cover">
                    </div>
                </div>

                <!-- 2. RIGHT POSTER: LOCATION INTELLIGENCE (A4 Landscape) -->
                <div id="right-poster-container" class="bg-white rounded-[2rem] shadow-xl border border-slate-200 p-6 lg:p-8 w-full lg:w-[48%] max-w-[700px] relative overflow-hidden flex flex-col h-full">
                
                <!-- DOWNLOAD BUTTON: Right (Ignored by html2canvas) -->
                <button onclick="downloadData()" data-html2canvas-ignore="true" class="absolute top-6 right-6 z-50 bg-black hover:bg-slate-800 text-white text-[10px] font-bold py-2 px-3 rounded-lg transition shadow-lg flex items-center gap-2">
                    <i class="fa-solid fa-download"></i> Download Image
                </button>

                <!-- Decorative Top Border -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400"></div>

                <!-- Title Section -->
                <div class="mb-6 flex justify-between items-end">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Location Intelligence</h2>
                      
                    </div>

                </div>

                <!-- Grid Layout Refactored -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
                    
                    <!-- [LEFT COLUMN] -->
                    <div class="flex flex-col gap-5">
                         
                         <!-- 1. AVG VIEWS (Moved to Top Left) -->
                         <div class="bg-white p-5 rounded-xl border border-purple-100 shadow-sm relative overflow-hidden group hover:border-purple-200 transition h-[160px] flex flex-col justify-center">
                            <div class="absolute right-0 top-0 w-16 h-16 bg-purple-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-purple-100"></div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-2 mb-1">
                                    <div class="w-5 h-5 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                                        <i class="fa-solid fa-eye text-[10px]"></i>
                                    </div>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase">AVG. VIEWS/DAY</span>
                                </div>
                                <h2 class="text-4xl font-extrabold text-slate-800 tracking-tight" id="detail-avg-views">0</h2>
                                <div class="mt-1 text-[10px] font-bold text-green-500 flex items-center gap-1">
                                    <i class="fa-solid fa-arrow-trend-up"></i> Consistent Growth
                                </div>
                            </div>
                         </div>

                         <!-- 2. TECH SPECS (Moved to Left, below Avg Views) -->
                         <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm space-y-3 relative group h-[225px] flex flex-col justify-center">
                            <!-- EDIT BUTTON (Moved Inside Tech Specs) -->
                            <button onclick="toggleEditMode()" id="btn-edit-location" class="absolute top-1 right-4 text-slate-400 hover:text-blue-600 transition p-1 z-10" title="Edit Data Lokasi">
                                <i class="fa-solid fa-pen-to-square"></i> <span class="text-xs font-bold">Edit</span>
                            </button>

                            <!-- Hidden Fields for JS Logic Compatibility (Area Name, Lat, Lng) -->
                            <div class="hidden">
                                <div id="detail-area-name"></div>
                                <div id="detail-lat"></div>
                                <div id="detail-lng"></div>
                            </div>

                            <div class="flex justify-between items-center border-b border-slate-50 pb-2 mt-4">
                                 <span class="text-xs font-medium text-slate-500">Media Type</span>
                                 <span class="text-xs font-bold text-slate-800" id="detail-type">-</span>
                            </div>
                             <div class="flex justify-between items-center border-b border-slate-50 pb-2">
                                 <span class="text-xs font-medium text-slate-500">Size (WxH)</span>
                                 <span class="text-xs font-bold text-slate-800" id="detail-size">-</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-slate-50 pb-2">
                                 <span class="text-xs font-medium text-slate-500">Orientation</span>
                                 <span class="text-xs font-bold text-slate-800" id="detail-orientation">Vertical / 1 Sisi</span>
                            </div>
                             <div class="flex justify-between items-center text-indigo-600 pt-1">
                                 <span class="text-xs font-bold flex items-center gap-2"><i class="fa-solid fa-wand-sparkles"></i> AI Score</span>
                                 <span class="text-xl font-extrabold" id="detail-ai-score">-</span>
                            </div>
                         </div>

                         <!-- 3. PLACE NEAR LOCATION (Limit 5 Items) -->
                         <div class="bg-white p-5 rounded-xl border border-slate-100 flex-1 flex flex-col h-full min-h-[350px]">
                            <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-location-crosshairs text-blue-500"></i> Place Near Location
                            </h3>
                            <!-- List fills remaining space -->
                            <div class="space-y-1 flex-1 overflow-y-auto pr-2 custom-scrollbar" id="detail-places-list">
                                 <!-- Filled by JS (Max 5 items) -->
                            </div>
                        </div>

                    </div>

                    <!-- [RIGHT COLUMN] -->
                    <div class="flex flex-col gap-5">

                         <!-- 1. IMPRESSIONS (Top Right) -->
                         <div class="bg-white p-5 rounded-xl border border-pink-100 shadow-sm relative overflow-hidden group hover:border-pink-200 transition h-[160px] flex flex-col justify-center">
                            <div class="absolute right-0 top-0 w-16 h-16 bg-pink-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-pink-100"></div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fa-solid fa-award text-pink-500 text-lg"></i>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase">TOTAL IMPRESSIONS (MO)</span>
                                </div>
                                <h2 class="text-4xl font-extrabold text-slate-800 tracking-tight" id="detail-impressions">0</h2>
                                <p class="text-[10px] text-slate-400 mt-1">Estimated monthly exposure</p>
                            </div>
                         </div>

                         <!-- 2. AUDIENCE PROFILE (Below Impressions) -->
                         <!-- 2. AUDIENCE PROFILE (Below Impressions) -->
                         <div class="bg-white p-5 rounded-xl border border-slate-100 h-[225px] flex flex-col justify-center">
                             <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-users-viewfinder text-purple-500"></i> Audience Profile
                            </h3>
                            
                            <div class="bg-slate-50 p-3 rounded-lg flex justify-between items-center mb-5 border border-slate-100">
                                <span class="text-slate-500 font-medium text-xs">Dominant Age</span>
                                <span class="bg-white px-3 py-1 rounded-md font-bold text-slate-800 border border-slate-200 shadow-sm text-xs" id="detail-dominant-age">18-24 Thn</span>
                            </div>
    
                            <!-- Gender Bar -->
                            <div class="mb-1.5 flex justify-between text-[9px] text-slate-400 font-bold uppercase tracking-wider">
                                <span>Male</span><span>Female</span>
                            </div>
                            <div class="w-full h-3 bg-red-100 rounded-full overflow-hidden flex mb-1.5">
                                <div class="h-full bg-blue-500" style="width: 55%"></div>
                                <div class="h-full bg-pink-400" style="width: 45%"></div>
                            </div>
                             <div class="flex justify-between text-[10px] font-bold text-slate-700">
                                <span>55%</span><span>45%</span>
                            </div>
                        </div>

                        <!-- 3. VEHICLE DISTRIBUTION CHART (Below Audience Profile) -->
                        <div class="bg-white p-5 rounded-xl border border-slate-100 h-[350px] flex flex-col">
                            <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wide mb-2">VEHICLE DISTRIBUTION</h3>
                            <div class="flex-1 relative flex items-center justify-center">
                                <div class="h-56 w-full relative">
                                    <canvas id="detailVehicleChart"></canvas>
                                </div>
                            </div>
                        </div>

                    </div> 

                </div> 
                
                <!-- [BOTTOM ROW - FULL WIDTH] -->
                <!-- VEHICLE DATA DETAIL (Memanjang) -->
                 <div class="bg-white p-8 rounded-xl border border-slate-100 w-full overflow-y-auto custom-scrollbar mt-5 min-h-[180px] flex flex-col justify-center">
                    <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wide mb-6 border-b pb-4">VEHICLE DATA DETAIL</h3>
                    <!-- Use grid for horizontal items or keep list but full width -->
                    <div class="space-y-3 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-6" id="detail-vehicle-list">
                         <!-- Filled by JS -->
                    </div>
                </div>
            </div>
        </div>

        <!-- VIEW 3: LAPORAN -->
        <div id="view-reports" class="view-section p-8 max-w-[1200px] mx-auto w-full fade-in">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800">Pusat Laporan</h3>
                        <p class="text-sm text-slate-500">Unduh laporan detail per lokasi.</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Periode</th>
                                <th class="px-6 py-4">Lokasi</th>
                                <th class="px-6 py-4">Impressions</th>
                                <th class="px-6 py-4">Tanggal Laporan</th>
                                <th class="px-6 py-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-bold text-slate-800">November 2024</td>
                                <td class="px-6 py-4">Simpang Sudirman</td>
                                <td class="px-6 py-4 text-blue-600 font-semibold">1,240,500</td>
                                <td class="px-6 py-4 text-slate-500">01 Des 2024</td>
                                <td class="px-6 py-4">
                                    <button class="text-blue-600 hover:text-blue-800 font-bold flex items-center gap-2"><i class="fa-solid fa-download"></i> PDF</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-bold text-slate-800">Oktober 2024</td>
                                <td class="px-6 py-4">Simpang Sudirman</td>
                                <td class="px-6 py-4 text-blue-600 font-semibold">1,105,200</td>
                                <td class="px-6 py-4 text-slate-500">01 Nov 2024</td>
                                <td class="px-6 py-4">
                                    <button class="text-blue-600 hover:text-blue-800 font-bold flex items-center gap-2"><i class="fa-solid fa-download"></i> PDF</button>
                                </td>
                            </tr>
                             <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-bold text-slate-800">September 2024</td>
                                <td class="px-6 py-4">Simpang Sudirman</td>
                                <td class="px-6 py-4 text-blue-600 font-semibold">980,000</td>
                                <td class="px-6 py-4 text-slate-500">01 Okt 2024</td>
                                <td class="px-6 py-4">
                                    <button class="text-blue-600 hover:text-blue-800 font-bold flex items-center gap-2"><i class="fa-solid fa-download"></i> PDF</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ROBUST GOOGLE MAPS LOADER -->
    <script>
        (function(g) {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
        })({
            key: "{{ config('services.google.maps_key') }}",
            v: "weekly",
            libraries: "places,geometry", // Preload places
            loading: "async"
        });
    </script>

    <!-- GEOSPASIAL V2 CUSTOM LOGIC -->
    <script src="{{ asset('js/geospasial_v2.js') }}"></script>
</body>
</html>

