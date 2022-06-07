<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container min-vh-100 d-flex align-items-center">
    <div class="d-flex flex-grow-1 flex-column">
        <div class="card card-effect">
            <div class="card-header bg-transparent px-4">
                <h1 class="display-4 mt-2">Fertiliser Inventory</h1>
            </div>
            <div class="card-body px-4">
                <form method="post" action="/fertiliser-request">
                    @csrf

                    <div class="input-group my-3 has-validation">
                        <span class="input-group-text">No. of units needed</span>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                               name="quantity">
                        <button class="btn btn-primary fw-bold text-uppercase" type="submit">Request</button>

                        @error('quantity')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </form>

                @if(session('success'))
                    <div class="alert alert-success mt-4" role="alert">
                        <h4 class="alert-heading">Inventory Updated!</h4>
                        <p>{{session('success')}}
                            <strong>{{session('data.quantity')}}</strong>
                            units valued at <strong>{{session('data.value')}}</strong>
                        </p>
                        <hr>
                        <p class="mb-0">
                            <strong>Remaining: </strong> {{session('data.remaining')}}
                        </p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger d-flex align-items-center mt-4" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                             class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                             aria-label="Warning:">
                            <path
                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                        <div>
                            {{session('error')}}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</body>
</html>
