<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planner</title>
    <script src="https://unpkg.com/htmx.org@1.9.4" onload="console.log('HTMX loaded')"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .navbar {
            background: linear-gradient(90deg, #2b5876 0%, #4e4376 100%);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 1rem 2rem;
        }
        .navbar-brand {
            font-family: 'Segoe UI', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: #fff !important;
            transform: translateY(-2px);
        }
        .main-content {
            flex: 1 0 auto;
            padding: 2rem;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.95);
        }
        .btn-primary {
            background: #4e4376;
            border: none;
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: #2b5876;
            transform: translateY(-2px);
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
        }
        .task-banner {
            background: #fff;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .task-banner:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        .task-details {
            flex-grow: 1;
        }
        .task-actions {
            display: flex;
            gap: 0.5rem;
        }
        .task-icon {
            margin-right: 1rem;
            color: #4e4376;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">Planner</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-danger">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="card p-4 mb-4">
            <h1 class="mb-4">Planner</h1>

            @auth
            <form hx-post="/activities" hx-target="#activity-list" hx-swap="beforeend" hx-indicator=".htmx-indicator">
    @csrf
    <div class="row g-3">
        <div class="col-md-4">
            <input type="text" name="title" placeholder="Activity Title" required class="form-control">
        </div>
        <div class="col-md-3">
            <input type="date" name="date" required class="form-control">
        </div>
        <div class="col-md-2">
            <input type="time" name="time" required class="form-control">
        </div>
        <div class="col-md-2">
            <input type="text" name="description" placeholder="Description" required class="form-control">
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary w-100">Add</button>
        </div>
    </div>
</form>


                <div id="activity-list">
                    @if(isset($activities) && $activities->count() > 0)
                        @foreach($activities as $activity)
                            @include('activities.partials.activity', ['activity' => $activity])
                        @endforeach
                    @else
                        <p>No activities available.</p>
                        @if(isset($error))
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endif
                    @endif
                </div>
            @else
                <div class="alert alert-info text-center">
                    Please <a href="{{ route('login') }}" class="alert-link">login</a> to manage your planner.
                </div>
            @endauth
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>