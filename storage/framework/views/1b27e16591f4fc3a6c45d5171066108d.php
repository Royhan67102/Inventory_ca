<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company Portal</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="bg-gray-50 text-gray-800">


<header class="absolute w-full z-50">
    <div class="flex justify-between items-center px-8 py-6">
        <a href="/">
            <img src="<?php echo e(asset('assets/img/ca3.png')); ?>"
                alt="MyCompany Logo"
                class="h-20 w-auto">
        </a>


        <div class="space-x-6">
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(url('/dashboard')); ?>" class="text-white">Dashboard</a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="text-white hover:underline">Login</a>
                <a href="<?php echo e(route('register')); ?>"
                   class="bg-white text-indigo-700 px-5 py-2 rounded-xl font-semibold hover:bg-gray-200 transition">
                    Register
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>



<section class="relative min-h-screen flex items-center justify-center text-center text-white">

    
    <div class="absolute inset-0">
        <img src="<?php echo e(asset('assets/img/ca2.jpeg')); ?>" alt="Hero Background"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    
    <div class="relative z-10 max-w-4xl px-6">
        <h2 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
            Empowering People.<br>
            Driving Excellence.
        </h2>

        <p class="text-lg md:text-xl mb-8 text-gray-200">
            Together we innovate, collaborate, and achieve extraordinary results.
        </p>

        <div class="flex justify-center gap-4 flex-wrap">
            <a href="<?php echo e(route('login')); ?>"
               class="bg-indigo-600 hover:bg-indigo-700 px-8 py-3 rounded-xl font-semibold transition">
                Get Started
            </a>

            <a href="#video"
               class="border border-white px-8 py-3 rounded-xl hover:bg-white hover:text-black transition">
                Watch Message
            </a>
        </div>
    </div>
</section>



<section id="video" class="py-24 bg-white text-center">
    <h3 class="text-3xl font-bold mb-10">Message From Our Leadership</h3>

    <div class="flex justify-center">
        <div class="w-80 aspect-[9/16]">
            <iframe
                class="w-full h-full rounded-2xl shadow-xl"
                src="https://www.youtube.com/embed/wnvTLGA5c9k"
                allowfullscreen>
            </iframe>
        </div>
    </div>

</section>



<section class="py-24 bg-gray-100">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h3 class="text-3xl font-bold mb-16">Our Core Values</h3>

        <div class="grid md:grid-cols-3 gap-10">

            <div class="bg-white p-10 rounded-2xl shadow hover:shadow-xl transition">
                <div class="text-4xl mb-4">🚀</div>
                <h4 class="text-xl font-semibold mb-4">Innovation</h4>
                <p class="text-gray-600">
                    We challenge the norm and create impactful solutions.
                </p>
            </div>

            <div class="bg-white p-10 rounded-2xl shadow hover:shadow-xl transition">
                <div class="text-4xl mb-4">🤝</div>
                <h4 class="text-xl font-semibold mb-4">Collaboration</h4>
                <p class="text-gray-600">
                    Success happens when we work together.
                </p>
            </div>

            <div class="bg-white p-10 rounded-2xl shadow hover:shadow-xl transition">
                <div class="text-4xl mb-4">🎯</div>
                <h4 class="text-xl font-semibold mb-4">Excellence</h4>
                <p class="text-gray-600">
                    We strive to deliver the best every single day.
                </p>
            </div>

        </div>
    </div>
</section>



<section class="py-24 bg-indigo-700 text-white text-center">
    <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-12 px-6">

        <div>
            <h4 class="text-4xl font-bold">150+</h4>
            <p class="mt-2 text-gray-200">Employees</p>
        </div>

        <div>
            <h4 class="text-4xl font-bold">12</h4>
            <p class="mt-2 text-gray-200">Departments</p>
        </div>

        <div>
            <h4 class="text-4xl font-bold">98%</h4>
            <p class="mt-2 text-gray-200">Client Satisfaction</p>
        </div>

    </div>
</section>



<footer class="py-8 text-center bg-black text-gray-400">
    © <?php echo e(date('Y')); ?> MyCompany. All rights reserved.
</footer>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/welcome.blade.php ENDPATH**/ ?>