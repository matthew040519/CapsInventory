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
          <div class="row g-3 mb-4">
            <div class="col-auto">
              <h2 class="mb-0">Loan Details</h2>
            <p class="text-body-tertiary">Below is a list of recent loan details, including order number, total amount, customer details, payment status, fulfilment status, delivery type, and date. Use the filters and search to find specific loan details.</p>
            </div>
          </div>
          <!-- <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
            <li class="nav-item"><a class="nav-link active" aria-current="page" href="#"><span>All </span><span class="text-body-tertiary fw-semibold">(68817)</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><span>Pending payment </span><span class="text-body-tertiary fw-semibold">(6)</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><span>Unfulfilled </span><span class="text-body-tertiary fw-semibold">(17)</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><span>Completed</span><span class="text-body-tertiary fw-semibold">(6,810)</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><span>Refunded</span><span class="text-body-tertiary fw-semibold">(8)</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><span>Failed</span><span class="text-body-tertiary fw-semibold">(2)</span></a></li>
          </ul> -->
            <?php

include('../Classes/Loan.php');
                $loan = new Loan($db->connect());
                
              ?>
          <div id="orderTable" data-list='{"valueNames":["order","total","customer","payment_status","fulfilment_status","delivery_type","date"],"page":10,"pagination":true}'>
            <div class="mb-4">
              <div class="row g-3 justify-content-between align-items-center">
                <div class="col-auto">
                  <!-- Pay Loan Button -->
                   <?php

                   if (isset($_GET['notification_id'])) {
              // include_once('../Classes/DB.php');
              // $db = new DB();
              // $conn = $db->connect();
              $notification_id = intval($_GET['notification_id']);
              $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
              $stmt->execute([$notification_id]);
            }
                                // Get the max balance for the reference
                                $loanByRef = $loan->getLoanByReference($_GET['reference']);
                                $maxBalance = isset($loanByRef['balance']) ? $loanByRef['balance'] : 0;
                                if($maxBalance > 0){
                              ?>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loanPaymentModal">
                    Pay Loan
                  </button>
                  <?php } ?>
                </div>
                <div class="col-auto">
                  <div class="search-box">
                    <form class="position-relative">
                      <input class="form-control search-input search" type="search" placeholder="Search orders" aria-label="Search" />
                      <span class="fas fa-search search-box-icon"></span>
                    </form>
                  </div>
                </div>
              </div>

            

              <!-- Loan Payment Modal -->
              <div class="modal fade" id="loanPaymentModal" tabindex="-1" aria-labelledby="loanPaymentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form method="post" action="pay_loan.php">
                      <div class="modal-header">
                        <h5 class="modal-title" id="loanPaymentModalLabel">Loan Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" name="reference" value="<?php echo $_GET['reference']; ?>">
                        <div class="mb-3">
                          <label for="loanAmount" class="form-label">Amount</label>

                              <?php
                                // Get the max balance for the reference
                                $loanByRef = $loan->getLoanByReference($_GET['reference']);
                                $maxBalance = isset($loanByRef['balance']) ? $loanByRef['balance'] : 0;
                              ?>
                              <input type="number" class="form-control" id="loanAmount" name="amount" max="<?php echo $maxBalance; ?>" required>

                        </div>
                        <?php
                                // Get the max balance for the reference
                                $loanByRef = $loan->getLoanByReference($_GET['reference']);
                                $customer_id = isset($loanByRef['customer_id']) ? $loanByRef['customer_id'] : 0;
                              ?>
                        <input type="hidden" value="<?php echo $customer_id; ?>" name="customer_id">
                        <div class="mb-3">
                          <label for="loanAmount" class="form-label">Balance</label>

                              <?php
                                // Get the max balance for the reference
                                $loanByRef = $loan->getLoanByReference($_GET['reference']);
                                $maxBalance = isset($loanByRef['balance']) ? $loanByRef['balance'] : 0;
                              ?>
                              <input type="number" class="form-control" id="loanAmount" readonly value="<?php echo $maxBalance; ?>" required>

                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Payment</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
              <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table table-sm fs-9 mb-0">
                  <thead>
                    <tr>
                      <!-- <th class="white-space-nowrap fs-9 align-middle ps-0" style="width:26px;">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" id="checkbox-bulk-order-select" type="checkbox" data-bulk-select='{"body":"order-table-body"}' />
                        </div>
                      </th> -->
                      <!-- <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order" style="width:5%;">ORDER</th> -->
                      
                      <th class="sort align-middle ps-8" scope="col" data-sort="customer">Reference</th>
                      <th class="sort align-middle pe-0" scope="col" data-sort="date">Credit</th>
                      <th class="sort align-middle pe-0" scope="col" data-sort="amount">Debit</th>
                      <th class="sort align-middle" scope="col" data-sort="date">Date</th>
                    </tr>
                  </thead>
                  <tbody class="list" id="order-table-body">
                    <?php 
                    // Include database and object files 
                    // include('../Classes/Loan.php');
                    $loan = new Loan($db->connect());
                    $loans = $loan->getLoanDetails($_GET['reference']);
                    foreach ($loans as $loan) {
                    ?>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <!-- <div class="avatar avatar-m">
                            <img class="rounded-circle" src="../../../assets/img/team/32.webp" alt="" />
                          </div> -->
                          <h6 class="mb-0 text-body"><?php echo $loan['transaction_ref']; ?></h6>
                        </a></td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary"><?php echo number_format($loan['credit'], 2); ?></td>
                      <td class="amount align-middle white-space-nowrap text-body-tertiary"><?php echo number_format($loan['debit'], 2); ?></td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary"><?php echo $loan['tdate']; ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                  <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p><a class="fw-semibold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
                <div class="col-auto d-flex">
                  <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                  <ul class="mb-0 pagination"></ul>
                  <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                </div>
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