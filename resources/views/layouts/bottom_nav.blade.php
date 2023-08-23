<div class="appBottomMenu">
    <a href="{{ route('dashboard') }}" class="item {{ \Route::is('dashboard') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline" role="img" class="md hydrated" aria-label="home-outline"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>
    <a href="#" class="item ">
        <div class="col">
            <ion-icon name="document-text-outline" role="img" class="md hydrated"
                aria-label="document text outline"></ion-icon>
            <strong>Histori</strong>
        </div>
    </a>
    <a href="{{ route('presensi.create') }}" class="item">
        <div class="col">
            <div class="action-button large bg-info">
                <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
            </div>
        </div>
    </a>
    <a href="#" class="item">
        <div class="col">
            <ion-icon name="newspaper-outline" role="img" class="md hydrated"
                aria-label="newspaper-outline"></ion-icon>
            <strong>Izin</strong>
        </div>
    </a>
    <a href="{{ route('profil.editprofil') }}" class="item {{ \Route::is('profil.editprofil') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
            <strong>Profil</strong>
        </div>
    </a>
</div>
