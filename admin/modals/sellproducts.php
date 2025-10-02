 <div class="modal fade" id="productModal<?php echo $product['id']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $product['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="../include/sellproduct.php" method="POST" class="d-inline">
                                        <div class="modal-header">
                                            <div>
                                                <h4 class="modal-title" id="modalLabel<?php echo $product['id']; ?>">
                                                    <?php echo htmlspecialchars($product['product_name']); ?>
                                                </h4>
                                                <span class="badge bg-secondary"><?php echo htmlspecialchars($product['category_name']); ?></span>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- <img style="width: 100%;" src="../uploads/products/<?php echo $product['image']; ?>" alt="Product Image" class="img-thumbnail mb-3" style="max-height:180px;"> -->
                                            <!-- <div class="mb-2"><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></div> -->
                                            <div class="mb-2">
                                                <label for="customer" class="form-label">Customer</label>
                                                <select name="customer_id" id="" class="form-select" required>
                                                    <option value="" disabled selected>Select Customer</option>
                                                    <?php
                                                    

                                                    $db = new DB();
                                                    $customer = new Customer($db->connect());
                                                    $customers = $customer->getAllCustomers();
                                                    foreach ($customers as $customer) {
                                                        echo '<option value="' . $customer['id'] . '">' . htmlspecialchars($customer['fullname']) . '</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <strong>Price:</strong>
                                                <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                                <input type="text" class="form-control" value="<?php echo number_format($product['price'], 2); ?>" readonly>
                                            </div>
                                            <div class="mb-2">
                                                <strong>Qty Left:</strong>
                                                <input type="text" class="form-control" name="qty_left" value="<?php echo number_format($product['total_quantity'], 0); ?>" readonly>
                                            </div>
                                            <div class="mb-2">
                                                <strong>Qty:</strong>
                                                <input type="text" class="form-control" id="quantity<?php echo $product['id']; ?>" name="quantity" value="1">
                                            </div>
                                            <div class="mb-2">
                                                <strong>Date:</strong>
                                                <input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                                            </div>
                                            <div class="mb-2">
                                                <strong>Discount:</strong>
                                                <input type="number" class="form-control" id="discount<?php echo $product['id']; ?>" name="discount" value="0.00">
                                            </div>
                                            <!-- <div class="mb-2">
                                                <strong>Total Price:</strong>
                                                <input type="text" class="form-control" readonly id="TotalPrice<?php echo $product['id']; ?>">
                                            </div> -->
                                        </div>
                                        <div class="modal-footer">
                                                <input type="hidden" name="voucher" value="CS">
                                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                <button type="submit" class="btn btn-success">Sell Product</button>
                                            
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                function calculateTotalPrice() {
                    var price = parseFloat($('input[name="price<?php echo $product['id']; ?>"]').val()) || 0;
                    var quantity = parseInt($('#quantity<?php echo $product['id']; ?>').val()) || 0;
                    var discount = parseFloat($('#discount<?php echo $product['id']; ?>').val()) || 0;

                    var totalPrice = (price * quantity) - discount;
                    $('#TotalPrice').val(totalPrice.toFixed(2));
                }

                // Initial calculation
                calculateTotalPrice();

                // Recalculate when quantity or discount changes
                $('#quantity, #discount').on('input', function() {
                    calculateTotalPrice();
                });
            });
        </script>