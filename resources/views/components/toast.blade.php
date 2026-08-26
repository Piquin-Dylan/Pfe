<div
    x-data="{
        toasts: [],
        push(message, type = 'success') {
            if (!message) return;

            const id = Date.now() + Math.random();

            this.toasts.push({ id, message, type });

            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 4000);
        }
    }"
    x-on:notify.window="push($event.detail.message, $event.detail.type)"
    @if(session()->has('success'))
        x-init="push(@js(session('success')), 'success')"
    @elseif(session()->has('error'))
        x-init="push(@js(session('error')), 'error')"
    @endif
    class="fixed bottom-5 right-5 z-[9999] flex flex-col gap-3 items-end pointer-events-none"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            :class="toast.type === 'error' ? 'bg-red-500' : 'bg-green-500'"
            class="pointer-events-auto max-w-sm text-white px-6 py-4 rounded-xl shadow-2xl font-semibold flex items-start gap-3"
            role="status"
            aria-live="polite"
        >
            <span x-text="toast.type === 'error' ? '⚠️' : '✅'"></span>
            <span x-text="toast.message"></span>
        </div>
    </template>
</div>
