<?php if (!empty($_SESSION['success']) || !empty($_SESSION['error'])): ?>
    <div class="fixed top-4 right-4 z-50 space-y-2 max-w-sm w-full">
        <!-- Success Messages -->
        <?php if (!empty($_SESSION['success'])): ?>
            <?php foreach ($_SESSION['success'] as $msg): ?>
                <div class="flex items-center justify-between bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md animate-slide-in"
                    role="alert">
                    <span>
                        <?= htmlspecialchars($msg) ?>
                    </span>
                    <button onclick="this.parentElement.remove();"
                        class="ml-4 font-bold text-green-700 hover:text-green-900">&times;</button>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- Error Messages -->
        <?php if (!empty($_SESSION['error'])): ?>
            <?php foreach ($_SESSION['error'] as $msg): ?>
                <div class="flex items-center justify-between bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-md animate-slide-in"
                    role="alert">
                    <span>
                        <?= htmlspecialchars($msg) ?>
                    </span>
                    <button onclick="this.parentElement.remove();"
                        class="ml-4 font-bold text-red-700 hover:text-red-900">&times;</button>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>

    <style>
        /* Optional: Smooth slide-in animation */
        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out forwards;
        }
    </style>
<?php endif; ?>