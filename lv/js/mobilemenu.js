// Gerenciador do Menu Mobile
class MobileMenuManager {
    constructor() {
        this.mobileMenuButton = document.getElementById('mobileMenuButton');
        this.isMenuOpen = false;
        this.mobileMenu = null;
        this.initialize();
    }

    initialize() {
        // Criar o menu mobile
        this.createMobileMenu();
        
        // Adicionar evento de clique ao botão
        this.mobileMenuButton.addEventListener('click', () => this.toggleMenu());
        
        // Fechar menu ao clicar fora
        document.addEventListener('click', (e) => {
            if (this.isMenuOpen && !this.mobileMenu.contains(e.target) && !this.mobileMenuButton.contains(e.target)) {
                this.closeMenu();
            }
        });

        // Fechar menu ao redimensionar para desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768 && this.isMenuOpen) {
                this.closeMenu();
            }
        });
    }

    createMobileMenu() {
        // Criar elemento do menu mobile
        this.mobileMenu = document.createElement('div');
        this.mobileMenu.className = 'fixed md:hidden bg-white w-full left-0 top-20 shadow-lg transform -translate-y-full transition-transform duration-300 ease-in-out';
        this.mobileMenu.innerHTML = `
            <nav class="container mx-auto px-4 py-4 flex flex-col space-y-4">
                <a href="#" class="text-gray-600 hover:text-primary transition py-2">Início</a>
                <a href="#" class="text-gray-600 hover:text-primary transition py-2">Coleções</a>
                <a href="#" class="text-gray-600 hover:text-primary transition py-2">Joias</a>
                <a href="#" class="text-gray-600 hover:text-primary transition py-2">Sobre</a>
                <a href="#" class="text-gray-600 hover:text-primary transition py-2">Contato</a>
                <div class="flex space-x-6 py-2">
                    <button class="cart-button text-gray-600 hover:text-primary relative" onclick="cartManager.openCartModal()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="cart-badge absolute -top-2 -right-2 bg-primary text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">0</span>
                    </button>
                    <button class="favorites-button text-gray-600 hover:text-primary" onclick="cartManager.openFavoritesModal()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                    </button>
                </div>
            </nav>
        `;
        document.body.appendChild(this.mobileMenu);
    }

    toggleMenu() {
        if (this.isMenuOpen) {
            this.closeMenu();
        } else {
            this.openMenu();
        }
    }

    openMenu() {
        this.isMenuOpen = true;
        this.mobileMenu.style.transform = 'translateY(0)';
        this.updateMenuButton('close');
        document.body.style.overflow = 'hidden';
    }

    closeMenu() {
        this.isMenuOpen = false;
        this.mobileMenu.style.transform = 'translateY(-100%)';
        this.updateMenuButton('menu');
        document.body.style.overflow = '';
    }

    updateMenuButton(type) {
        const iconPath = type === 'close' 
            ? '<path d="M6 18L18 6M6 6l12 12" />'
            : '<path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />';
        
        this.mobileMenuButton.querySelector('svg').innerHTML = iconPath;
    }
}

// Inicializar o menu mobile quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', () => {
    const mobileMenu = new MobileMenuManager();
});