<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<title><?php echo e($title ?? config('app.name')); ?></title>


<link rel="icon" href="/Seal_White.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">


<link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">








<?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
<?php /**PATH C:\Users\monro\Herd\shusseki\resources\views/partials/head.blade.php ENDPATH**/ ?>