document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar on mobile
    const toggleSidebar = document.getElementById('toggleSidebar');
    const adminSidebar = document.getElementById('adminSidebar');
    
    if (toggleSidebar && adminSidebar) {
        toggleSidebar.addEventListener('click', function() {
            adminSidebar.classList.toggle('show');
        });
    }

    // User dropdown
    const userDropdown = document.getElementById('userDropdown');
    if (userDropdown) {
        userDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.querySelector('.admin-user-dropdown');
            dropdown.classList.toggle('show');
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function() {
        const dropdowns = document.querySelectorAll('.admin-user-dropdown');
        dropdowns.forEach(dropdown => {
            dropdown.classList.remove('show');
        });
    });

    // Tab functionality
    const tabs = document.querySelectorAll('.admin-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs and contents
            document.querySelectorAll('.admin-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.admin-tab-content').forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            this.classList.add('active');
            const tabId = this.getAttribute('data-tab');
            document.getElementById(`${tabId}Tab`).classList.add('active');
        });
    });

    // Image preview functionality
    const productImageInput = document.getElementById('productImage');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    
    if (productImageInput && imagePreviewContainer) {
        productImageInput.addEventListener('change', function() {
            imagePreviewContainer.innerHTML = '';
            const files = this.files;
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (!file.type.match('image.*')) continue;
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'image-preview';
                    
                    const removeBtn = document.createElement('span');
                    removeBtn.className = 'remove-image';
                    removeBtn.innerHTML = '&times;';
                    removeBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        img.remove();
                        productImageInput.value = '';
                    });
                    
                    img.appendChild(removeBtn);
                    imagePreviewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Barcode preview
    const productBarcode = document.getElementById('productBarcode');
    const barcodePreview = document.getElementById('barcodePreview');
    
    if (productBarcode && barcodePreview) {
        productBarcode.addEventListener('input', function() {
            const barcode = this.value;
            barcodePreview.textContent = barcode ? `*${barcode}*` : '';
        });
    }

    // Auto-generate product code if empty
    const productName = document.getElementById('productName');
    const productCode = document.getElementById('productCode');
    
    if (productName && productCode) {
        productName.addEventListener('blur', function() {
            if (!productCode.value && this.value) {
                // Generate a simple code from the product name
                const code = this.value.substring(0, 3).toUpperCase() + 
                             Math.floor(1000 + Math.random() * 9000);
                productCode.value = code;
            }
        });
    }

    // Calculate total price for stock in
    const stockInQuantity = document.getElementById('stockInQuantity');
    const stockInUnitPrice = document.getElementById('stockInUnitPrice');
    const stockInTotalPrice = document.getElementById('stockInTotalPrice');
    
    if (stockInQuantity && stockInUnitPrice && stockInTotalPrice) {
        stockInQuantity.addEventListener('input', calculateStockInTotal);
        stockInUnitPrice.addEventListener('input', calculateStockInTotal);
        
        function calculateStockInTotal() {
            const quantity = parseFloat(stockInQuantity.value) || 0;
            const unitPrice = parseFloat(stockInUnitPrice.value) || 0;
            const totalPrice = quantity * unitPrice;
            stockInTotalPrice.value = totalPrice.toFixed(2);
        }
    }

    // Calculate total price for stock out
    const stockOutQuantity = document.getElementById('stockOutQuantity');
    const stockOutUnitPrice = document.getElementById('stockOutUnitPrice');
    const stockOutTotalPrice = document.getElementById('stockOutTotalPrice');
    
    if (stockOutQuantity && stockOutUnitPrice && stockOutTotalPrice) {
        stockOutQuantity.addEventListener('input', calculateStockOutTotal);
        stockOutUnitPrice.addEventListener('input', calculateStockOutTotal);
        
        function calculateStockOutTotal() {
            const quantity = parseFloat(stockOutQuantity.value) || 0;
            const unitPrice = parseFloat(stockOutUnitPrice.value) || 0;
            const totalPrice = quantity * unitPrice;
            stockOutTotalPrice.value = totalPrice.toFixed(2);
        }
    }

    // Close modals
    const closeButtons = document.querySelectorAll('[id^="close"], [id^="cancel"]');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.admin-modal');
            if (modal) modal.classList.remove('show');
        });
    });

    // Show toast notification from PHP
    const toastMessage = document.getElementById('toastMessage');
    if (toastMessage && toastMessage.textContent.trim() !== '') {
        const toast = document.getElementById('toastNotification');
        if (toast) {
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }
    }
});

// Show toast notification
function showToast(message, type = 'success') {
    const toast = document.getElementById('toastNotification');
    const toastMessage = document.getElementById('toastMessage');
    
    if (!toast || !toastMessage) return;
    
    // Set message and type
    toastMessage.textContent = message;
    toast.className = `admin-toast admin-toast-${type} show`;
    
    // Set icon based on type
    const icon = toast.querySelector('.admin-toast-icon');
    if (type === 'success') {
        icon.className = 'admin-toast-icon fas fa-check-circle';
    } else if (type === 'error') {
        icon.className = 'admin-toast-icon fas fa-exclamation-circle';
    } else if (type === 'warning') {
        icon.className = 'admin-toast-icon fas fa-exclamation-triangle';
    }
    
    // Hide after 3 seconds
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

// Confirm action
function confirmAction(message, callback) {
    const confirmationModal = document.getElementById('confirmationModal');
    const confirmationMessage = document.getElementById('confirmationMessage');
    
    if (!confirmationModal || !confirmationMessage) return;
    
    confirmationMessage.textContent = message;
    confirmationModal.classList.add('show');
    
    const confirmButton = document.getElementById('confirmAction');
    const oldHandler = confirmButton.onclick;
    
    confirmButton.onclick = function() {
        confirmationModal.classList.remove('show');
        if (typeof callback === 'function') callback();
        confirmButton.onclick = oldHandler;
    };
}