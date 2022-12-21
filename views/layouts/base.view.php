<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen bg-gray-100 grid grid-rows-[60px_auto_50px]">

    <header class="py-2 bg-sky-900 flex items-center justify-around">
        <h1 class="font-bold text-xl text-white">
            <a href="/">
                Suggestron
            </a>
        </h1>
        <p class="text-white">
            <a class="p-3 rounded-md font-bold text-gray-50 bg-blue-600 hover:bg-blue-800" href="/create.php">Create</a>
        </p>
    </header>

    <?= $viewContent ?>

    <footer class="bg-black py-1 flex justify-center items-center text-white max-h-min">
        <p>
            &copy; 2022 by
            <a class="hover:text-blue-300" href="https://github.com/ampmonteiro" title="visit my github">
                AMPM
            </a>
        </p>
    </footer>
</body>

</html>