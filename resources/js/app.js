import './bootstrap';

const orderNotification = document.querySelector('#order-notification');

if (orderNotification && window.Echo) {
    window.Echo.private('admin.orders').listen('.order.placed', (order) => {
        const orderCount = document.querySelector('#order-count');
        if (orderCount) {
            orderCount.textContent = String(Number(orderCount.textContent) + 1);
        }

        const message = document.createElement('span');
        message.textContent = `Transaksi baru ${order.invoice_number} dari ${order.cashier_name}. Total Rp${Number(order.total).toLocaleString('id-ID')}. `;

        const invoice = document.createElement('a');
        invoice.href = order.invoice_url;
        invoice.textContent = 'Lihat invoice';

        orderNotification.replaceChildren(message, invoice);
        orderNotification.hidden = false;
    });
}
