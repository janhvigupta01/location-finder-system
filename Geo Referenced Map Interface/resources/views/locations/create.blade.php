@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h1 class="mb-2">{{ __('messages.add_location') }}</h1>
                    <p class="text-secondary">{{ __('Create a new location and add it to your map') }}</p>
                </div>

                <form action="{{ route('locations.store') }}" method="POST" enctype="multipart/form-data" class="card">
                    @csrf
                    <div class="card-body">
                        <!-- Location Name -->
                        <div class="mb-4">
                            <label for="location_name" class="form-label">{{ __('messages.location_name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location_name') is-invalid @enderror" id="location_name" name="location_name" value="{{ old('location_name') }}" placeholder="Enter location name" required>
                            @error('location_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label">{{ __('messages.description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Enter location description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label for="category_id" class="form-label">{{ __('messages.category') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">{{ __('messages.select_category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Coordinates -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">{{ __('messages.latitude') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" step="0.00000001" value="{{ old('latitude') }}" placeholder="e.g., 28.7041" required>
                                @error('latitude')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-secondary">Range: -90 to 90</small>
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">{{ __('messages.longitude') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" step="0.00000001" value="{{ old('longitude') }}" placeholder="e.g., 77.1025" required>
                                @error('longitude')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-secondary">Range: -180 to 180</small>
                            </div>
                        </div>

                        <!-- Map for coordinate selection -->
                        <div class="mb-4">
                            <label class="form-label">{{ __('messages.or_click_map') }}</label>
                            <div id="map" style="height: 300px; border-radius: 0.75rem;"></div>
                            <small class="form-text text-secondary d-block mt-2">{{ __('Click on the map to automatically fill coordinates') }}</small>
                        </div>

                        <!-- Image -->
                        <div class="mb-4">
                            <label for="image" class="form-label">{{ __('messages.image') }}</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-secondary">{{ __('messages.max_file_size') }}: 2MB. {{ __('messages.formats') }}: JPEG, PNG, GIF</small>
                        </div>

                        <!-- Preview Image -->
                        <div id="imagePreview" class="mb-4" style="display: none;">
                            <label class="form-label">Image Preview</label>
                            <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 0.75rem; border: 1px solid #e2e8f0;">
                        </div>
                    </div>

                    <div class="card-footer d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('messages.save_location') }}
                        </button>
                        <a href="{{ route('locations.index') }}" class="btn btn-secondary">
                            {{ __('messages.cancel') }}
                        </a>
                    </div>
                </form>
            </div>

            <!-- Helpful Info Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ __('messages.tips') }}</h5>
                        <ul class="small">
                            <li>{{ __('messages.tip_location_name') }}</li>
                            <li>{{ __('messages.tip_coordinates') }}</li>
                            <li>{{ __('messages.tip_map_click') }}</li>
                            <li>{{ __('messages.tip_image_upload') }}</li>
                            <li>{{ __('messages.tip_category_select') }}</li>
                        </ul>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h5>{{ __('messages.example_locations') }}</h5>
                        <small>
                            <strong>Delhi:</strong> 28.7041, 77.1025<br>
                            <strong>Mumbai:</strong> 19.0760, 72.8777<br>
                            <strong>Bangalore:</strong> 12.9716, 77.5946<br>
                            <strong>Hyderabad:</strong> 17.3850, 78.4867
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Initialize map
        const map = L.map('map').setView([28.7041, 77.1025], 12);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        let marker = null;

        // Get initial coordinates if they exist
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        if (latInput.value && lngInput.value) {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);
            marker = L.marker([lat, lng]).addTo(map);
            map.setView([lat, lng], 14);
        }

        // Handle map clicks
        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            
            // Update input fields
            latInput.value = lat.toFixed(8);
            lngInput.value = lng.toFixed(8);

            // Update or create marker
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
        });

        // Handle coordinate input changes
        latInput.addEventListener('change', updateMapFromInputs);
        lngInput.addEventListener('change', updateMapFromInputs);

        function updateMapFromInputs() {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);
            
            if (!isNaN(lat) && !isNaN(lng)) {
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng]).addTo(map);
                }
                map.setView([lat, lng], 14);
            }
        }

        // Image preview
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('previewImg').src = event.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
