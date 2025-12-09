 <div class="modal fade" id="productModal<?php echo $product['id']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $product['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="../include/sellproduct.php" method="POST" class="d-inline">
                                        <div class="modal-header">
                                            <div>
                                                <h4 class="modal-title" id="modalLabel<?php echo $product['id']; ?>">
                                                    <?php echo htmlspecialchars($product['product_name']); ?>
                                                </h4>
                                                <!-- <span class="badge bg-secondary"><?php echo htmlspecialchars($product['category_name']); ?></span> -->
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- <img style="width: 100%;" src="../uploads/products/<?php echo $product['image']; ?>" alt="Product Image" class="img-thumbnail mb-3" style="max-height:180px;"> -->
                                            <!-- <div class="mb-2"><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></div> -->
                                            <div class="row mb-5 mb-lg-8" data-product-details="data-product-details">
                                            <div class="col-12 col-lg-6">
                <div class="row g-3 mb-3">
                  <img src="../uploads/products/<?php echo $product['image']; ?>" style="height: 100%;" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="img-fluid rounded-1" />
                </div>
              </div>
                                            <div class="col-12 col-lg-6">
                <div class="d-flex flex-column justify-content-between h-100">
                  <div>
                    <div class="d-flex flex-wrap">
                      <div class="me-2">
                        <!-- <span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span> -->
                      </div>
                    </div>
                    <h3 class="mb-3 lh-sm"><?php echo $product['product_name']; ?></h3>
                    <div class="d-flex flex-wrap align-items-start mb-3">
                        <!-- <span class="badge text-bg-success fs-9 rounded-pill me-2 fw-semibold">#1 Best seller</span><a class="fw-semibold" href="#!">in Phoenix sell analytics 2021</a> -->
                    </div>
                    <div class="d-flex flex-wrap align-items-center">
                    <h1 class="me-3">&#8369; <?php echo $product['price']; ?></h1>
                      <p class="text-body-quaternary text-decoration-line-through fs-6 mb-0 me-3"></p>
                      <!-- <p class="text-warning fw-bolder fs-6 mb-0">10% off</p> -->
                    </div>
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
                                                <strong>Date:</strong>
                                                <input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                                            </div>
                                            <div class="mb-2">
                                                <strong>Discount:</strong>
                                                <input type="number" class="form-control" id="discount<?php echo $product['id']; ?>" name="discount" value="0.00">
                                            </div>
                                            <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                    <!-- <p class="text-success fw-semibold fs-7 mb-2">In stock</p> -->
                  </div>
                  <div>
                    <div class="row g-3 g-sm-5 align-items-end">
                      <div class="col-12 col-sm">
                        <p class="fw-semibold mb-2 text-body">Quantity : </p>
                        <div class="d-flex justify-content-between align-items-end">
                          <div class="d-flex flex-between-center" data-quantity="data-quantity">
                            <button class="btn btn-phoenix-primary px-3" type="button" data-type="minus"><span class="fas fa-minus"></span></button>
                            <input class="form-control text-center input-spin-none bg-transparent border-0 outline-none" style="width:50px;" name="quantity" type="number" value="1" min="1" max="<?php echo $product['total_quantity']; ?>" />
                            <button class="btn btn-phoenix-primary px-3" type="button" data-type="plus"><span class="fas fa-plus"></span></button>
                          </div>
                          <!-- <button class="btn btn-phoenix-primary px-3 border-0"><span class="fas fa-share-alt fs-7"></span></button> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                                            </div>
                                            <!-- <div class="row">
                                                <div class="col-md-3">
                                                    <img style="width: 100%;" src="../uploads/products/<?php echo $product['image']; ?>" alt="Product Image" class="img-thumbnail mb-3" style="max-height:180px;">
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-2"><strong>Product:</strong> <?php echo htmlspecialchars($product['product_name']); ?></div>
                                                    <div class="mb-2"><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="mb-2">
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
                                                <input type="number" class="form-control" id="quantity<?php echo $product['id']; ?>" max="<?php echo $product['total_quantity']; ?>" name="quantity" value="1">
                                            </div>
                                            <div class="mb-2">
                                                <strong>Date:</strong>
                                                <input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                                            </div>
                                            <div class="mb-2">
                                                <strong>Discount:</strong>
                                                <input type="number" class="form-control" id="discount<?php echo $product['id']; ?>" name="discount" value="0.00">
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