<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<script>
    setTimeout(() => {
        window.location.href = "/dashboard";
    }, 2500);
</script>

<body class="bg-black flex items-center justify-center h-screen">

    <div class="text-center">

        <!-- GOAT IMAGE ONLY -->
        <img src="{{ asset('images/goat.png') }}"
             class="w-48 h-48 mx-auto mb-4">

        <h1 class="text-2xl font-bold text-green-400">
            Mambuzi EATS & DINE
        </h1>

    </div>

</body>
</html>
