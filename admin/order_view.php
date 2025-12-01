<?php 

session_start();
require_once '../Classes/Auth.php';
Login::requireLogin();

// 
?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Caps Inventory</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicons/favicon.ico">
    <link rel="manifest" href="../assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="../assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="../vendors/simplebar/simplebar.min.js"></script>
    <script src="../assets/js/config.js"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="../vendors/choices/choices.min.css" rel="stylesheet">
    <link href="../vendors/dhtmlx-gantt/dhtmlxgantt.css" rel="stylesheet">
    <link href="../vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com"> -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" href="../assets/img/favicons/favicon.ico" type="image/x-icon">
    <link rel="manifest" href="../assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="../assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="../vendors/simplebar/simplebar.min.js"></script>
    <script src="../assets/js/config.js"></script>

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="../assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="../assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="../assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="../assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
    <script>
      var phoenixIsRTL = window.config.config.phoenixIsRTL;
      if (phoenixIsRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
  </head>


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <?php include('../include/layout/sidebar.php') ?>
      <?php include('../include/layout/header.php') ?>
      <div class="content">
        <div class="mb-9">
          <h2 class="mb-0">Order <span>#<?php echo $_GET['id']; ?></span></h2><br>
          <div class="d-sm-flex flex-between-center mb-3">
            <!-- <p class="text-body-secondary lh-sm mb-0 mt-2 mt-sm-0">Customer ID : <a class="fw-bold" href="#!"> 2364847</a></p> -->
            <!-- <div class="d-flex">
              <button class="btn btn-link pe-3 ps-0 text-body"><span class="fas fa-print me-2"></span>Print</button>
              <button class="btn btn-link px-3 text-body"><span class="fas fa-undo me-2"></span>Refund</button>
              <div class="dropdown">
                <button class="btn text-body dropdown-toggle dropdown-caret-none ps-3 pe-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">More action<span class="fas fa-chevron-down ms-2"></span></button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </div>
            </div> -->
          </div>
          
          <div class="row g-5 gy-7">
            <div class="col-12 col-xl-12 col-xxl-12">
              <div id="orderTable" data-list='{"valueNames":["products","discount","size","price","quantity","total"],"page":10}'>
                <div class="table-responsive scrollbar">
                  <table class="table fs-9 mb-0 border-top border-translucent">
                    <thead>
                      <tr>
                        <th class="sort white-space-nowrap align-middle fs-10" scope="col"></th>
                        <th class="sort white-space-nowrap align-middle" scope="col" data-sort="products" style="width: 300px;">PRODUCTS</th>
                        <th class="sort align-middle text-end ps-4" scope="col" data-sort="price">PRICE</th>
                        <th class="sort align-middle text-end ps-4" scope="col" data-sort="status">Status</th>
                        <th class="sort align-middle text-end ps-4" scope="col" data-sort="quantity">QUANTITY</th>
                        <th class="sort align-middle text-end ps-4" scope="col" data-sort="discount">DISCOUNT</th>
                        <th class="sort align-middle text-end ps-4" scope="col" data-sort="total">TOTAL</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody class="list" id="order-table-body">
                        <?php
            include('../Classes/ProductTransaction.php');
            include('../Classes/Cart.php');
            $conn = $db->connect();
            $productTransaction = new ProductTransaction($conn);

            $total = 0;
            $discount = 0;
            $CustomerId = '';

            if (isset($_GET['notification_id'])) {
              // include_once('../Classes/DB.php');
              // $db = new DB();
              // $conn = $db->connect();
              $notification_id = intval($_GET['notification_id']);
              $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
              $stmt->bind_param("i", $notification_id);
              $stmt->execute();
            }

            $result = $productTransaction->getCSTransactionById($_GET['id']);
            foreach ($result as $results) {
                if($results['voucher'] != 'LS'){  
                    $total += $results['price'] * $results['quantity_out'];
                }
                
                $discount += $results['discount'];
                // $CustomerId = $results['CustomerId'];
                ?>

                      <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="align-middle white-space-nowrap py-2">
                            <!-- <a class="d-block border border-translucent rounded-2" href="../../../apps/e-commerce/landing/product-details.html"> -->
                                <img src="../uploads/products/<?php echo $results['image'] ?>" alt="" style="height: 50px; width: 100px;" />
                            <!-- </a> -->
                        </td>
                        <td class="products align-middle py-0">
                            <?php echo $results['product_name']; ?>
                        </td>
                        <td class="price align-middle text-end py-0 ps-4 text-body-tertiary"><?php echo number_format($results['price'], 2); ?></td>
                        <td class="quantity align-middle text-end py-0 ps-4 text-body-tertiary"><?php echo $results['voucher'] == 'LS' ?  'Loaned' : ''; ?></td>
                        <td class="quantity align-middle text-end py-0 ps-4 text-body-tertiary"><?php echo $results['quantity_out']; ?></td>
                        <td class="discount align-middle text-end py-0 ps-4 text-body-tertiary"><?php echo number_format($results['discount'], 2); ?></td>
                        <td class="total align-middle fw-bold text-body-highlight text-end py-0 ps-4"><?php echo number_format($results['price'] * $results['quantity_out'], 2); ?></td>
                        <td>
                    
                          <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal<?php echo $results['id']; ?>">
                          <i class="fas fa-trash-alt"></i>
                          </button>

                             <?php if ($results['voucher'] != 'LS') { ?>
                              <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#moveToLoanModal<?php echo $results['id']; ?>">
                                <i class="fas fa-arrows-turn-right"></i>
                              </button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#backToStockModal<?php echo $results['id']; ?>">
                                <i class="fas fa-arrows-turn-right"></i>
                              </button>
                            <?php } ?>

                             <div class="modal fade" id="backToStockModal<?php echo $results['id']; ?>" tabindex="-1" aria-labelledby="moveToLoanLabel<?php echo $results['id']; ?>" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="moveToLoanLabel<?php echo $results['id']; ?>">Retrieve Loan</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  Retrieve <strong><?php echo htmlspecialchars($results['product_name']); ?></strong> to loan? This action cannot be undone.
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <a href="move_to_loan.php?order_id=<?php echo $_GET['id']; ?>&item_id=<?php echo $results['id']; ?>&voucher=CS" class="btn btn-warning">Confirm</a>
                                </div>
                                </div>
                              </div>
                            </div>


                            <div class="modal fade" id="moveToLoanModal<?php echo $results['id']; ?>" tabindex="-1" aria-labelledby="moveToLoanLabel<?php echo $results['id']; ?>" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="moveToLoanLabel<?php echo $results['id']; ?>">Move Item to Loan</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  Move <strong><?php echo htmlspecialchars($results['product_name']); ?></strong> to loan? This action cannot be undone.
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <a href="move_to_loan.php?order_id=<?php echo $_GET['id']; ?>&item_id=<?php echo $results['id']; ?>&voucher=LS" class="btn btn-warning">Confirm</a>
                                </div>
                                </div>
                              </div>
                            </div>
                          <!-- Modal -->
                          <div class="modal fade" id="confirmDeleteModal<?php echo $results['id']; ?>" tabindex="-1" aria-labelledby="confirmDeleteLabel<?php echo $results['id']; ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="confirmDeleteLabel<?php echo $results['id']; ?>">Confirm Deletion</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Are you sure you want to delete <strong><?php echo htmlspecialchars($results['product_name']); ?></strong> from this order?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                              <a href="delete_order_item.php?order_id=<?php echo $_GET['id']; ?>&item_id=<?php echo $results['id']; ?>" class="btn btn-danger">Delete</a>
                            </div>
                            </div>
                          </div>
                          </div>
                        </td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td><p class="text-body-emphasis fw-semibold lh-sm mb-0">Items subtotal :</p></td>
                        <td class="text-end fw-bold" colspan="6">&#8369;<?php echo number_format($total, 2); ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <?php
              
              include('../Classes/Customer.php');

                $db = new DB();
                $customer = new Customer($db->connect());

                $cart = new Cart($conn);
                $cartItems = $cart->getTransactionItems($_GET['id']);

                foreach ($cartItems as $item) {
                    $CustomerId = $item['customer_id'];
                    break; // Exit the loop after getting the first item
                }

                $customerDetails = $customer->getCustomerById($CustomerId);

                echo '<pre>';
                // print_r($customerDetails['fullname']);
                echo '</pre>';

              ?>
              <div class="row mt-4">
                <div class="col-6">
                  <h4 class="mb-5">Billing details</h4>
                  <div class="row g-4 flex-sm-column">
                    <div class="col-6 col-sm-12">
                      <div class="d-flex align-items-center mb-1"><span class="me-2" data-feather="user" style="stroke-width:2.5;"></span>
                        <h6 class="mb-0">Customer</h6>
                      </div>
                      <a class="d-block fs-9 ms-4" href="#!"><?php print_r($customerDetails['fullname']); ?></a>
                    </div>
                    <div class="col-6 col-sm-12">
                      <div class="d-flex align-items-center mb-1"><span class="me-2" data-feather="phone" style="stroke-width:2.5;"></span>
                        <h6 class="mb-0">Phone</h6>
                      </div>
                      <a class="d-block fs-9 ms-4" href="tel:<?php echo $customerDetails['contact_no']; ?>"><?php echo $customerDetails['contact_no']; ?></a>
                    </div>
                    <div class="col-6 col-sm-12 order-sm-1">
                      <div class="d-flex align-items-center mb-1"><span class="me-2" data-feather="home" style="stroke-width:2.5;"></span>
                        <h6 class="mb-0">Address</h6>
                      </div>
                      <div class="ms-4">
                        <p class="text-body-secondary mb-0 fs-9"><?php print_r($customerDetails['address']); ?></p>
                      </div>
                    </div>
                    
                  </div>
                </div>
                <div class="col-6">
                  <div class="card mb-3">
                    <div class="card-body">
                      <form action="checkout.php" method="POST">
                      <h3 class="card-title mb-4">Summary</h3>
                      <div>
                        <div class="d-flex justify-content-between">
                          <p class="text-body fw-semibold">Items subtotal :</p>
                          <p class="text-body-emphasis fw-semibold">&#8369;<?php echo number_format($total, 2); ?></p>
                        </div>
                        <div class="d-flex justify-content-between">
                          <p class="text-body fw-semibold">Discount :</p>
                          <p class="text-danger fw-semibold">- &#8369;<?php echo number_format($discount, 2); ?></p>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                          <p class="text-body fw-semibold">Downpayment :</p>
                          <input type="number" step="0.01" max="<?php echo $total; ?>" class="form-control w-50 text-end d-inline-block" name="downpayment" id="downpayment" style="display:inline-block;">
                        </div>
                      </div>
                      <div class="d-flex justify-content-between border-top border-translucent border-dashed pt-4">
                        <h4 class="mb-0">Total :</h4>
                        <h4 class="mb-0">&#8369;<?php echo number_format($total - $discount, 2); ?></h4>
                      </div>
                      <br>
                      <input type="hidden" name="order_id" value="<?php echo $_GET['id']; ?>">
                      <input type="hidden" name="total_amt" value="<?php echo $total - $discount; ?>">
                      <button type="submit" class="btn btn-primary w-100">Checkout</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-xl-4 col-xxl-3">
              <div class="row">
                
                <!-- <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <h3 class="card-title mb-4">Order Status</h3>
                      <h6 class="mb-2">Payment status</h6>
                      <select class="form-select mb-4" aria-label="delivery type">
                        <option value="cod">Processing</option>
                        <option value="card">Canceled</option>
                        <option value="paypal">Completed</option>
                      </select>
                    
                    </div>
                  </div>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
        var navbarTop = document.querySelector('.navbar-top');
        if (navbarTopStyle === 'darker') {
          navbarTop.setAttribute('data-navbar-appearance', 'darker');
        }

        var navbarVerticalStyle = window.config.config.phoenixNavbarVerticalStyle;
        var navbarVertical = document.querySelector('.navbar-vertical');
        if (navbarVertical && navbarVerticalStyle === 'darker') {
          navbarVertical.setAttribute('data-navbar-appearance', 'darker');
        }
      </script>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="../vendors/popper/popper.min.js"></script>
    <script src="../vendors/bootstrap/bootstrap.min.js"></script>
    <script src="../vendors/anchorjs/anchor.min.js"></script>
    <script src="../vendors/is/is.min.js"></script>
    <script src="../vendors/fontawesome/all.min.js"></script>
    <script src="../vendors/lodash/lodash.min.js"></script>
    <script src="../vendors/list.js/list.min.js"></script>
    <script src="../vendors/feather-icons/feather.min.js"></script>
    <script src="../vendors/dayjs/dayjs.min.js"></script>
    <script src="../vendors/choices/choices.min.js"></script>
    <script src="../vendors/echarts/echarts.min.js"></script>
    <script src="../vendors/dhtmlx-gantt/dhtmlxgantt.js"></script>
    <script src="../vendors/flatpickr/flatpickr.min.js"></script>
    <script src="../assets/js/phoenix.js"></script>
    <script src="../assets/js/projectmanagement-dashboard.js"></script>

  </body>

</html>