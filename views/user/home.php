<?php
$pageTitle = 'POS Panel';
include __DIR__ . '/../layouts/head.php';
?>
    <?php include __DIR__ . '/../components/navbar.php'; ?>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="container py-5">
            <div class="card-modern mx-auto" style="max-width: 560px;">
                <div class="card-body-modern text-center py-5">
                    <h2 class="mb-3"><i class="fas fa-cash-register me-2"></i>POS Panel</h2>
                    <p class="text-muted mb-4">Please sign in to open the cashier workspace.</p>
                    <a href="/login" class="btn btn-primary-modern">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="container-fluid py-4">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card-modern mb-4">
                        <div class="card-body-modern">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label class="form-label-modern">Search</label>
                                    <input id="posSearch" type="text" class="form-control-modern" placeholder="Type item name...">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-modern">Category</label>
                                    <select id="posCategory" class="form-select-modern">
                                        <option value="">All Categories</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button id="clearFiltersBtn" class="btn btn-secondary-modern w-100" type="button">
                                        <i class="fas fa-rotate-left me-2"></i>Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="posProducts" class="row g-3">
                        <div class="col-12">
                            <div class="empty-state">
                                <i class="fas fa-spinner fa-spin"></i>
                                <p>Loading products...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card-modern" style="position: sticky; top: 95px;">
                        <div class="card-header-modern d-flex justify-content-between align-items-center">
                            <h5><i class="fas fa-shopping-cart me-2"></i>Current Order</h5>
                            <span id="posItemsCount" class="badge-modern">0 items</span>
                        </div>
                        <div class="card-body-modern">
                            <div id="posCartItems" class="mb-3">
                                <div class="empty-state py-4">
                                    <i class="fas fa-basket-shopping"></i>
                                    <p>No items selected</p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label-modern">Order Notes</label>
                                <textarea id="posNotes" class="form-control-modern" rows="2" placeholder="Optional notes for kitchen..." style="resize: none;"></textarea>
                            </div>

                            <div class="cart-totals-summary">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <strong id="posSubtotal">EGP 0.00</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax (14%)</span>
                                    <strong id="posTax">EGP 0.00</strong>
                                </div>
                                <hr class="my-2 border-0" style="height:1px;background:#e8e0d5;">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">Total</span>
                                    <strong id="posTotal" style="color: var(--primary-accent);">EGP 0.00</strong>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-3">
                                <button id="placeOrderBtn" class="btn btn-primary-modern" type="button">
                                    <i class="fas fa-check me-2"></i>Place Order
                                </button>
                                <button id="clearCartBtn" class="btn btn-secondary-modern" type="button">
                                    <i class="fas fa-trash me-2"></i>Clear Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .pos-card {
                height: 100%;
            }

            .pos-product-image {
                height: 96px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #f8f4ee;
                margin-bottom: 12px;
            }

            .pos-product-image img {
                max-height: 88px;
                max-width: 100%;
                object-fit: contain;
            }

            .pos-name {
                color: var(--text-dark);
                font-weight: 700;
                margin-bottom: 4px;
            }

            .pos-desc {
                color: var(--text-muted);
                font-size: 0.85rem;
                min-height: 38px;
                margin-bottom: 10px;
            }

            .pos-price {
                color: var(--primary-dark);
                font-weight: 700;
                font-size: 1.15rem;
            }

            .pos-cart-item {
                display: flex;
                gap: 10px;
                align-items: center;
                justify-content: space-between;
                padding: 10px;
                border: 1px solid #e8e0d5;
                border-radius: 10px;
                margin-bottom: 10px;
                background: #fcfaf7;
            }

            .pos-qty {
                display: inline-flex;
                align-items: center;
                border: 1px solid #d8cbb8;
                border-radius: 8px;
                overflow: hidden;
            }

            .pos-qty button {
                border: none;
                background: #f3ece2;
                width: 28px;
                height: 28px;
                color: var(--primary-dark);
                font-weight: 700;
            }

            .pos-qty span {
                width: 32px;
                text-align: center;
                font-size: 0.9rem;
                font-weight: 600;
            }
        </style>
    <?php endif; ?>

    <?php include __DIR__ . '/../components/footer.php'; ?>
    <?php include __DIR__ . '/../layouts/scripts.php'; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
    <script>
        const POS = {
            products: [],
            categories: [],
            cart: {},
            me: null,
            taxRate: 0.14
        };

        document.addEventListener('DOMContentLoaded', async () => {
            await loadCurrentUser();
            await loadCategories();
            await loadProducts();
            bindPOSActions();
            renderProducts();
            renderCart();
        });

        async function loadCurrentUser() {
            const res = await Utils.apiRequest('/api/me');
            if (res.success && res.data && res.data.success) {
                POS.me = res.data.data;
            }
        }

        async function loadCategories() {
            const response = await Utils.apiRequest('/api/categories');
            if (response.success && response.data && response.data.data) {
                POS.categories = response.data.data;
            }

            const select = document.getElementById('posCategory');
            POS.categories.forEach(cat => {
                const option = document.createElement('option');
                option.value = String(cat.id);
                option.textContent = cat.name;
                select.appendChild(option);
            });
        }

        async function loadProducts() {
            const response = await Utils.apiRequest('/api/products');
            if (response.success && response.data && response.data.data) {
                POS.products = response.data.data;
            } else {
                POS.products = [];
            }
        }

        function bindPOSActions() {
            document.getElementById('posSearch').addEventListener('input', renderProducts);
            document.getElementById('posCategory').addEventListener('change', renderProducts);

            document.getElementById('clearFiltersBtn').addEventListener('click', () => {
                document.getElementById('posSearch').value = '';
                document.getElementById('posCategory').value = '';
                renderProducts();
            });

            document.getElementById('clearCartBtn').addEventListener('click', () => {
                POS.cart = {};
                renderCart();
            });

            document.getElementById('placeOrderBtn').addEventListener('click', placeOrder);
        }

        function getFilteredProducts() {
            const query = document.getElementById('posSearch').value.trim().toLowerCase();
            const category = document.getElementById('posCategory').value;

            return POS.products.filter(product => {
                const name = String(product.name || '').toLowerCase();
                const desc = String(product.description || '').toLowerCase();
                const matchesQuery = !query || name.includes(query) || desc.includes(query);
                const matchesCategory = !category || String(product.category_id) === category;
                return matchesQuery && matchesCategory;
            });
        }

        function renderProducts() {
            const container = document.getElementById('posProducts');
            const products = getFilteredProducts();

            if (!products.length) {
                container.innerHTML = `
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-search"></i>
                            <p>No products match your filters</p>
                        </div>
                    </div>
                `;
                return;
            }

            container.innerHTML = products.map(product => {
                const imageUrl = Utils.getProductImageUrl(product.image || product.image_path);
                return `
                    <div class="col-sm-6 col-xl-4">
                        <div class="card-modern pos-card">
                            <div class="card-body-modern">
                                <div class="pos-product-image">
                                    ${imageUrl
                                        ? `<img src="${imageUrl}" alt="${escapeHtml(product.name)}">`
                                        : `<i class="fas fa-mug-hot fa-2x" style="color: var(--primary-dark);"></i>`}
                                </div>
                                <div class="pos-name">${escapeHtml(product.name)}</div>
                                <div class="pos-desc">${escapeHtml(product.description || 'Freshly prepared item')}</div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="pos-price">EGP ${Number(product.price || 0).toFixed(2)}</span>
                                    <button class="btn btn-primary-modern btn-sm" type="button" onclick="addToPOSCart(${Number(product.id)})">
                                        <i class="fas fa-plus me-1"></i>Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function addToPOSCart(productId) {
            const product = POS.products.find(p => Number(p.id) === Number(productId));
            if (!product) return;

            const key = String(product.id);
            if (!POS.cart[key]) {
                POS.cart[key] = {
                    id: Number(product.id),
                    name: product.name,
                    price: Number(product.price || 0),
                    quantity: 0
                };
            }
            POS.cart[key].quantity += 1;
            renderCart();
        }

        function updateItemQty(productId, delta) {
            const key = String(productId);
            if (!POS.cart[key]) return;

            POS.cart[key].quantity += delta;
            if (POS.cart[key].quantity <= 0) {
                delete POS.cart[key];
            }
            renderCart();
        }

        function renderCart() {
            const container = document.getElementById('posCartItems');
            const items = Object.values(POS.cart);

            if (!items.length) {
                container.innerHTML = `
                    <div class="empty-state py-4">
                        <i class="fas fa-basket-shopping"></i>
                        <p>No items selected</p>
                    </div>
                `;
            } else {
                container.innerHTML = items.map(item => {
                    const lineTotal = item.quantity * item.price;
                    return `
                        <div class="pos-cart-item">
                            <div style="flex: 1;">
                                <div class="fw-bold" style="color: var(--text-dark);">${escapeHtml(item.name)}</div>
                                <small class="text-muted">EGP ${item.price.toFixed(2)} each</small>
                            </div>
                            <div class="pos-qty">
                                <button type="button" onclick="updateItemQty(${item.id}, -1)">-</button>
                                <span>${item.quantity}</span>
                                <button type="button" onclick="updateItemQty(${item.id}, 1)">+</button>
                            </div>
                            <div class="fw-bold" style="min-width: 82px; text-align: right;">EGP ${lineTotal.toFixed(2)}</div>
                        </div>
                    `;
                }).join('');
            }

            const totals = calculateTotals();
            document.getElementById('posItemsCount').textContent = `${totals.items} items`;
            document.getElementById('posSubtotal').textContent = `EGP ${totals.subtotal.toFixed(2)}`;
            document.getElementById('posTax').textContent = `EGP ${totals.tax.toFixed(2)}`;
            document.getElementById('posTotal').textContent = `EGP ${totals.total.toFixed(2)}`;
        }

        function calculateTotals() {
            const items = Object.values(POS.cart);
            const count = items.reduce((sum, item) => sum + item.quantity, 0);
            const subtotal = items.reduce((sum, item) => sum + (item.quantity * item.price), 0);
            const tax = subtotal * POS.taxRate;
            return {
                items: count,
                subtotal: Number(subtotal.toFixed(2)),
                tax: Number(tax.toFixed(2)),
                total: Number((subtotal + tax).toFixed(2))
            };
        }

        async function placeOrder() {
            const items = Object.values(POS.cart);
            if (!items.length) {
                toast.warning('Add at least one item before checkout', 'Empty Order');
                return;
            }

            const totals = calculateTotals();
            const payload = {
                userId: POS.me && POS.me.id ? Number(POS.me.id) : null,
                notes: document.getElementById('posNotes').value || '',
                subtotal: totals.subtotal,
                tax: totals.tax,
                total: totals.total,
                items: items.map(item => ({
                    id: item.id,
                    quantity: item.quantity,
                    price: item.price
                }))
            };

            try {
                LoadingSpinner.show('Placing order...');
                const response = await fetch('/api/orders/create', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const result = await response.json();
                LoadingSpinner.hide();

                if (result.success) {
                    toast.success('Order created successfully', 'POS Checkout');
                    POS.cart = {};
                    document.getElementById('posNotes').value = '';
                    renderCart();
                } else {
                    toast.error(result.message || 'Failed to create order', 'Checkout Error');
                }
            } catch (error) {
                LoadingSpinner.hide();
                toast.error(error.message || 'Unexpected error', 'Checkout Error');
            }
        }

        function escapeHtml(value) {
            return String(value || '').replace(/[&<>"']/g, ch => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[ch]));
        }
    </script>
    <?php endif; ?>
</body>
</html>
