<div 
    x-data="toastComponent()" 
    x-on:toast.window="addToast($event.detail)"
    class="fixed top-4 right-4 z-[99999] space-y-2 pointer-events-none"
    aria-live="assertive"
    aria-atomic="true"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="visible.includes(toast.id)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
            class="pointer-events-auto px-4 py-3 rounded-lg shadow-lg text-white flex items-start gap-3"
            :class="{
                'bg-red-600': toast.type === 'error',
                'bg-green-600': toast.type === 'success',
                'bg-blue-600': toast.type === 'info',
                'bg-gray-700': toast.type === 'default'
            }"
        >
            <span x-text="toast.message" class="text-sm font-medium"></span>

            <button 
                @click="removeToast(toast.id)" 
                class="text-white/70 hover:text-white ml-2"
                aria-label="Close notification"
            >
                ✕
            </button>
        </div>
    </template>
</div>

<script>
    function toastComponent() {
        return {
            toasts: [],
            visible: [],

            addToast(detail) {
                const id = Date.now();

                const toast = {
                    id,
                    message: detail.message ?? 'Notification',
                    type: detail.type ?? 'default',
                    duration: detail.duration ?? 4000
                };

                this.toasts.push(toast);

                setTimeout(() => {
                    this.visible.push(id);
                }, 10);

                setTimeout(() => {
                    this.removeToast(id);
                }, toast.duration);
            },

            removeToast(id) {
                this.visible = this.visible.filter(i => i !== id);
                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 300); // Match leave animation
            },
        };
    }
</script>
