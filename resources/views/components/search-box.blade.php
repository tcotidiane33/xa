<div class="search-box">
    <form class="input" action="{{ route('search') }}" method="GET">
        <input class="sb-search-input input__field--madoka" placeholder="Search..." type="search" id="input-31" name="q" />
        <label class="input__label" for="input-31">
            <svg class="graphic" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
                <path d="m0,0l404,0l0,77l-404,0l0,-77z"/>
            </svg>
        </label>
    </form>
</div>


{{-- used :
@include('components.search-box')
 --}}
