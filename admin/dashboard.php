<?php 

session_start();
require_once '../Classes/Auth.php';
Login::requireLogin();

include('../Classes/DB.php');

$db = new DB();

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
        <div class="row gy-3 mb-6 justify-content-between">
          <div class="col-md-9 col-auto">
            <h2 class="mb-2 text-body-emphasis">Dashboard</h2>
            <h5 class="text-body-tertiary fw-semibold">Here’s what’s going on at your business right now</h5>
          </div>
          <div class="col-md-3 col-auto">
            <div class="flatpickr-input-container">
              <input class="form-control ps-6 datetimepicker" id="datepicker" type="text" data-options='{"dateFormat":"M j, Y","disableMobile":true,"defaultDate":"Mar 1, 2022"}' /><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="card-title">Products</h6>
                <?php include('../Classes/Product.php');
                  $product = new Product($db->connect());
                   ?>
                <h3 class="card-text mb-2"><?php echo $product->countProducts(); ?></h3>
                
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="card-title">Customers</h6>
                <?php include('../Classes/Customer.php');
                  $customer = new Customer($db->connect());
                   ?>
                <h3 class="card-text mb-2"> <?php echo $customer->countCustomers(); ?></h3>
                
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="card-title">Orders</h6>
                <?php include('../Classes/Order.php');
                  $order = new Order($db->connect());
                   ?>
                <h3 class="card-text mb-2"><?php echo $order->countOrders(); ?></h3>
                
              </div>
            </div>
          </div>
           <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="card-title">Total Sales</h6>
                <?php include('../Classes/ProductTransaction.php');
                  $transaction = new ProductTransaction($db->connect());
                   ?>
                <h3 class="card-text mb-2">₱ <?php echo number_format($transaction->sumCSTransactionsAll() - $transaction->sumDownPayments(), 2); ?></h3>
                
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <!-- CanvasJS CDN -->
              <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
              <div class="card">
                <div class="card-body">
                  <div id="salesChartContainer" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
              
              <?php
              // Example: Get sales data for the last 7 days
              $salesData = $transaction->chartdataCS(); // Should return array: [['date'=>'2024-06-01','total'=>1000], ...]
              // print_r($salesData);
              // Prepare dataPoints for CanvasJS
              $dataPoints = [];
              foreach ($salesData as $row) {
                $dataPoints[] = [
                  "label" => $row['label'],
                  "y" => (float)$row['y']
                ];
              }
              ?>
              <script>
              window.addEventListener('DOMContentLoaded', function() {
                var chart = new CanvasJS.Chart("salesChartContainer", {
                  animationEnabled: true,
                  theme: "light2",
                  title:{
                    text: "Sales (Every Month)"
                  },
                  axisX:{
                    valueFormatString: "MMM YYYY"
                  },
                  axisY:{
                    title: "Sales (₱)",
                    includeZero: true
                  },
                  data: [{        
                    type: "line",
                    markerSize: 8,
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                  }]
                });
                chart.render();
              });
              </script>
          </div>
        </div>
        <!-- <div class="row g-4 mb-4">
          <div class="col-md-4">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="card-title">Total Products</h6>
                <p class="fs-2 fw-bold mb-0">
                  
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="card-title">Low Stock</h6>
                <p class="fs-2 fw-bold mb-0">
                    <?php
                  $product = new Product($db->connect());
                  echo $product->getLowStockCount(); ?>
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="card-title">Total Sales</h6>
                <p class="fs-2 fw-bold mb-0">
                  
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="card-title">Customers</h6>
                <p class="fs-2 fw-bold mb-0">
                  
                </p>
              </div>
            </div>
          </div>
        </div> -->
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