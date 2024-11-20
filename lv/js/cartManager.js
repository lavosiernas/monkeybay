class CartManager {
    constructor() {
        this.cart = JSON.parse(localStorage.getItem('cart') || '[]');
        this.favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        this.setupEventListeners();
    }

    setupEventListeners() {
        window.addEventListener('storage', () => {
            this.loadFromStorage();
            this.updateUI();
        });
    }

    loadFromStorage() {
        this.cart = JSON.parse(localStorage.getItem('cart') || '[]');
        this.favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    }

    saveToStorage() {
        localStorage.setItem('cart', JSON.stringify(this.cart));
        localStorage.setItem('favorites', JSON.stringify(this.favorites));
    }

    addToCart(product, quantity) {
        const existingItem = this.cart.find(item => item.id === product.id);
        
        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            this.cart.push({ ...product, quantity });
        }
        
        this.saveToStorage();
        this.updateUI();
    }

    removeFromCart(productId) {
        this.cart = this.cart.filter(item => item.id !== productId);
        this.saveToStorage();
        this.updateUI();
        productManager.showNotification('Produto removido do carrinho!');
    }

    updateQuantity(productId, change) {
        const item = this.cart.find(item => item.id === productId);
        if (item) {
            item.quantity = Math.max(1, item.quantity + change);
            this.saveToStorage();
            this.updateUI();
        }
    }

    toggleFavorite(productId) {
        const index = this.favorites.indexOf(productId);
        if (index === -1) {
            this.favorites.push(productId);
            productManager.showNotification('Produto adicionado aos favoritos!');
        } else {
            this.favorites.splice(index, 1);
            productManager.showNotification('Produto removido dos favoritos!');
        }
        this.saveToStorage();
        this.updateUI();
    }

    isFavorite(productId) {
        return this.favorites.includes(productId);
    }

    getCartItemsCount() {
        return this.cart.reduce((total, item) => total + item.quantity, 0);
    }

    getCartTotal() {
        return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    updateUI() {
        this.updateCartItems();
        this.updateFavoriteItems();
        productManager.updateCartBadge();
    }

    updateCartItems() {
        const cartItems = document.getElementById('cartItems');
        if (!cartItems) return;

        if (this.cart.length === 0) {
            cartItems.innerHTML = this.getEmptyCartTemplate();
            return;
        }

        cartItems.innerHTML = this.cart.map(item => this.getCartItemTemplate(item)).join('');
        this.updateCartSubtotal();
    }

    updateFavoriteItems() {
        const favoriteItems = document.getElementById('favoriteItems');
        if (!favoriteItems) return;

        if (this.favorites.length === 0) {
            favoriteItems.innerHTML = this.getEmptyFavoritesTemplate();
            return;
        }

        const favoriteProducts = this.favorites
            .map(id => products.find(p => p.id === id))
            .filter(Boolean);

        favoriteItems.innerHTML = favoriteProducts
            .map(product => this.getFavoriteItemTemplate(product))
            .join('');
    }

    getEmptyCartTemplate() {
        return `
            <div class="text-center py-8 text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <p>Seu carrinho está vazio</p>
            </div>
        `;
    }

    getCartItemTemplate(item) {
        return `
            <div class="flex items-center space-x-4 py-4 border-b">
                <img src="${item.mainImage}" alt="${item.name}" class="w-20 h-20 object-cover rounded">
                <div class="flex-1">
                    <h3 class="heading text-lg">${item.name}</h3>
                    <p class="text-primary">${productManager.formatPrice(item.price)}</p>
                    <div class="flex items-center space-x-2 mt-2">
                        <button onclick="cartManager.updateQuantity(${item.id}, -1)" 
                                class="text-gray-500 hover:text-primary">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="cartManager.updateQuantity(${item.id}, 1)" class="text-gray-500 hover:text-primary">+</button>
                    </div>
                </div>
                <button onclick="cartManager.removeFromCart(${item.id})" 
                        class="text-gray-500 hover:text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
        `;
    }

    getEmptyFavoritesTemplate() {
        return `
            <div class="text-center py-8 text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
                <p>Sua lista de favoritos está vazia</p>
            </div>
        `;
    }

    getFavoriteItemTemplate(product) {
        return `
            <div class="flex items-center space-x-4 py-4 border-b">
                <img src="${product.mainImage}" alt="${product.name}" 
                     class="w-20 h-20 object-cover rounded">
                <div class="flex-1">
                    <h3 class="heading text-lg">${product.name}</h3>
                    <p class="text-primary">${productManager.formatPrice(product.price)}</p>
                </div>
                <div class="flex space-x-2">
                    <button onclick="cartManager.addToCart(${JSON.stringify(product)}, 1)" 
                            class="text-gray-500 hover:text-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </button>
                    <button onclick="cartManager.toggleFavorite(${product.id})" 
                            class="text-gray-500 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
    }

    updateCartSubtotal() {
        const subtotalElement = document.getElementById('cartSubtotal');
        if (subtotalElement) {
            subtotalElement.textContent = productManager.formatPrice(this.getCartTotal());
        }
    }

    openCartModal() {
        const modal = document.getElementById('cartModal');
        if (modal) {
            modal.classList.remove('hidden');
            this.updateCartItems();
        }
    }

    closeCartModal() {
        const modal = document.getElementById('cartModal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    openFavoritesModal() {
        const modal = document.getElementById('favoritesModal');
        if (modal) {
            modal.classList.remove('hidden');
            this.updateFavoriteItems();
        }
    }

    closeFavoritesModal() {
        const modal = document.getElementById('favoritesModal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    proceedToCheckout() {
        if (this.cart.length === 0) {
            productManager.showNotification('Seu carrinho está vazio!', 'error');
            return;
        }
        productManager.showNotification('Implementação do checkout em desenvolvimento!', 'info');
    }
}

const cartManager = new CartManager();