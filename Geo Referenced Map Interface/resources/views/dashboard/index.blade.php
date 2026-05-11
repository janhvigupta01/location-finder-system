@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col">
                <h1>{{ __('messages.dashboard') }}</h1>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('messages.total_locations') }}</h5>
                        <h2 class="text-primary">{{ $totalLocations }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('messages.quick_actions') }}</h5>
                        <a href="{{ route('locations.create') }}" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-plus"></i> {{ __('messages.add_location') }}
                        </a>
                        <a href="{{ route('map') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-map"></i> {{ __('messages.view_map') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('messages.user_info') }}</h5>
                        <p class="mb-0">{{ Auth::user()->name }}</p>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Locations -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('messages.recent_locations') }}</h5>
                <a href="{{ route('locations.index') }}" class="btn btn-sm btn-outline-primary">
                    {{ __('messages.view_all') }}
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('messages.location_name') }}</th>
                            <th>{{ __('messages.category') }}</th>
                            <th>{{ __('messages.coordinates') }}</th>
                            <th>{{ __('messages.created') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLocations as $location)
                            <tr>
                                <td>
                                    <strong>{{ $location->location_name }}</strong>
                                </td>
                                <td>
                                    <span class="category-badge category-{{ strtolower($location->category->category_name ?? 'other') }}">
                                        {{ $location->category->category_name ?? 'Other' }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ number_format($location->latitude, 4) }}, {{ number_format($location->longitude, 4) }}</small>
                                </td>
                                <td>
                                    <small>{{ $location->created_at->format('M d, Y') }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('locations.show', $location) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('locations.edit', $location) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('locations.destroy', $location) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('messages.confirm_delete') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <p class="text-muted mb-0">{{ __('messages.no_locations_yet') }}</p>
                                    <a href="{{ route('locations.create') }}" class="btn btn-sm btn-primary mt-2">
                                        {{ __('messages.add_your_first_location') }}
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Getting Started Guide -->
        <div class="card bg-light">
            <div class="card-body">
                <h5 class="card-title">{{ __('messages.getting_started') }}</h5>
                <ol>
                    <li>{{ __('messages.guide_step_1') }}</li>
                    <li>{{ __('messages.guide_step_2') }}</li>
                    <li>{{ __('messages.guide_step_3') }}</li>
                    <li>{{ __('messages.guide_step_4') }}</li>
                </ol>
                <p class="mb-0">{{ __('messages.for_api_help') }} <a href="{{ route('about') }}">{{ __('messages.documentation') }}</a></p>
            </div>
        </div>
    </div>
@endsection
