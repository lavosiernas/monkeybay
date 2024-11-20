<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-gray-900">Registro</h2>

        <form action="process_register.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>

            <button type="submit"
                class="w-full py-2 px-4 border border-transparent rounded-md text-white bg-blue-600 hover:bg-blue-700">
                Registrar
            </button>
        </form>

        <p class="mt-4 text-center">
            <a href="login.php" class="text-blue-600 hover:text-blue-800">Já tem conta? Faça login</a>
        </p>
    </div>
</body>

</html>