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
    <section class="pt-5 pb-9 bg-body-emphasis dark__bg-gray-1200 border-top">

        <div class="container-small">
          <!-- <nav class="mb-3" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="#!">Page 1</a></li>
              <li class="breadcrumb-item"><a href="#!">Page 2</a></li>
              <li class="breadcrumb-item active" aria-current="page">Default</li>
            </ol>
          </nav> -->
          <?php

            include '../Classes/DB.php';
            include '../Classes/Order.php';
            include '../Classes/Customer.php';
            include '../Classes/ProductTransaction.php';
            $db = new DB();
            $conn = $db->connect();

            if (isset($_GET['order_id'])) {
                $order_id = $_GET['order_id'];

                $order = new Order($conn);
                $orderDetails = $order->getOrderById($order_id);

                $customer = new Customer($conn);
                $customerDetails = $customer->getCustomerById($orderDetails['customer_id']);
                
                $productTransaction = new ProductTransaction($conn);
                $transaction = $productTransaction->getCSTransactionById($order_id);
            } else {
                echo "<script>alert('Order ID is required'); window.close();</script>";
                exit();
            }
          ?>
          <div class="d-flex justify-content-between align-items-end mb-4">
            <h2 class="mb-0">Invoice</h2>
            <div>
              <button class="btn btn-phoenix-secondary me-2"><span class="fa-solid fa-download me-sm-2"></span><span class="d-none d-sm-inline-block">Download Invoice</span></button>
              <button class="btn btn-phoenix-secondary"><span class="fa-solid fa-print me-sm-2"></span><span class="d-none d-sm-inline-block">Print</span></button>
            </div>
          </div>
          <div class="bg-body dark__bg-gray-1100 p-4 mb-4 rounded-2">
            <div class="row g-4">
              <div class="col-12 col-sm-6 col-lg-3">
                <div class="row g-4 g-lg-2">
                  <div class="col-12 col-sm-6 col-lg-12">
                    <div class="row align-items-center g-0">
                      <div class="col-auto col-lg-6 col-xl-5">
                        <h6 class="mb-0 me-3">Invoice No :</h6>
                      </div>
                      <div class="col-auto col-lg-6 col-xl-7">
                        <p class="fs-9 text-body-secondary fw-semibold mb-0">#<?php echo rand(100000, 999999); ?></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-lg-12">
                    <div class="row align-items-center g-0">
                      <div class="col-auto col-lg-6 col-xl-5">
                        <h6 class="me-3">Invoice Date :</h6>
                      </div>
                      <div class="col-auto col-lg-6 col-xl-7">
                        <p class="fs-9 text-body-secondary fw-semibold mb-0"><?php echo date('d.m.Y'); ?></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-lg-12">
                    <div class="row align-items-center g-0">
                      <div class="col-auto col-lg-6 col-xl-5">
                        <h6 class="me-3">Order No :</h6>
                      </div>
                      <div class="col-auto col-lg-6 col-xl-7">
                        <p class="fs-9 text-body-secondary fw-semibold mb-0"><?php echo $_GET['order_id']; ?></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-lg-12">
                    <div class="row align-items-center g-0">
                      <div class="col-auto col-lg-6 col-xl-5">
                        <h6 class="me-3">Sold By :</h6>
                      </div>
                      <div class="col-auto col-lg-6 col-xl-7">
                        <p class="fs-9 text-body-secondary fw-semibold mb-0">CAPS</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-lg-12">
                    <div class="row align-items-center g-0">
                      <div class="col-auto col-lg-6 col-xl-5">
                        <h6 class="me-3">Order Date:</h6>
                      </div>
                      <div class="col-auto col-lg-6 col-xl-7">
                        <p class="fs-9 text-body-secondary fw-semibold mb-0"><?php echo date('d.m.Y'); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-12 col-sm-6 col-lg-4">
                <div class="row g-4">
                  <div class="col-12 col-lg-6">
                    <h6 class="mb-2"> Billing Address :</h6>
                    <div class="fs-9 text-body-secondary fw-semibold mb-0">
                      <p class="mb-2"><?php print_r($customerDetails['fullname']); ?></p>
                      <p class="mb-2"><?php print_r($customerDetails['address']); ?></p>
                      <p class="mb-2"><?php print_r($customerDetails['gender']); ?></p>
                      <p class="mb-0"><?php print_r($customerDetails['contact_no']); ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="px-0">
            <div class="table-responsive scrollbar">
              <table class="table fs-9 text-body mb-0">
                <thead class="bg-body-secondary">
                  <tr>
                    <th scope="col" style="width: 24px;"></th>
                    <th scope="col" style="min-width: 60px;">SL NO.</th>
                    <th scope="col" style="min-width: 360px;">Products</th>
                    <th class="ps-5" scope="col" style="min-width: 150px;"></th>
                    <th scope="col" style="width: 60px;"></th>
                    
                    <th class="text-end" scope="col" style="width: 138px;"></th>
                    <th class="text-center" scope="col" style="width: 80px;"></th>
                    <th class="text-end" scope="col" style="min-width: 92px;"></th>
                    <th class="text-end" scope="col" style="width: 80px;">Quantity</th>
                    <th class="text-end" scope="col" style="width: 100px;">Price</th>
                    <th class="text-end" scope="col" style="min-width: 60px;">Total</th>
                    <th scope="col" style="width: 24px;"></th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    $discount = 0;
                        foreach ($transaction as $index => $item) {
                            $total += $item['price'] * $item['quantity_out'];
                            $discount += $item['discount'];
                    ?>
                  <tr>
                    <td class="border-0"></td>
                    <td class="align-middle"><?php echo ($index + 1); ?></td>
                    <td class="align-middle">
                      <p class="line-clamp-1 mb-0 fw-semibold"><?php echo $item['product_name']; ?></p>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="align-middle ps-5"><?php echo $item['quantity_out']; ?></td>
                    <td class="align-middle text-end text-body-highlight fw-semibold"><?php echo $item['price']; ?></td>
                    <td class="align-middle text-end text-body-highlight fw-semibold"><?php echo number_format($item['price'] * $item['quantity_out'], 2); ?></td>
                    
                  </tr>
                  <?php } ?>
                  <tr class="bg-body-secondary">
                    <td></td>
                    <td class="align-middle fw-semibold" colspan="9">Subtotal</td>
                    <td class="align-middle text-end fw-bold">&#8369;<?php echo number_format($total, 2); ?></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="6"></td>
                    <td class="align-middle fw-bold ps-15" colspan="2">Discount/Voucher</td>
                    <td class="align-middle text-end fw-semibold text-danger" colspan="2">-&#8369;<?php echo number_format($discount, 2); ?></td>
                    <td></td>
                  </tr>
                  <tr class="bg-body-secondary">
                    <td class="align-middle ps-4 fw-bold text-body-highlight" colspan="3">Grand Total</td>
                    <td class="align-middle fw-bold text-body-highlight" colspan="7"></td>
                    <td class="align-middle text-end fw-bold">&#8369;<?php echo number_format($total - $discount, 2); ?></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- <div class="text-end py-9 border-bottom"><img class="mb-3" src="../../../assets/img/logos/phoenix-mart.png" alt="" />
              <h4>Authorized Signatory</h4>
            </div>
            <div class="text-center py-4 mb-9">
              <p class="mb-0">Thank you for buying with Phoenix | 2022 © <a href="https://themewagon.com/">Themewagon</a></p>
            </div> -->
          </div>
          <!-- <div class="d-flex justify-content-between">
            <button class="btn btn-primary"><span class="fa-solid fa-bag-shopping me-2"></span>Browse more items</button>
            <div>
              <button class="btn btn-phoenix-secondary me-2"><span class="fa-solid fa-download me-sm-2"></span><span class="d-none d-sm-inline-block">Download Invoice</span></button>
              <button class="btn btn-phoenix-secondary"><span class="fa-solid fa-print me-sm-2"></span><span class="d-none d-sm-inline-block">Print</span></button>
            </div>
          </div> -->
        </div>
        <!-- end of .container-->

      </section>
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