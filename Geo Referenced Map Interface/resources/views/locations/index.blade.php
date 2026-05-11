@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col">
                <h1>{{ __('messages.my_locations') }}</h1>
            </div>
            <div class="col-auto">
                <a href="{{ route('locations.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('messages.add_location') }}
                </a>
            </div>
        </div>

        <!-- Filter Options -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('locations.index') }}" class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="{{ __('messages.search_location') }}" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-control">
                            <option value="">{{ __('messages.all_categories') }}</option>
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            {{ __('messages.filter') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Locations Table -->
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('messages.image') }}</th>
                            <th>{{ __('messages.location_name') }}</th>
                            <th>{{ __('messages.category') }}</th>
                            <th>{{ __('messages.coordinates') }}</th>
                            <th>{{ __('messages.created') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($locations as $location)
                            <tr>
                                <td>
                                    <img src="{{ $location->getImageUrl() }}" alt="{{ $location->location_name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                </td>
                                <td>
                                    <strong>{{ $location->location_name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Str::limit($location->description, 50) }}</small>
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
                                <td colspan="6" class="text-center py-4">
                                    <p class="text-muted mb-0">{{ __('messages.no_locations_found') }}</p>
                                    <a href="{{ route('locations.create') }}" class="btn btn-sm btn-primary mt-2">
                                        {{ __('messages.add_location') }}
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($locations->total() > $locations->perPage())
            <div class="d-flex justify-content-center mt-4">
                {{ $locations->links() }}
            </div>
        @endif
    </div>
@endsection
