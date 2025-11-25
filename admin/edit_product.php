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
            <h2 class="mb-2 text-body-emphasis">Edit Product</h2>
            <p class="text-body-tertiary fw-semibold">
              Use this page to edit product details. Update information such as name, category, price, reorder point, and description to keep your inventory accurate and up to date.
            </p>
          </div>
        </div>
        <?php
                      if (isset($_GET['success'])) {
                        $success = htmlspecialchars($_GET['success']);
                        echo '<div class="alert alert-success text-center" role="alert">' . $success . '</div>';
                      }
                    require_once '../Classes/Product.php';

                    $productObj = new Product($db->connect());

                    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                        echo '<div class="alert alert-danger text-center" role="alert">Invalid product ID.</div>';
                        exit;
                    }

                    $product_id = (int)$_GET['id'];
                    $product = $productObj->getProductById($product_id);

                    if (!$product) {
                        echo '<div class="alert alert-danger text-center" role="alert">Product not found.</div>';
                        exit;
                    }
                      ?>
                      <div class="card">
                            <div class="card-body">
                                <form action="../include/product.php" enctype="multipart/form-data" method="POST">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="product_image" class="form-label">Image</label>
                                                <?php if (!empty($product['image'])): ?>
                                                    <div class="mb-2">
                                                        <img src="../uploads/products/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" style="max-width: 120px; max-height: 120px;">
                                                    </div>
                                                <?php endif; ?>
                                                <input type="file" class="form-control" accept="image/*" id="product_image" name="product_image">
                                                <small class="form-text text-muted">Leave blank to keep current image.</small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="product_name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" name="product_name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="category" class="form-label">Category</label>
                                                <select name="category_id" id="category" class="form-select" required>
                                                    <option value="" disabled>Select Category</option>
                                                    <?php
                                                    include('../Classes/Category.php');
                                                    $categoryObj = new Category($db->connect());
                                                    $categories = $categoryObj->getAllCategories();
                                                    foreach ($categories as $cat) {
                                                        $selected = ($cat['id'] == $product['category_id']) ? 'selected' : '';
                                                        echo '<option value="' . $cat['id'] . '" ' . $selected . '>' . htmlspecialchars($cat['category_name']) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price</label>
                                                <input type="number" class="form-control" value="<?php echo $product['price']; ?>" id="price" name="price" required step="0.01" min="0">
                                            </div>
                                            <div class="mb-3">
                                                <label for="re_order_point" class="form-label">Re Order Point</label>
                                                <input type="number" class="form-control" value="<?php echo $product['reorder_point']; ?>" id="re_order_point" name="re_order_point" required min="0">
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea name="description" class="form-control" id="description" cols="6" rows="6" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="products.php" class="btn btn-secondary">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </form>
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