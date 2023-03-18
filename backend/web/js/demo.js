"use strict";

/*
// Table of content
// - Toasts / Live
// - Toasts / Placement
// - Forms
*/

(function($, window){
    /*
    // Toasts / Live
    */
    (function() {
        let counter = 0;

        $('#liveToastBtn').on('click', function() {
            const $toast = $('#liveToast').clone();

            if ($toast.length !== 1) {
                return;
            }

            $toast.find('.toast-body').text((++counter).toString());

            window.stroyka.toast.insert($toast).show();
        });
    })();

    /*
    // Toasts / Placement
    */
    (function() {
        const selectPlacement = document.getElementById('selectToastPlacement');

        if (!selectPlacement) {
            return;
        }

        selectPlacement.addEventListener('change', function() {
            const container = document.getElementById('toastPlacement');
            const previousClass = container.dataset.previousClass;

            if (previousClass) {
                container.classList.remove(...previousClass.split(' '));
            }

            if (this.value) {
                container.classList.add(...this.value.split(' '));
            }

            container.dataset.previousClass = this.value;
        });
    })();

    /*
    // Forms
    //
    // JavaScript for disabling form submissions if there are invalid fields
    */
    $('.needs-validation').on('submit', function(event) {
        if (!this.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
        }

        $(this).addClass('was-validated');
    });


    
    $(document).on('click', '.qty-plus', function () {
    // $('.qty-plus').on('click', function() {
        // alert('.qty-plus');
        var quantityId = document.getElementById('partsapplicationmodel-quantity');
        var quantityVal = parseFloat($('#partsapplicationmodel-quantity').val()); // quantity
        var orderId = quantityId.dataset.orderId;// data order id
        var qtyId = document.getElementById('qty-' + orderId);
        
        $.ajax({
            url:'/shop-admin/crm/order-parts-listed/quantity-order-plus',
            type:'get',
            data:{id:orderId},
            success:function(data){
                console.log('qty', data.order.quantity);
                qtyId.innerHTML = data.order.quantity;

            },
            error: function (data) {
                console.log('errors', data);

            }
        });
    });
    
    $(document).on('click', '.qty-minus', function () {
        var quantityId = document.getElementById('partsapplicationmodel-quantity');
        var quantityVal = parseFloat($('#partsapplicationmodel-quantity').val()); // quantity
        var orderId = quantityId.dataset.orderId;// data order id
        var qtyId = document.getElementById('qty-' + orderId);
        
        $.ajax({
            url:'/shop-admin/crm/order-parts-listed/quantity-order-minus',
            type:'get',
            data:{id:orderId},
            success:function(data){
                console.log('qty', data.order.quantity);
                qtyId.innerHTML = data.order.quantity;

            },
            error: function (data) {
                console.log('errors', data);

            }
        });
    });
    



}(jQuery, window));
