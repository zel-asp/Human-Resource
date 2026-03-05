<?php if (!empty($_SESSION['success']) || !empty($_SESSION['error'])): ?>
    <div class="fixed top-6 right-6 z-50 space-y-3 max-w-sm w-full pointer-events-none">
        <!-- Success Messages -->
        <?php if (!empty($_SESSION['success'])): ?>
            <?php foreach ($_SESSION['success'] as $msg): ?>
                <div class="relative pointer-events-auto group animate-message-pop">
                    <div
                        class="bg-primary rounded-2xl shadow-lg border border-primary p-4 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-xl">
                        <!-- Tail/arrow -->
                        <div
                            class="absolute right-4 -bottom-2 w-4 h-4 bg-primary border-b border-r border-gray-100 transform rotate-45">
                        </div>

                        <div class="flex items-start gap-3">
                            <!-- Success Icon -->
                            <div class="shrink-0 w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check text-white text-lg"></i>
                            </div>

                            <!-- Content -->
                            <div class="flex-1">
                                <p class="text-sm text-white leading-relaxed">
                                    <?= htmlspecialchars($msg) ?>
                                </p>
                            </div>

                            <!-- Close button -->
                            <button onclick="this.closest('.pointer-events-auto').remove()"
                                class="shrink-0 w-6 h-6 rounded-lg text-white/60 hover:text-white hover:bg-white/10 flex items-center justify-center transition-colors duration-200">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- Error Messages -->
        <?php if (!empty($_SESSION['error'])): ?>
            <?php foreach ($_SESSION['error'] as $msg): ?>
                <div class="relative pointer-events-auto group animate-message-pop">
                    <!-- Message bubble -->
                    <div
                        class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-xl">
                        <!-- Tail/arrow -->
                        <div
                            class="absolute right-4 -bottom-2 w-4 h-4 bg-white border-b border-r border-gray-100 transform rotate-45">
                        </div>

                        <div class="flex items-start gap-3">
                            <!-- Error Icon -->
                            <div
                                class="shrink-0 w-10 h-10 bg-gradient-to-br from-rose-400 to-red-500 rounded-2xl flex items-center justify-center shadow-sm">
                                <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                            </div>

                            <!-- Content -->
                            <div class="flex-1">
                                <p class="text-sm text-gray-800 leading-relaxed">
                                    <?= htmlspecialchars($msg) ?>
                                </p>
                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    Just now
                                </p>
                            </div>

                            <!-- Close button -->
                            <button onclick="this.closest('.pointer-events-auto').remove()"
                                class="shrink-0 w-6 h-6 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 flex items-center justify-center transition-colors duration-200">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>

    <style>
        @keyframes messagePop {
            0% {
                opacity: 0;
                transform: scale(0.8) translateY(20px);
            }

            50% {
                transform: scale(1.02) translateY(-2px);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .animate-message-pop {
            animation: messagePop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
    </style>
<?php endif; ?>