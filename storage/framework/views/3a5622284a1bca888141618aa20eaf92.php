<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        
        <style>
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateX(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .form-container {
                animation: fadeInUp 0.6s ease;
            }

            .form-field {
                animation: slideIn 0.5s ease both;
            }

            .form-field:nth-child(1) { animation-delay: 0.1s; }
            .form-field:nth-child(2) { animation-delay: 0.2s; }
            .form-field:nth-child(3) { animation-delay: 0.3s; }
            .form-field:nth-child(4) { animation-delay: 0.4s; }

            .input-wrapper {
                position: relative;
            }

            .input-focus-ring {
                position: absolute;
                inset: 0;
                border-radius: 0.75rem;
                pointer-events: none;
                transition: all 0.3s ease;
                opacity: 0;
            }

            .form-input:focus ~ .input-focus-ring {
                opacity: 1;
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            }

            .form-input {
                transition: all 0.3s ease;
            }

            .form-input:focus {
                transform: translateY(-1px);
            }

            .primary-btn {
                position: relative;
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .primary-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: left 0.5s ease;
            }

            .primary-btn:hover::before {
                left: 100%;
            }

            .primary-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.4);
            }

            .link-hover {
                position: relative;
                transition: color 0.3s ease;
            }

            .link-hover::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 0;
                height: 2px;
                background: linear-gradient(90deg, #2563eb, #06b6d4);
                transition: width 0.3s ease;
            }

            .link-hover:hover::after {
                width: 100%;
            }

            .card-shine {
                position: relative;
                overflow: hidden;
            }

            .card-shine::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -50%;
                width: 200%;
                height: 200%;
                background: linear-gradient(
                    45deg,
                    transparent,
                    rgba(255, 255, 255, 0.03),
                    transparent
                );
                transform: rotate(45deg);
                animation: shine 3s ease-in-out infinite;
            }

            @keyframes shine {
                0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
                100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-blue-50">
        <?php echo e($slot); ?>

        <?php app('livewire')->forceAssetInjection(); ?>
<?php echo app('flux')->scripts(); ?>

    </body>
</html><?php /**PATH C:\Users\Zealda Junior\Desktop\Event\event_management\resources\views/layouts/guest.blade.php ENDPATH**/ ?>