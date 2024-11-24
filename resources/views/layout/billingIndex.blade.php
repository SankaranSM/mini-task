<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Billing Page</h2>
    <form action="{{url('billing')}}" id="billing-form">

        <div class="mb-3">
            <h5>Customer Email</h5>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email ID" required>
        </div>

        {{-- Billing --}}
        <h5 class="form-label">Bill Section</h5>
        <div id="bill-section">

            <button type="button" id="add-new" class="btn btn-primary mb-3">Add New</button>

            <div class="row g-3 align-items-center mb-2 product-row">
                <div class="col-md-5">
                    <select class="form-select product-select" name="productId[]" required>
                        <option value="" selected disabled>-- Select Product --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }} (₹{{ $product->price }})
                            </option>
                        @endforeach                    
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="number" class="form-control product-quantity" name="quantity[]" placeholder="Quantity" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-remove" style="display:none;">Remove</button>
                </div>
            </div>
        </div>
        <hr>

        <div class="mb-3" style="display:none;">
            <label for="totalPrice" class="form-label">Total Price</label>
            <input type="number" class="form-control" id="totalPrice" name="totalPrice" placeholder="Calculated Total Price" readonly>
        </div>

        {{-- denaomonation --}}
        <div class="mb-3">
            <h5>Denominations</h5>
            <div class="row g-3 align-items-center mb-2">
                <div class="col-md-3">
                    <label class="form-label">₹500</label>
                    <input type="number" class="form-control denomination" data-value="500" placeholder="Count">
                </div>
                <div class="col-md-3">
                    <label class="form-label">₹200</label>
                    <input type="number" class="form-control denomination" data-value="200" placeholder="Count">
                </div>
                <div class="col-md-3">
                    <label class="form-label">₹100</label>
                    <input type="number" class="form-control denomination" data-value="100" placeholder="Count">
                </div>
                <div class="col-md-3">
                    <label class="form-label">₹50</label>
                    <input type="number" class="form-control denomination" data-value="50" placeholder="Count">
                </div>
                <div class="col-md-3">
                    <label class="form-label">₹20</label>
                    <input type="number" class="form-control denomination" data-value="20" placeholder="Count">
                </div>
                <div class="col-md-3">
                    <label class="form-label">₹10</label>
                    <input type="number" class="form-control denomination" data-value="10" placeholder="Count">
                </div>
                <div class="col-md-3">
                    <label class="form-label">₹5</label>
                    <input type="number" class="form-control denomination" data-value="5" placeholder="Count">
                </div>
                <div class="col-md-3">
                    <label class="form-label">₹1</label>
                    <input type="number" class="form-control denomination" data-value="1" placeholder="Count">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="cashPaid" class="form-label">Cash Paid by Customer</label>
            <input type="number" class="form-control" id="cashPaid" name="cashPaid" placeholder="Amount" required readonly>
            <small id="cashPaidError" class="text-danger d-none">Cash Paid by customer must be greater than or equal to the Product Price!</small>
        </div>      

        <button type="submit" class="btn btn-success">Generate Bill</button>
        <button type="reset" class="btn btn-secondary">Cancel</button>
    </form>
</div>

<script>
    $(document).ready(function () 
    {
        // add product row
        $('#add-new').on('click', function () {
            const newRow = `
            <div class="row g-3 align-items-center mb-2 product-row">
                <div class="col-md-5">
                    <select class="form-select product-select" name="productId[]" required>
                        <option value="" selected disabled>-- Select Product --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }} (₹{{ $product->price }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="number" class="form-control product-quantity" name="quantity[]" placeholder="Quantity" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-remove">Remove</button>
                </div>
            </div>`;
            $('#bill-section').append(newRow);
        });

        // remove product row
        $(document).on('click', '.btn-remove', function () {
            $(this).closest('.product-row').remove();
        });

        // denomination
        $('.denomination').on('input', function () {
            let total = 0;

            $('.denomination').each(function () {
                const count = parseInt($(this).val()) || 0; 
                const value = parseInt($(this).data('value')); 
                total += count * value; 
            });

            $('#cashPaid').val(total);
        });

        // total price function
        function calculateTotalPrice() {
            let totalPrice = 0;

            $('.product-row').each(function () {
                const productSelect = $(this).find('.product-select');
                const quantityInput = $(this).find('.product-quantity');
                const price = parseFloat(productSelect.find(':selected').data('price')) || 0;
                const quantity = parseInt(quantityInput.val()) || 0;

                totalPrice += price * quantity;
            });

            $('#totalPrice').val(totalPrice);
        }

        // total price of product selected
        $(document).on('change', '.product-select, .product-quantity', calculateTotalPrice);

        // cashPaid validation
        $('#billing-form').on('submit', function (e) {
            const totalPrice = parseFloat($('#totalPrice').val()) || 0;
            const cashPaid = parseFloat($('#cashPaid').val()) || 0;

            if (cashPaid < totalPrice) {
                e.preventDefault();
                $('#cashPaidError').removeClass('d-none');
            } else {
                $('#cashPaidError').addClass('d-none');
            }
        });
    });
</script>
</body>
</html>
