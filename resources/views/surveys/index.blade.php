@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Surveys</h1>

    @if($surveys->isEmpty())
        <p>No surveys available.</p>
    @else
        <div class="row">
            @foreach($surveys as $survey)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <!-- Image -->
                        <img src="{{ asset('storage/' . $survey->image) }}" alt="Survey Image" class="card-img-top" style="max-height: 200px; object-fit: cover;">

                        <div class="card-body">
                            <h5 class="card-title">{{ $survey->title }}</h5>
                            <p class="card-text">{{ \Str::limit($survey->description, 100) }}</p>
                            <a href="{{ route('surveys.show', $survey->id) }}" class="btn btn-primary">View Survey</a>

                            <!-- Show Edit and Delete buttons if the user is the creator -->
                            @auth
                            @if(auth()->id() === $survey->user_id || auth()->user()->role ==="admin")
                                <div class="mt-2">
                                    <a href="{{ route('surveys.edit', $survey->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('surveys.destroy', $survey->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this survey?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            @endif
                            @endauth
                            @guest
                                
                            @endguest

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination with Fade-in effect -->
        <div class="d-flex justify-content-center" style="opacity: 0;">
            {{ $surveys->links('pagination::simple-bootstrap-5') }}
        </div>
    @endif
</div>

<script>
    // Smooth fade-in effect for the pagination links
    window.addEventListener('DOMContentLoaded', (event) => {
        const paginationLinks = document.querySelector('.d-flex.justify-content-center');
        paginationLinks.style.opacity = 1;
    });
</script>
@endsection
