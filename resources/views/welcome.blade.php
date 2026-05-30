<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Dependent Dropdown Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; border-radius: 10px; }
        .table-container { background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); }
    </style>
</head>

<body>
    <div class="container-fluid px-5 mt-5">
        <h2 class="mb-5 text-center fw-bold text-dark">Location Management Dashboard</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card p-4 shadow-sm bg-white">
                    <h4 class="mb-4 text-secondary border-bottom pb-2 fw-semibold">Add New Entry</h4>
                    <form method="POST" action="{{ route('dropdown.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold small text-muted">Entry Name / Description</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Country</label>
                            <select id="country-dd" name="country" class="form-select" required>
                                <option value="">Select Country</option>
                                @foreach ($countries as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">State</label>
                            <select id="state-dd" name="state" class="form-select" required>
                                <option value="">Select State</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">City</label>
                            <select id="city-dd" name="city" class="form-select" required>
                                <option value="">Select City</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm">Save Record</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="table-container shadow-sm">
                    <h4 class="mb-4 text-secondary border-bottom pb-2 fw-semibold">Registered Entries</h4>
                    <div class="table-responsive" style="max-height: 480px; overflow-y: auto;">
                        <table class="table table-hover align-middle">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="py-3">Name</th>
                                    <th class="py-3">Country</th>
                                    <th class="py-3">State</th>
                                    <th class="py-3">City</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($submitted_data as $row)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $row->entry_name }}</td>
                                        <td><span class="badge bg-secondary px-2 py-1.5">{{ $row->country_name }}</span></td>
                                        <td>{{ $row->state_name }}</td>
                                        <td>{{ $row->city_name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted italic">
                                            No records exist in the database yet. Fill out the form to add one!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Country Change Handler
            $('#country-dd').on('change', function() {
                var idCountry = this.value;
                $("#state-dd").html('<option value="">Select State</option>');
                $("#city-dd").html('<option value="">Select City</option>');
                
                if(!idCountry) return;

                $.ajax({
                    url: "{{url('api/fetch-states')}}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $.each(result.states, function(key, value) {
                            $("#state-dd").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });

            // State Change Handler
            $('#state-dd').on('change', function() {
                var idState = this.value;
                $("#city-dd").html('<option value="">Select City</option>');
                
                if(!idState) return;

                $.ajax({
                    url: "{{url('api/fetch-cities')}}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        $.each(res.cities, function(key, value) {
                            $("#city-dd").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>