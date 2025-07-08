{{-- resources/views/components/navbar.blade.php --}}
<nav class="bg-gradient-to-r from-white to-gray-50 shadow-lg border-b border-gray-200 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="/index" class="flex items-center space-x-3 group">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-leaf text-2xl text-green-600"></i>
                        <h1 class="text-xl font-bold text-green-600">CESIZen</h1>
                    </div>
                </a>
            </div>

            {{-- Menu Desktop --}}
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-2">
                    <a href="/index" 
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 transform hover:scale-105 
                              {{ request()->is('index') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                        <i class="fas fa-home mr-2"></i>
                        Accueil
                    </a>
                    <a href="/exercice" 
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 transform hover:scale-105 
                              {{ request()->is('exercice*') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                        <i class="fas fa-wind mr-2"></i>
                        Exercices
                    </a>
                    <div id="dashboard-link-desktop" style="display: none;">
                        <a href="/dashboard" 
                           class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 transform hover:scale-105 
                                  {{ request()->is('dashboard') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                            <i class="fas fa-chart-line mr-2"></i>
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>

            {{-- Menu utilisateur (desktop) --}}
            <div class="hidden md:flex items-center space-x-4">
                {{-- Bouton Connexion --}}
                <div id="login-button-desktop">
                    <form method="GET" action="/login">
                        <button type="submit" 
                                class="flex items-center px-4 py-2 rounded-xl text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-2 text-gray-400"></i>
                            Connexion
                        </button>
                    </form>
                </div>

                {{-- Bouton Déconnexion --}}
                <div id="logout-button-desktop" style="display: none;">
                    <form method="GET" action="/login">
                        <button id="logout-desktop-btn" type="submit" 
                                class="flex items-center px-4 py-2 rounded-xl text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-sign-out-alt mr-2 text-gray-400"></i>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>

            {{-- Menu Mobile Button --}}
            <div class="md:hidden">
                <button type="button" id="mobile-menu-button" 
                        class="inline-flex items-center justify-center p-3 rounded-xl text-gray-700 hover:text-green-600 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500 transition-all duration-300 transform hover:scale-105">
                    <span class="sr-only">Ouvrir le menu</span>
                    {{-- Icône hamburger --}}
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu Mobile --}}
    <div class="md:hidden hidden transform transition-all duration-300 opacity-0 scale-95" id="mobile-menu">
        <div class="px-4 pt-4 pb-6 space-y-2 sm:px-6 bg-gradient-to-br from-white to-gray-50 border-t border-gray-200">
            <a href="/index" 
               class="flex items-center px-4 py-3 rounded-xl text-base font-medium transition-all duration-300 transform hover:scale-105 
                      {{ request()->is('index') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                <i class="fas fa-home mr-3"></i>
                Accueil
            </a>
            <a href="/exercice" 
               class="flex items-center px-4 py-3 rounded-xl text-base font-medium transition-all duration-300 transform hover:scale-105 
                      {{ request()->is('exercice*') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                <i class="fas fa-wind mr-3"></i>
                Exercices
            </a>
            
            {{-- Dashboard mobile (affiché seulement si connecté) --}}
            <div id="dashboard-link-mobile" style="display: none;">
                <a href="/dashboard" 
                   class="flex items-center px-4 py-3 rounded-xl text-base font-medium transition-all duration-300 transform hover:scale-105 
                          {{ request()->is('dashboard') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <i class="fas fa-chart-line mr-3"></i>
                    Dashboard
                </a>
            </div>

            {{-- Séparateur --}}
            <div class="border-t border-gray-200 my-4"></div>

            {{-- Bouton connexion mobile --}}
            <div id="login-button-mobile">
                <form method="GET" action="/login">
                    <button type="submit" 
                            class="flex items-center w-full text-left px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-300">
                        <i class="fas fa-sign-in-alt mr-3"></i>
                        Connexion
                    </button>
                </form>
            </div>

            {{-- Bouton déconnexion mobile --}}
            <div id="logout-button-mobile" style="display: none;">
                <form method="GET" action="/login">
                    <button id="logout-mobile-btn" type="submit" 
                            class="flex items-center w-full text-left px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-300">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

{{-- JavaScript pour le menu mobile + affichage conditionnel --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    // Mobile menu toggle
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function () {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                setTimeout(() => {
                    mobileMenu.classList.remove('opacity-0', 'scale-95');
                    mobileMenu.classList.add('opacity-100', 'scale-100');
                }, 10);
            } else {
                mobileMenu.classList.add('opacity-0', 'scale-95');
                mobileMenu.classList.remove('opacity-100', 'scale-100');
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300);
            }
        });
    }

    // Fermer le menu mobile si clic hors menu
    document.addEventListener('click', function (event) {
        if (mobileMenuButton && mobileMenu && !mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
            mobileMenu.classList.add('opacity-0', 'scale-95');
            mobileMenu.classList.remove('opacity-100', 'scale-100');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
            }, 300);
        }
    });

    // Fonction pour vérifier l'état de connexion
    function checkAuthState() {
        const userLoggedIn = sessionStorage.getItem('userLoggedIn') === 'true';
        const userAdmin = sessionStorage.getItem('isAdmin') === 'true';

        // Éléments desktop
        const loginDesktop = document.getElementById('login-button-desktop');
        const logoutDesktop = document.getElementById('logout-button-desktop');
        const dashboardDesktop = document.getElementById('dashboard-link-desktop');
        
        // Éléments mobile
        const loginMobile = document.getElementById('login-button-mobile');
        const logoutMobile = document.getElementById('logout-button-mobile');
        const dashboardMobile = document.getElementById('dashboard-link-mobile');

        if (userLoggedIn) {
            // Utilisateur connecté
            if (loginDesktop) loginDesktop.style.display = 'none';
            if (logoutDesktop) logoutDesktop.style.display = 'block';
            
            if (loginMobile) loginMobile.style.display = 'none';
            if (logoutMobile) logoutMobile.style.display = 'block';
        } else {
            // Utilisateur non connecté
            if (loginDesktop) loginDesktop.style.display = 'block';
            if (logoutDesktop) logoutDesktop.style.display = 'none';
            if (dashboardDesktop) dashboardDesktop.style.display = 'none';
            
            if (loginMobile) loginMobile.style.display = 'block';
            if (logoutMobile) logoutMobile.style.display = 'none';
            if (dashboardMobile) dashboardMobile.style.display = 'none';
        }

        if (userAdmin){
            if (dashboardDesktop) dashboardDesktop.style.display = 'block';
            if (dashboardMobile) dashboardMobile.style.display = 'block';
        }
        else{
            if (dashboardDesktop) dashboardDesktop.style.display = 'none';
            if (dashboardMobile) dashboardMobile.style.display = 'none';
        }
    }

    // Vérifier l'état au chargement
    checkAuthState();

    // Gérer la déconnexion
    const logoutDesktopBtn = document.getElementById('logout-desktop-btn');
    const logoutMobileBtn = document.getElementById('logout-mobile-btn');

    if (logoutDesktopBtn) {
        logoutDesktopBtn.addEventListener('click', function () {
            sessionStorage.clear();
            // Optionnel : rafraîchir l'affichage immédiatement
            setTimeout(() => {
                checkAuthState();
            }, 100);
        });
    }

    if (logoutMobileBtn) {
        logoutMobileBtn.addEventListener('click', function () {
            sessionStorage.clear();
            // Optionnel : rafraîchir l'affichage immédiatement
            setTimeout(() => {
                checkAuthState();
            }, 100);
        });
    }

    // Écouter les changements dans sessionStorage (si vous vous connectez/déconnectez dans un autre onglet)
    window.addEventListener('storage', function(e) {
        if (e.key === 'userLoggedIn') {
            checkAuthState();
        }
    });
});
</script>