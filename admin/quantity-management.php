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
        <div class="row gy-3 mb-6 justify-content-between">
          <div class="col-md-9 col-auto">
            <h2 class="mb-2 text-body-emphasis">Stock Management</h2>
            <p class="text-body-tertiary fw-semibold">
              Stock Management involves overseeing all activities and tasks needed to maintain a desired level of inventory. This includes determining stock policies, creating and implementing stock planning and assurance, and stock control and improvement.
            </p>
          </div>
        </div>
        <?php
                      if (isset($_GET['success'])) {
                        $success = htmlspecialchars($_GET['success']);
                        echo '<div class="alert alert-success text-center" role="alert">' . $success . '</div>';
                      }
                      ?>
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="../include/product_transaction.php" enctype="multipart/form-data" method="POST">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="productModalLabel">Create Stock</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <input type="hidden" name="voucher" value="PD">
                                                <label for="category" class="form-label">Product</label>
                                                <select name="product_id" id="" class="form-select" required>
                                                    <option value="" disabled selected>Select Product</option>
                                                    <?php
                                                    include('../Classes/Product.php');

                                                    $product = new Product($db->connect());
                                                    $categories = $product->getAllProducts();
                                                    foreach ($categories as $category) {
                                                        echo '<option value="' . $category['id'] . '">' . htmlspecialchars($category['product_name']) . '</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="supplier" class="form-label">Supplier</label>
                                                <select name="supplier_id" id="" class="form-select" required>
                                                    <option value="" disabled selected>Select Supplier</option>
                                                    <?php
                                                    include('../Classes/Supplier.php');

                                                    $db = new DB();
                                                    $supplier = new Supplier($db->connect());
                                                    $suppliers = $supplier->getAllSuppliers();
                                                    foreach ($suppliers as $supplier) {
                                                        echo '<option value="' . $supplier['id'] . '">' . htmlspecialchars($supplier['supplier_name']) . '</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="quantity" class="form-label">Quantity</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Date</label>
                                                <input type="date" name="date" class="form-control" id="date" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
         <div class="p-4 code-to-copy">
                      <div id="tableExample3" data-list='{"valueNames":["id","category_name","product_name", "quantity", "price"],"page":10,"pagination":true}'>
                        <!-- Add Category Button, Modal Trigger, and Search Box in the Same Row -->
                        <div class="row mb-3 align-items-center">
                            <div class="col d-flex justify-content-between align-items-center">
                                <div>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addProductModal">
                                        <i class="uil uil-plus"></i> Add Stock
                                    </button>
                                </div>
                                <div>
                                    <div class="search-box">
                                        <form class="position-relative">
                                            <input class="form-control search-input search form-control-sm" type="search" placeholder="Search" aria-label="Search" />
                                            <span class="fas fa-search search-box-icon"></span>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                          <table class="table table-striped table-sm fs-9 mb-0">    
                            <thead>
                              <tr>
                                <th class="sort border-top border-translucent ps-3" data-sort="id">ID</th>
                                <th class="sort border-top" data-sort="category_name">Category</th>
                                <th class="sort border-top" data-sort="product_name">Product</th>
                                <th class="sort border-top" data-sort="quantity">Quantity</th>
                                <th class="sort border-top" data-sort="date">Date</th>
                                <th class="sort border-top" data-sort="price">Price</th>
                                <th class="sort text-end align-middle pe-0 border-top" scope="col"></th>
                              </tr>
                            </thead>
                            <tbody class="list">
                                <?php 
                                include('../Classes/ProductTransaction.php');
                                $db = new DB();
                                $product_transaction = new ProductTransaction($db->connect());
                                $transactions = $product_transaction->getPDTransactions();
                                foreach ($transactions as $transaction) { ?>
                              <tr>
                                <td class="align-middle ps-3 id"><?php echo $transaction['id']; ?></td>
                                <td class="align-middle category_name"><?php echo $transaction['category_name']; ?></td>
                                <td class="align-middle product_name"><?php echo $transaction['product_name']; ?></td>
                                <td class="align-middle quantity"><?php echo $transaction['quantity_in']; ?></td>
                                <td class="align-middle date"><?php echo $transaction['date']; ?></td>
                                <td class="align-middle price"><?php echo number_format($transaction['price'], 2); ?></td>
                              </tr>
                            <?php } ?>
                            </tbody>
                          </table>
                        </div>
                        <div class="d-flex justify-content-between mt-3"><span class="d-none d-sm-inline-block" data-list-info="data-list-info"></span>
                          <div class="d-flex">
                            <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                            <ul class="mb-0 pagination"></ul>
                            <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
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