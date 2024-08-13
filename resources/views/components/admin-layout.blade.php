<!-- resources/views/components/admin-layout.blade.php -->

<div class="admin-layout">
    <header>
        <!-- Inclure ici le header, la barre de navigation, etc. -->
        {{ $header }}
    </header>
    
    <main>
        {{ $slot }}
    </main>
</div>
