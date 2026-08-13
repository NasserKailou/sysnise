@extends('layouts.app')

@section('content')
<div class="sys-dashboard">
    <div class="dashboard-header">
        <div>
            <div class="eyebrow"><i class="bi bi-bar-chart-fill"></i> SYSNISE • PILOTAGE NATIONAL</div>
            <h1>Suivi des projets</h1>
            <p>Système National Intégré de Suivi-Évaluation</p>
        </div>
        <div class="clock-box">
            <div id="clock">--:--:--</div>
            <span id="date-label">{{ now()->locale('fr')->translatedFormat('l d F Y') }}</span>
        </div>
    </div>

    <div class="kpi-grid">
        <div class="kpi kpi-blue"><div class="kpi-icon"><i class="bi bi-folder2-open"></i></div><div><span>PROJETS</span><strong>{{ number_format($stats['total_projets'], 0, ',', ' ') }}</strong><small>Portefeuille total</small></div></div>
        <div class="kpi kpi-cyan"><div class="kpi-icon"><i class="bi bi-lightning-charge-fill"></i></div><div><span>EN COURS</span><strong>{{ number_format($stats['projets_actifs'], 0, ',', ' ') }}</strong><small>Projets en exécution</small></div></div>
        <div class="kpi kpi-purple"><div class="kpi-icon"><i class="bi bi-cash-stack"></i></div><div><span>FINANCEMENT</span><strong>{{ number_format($stats['total_financement']/1000000000, 1, ',', ' ') }} <em>Mds</em></strong><small>FCFA mobilisés</small></div></div>
        <div class="kpi kpi-green"><div class="kpi-icon"><i class="bi bi-graph-up-arrow"></i></div><div><span>EXÉCUTION</span><strong>{{ number_format($stats['taux_execution'], 1, ',', ' ') }}<em>%</em></strong><small>{{ number_format($stats['total_budget_depense']/1000000000, 1, ',', ' ') }} Mds dépensés</small></div></div>
    </div>

    <div class="dashboard-grid grid-top">
        <section class="panel">
            <div class="panel-title"><div><i class="bi bi-diagram-3-fill"></i><h2>Financement par secteur</h2></div><span class="live-dot">DONNÉES RÉELLES</span></div>
            <div class="chart-wrap"><canvas id="secteurChart"></canvas></div>
        </section>
        <section class="panel">
            <div class="panel-title"><div><i class="bi bi-pie-chart-fill"></i><h2>État du portefeuille</h2></div></div>
            <div class="chart-wrap doughnut-wrap"><canvas id="statutChart"></canvas></div>
        </section>
    </div>

    <div class="dashboard-grid grid-middle">
        <section class="panel">
            <div class="panel-title"><div><i class="bi bi-graph-up-arrow"></i><h2>Budget prévu vs dépensé</h2></div></div>
            <div class="chart-wrap tall"><canvas id="budgetChart"></canvas></div>
        </section>
        <section class="panel">
            <div class="panel-title"><div><i class="bi bi-geo-alt-fill"></i><h2>Financement par région</h2></div></div>
            <div class="chart-wrap"><canvas id="regionChart"></canvas></div>
        </section>
    </div>

    <section class="panel alert-panel">
        <div class="panel-title">
            <div><i class="bi bi-exclamation-triangle-fill"></i><h2>Projets nécessitant une attention</h2></div>
            <span class="alert-count">{{ $alertes->count() }} alerte(s)</span>
        </div>
        @if($alertes->count())
        <div class="alerts">
            @foreach($alertes->take(6) as $alerte)
            <div class="alert-row {{ $alerte['niveau'] }}">
                <div class="alert-status"><i class="bi {{ $alerte['niveau'] === 'critique' ? 'bi-exclamation-octagon-fill' : 'bi-exclamation-circle-fill' }}"></i></div>
                <div class="alert-project"><strong>{{ $alerte['sigle'] ?: 'Projet #'.$alerte['id'] }}</strong><span>{{ \Illuminate\Support\Str::limit($alerte['intitule'], 75) }}</span></div>
                <div class="alert-msg">{{ $alerte['message'] }}</div>
                <div class="alert-metric"><strong>{{ number_format($alerte['execution'], 1) }}%</strong><span>exécution</span></div>
                @if($alerte['temps'] !== null)<div class="alert-metric"><strong>{{ number_format($alerte['temps'], 0) }}%</strong><span>temps écoulé</span></div>@endif
            </div>
            @endforeach
        </div>
        @else
            <div class="empty-state"><i class="bi bi-check2-circle"></i><span>Aucune alerte critique détectée sur le portefeuille.</span></div>
        @endif
    </section>

    <section class="panel">
        <div class="panel-title">
            <div><i class="bi bi-table"></i><h2>Situation financière des projets</h2></div>
            <div class="exports">
                <a href="{{ route('dashboard.export.projets') }}" class="btn-dashboard"><i class="bi bi-download"></i> Projets CSV</a>
                <a href="{{ route('dashboard.export.cadres') }}" class="btn-dashboard"><i class="bi bi-download"></i> Cadres CSV</a>
            </div>
        </div>
        <div class="table-responsive">
            <table id="projetsTable" class="table dashboard-table">
                <thead><tr><th>Projet</th><th>Statut</th><th>Financement</th><th>Budgété</th><th>Dépensé</th><th>Exécution</th></tr></thead>
                <tbody>
                @foreach($projetsFinancement as $projet)
                    @php
                        $taux = (float)($projet->taux_consommation ?? 0);
                        $tone = $taux >= 70 ? 'good' : ($taux >= 40 ? 'warn' : 'bad');
                    @endphp
                    <tr>
                        <td><div class="project-cell"><strong>{{ $projet->sigle ?: 'Projet #'.$projet->id }}</strong><span>{{ \Illuminate\Support\Str::limit($projet->intitule, 55) }}</span></div></td>
                        <td><span class="status-badge">{{ $projet->statut ?: 'Non défini' }}</span></td>
                        <td style="color:#fff">{{ number_format((float)$projet->financement_prevu/1000000, 1, ',', ' ') }} M</td>
                        <td style="color:#fff">{{ number_format((float)$projet->budget_budgetise/1000000, 1, ',', ' ') }} M</td>
                        <td style="color:#fff">{{ number_format((float)$projet->budget_depense/1000000, 1, ',', ' ') }} M</td>
                        <td style="color:#fff"><div class="progress-box"><div class="progress-track"><div class="progress-fill {{ $tone }}" style="width:{{ min(100,max(0,$taux)) }}%"></div></div><b>{{ number_format($taux, 1) }}%</b></div></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <div class="dashboard-footer">
        <span><i class="bi bi-circle-fill"></i> Données actualisées automatiquement</span>
        <span>SYSNISE • INS Niger</span>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
