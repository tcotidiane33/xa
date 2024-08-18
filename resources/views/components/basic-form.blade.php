@props(['action' => '#', 'method' => 'POST'])

<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>{{ $title ?? 'Basic Form' }}</h4>
    </div>
    <div class="form-body">
        <form action="{{ $action }}" method="{{ $method }}">
            @csrf
            {{ $slot }}
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</div>



{{-- used
<x-basic-form action="{{ route('some.route') }}" method="POST">
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
</x-basic-form> --}}
