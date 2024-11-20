<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
} ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luh Lumiere | Joalheria Exclusiva</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Header -->
    <header class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                <div class="text-3xl heading text-primary">Luh Lumiere</div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-600 hover:text-primary transition">Início</a>
                    <a href="#" class="text-gray-600 hover:text-primary transition">Coleções</a>
                    <a href="#" class="text-gray-600 hover:text-primary transition">Joias</a>
                    <a href="#" class="text-gray-600 hover:text-primary transition">Sobre</a>
                    <a href="#" class="text-gray-600 hover:text-primary transition">Contato</a>
                </nav>

               <!-- Desktop Actions -->
                <div class="hidden md:flex items-center space-x-6">
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

                    <button class="login-button text-gray-600 hover:text-primary" onclick="openLoginModal()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-600 hover:text-primary transition" id="mobileMenuButton">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('https://img.freepik.com/vetores-premium/ramo-de-palma-realista-folhas-e-galhos-de-palmeiras-fundo-de-folha-tropical-folhagem-verde-padrao-de-folhas-tropicais-ilustracao-vetorial_611910-6747.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="relative z-10 text-center text-white">
            <h1 class="heading text-5xl md:text-7xl mb-6">Luh Lumiere</h1>
            <p class="text-xl md:text-2xl mb-8">Joias exclusivas para momentos únicos</p>
            <button class="btn-primary px-8 py-3 rounded-full">
                Explorar Coleção
            </button>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <h2 class="heading text-4xl text-center mb-16">Coleção Exclusiva</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="productsGrid">
                <!-- Products will be dynamically inserted here -->
            </div>
        </div>
    </section>

<!-- Modal de Login -->
<div id="loginModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
        <!-- Cabeçalho do Modal -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Login</h2>
            <button onclick="closeLoginModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Formulário de Login -->
        <form id="loginForm" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
            </div>

            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Entrar
            </button>

            <!-- Divisor -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Ou continue com</span>
                </div>
            </div>

            <!-- Botão do Google -->
            <button onclick="handleGoogleSignIn()" 
                class="w-full flex items-center justify-center gap-3 py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4285F4] transition-all duration-200">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Continuar com Google
            </button>
        </form>
    </div>
</div>
<!-- Scripts -->
<script>
    // Função para abrir o modal
    function openLoginModal() {
        document.getElementById('loginModal').classList.remove('hidden');
    }

    // Função para fechar o modal
    function closeLoginModal() {
        document.getElementById('loginModal').classList.add('hidden');
    }

    // Fechar modal quando clicar fora dele
    window.onclick = function(event) {
        const modal = document.getElementById('loginModal');
        if (event.target === modal) {
            closeLoginModal();
        }
    }

    // Manipulador do formulário de login
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        console.log('Login tradicional:', { email, password });
        // Adicione aqui sua lógica de autenticação
    });

    // Função para lidar com a resposta do Google
    function handleCredentialResponse(response) {
        const responsePayload = decodeJwtResponse(response.credential);
        
        const userData = {
            id: responsePayload.sub,
            name: responsePayload.name,
            email: responsePayload.email,
            imageUrl: responsePayload.picture
        };

        console.log('Usuário Google:', userData);
        localStorage.setItem('userProfile', JSON.stringify(userData));
        closeLoginModal();
    }

    // Função para decodificar o token JWT
    function decodeJwtResponse(token) {
        const base64Url = token.split('.')[1];
        const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        const jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
        return JSON.parse(jsonPayload);
    }

    // Inicializar o Google Sign-In quando a página carregar
    window.onload = function() {
        initializeGoogleSignIn();
    }
</script>

    <!-- Product Modal -->
    <div id="productModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg w-11/12 max-w-4xl overflow-hidden">
            <button class="absolute top-4 right-4 z-10 text-gray-500 hover:text-gray-700 transition-colors" onclick="productManager.closeProductModal()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="flex flex-col md:flex-row">
                <!-- Product Gallery -->
                <div class="w-full md:w-1/2">
                    <div class="swiper-container product-gallery">
                        <div class="swiper-wrapper">
                            <!-- Gallery slides will be inserted here -->
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="w-full md:w-1/2 p-8">
                    <div class="space-y-6">
                        <div>
                            <h2 id="modalProductName" class="heading text-3xl mb-2"></h2>
                            <p id="modalProductRef" class="text-gray-500 text-sm"></p>
                        </div>

                        <div id="modalProductPrice" class="text-primary text-3xl font-semibold"></div>

                        <div>
                            <h3 class="heading text-lg mb-2">Descrição</h3>
                            <p id="modalProductDescription" class="text-gray-600"></p>
                        </div>

                        <div>
                            <h3 class="heading text-lg mb-2">Especificações</h3>
                            <ul id="modalProductSpecs" class="space-y-2 text-gray-600"></ul>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <span class="text-gray-600">Quantidade:</span>
                                <div class="flex items-center border rounded-full">
                                    <button class="px-4 py-2 hover:bg-gray-100 transition-colors" onclick="productManager.updateQuantity(-1)">-</button>
                                    <span id="productQuantity" class="px-4">1</span>
                                    <button class="px-4 py-2 hover:bg-gray-100 transition-colors" onclick="productManager.updateQuantity(1)">+</button>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <button onclick="productManager.addToCart()" class="flex-1 bg-primary text-white px-6 py-3 rounded-full hover:bg-primary-dark transition-colors flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <span>Adicionar ao Carrinho</span>
                                </button>
                                <button id="favoriteButton" onclick="productManager.toggleFavorite()" class="p-3 rounded-full border hover:border-primary transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Modal -->
    <div id="cartModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
        <div class="absolute right-0 top-0 h-full w-full md:w-96 bg-white shadow-lg transform transition-transform duration-300">
            <div class="flex flex-col h-full">
                <div class="p-6 border-b">
                    <div class="flex items-center justify-between">
                        <h2 class="heading text-2xl">Carrinho</h2>
                        <button onclick="cartManager.closeCartModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div id="cartItems" class="flex-1 overflow-y-auto p-6">
                    <!-- Cart items will be inserted here -->
                </div>

                <div class="p-6 border-t bg-gray-50">
                    <div class="space-y-4">
                        <div class="flex justify-between text-lg">
                            <span>Subtotal:</span>
                            <span id="cartSubtotal" class="text-primary font-semibold"></span>
                        </div>
                        <button onclick="cartManager.proceedToCheckout()" class="w-full btn-primary py-3 rounded-full text-center">
                            Finalizar Compra
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Favorites Modal -->
    <div id="favoritesModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
        <div class="absolute right-0 top-0 h-full w-full md:w-96 bg-white shadow-lg transform transition-transform duration-300">
            <div class="flex flex-col h-full">
                <div class="p-6 border-b">
                    <div class="flex items-center justify-between">
                        <h2 class="heading text-2xl">Favoritos</h2>
                        <button onclick="cartManager.closeFavoritesModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div id="favoriteItems" class="flex-1 overflow-y-auto p-6">
                    <!-- Favorite items will be inserted here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="js/products.js"></script>
    <script src="js/productManager.js"></script>
    <script src="js/cartManager.js"></script>
    <script src="js/mobilemenu.js"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="js/client_secret_935081171756-h8l1et14ba940ahlfn6j8ldef4uktkd9.apps.googleusercontent.com.json"></script>
</body>
</html>