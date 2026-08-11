@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- En-tête avec horloge et statistiques clés -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="dashboard-title">
                            <i class="bi bi-speedometer2"></i> Tableau de Bord - SysNISE
                        </h2>
                        <p class="text-muted mb-0">Système National Intégré de Suivi Évaluation</p>
                    </div>
                    <div class="text-end">
                        <div class="clock-container">
                            <div class="clock-time" id="clock">{{ date('H:i:s') }}</div>
                            <div class="clock-date">{{ date('l j F Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cartes statistiques -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card stat-primary">
                <div class="stat-icon">
                    <i class="bi bi-folder-fill"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Projets</div>
                    <div class="stat-value">{{ number_format($stats['total_projets']) }}</div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card stat-success">
                <div class="stat-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Projets Actifs</div>
                    <div class="stat-value">{{ number_format($stats['projets_actifs']) }}</div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card stat-info">
                <div class="stat-icon">
                    <i class="bi bi-diagram-3-fill"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Cadres Stratégiques</div>
                    <div class="stat-value">{{ number_format($stats['total_cadres']) }}</div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card stat-warning">
                <div class="stat-icon">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Financement Total</div>
                    <div class="stat-value">{{ number_format($stats['total_financement'], 0, ',', ' ') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques principaux -->
    <div class="row mb-4">
        <!-- Financement par secteur -->
        <div class="col-lg-6 mb-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h5><i class="bi bi-pie-chart-fill"></i> Financement par Secteur</h5>
                    <button class="btn btn-sm btn-outline-primary" onclick="refreshChart('secteurChart')">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
                <div class="chart-body">
                    <canvas id="secteurChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Financement par région -->
        <div class="col-lg-6 mb-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h5><i class="bi bi-geo-alt-fill"></i> Financement par Région</h5>
                    <button class="btn btn-sm btn-outline-primary" onclick="refreshChart('regionChart')">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
                <div class="chart-body">
                    <canvas id="regionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Projets par statut -->
        <div class="col-lg-4 mb-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h5><i class="bi bi-graph-up"></i> Projets par Statut</h5>
                </div>
                <div class="chart-body">
                    <canvas id="statutChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Financement par bailleur -->
        <div class="col-lg-8 mb-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h5><i class="bi bi-building"></i> Top 10 Bailleurs</h5>
                </div>
                <div class="chart-body">
                    <canvas id="bailleurChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Evolution des budgets -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="chart-card">
                <div class="chart-header">
                    <h5><i class="bi bi-graph-up-arrow"></i> Évolution des Budgets (Prévu vs Dépensé)</h5>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-success" onclick="toggleDataset(budgetChart, 0)">
                            <i class="bi bi-eye"></i> Budget Prévu
                        </button>
                        <button class="btn btn-outline-danger" onclick="toggleDataset(budgetChart, 1)">
                            <i class="bi bi-eye"></i> Budget Dépensé
                        </button>
                    </div>
                </div>
                <div class="chart-body" style="height: 400px;">
                    <canvas id="budgetChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des financements par projet -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-table"></i> Situation des Financements par Projet
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="projetsTable" class="table table-hover table-striped" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>Projet</th>
                                    <th class="text-end">Financement Prévu</th>
                                    <th class="text-end">Budget Budgétisé</th>
                                    <th class="text-end">Montant Dépensé</th>
                                    <th class="text-center" style="min-width: 200px;">Taux de Consommation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projetsFinancement as $projet)
                                <tr>
                                    <td>
                                        <div class="projet-info">
                                            <div class="fw-bold text-primary">{{ $projet->sigle }}</div>
                                            <div class="small text-muted">{{ Str::limit($projet->intitule, 50) }}</div>
                                            <div class="small">
                                                <span class="badge bg-info text-dark">{{ $projet->secteurs ?: 'Non défini' }}</span>
                                            </div>
                                            <div class="small text-secondary">
                                                <i class="bi bi-building"></i> {{ Str::limit($projet->institution_tutelle ?: 'Non défini', 40) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold text-primary">
                                            {{ number_format($projet->financement_prevu, 0, ',', ' ') }}
                                        </span>
                                        <div class="small text-muted">FCFA</div>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold text-info">
                                            {{ number_format($projet->budget_budgetise, 0, ',', ' ') }}
                                        </span>
                                        <div class="small text-muted">FCFA</div>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold text-success">
                                            {{ number_format($projet->budget_depense, 0, ',', ' ') }}
                                        </span>
                                        <div class="small text-muted">FCFA</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="progress flex-grow-1" style="height: 25px;">
                                                @php
                                                    $taux = $projet->taux_consommation;
                                                    $couleur = $taux >= 80 ? 'success' : ($taux >= 50 ? 'warning' : 'danger');
                                                @endphp
                                                <div class="progress-bar bg-{{ $couleur }}" 
                                                     role="progressbar" 
                                                     style="width: {{ min($taux, 100) }}%"
                                                     aria-valuenow="{{ $taux }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    <span class="fw-bold">{{ number_format($taux, 1) }}%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Boutons d'export -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-download"></i> Exports de Données</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="export-item">
                                <div class="export-icon">
                                    <i class="bi bi-file-earmark-spreadsheet"></i>
                                </div>
                                <div class="export-content">
                                    <h6>Fichier Plat - Projets</h6>
                                    <p class="text-muted mb-2">Export complet des projets avec toutes les données associées</p>
                                    <a href="{{ route('dashboard.export.projets') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-download"></i> Télécharger CSV
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="export-item">
                                <div class="export-icon">
                                    <i class="bi bi-file-earmark-spreadsheet"></i>
                                </div>
                                <div class="export-content">
                                    <h6>Fichier Plat - Cadres Stratégiques</h6>
                                    <p class="text-muted mb-2">Export des indicateurs par niveau (Impact, Effet, Produit)</p>
                                    <a href="{{ route('dashboard.export.cadres') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-download"></i> Télécharger CSV
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        padding: 2rem;
        border-radius: 15px;
        color: white;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .dashboard-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
    }

    .clock-container {
        background: rgba(255, 255, 255, 0.1);
        padding: 1rem 1.5rem;
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }

    .clock-time {
        font-size: 2rem;
        font-weight: 700;
        font-family: 'Courier New', monospace;
        letter-spacing: 2px;
    }

    .clock-date {
        font-size: 0.9rem;
        opacity: 0.9;
        text-transform: capitalize;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s, box-shadow 0.3s;
        border-left: 4px solid;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-primary { border-color: #3b82f6; }
    .stat-success { border-color: #10b981; }
    .stat-info { border-color: #06b6d4; }
    .stat-warning { border-color: #f59e0b; }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    .stat-primary .stat-icon {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .stat-success .stat-icon {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .stat-info .stat-icon {
        background: rgba(6, 182, 212, 0.1);
        color: #06b6d4;
    }

    .stat-warning .stat-icon {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e293b;
    }

    .chart-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        height: 100%;
    }

    .chart-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 1rem 1.5rem;
        border-bottom: 2px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chart-header h5 {
        margin: 0;
        font-weight: 600;
        color: #1e293b;
        font-size: 1.1rem;
    }

    .chart-body {
        padding: 1.5rem;
        position: relative;
    }

    .chart-footer {
        padding: 1rem 1.5rem;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }

    .export-item {
        display: flex;
        gap: 1rem;
        align-items: center;
        padding: 1.5rem;
        background: #f8fafc;
        border-radius: 10px;
        transition: all 0.3s;
    }

    .export-item:hover {
        background: #e0f2fe;
        transform: translateX(5px);
    }

    .export-icon {
        font-size: 2.5rem;
        color: #3b82f6;
    }

    .export-content h6 {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    }

    /* Animation pour les cartes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card, .chart-card {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Styles pour le tableau des projets */
    .projet-info {
        line-height: 1.6;
    }

    .projet-info .fw-bold {
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
    }

    .projet-info .small {
        font-size: 0.85rem;
        margin-bottom: 0.15rem;
    }

    #projetsTable tbody tr {
        transition: all 0.3s ease;
    }

    #projetsTable tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.05) !important;
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    #projetsTable .progress {
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        overflow: hidden;
    }

    #projetsTable .progress-bar {
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: width 1s ease-in-out;
    }

    /* Responsive pour DataTables */
    @media (max-width: 768px) {
        #projetsTable_wrapper .dataTables_length,
        #projetsTable_wrapper .dataTables_filter {
            text-align: center;
            margin-bottom: 1rem;
        }
    }

</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
    // Horloge en temps réel
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('fr-FR');
        document.getElementById('clock').textContent = timeString;
    }
    setInterval(updateClock, 1000);

    // Couleurs du thème
    const colors = {
        primary: '#3b82f6',
        success: '#10b981',
        warning: '#f59e0b',
        danger: '#ef4444',
        info: '#06b6d4',
        purple: '#8b5cf6',
        pink: '#ec4899'
    };

    // Palette de couleurs pour les graphiques
    const chartColors = [
        '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#06b6d4', 
        '#8b5cf6', '#ec4899', '#f97316', '#84cc16', '#06b6d4'
    ];

    // Configuration globale Chart.js
    Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    Chart.defaults.color = '#64748b';

    // Financement par secteur
    const secteurData = @json($chartsData['financement_par_secteur']);
    const secteurChart = new Chart(document.getElementById('secteurChart'), {
        type: 'doughnut',
        data: {
            labels: secteurData.map(s => s.secteur),
            datasets: [{
                data: secteurData.map(s => s.montant),
                backgroundColor: chartColors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        padding: 15,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = new Intl.NumberFormat('fr-FR').format(context.parsed);
                            return label + ': ' + value + ' FCFA';
                        }
                    }
                }
            }
        }
    });

    // Financement par région
    const regionData = @json($chartsData['financement_par_region']);
    const regionChart = new Chart(document.getElementById('regionChart'), {
        type: 'bar',
        data: {
            labels: regionData.map(r => r.region),
            datasets: [{
                label: 'Financement',
                data: regionData.map(r => r.montant),
                backgroundColor: colors.primary,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('fr-FR').format(context.parsed.x) + ' FCFA';
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR', {
                                notation: 'compact',
                                compactDisplay: 'short'
                            }).format(value);
                        }
                    }
                }
            }
        }
    });

    // Projets par statut
    const statutData = @json($chartsData['projets_par_statut']);
    const statutChart = new Chart(document.getElementById('statutChart'), {
        type: 'pie',
        data: {
            labels: statutData.map(s => s.statut),
            datasets: [{
                data: statutData.map(s => s.nombre),
                backgroundColor: chartColors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Financement par bailleur
    const bailleurData = @json($chartsData['financement_par_bailleur']);
    const bailleurChart = new Chart(document.getElementById('bailleurChart'), {
        type: 'bar',
        data: {
            labels: bailleurData.map(b => b.bailleur),
            datasets: [{
                label: 'Financement',
                data: bailleurData.map(b => b.montant),
                backgroundColor: colors.success,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('fr-FR').format(context.parsed.y) + ' FCFA';
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR', {
                                notation: 'compact',
                                compactDisplay: 'short'
                            }).format(value);
                        }
                    }
                }
            }
        }
    });

    // Evolution des budgets
    const evolutionData = @json($chartsData['evolution_budgets']);
    const annees = [...new Set(evolutionData.map(e => e.annee))].sort();
    const budgetPrevu = annees.map(annee => {
        const item = evolutionData.find(e => e.annee === annee && e.type.toLowerCase().includes('prévu'));
        return item ? item.montant : 0;
    });
    const budgetDepense = annees.map(annee => {
        const item = evolutionData.find(e => e.annee === annee && e.type.toLowerCase().includes('dépensé'));
        return item ? item.montant : 0;
    });

    const budgetChart = new Chart(document.getElementById('budgetChart'), {
        type: 'line',
        data: {
            labels: annees,
            datasets: [
                {
                    label: 'Budget Prévu',
                    data: budgetPrevu,
                    borderColor: colors.success,
                    backgroundColor: colors.success + '20',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Budget Dépensé',
                    data: budgetDepense,
                    borderColor: colors.danger,
                    backgroundColor: colors.danger + '20',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + 
                                new Intl.NumberFormat('fr-FR').format(context.parsed.y) + ' FCFA';
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR', {
                                notation: 'compact',
                                compactDisplay: 'short'
                            }).format(value);
                        }
                    }
                }
            }
        }
    });

    // Répartition par sexe
    const sexeData = @json($chartsData['repartition_sexe']);
    const sexeChart = new Chart(document.getElementById('sexeChart'), {
        type: 'doughnut',
        data: {
            labels: sexeData.map(s => s.sexe),
            datasets: [{
                data: sexeData.map(s => s.nombre),
                backgroundColor: [colors.success, colors.warning],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = ((context.parsed / total) * 100).toFixed(0);
                            return context.label + ': ' + 
                                new Intl.NumberFormat('fr-FR').format(context.parsed) + 
                                ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Candidats par tranche d'âge
    const ageData = @json($chartsData['tranches_age']);
    const ageChart = new Chart(document.getElementById('ageChart'), {
        type: 'bar',
        data: {
            labels: ageData.map(a => a.tranche),
            datasets: [{
                label: 'Nombre de candidats',
                data: ageData.map(a => a.nombre),
                backgroundColor: chartColors.slice(0, ageData.length),
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('fr-FR').format(context.parsed.y) + ' candidats';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR').format(value);
                        }
                    }
                }
            }
        }
    });

    // Initialisation de DataTables pour le tableau des projets
    $(document).ready(function() {
        $('#projetsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json'
            },
            pageLength: 10,
            order: [[0, 'asc']],
            columnDefs: [
                {
                    targets: [1, 2, 3],
                    className: 'text-end'
                },
                {
                    targets: 4,
                    orderable: true,
                    className: 'text-center'
                }
            ],
            responsive: true,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
            drawCallback: function() {
                // Animation des barres de progression après le rendu
                $('.progress-bar').each(function() {
                    $(this).css('width', '0%');
                    const width = $(this).attr('aria-valuenow') + '%';
                    $(this).animate({width: width}, 1000);
                });
            }
        });
    });

    // Fonction pour rafraîchir un graphique
    function refreshChart(chartId) {
        location.reload();
    }

    // Fonction pour basculer la visibilité d'un dataset
    function toggleDataset(chart, index) {
        const meta = chart.getDatasetMeta(index);
        meta.hidden = !meta.hidden;
        chart.update();
    }
</script>
@endpush
@endsection
