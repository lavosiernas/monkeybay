class ProductManager {
    constructor() {
        this.currentProduct = null;
        this.quantity = 1;
        this.initializeEventListeners();
        this.renderProducts();
    }

    initializeEventListeners() {
        document.addEventListener('DOMContentLoaded', () => {
            this.updateCartBadge();
            this.setupModalListeners();
        });
    }

    setupModalListeners() {
        const modal = document.getElementById('productModal');
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) this.closeProductModal();
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') this.closeProductModal();
            });
        }
    }

    renderProducts() {
        const productsGrid = document.getElementById('productsGrid');
        if (!productsGrid) return;

        productsGrid.innerHTML = products.map(product => this.createProductCard(product)).join('');
    }

    createProductCard(product) {
        return `
            <div class="product-card">
                <div class="relative group">
                    <img src="${product.mainImage}" alt="${product.name}" class="w-full h-64 object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <button onclick="productManager.openProductModal(${product.id})" class="bg-white text-primary px-6 py-2 rounded-full transform -translate-y-2 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                            Ver Detalhes
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="heading text-xl mb-2">${product.name}</h3>
                    <p class="text-gray-600 mb-4">${product.description.substring(0, 100)}...</p>
                    <div class="text-primary text-xl mb-4">${this.formatPrice(product.price)}</div>
                    <div class="flex space-x-4">
                        <button onclick="productManager.quickAddToCart(${product.id})" class="btn-primary px-6 py-2 rounded-full flex-1">
                            Comprar
                        </button>
                        <button onclick="productManager.openProductModal(${product.id})" class="btn-secondary px-6 py-2 rounded-full flex-1">
                            Ver Detalhes
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    openProductModal(productId) {
        const product = products.find(p => p.id === productId);
        if (!product) return;

        this.currentProduct = product;
        this.quantity = 1;
        
        document.getElementById('modalProductName').textContent = product.name;
        document.getElementById('modalProductRef').textContent = `Ref: ${product.reference}`;
        document.getElementById('modalProductPrice').textContent = this.formatPrice(product.price);
        document.getElementById('modalProductDescription').textContent = product.description;
        document.getElementById('productQuantity').textContent = this.quantity;
        
        const specsList = document.getElementById('modalProductSpecs');
        specsList.innerHTML = product.specifications
            .map(spec => `
                <li class="flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                    <span>${spec}</span>
                </li>
            `)
            .join('');

        this.updateFavoriteButton();
        document.getElementById('productModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    closeProductModal() {
        document.getElementById('productModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        this.currentProduct = null;
        this.quantity = 1;
    }

    updateQuantity(change) {
        this.quantity = Math.max(1, this.quantity + change);
        document.getElementById('productQuantity').textContent = this.quantity;
    }

    quickAddToCart(productId) {
        const product = products.find(p => p.id === productId);
        if (product) {
            cartManager.addToCart(product, 1);
            this.showNotification('Produto adicionado ao carrinho!');
        }
    }

    addToCart() {
        if (!this.currentProduct) return;
        cartManager.addToCart(this.currentProduct, this.quantity);
        this.showNotification('Produto adicionado ao carrinho!');
        this.closeProductModal();
    }

    toggleFavorite() {
        if (!this.currentProduct) return;
        cartManager.toggleFavorite(this.currentProduct.id);
        this.updateFavoriteButton();
    }

    updateFavoriteButton() {
        const button = document.getElementById('favoriteButton');
        if (!button || !this.currentProduct) return;

        const isFavorite = cartManager.isFavorite(this.currentProduct.id);
        const svg = button.querySelector('svg');
        svg.style.fill = isFavorite ? '#FF4136' : 'none';
        svg.style.stroke = isFavorite ? '#FF4136' : 'currentColor';
    }

    updateCartBadge() {
        const badge = document.querySelector('.cart-badge');
        if (badge) {
            const totalItems = cartManager.getCartItemsCount();
            badge.textContent = totalItems;
        }
    }

    formatPrice(price) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(price);
    }

    showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed bottom-4 right-4 p-4 rounded-lg shadow-lg z-50 transform transition-transform duration-300 ${
            type === 'success' ? 'bg-green-600' : 'bg-red-600'
        } text-white`;
        
        notification.innerHTML = `
            <div class="flex items-center space-x-2">
                <span class="text-sm font-medium">${message}</span>
            </div>
        `;

        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transform = 'translateY(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
}

const productManager = new ProductManager();