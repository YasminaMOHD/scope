<ul class="sidebar toggled navbar-nav">
    <li class="nav-item  {{request()->routeIs('admin.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{route('admin.index')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    @can('view-role')
    <li class="nav-item  {{request()->routeIs('superAdmin.role.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{route('superAdmin.role.index')}}">
            <i class="fas fa-hands-helping"></i>
            <span>Role</span>
        </a>
    </li>
    @endcan
    @can('view-status')
    <li class="nav-item  {{request()->routeIs('superAdmin.status.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{route('superAdmin.status.index')}}">
            <i class="fas fa-fw fa-list"></i>
            <span>Lead Status</span>
        </a>
    </li>
    @endcan
    @can('view-lead')
    <li class="nav-item {{request()->routeIs('lead.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{route('lead.index')}}">
            <i class="fas fa-fire-alt"></i>
            <span> Leads</span></a>
    </li>
    @endcan
    @can('view-project')
    <li class="nav-item {{request()->routeIs('admin.project.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{route('admin.project.index')}}">
            <i class="far fa-building"></i>
            <span> Projects</span></a>
    </li>
    @endcan
    @can('view-agent')
    <li class="nav-item {{request()->routeIs('admin.agent.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{route('admin.agent.index')}}">
            <i class="fas fa-user-tie"></i>
            <span> Agents</span></a>
    </li>
    @endcan
    @can('view-agent')
    <li class="nav-item {{request()->routeIs('admin.agent_lead.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{route('admin.agent_lead.index')}}">
            <i class="fas fa-arrow-right"></i>
            <span> Assign Leads Agent</span></a>
    </li>
    @endcan
    @can('create-lead')
    {{-- @can('can:viwe-excel,App\Models\Excel::class') --}}
    <li class="nav-item {{request()->routeIs('admin.excel') ? 'active' : ''}}">
        <a class="nav-link" href="{{route('admin.excel')}}">
            <i class="far fa-file-excel"></i>
            <span> Excel</span></a>
    </li>
    @endcan
    @can('view-project')
    <li class="nav-item {{request()->routeIs('admin.landing.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{route('admin.landing.index')}}">
            <i class="fas fa-file-upload"></i>
            <span> Landing</span></a>
    </li>
    @endcan
    @can('view-project')
    <li class="nav-item {{request()->routeIs('admin.campaigen.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{route('admin.campaigen.index')}}">
            <i class="fas fa-bullhorn"></i>
            <span> Campaigns</span></a>
    </li>
    @endcan
    @can('view-user')
    <li class="nav-item {{request()->routeIs('admin.secuirety') ? 'active' : ''}}">
        <a class="nav-link" href="{{route('admin.secuirety')}}">
            <i class="fas fa-key"></i>
            <span> Security</span></a>
    </li>
    @endcan
</ul>