:root{--navy:#061a2b;--navy2:#0b2942;--card:#102f48;--card2:#123a59;--blue:#1683d8;--cyan:#27b7e8;--green:#27c47a;--orange:#f5a623;--red:#ef5350;--text:#f5faff;--muted:#9cb3c7;--line:rgba(255,255,255,.11)}
.sys-dashboard{margin:-1rem;min-height:calc(100vh - 60px);padding:22px;background:radial-gradient(circle at 10% 0%,rgba(22,131,216,.18),transparent 30%),linear-gradient(145deg,var(--navy),#071f34 55%,#082944);color:var(--text)}
.dashboard-header{display:flex;justify-content:space-between;align-items:center;padding:20px 24px;margin-bottom:12px;border-bottom:1px solid var(--line);background:linear-gradient(135deg,rgba(22,131,216,.23),rgba(12,48,75,.7));border-radius:18px;box-shadow:0 14px 35px rgba(0,0,0,.18)}
.eyebrow{color:#7bdcff;font-size:.72rem;font-weight:800;letter-spacing:1.4px;margin-bottom:5px}.dashboard-header h1{margin:0;font-size:1.65rem;font-weight:800}.dashboard-header p{margin:3px 0 0;color:var(--muted);font-size:.82rem}.clock-box{text-align:right}.clock-box #clock{font-size:1.9rem;font-weight:900;color:#7ce1ff;line-height:1}.clock-box span{font-size:.72rem;color:#a9d4e7;text-transform:capitalize}
.kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:12px}.kpi{display:flex;gap:14px;align-items:center;padding:15px 17px;border:1px solid var(--line);border-radius:16px;background:linear-gradient(135deg,rgba(255,255,255,.075),rgba(255,255,255,.025));box-shadow:0 10px 25px rgba(0,0,0,.16);position:relative;overflow:hidden}.kpi:after{content:"";position:absolute;inset:auto -20px -35px auto;width:100px;height:100px;border-radius:50%;background:var(--accent);opacity:.12}.kpi-icon{width:48px;height:48px;border-radius:13px;display:grid;place-items:center;background:color-mix(in srgb,var(--accent) 18%,transparent);color:var(--accent);font-size:1.3rem}.kpi span{display:block;color:#9db8c9;font-size:.66rem;font-weight:800;letter-spacing:.8px}.kpi strong{display:block;font-size:1.55rem;line-height:1.15;color:#fff}.kpi em{font-style:normal;font-size:.72rem;color:#b4d4e4}.kpi small{color:#86a5b9;font-size:.67rem}.kpi-blue{--accent:#1683d8}.kpi-cyan{--accent:#27b7e8}.kpi-purple{--accent:#8b7cf6}.kpi-green{--accent:#27c47a}
.dashboard-grid{display:grid;gap:12px;margin-bottom:12px}.grid-top{grid-template-columns:1.55fr 1fr}.grid-middle{grid-template-columns:1.45fr 1fr}.panel{background:linear-gradient(145deg,rgba(18,58,89,.84),rgba(8,37,58,.92));border:1px solid var(--line);border-radius:17px;overflow:hidden;box-shadow:0 12px 28px rgba(0,0,0,.17)}.panel-title{display:flex;align-items:center;justify-content:space-between;padding:13px 16px;border-bottom:1px solid var(--line);background:rgba(255,255,255,.025)}.panel-title>div{display:flex;align-items:center;gap:9px}.panel-title i{color:#55cfff}.panel-title h2{font-size:.86rem;margin:0;font-weight:800}.live-dot,.alert-count{font-size:.62rem;font-weight:800;color:#7ee9b0}.live-dot:before{content:"";display:inline-block;width:7px;height:7px;border-radius:50%;background:var(--green);margin-right:6px;box-shadow:0 0 10px var(--green)}.alert-count{color:#ffc46b}.chart-wrap{height:285px;padding:15px}.chart-wrap.tall{height:310px}.doughnut-wrap{height:285px}.alert-panel{margin-bottom:12px}.alerts{padding:8px 12px}.alert-row{display:grid;grid-template-columns:34px 1.5fr 1.5fr 90px 90px;gap:10px;align-items:center;padding:10px 6px;border-bottom:1px solid rgba(255,255,255,.07)}.alert-row:last-child{border-bottom:0}.alert-status{font-size:1.1rem}.alert-row.critique .alert-status{color:var(--red)}.alert-row.attention .alert-status{color:var(--orange)}.alert-project strong,.alert-project span{display:block}.alert-project strong{font-size:.78rem}.alert-project span,.alert-msg{font-size:.68rem;color:var(--muted)}.alert-metric{text-align:right}.alert-metric strong{display:block;font-size:.82rem}.alert-metric span{font-size:.6rem;color:var(--muted)}.empty-state{padding:28px;text-align:center;color:#9ccbb4}.empty-state i{font-size:1.8rem;display:block;color:var(--green);margin-bottom:6px}.exports{display:flex;gap:7px}.btn-dashboard{font-size:.65rem;color:#bdeeff;border:1px solid rgba(39,183,232,.35);padding:6px 9px;border-radius:8px;text-decoration:none;background:rgba(39,183,232,.08)}.btn-dashboard:hover{background:rgba(39,183,232,.18);color:#fff}.table-responsive{padding:4px 10px 10px}.dashboard-table{color:#dbeaf3!important;margin:0!important;font-size:.72rem}.dashboard-table thead th{color:#82c8e7;border-bottom:1px solid rgba(255,255,255,.12);background:rgba(0,0,0,.12);font-size:.64rem;text-transform:uppercase;letter-spacing:.4px}.dashboard-table tbody td{border-color:rgba(255,255,255,.07);vertical-align:middle;padding:9px 7px}.dashboard-table tbody tr:hover{background:rgba(39,183,232,.07)}.project-cell strong,.project-cell span{display:block}.project-cell strong{color:#67d8ff}.project-cell span{color:#8da8ba;font-size:.64rem}.status-badge{border:1px solid rgba(39,183,232,.25);background:rgba(39,183,232,.08);padding:4px 7px;border-radius:7px;color:#a8dff2;font-size:.62rem}.progress-box{display:flex;align-items:center;gap:7px;min-width:135px}.progress-box b{font-size:.65rem;width:38px}.progress-track{height:6px;flex:1;background:rgba(255,255,255,.09);border-radius:8px;overflow:hidden}.progress-fill{height:100%;border-radius:8px}.progress-fill.good{background:var(--green)}.progress-fill.warn{background:var(--orange)}.progress-fill.bad{background:var(--red)}.dashboard-footer{display:flex;justify-content:space-between;padding:12px 5px 2px;color:#7595a9;font-size:.65rem}.dashboard-footer i{color:var(--green);font-size:.48rem;margin-right:4px}
.dataTables_wrapper .dataTables_length,.dataTables_wrapper .dataTables_filter,.dataTables_wrapper .dataTables_info,.dataTables_wrapper .dataTables_paginate{color:#8faabc!important;font-size:.68rem}.dataTables_wrapper .form-control,.dataTables_wrapper select{background:#0a2941!important;color:#dcecf5!important;border-color:rgba(255,255,255,.13)!important;font-size:.68rem}.dataTables_wrapper .page-link{background:#0a2941;color:#9ed8ee;border-color:rgba(255,255,255,.1)}
@media(max-width:1100px){.kpi-grid{grid-template-columns:repeat(2,1fr)}.grid-top,.grid-middle{grid-template-columns:1fr}}@media(max-width:650px){.sys-dashboard{padding:10px}.dashboard-header{padding:15px}.clock-box{display:none}.kpi-grid{grid-template-columns:1fr}.alert-row{grid-template-columns:28px 1fr 80px}.alert-msg{display:none}.alert-metric:last-child{display:none}.panel-title{padding:11px}.exports{display:none}}

.sys-dashboard #projetsTable,
.sys-dashboard #projetsTable_wrapper,
.sys-dashboard #projetsTable tbody,
.sys-dashboard #projetsTable tr,
.sys-dashboard #projetsTable td,
.sys-dashboard #projetsTable th {
    background: transparent !important;
}

.sys-dashboard .clock-box {
    background: var(--sys-header);
    border: 1px solid var(--sys-line);
    border-radius: 14px;
    padding: 12px 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,.14);
}

</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
(function(){
    const colors={blue:'#1683d8',cyan:'#27b7e8',green:'#27c47a',orange:'#f5a623',red:'#ef5350',purple:'#8b7cf6',muted:'#7f9bad',grid:'rgba(255,255,255,.08)'};
    Chart.defaults.font.family="'Segoe UI',Arial,sans-serif"; Chart.defaults.color='#9cb3c7';
    Chart.defaults.plugins.legend.labels.usePointStyle=true;
    Chart.defaults.plugins.legend.labels.boxWidth=8;

    function money(v){v=Number(v||0); if(Math.abs(v)>=1e9)return (v/1e9).toLocaleString('fr-FR',{maximumFractionDigits:1})+' Mds FCFA'; if(Math.abs(v)>=1e6)return (v/1e6).toLocaleString('fr-FR',{maximumFractionDigits:1})+' M FCFA'; return v.toLocaleString('fr-FR')+' FCFA';}
    const secteurs=@json($chartsData['financement_par_secteur']);
    const regions=@json($chartsData['financement_par_region']);
    const statuts=@json($chartsData['projets_par_statut']);
    const budgets=@json($chartsData['evolution_budgets']);

    new Chart(document.getElementById('secteurChart'),{type:'bar',data:{labels:secteurs.map(x=>x.secteur),datasets:[{label:'Financement',data:secteurs.map(x=>Number(x.montant)),backgroundColor:colors.blue,borderRadius:7,barThickness:18}]},options:{indexAxis:'y',responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:{callbacks:{label:c=>money(c.raw)}}},scales:{x:{grid:{color:colors.grid},ticks:{callback:v=>money(v)}},y:{grid:{display:false},ticks:{color:'#d3e5ee'}}}}});
    new Chart(document.getElementById('regionChart'),{type:'bar',data:{labels:regions.map(x=>x.region),datasets:[{label:'Financement',data:regions.map(x=>Number(x.montant)),backgroundColor:colors.cyan,borderRadius:7,barThickness:22}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:{callbacks:{label:c=>money(c.raw)}}},scales:{x:{grid:{display:false},ticks:{color:'#a8c0cf'}},y:{grid:{color:colors.grid},ticks:{callback:v=>money(v)}}}}});
    new Chart(document.getElementById('statutChart'),{type:'doughnut',data:{labels:statuts.map(x=>x.statut),datasets:[{data:statuts.map(x=>Number(x.nombre)),backgroundColor:[colors.blue,colors.cyan,colors.green,colors.orange,colors.red,colors.purple],borderColor:'#123a59',borderWidth:3}]},options:{responsive:true,maintainAspectRatio:false,cutout:'67%',plugins:{legend:{position:'bottom',labels:{padding:12,color:'#cfe1eb'}},tooltip:{callbacks:{label:c=>`${c.label}: ${Number(c.raw).toLocaleString('fr-FR')} projet(s)`}}}}});
    const years=[...new Set(budgets.map(x=>x.annee))].sort();
    const types=[...new Set(budgets.map(x=>String(x.type).toLowerCase()))];
    const findType=(keys,year)=>{const r=budgets.find(x=>Number(x.annee)===Number(year)&&keys.some(k=>String(x.type).toLowerCase().includes(k)));return r?Number(r.montant):0};
    new Chart(document.getElementById('budgetChart'),{type:'line',data:{labels:years,datasets:[
        {label:'Prévu / budgété',data:years.map(y=>findType(['prévu','prevu','budgetisé','budgetise','budgété','budgete'],y)),borderColor:colors.blue,backgroundColor:'rgba(22,131,216,.14)',fill:true,tension:.35,pointRadius:3},
        {label:'Dépensé',data:years.map(y=>findType(['dépens','depens'],y)),borderColor:colors.green,backgroundColor:'rgba(39,196,122,.08)',fill:true,tension:.35,pointRadius:3}
    ]},options:{responsive:true,maintainAspectRatio:false,interaction:{intersect:false,mode:'index'},plugins:{legend:{position:'top'},tooltip:{callbacks:{label:c=>`${c.dataset.label}: ${money(c.raw)}`}}},scales:{x:{grid:{color:colors.grid}},y:{grid:{color:colors.grid},ticks:{callback:v=>money(v)}}}}});
    if(window.jQuery){jQuery('#projetsTable').DataTable({pageLength:10,order:[[5,'desc']],language:{search:'Rechercher :',lengthMenu:'_MENU_ lignes',info:'_START_ à _END_ sur _TOTAL_',paginate:{previous:'‹',next:'›'},zeroRecords:'Aucun projet trouvé'}});}
    function clock(){const d=new Date();document.getElementById('clock').textContent=d.toLocaleTimeString('fr-FR');}
    clock();setInterval(clock,1000);
})();
</script>
@endpush
