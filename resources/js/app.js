import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Optional helper store for notification toasts
Alpine.store('notifications', {
    items: [],
    add(message, type = 'info') {
        const id = Date.now();
        this.items.push({ id, message, type });
        setTimeout(() => this.remove(id), 4000);
    },
    remove(id) {
        this.items = this.items.filter(item => item.id !== id);
    }
});

Alpine.start();
