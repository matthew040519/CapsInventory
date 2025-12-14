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
              <h2 class="mb-0">Projects</h2>
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

include('../Classes/Projects.php');
                $projects = new Projects($db->connect());
                
              ?>
              <?php
                      if (isset($_GET['success'])) {
                        $success = htmlspecialchars($_GET['success']);
                        echo '<div class="alert alert-success text-center" role="alert">' . $success . '</div>';
                      }
                      else if (isset($_GET['error'])) {
                        $error = htmlspecialchars($_GET['error']);
                        echo '<div class="alert alert-danger text-center" role="alert">' . $error . '</div>';
                      }
                      ?>
              
          <div id="orderTable" data-list='{"valueNames":["id","order","total","customer","payment_status","fulfilment_status","delivery_type","date"],"page":10,"pagination":true}'>
            <div class="mb-4">
              <div class="row g-3 justify-content-between align-items-center">
                <div class="col-auto">
                </div>
                <div class="col-auto">
                  <div class="search-box">
                    <form class="position-relative">
                      <input class="form-control search-input search" type="search" placeholder="Search projects" aria-label="Search" />
                      <span class="fas fa-search search-box-icon"></span>
                    </form>
                  </div>
                </div>
              </div>

            

              <!-- Loan Payment Modal -->
            <!-- Add Project Button -->
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                <i class="uil uil-plus"></i> Add Project
            </button>

            <!-- Add Project Modal -->
            <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="add_project.php" method="post" enctype="multipart/form-data" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProjectModalLabel">Add New Project</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="project_name" class="form-label">Project Name</label>
                                <input type="text" class="form-control" id="project_name" name="project_name" required>
                            </div>
                           
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer</label>
                                <select class="form-select" id="customer_id" name="customer_id" required>
                                    <option value="" disabled selected>Select Customer</option>
                                                    <?php
                                                    require_once '../Classes/Customer.php';
                                                    $customer = new Customer($db->connect());
                                                    $customers = $customer->getAllCustomers();
                                                    foreach ($customers as $customer) {
                                                        echo '<option value="' . $customer['id'] . '">' . htmlspecialchars($customer['fullname']) . '</option>';
                                                    }
                                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="project_cost" class="form-label">Approved Project Cost</label>
                                <input type="number" step="0.01" class="form-control" id="project_cost" name="project_cost" required>
                            </div>
                            <div class="mb-3">
                                <label for="downpayment" class="form-label">Downpayment</label>
                                <input type="number" step="0.01" class="form-control" id="downpayment" name="downpayment" required>
                            </div>
                            <div class="mb-3">
                                <label for="project_file" class="form-label">Project File</label>
                                <input type="file" class="form-control" id="project_file" name="project_file">
                            </div>
                            <div class="mb-3">
                                <label for="tdate" class="form-label">Date</label>
                                <input type="date" class="form-control" id="tdate" name="tdate" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="0">Pending</option>
                                    <option value="1">Ongoing</option>
                                    <option value="2">Completed</option>
                                    <option value="3">Rejected</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="project_description" class="form-label">Project Description</label>
                                <textarea class="form-control" id="project_description" name="project_description" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Project</button>
                        </div>
                    </form>
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
                      <th class="sort align-middle" scope="col" data-sort="id"></th>
                      <th class="sort align-middle" scope="col" data-sort="customer">Project File</th>
                      <th class="sort align-middle ps-8" scope="col" data-sort="customer">Project Name</th>
                      <th class="sort align-middle pe-0" scope="col" data-sort="date">Customer</th>
                      <th class="sort align-middle pe-0" scope="col" data-sort="amount">Project Cost</th>
                      <th class="sort align-middle pe-0" scope="col" data-sort="amount">Project Downpayment</th>
                      <th class="sort align-middle" scope="col" data-sort="date">Date</th>
                      <th class="sort align-middle" scope="col" data-sort="date">Status</th>
                      <th class="sort align-middle">Action</th>
                    </tr>
                  </thead>
                  <tbody class="list" id="order-table-body">
                    <?php 
                    // Include database and object files 
                        // include('../Classes/Loan.php');
                        $allprojects = $projects->getAllProjects();
                    foreach ($allprojects as $project) {
                    ?>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="date align-middle white-space-nowrap text-body-tertiary"><?php echo $project['project_id']; ?></td>
                        <td class="date align-middle white-space-nowrap text-body-tertiary"><a href="../uploads/projects/<?php echo $project['project_file']; ?>" target="_blank"><?php echo $project['project_file']; ?></a></td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <!-- <div class="avatar avatar-m">
                            <img class="rounded-circle" src="../../../assets/img/team/32.webp" alt="" />
                          </div> -->
                          <h6 class="mb-0 text-body"><?php echo $project['project_name']; ?></h6>
                        </a></td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary"><?php echo $project['fullname']; ?></td>
                      <td class="amount align-middle white-space-nowrap text-body-tertiary"><?php echo number_format($project['project_cost'], 2); ?></td>
                      <td class="amount align-middle white-space-nowrap text-body-tertiary"><?php echo number_format($project['project_downpayment'], 2); ?></td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary"><?php echo $project['tdate']; ?></td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary">
                      <?php
                    // Add a badge for status
                    $statusClass = '';
                    switch ($project['status']) {
                        case 0:
                            $statusClass = 'bg-warning text-dark'; // Pending
                            break;
                        case 1:
                            $statusClass = 'bg-info text-white'; // Ongoing
                            break;
                        case 2:
                            $statusClass = 'bg-success text-white'; // Completed
                            break;
                        case 3:
                            $statusClass = 'bg-danger text-white'; // Rejected
                            break;
                        default:
                            $statusClass = 'bg-secondary text-white';
                    }
                    ?>  
                      <span class="badge <?php echo $statusClass; ?>">
                        <?php echo $project['status_text']; ?>
                    </span></td>
                    <td class="align-middle white-space-nowrap text-body-tertiary">
                        <!-- Edit Button -->
                        <!-- Edit Button triggers modal -->
                        <button type="button" class="btn btn-sm btn-warning me-1" title="Edit" data-bs-toggle="modal" data-bs-target="#editProjectModal_<?php echo $project['project_id']; ?>">
                            <i class="uil uil-edit"></i>
                        </button>

                        <!-- Edit Project Modal -->
                        <div class="modal fade" id="editProjectModal_<?php echo $project['project_id']; ?>" tabindex="-1" aria-labelledby="editProjectModalLabel_<?php echo $project['project_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="edit_project.php" method="post" enctype="multipart/form-data" class="modal-content">
                                    <input type="text" name="id" value="<?php echo $project['project_id']; ?>">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProjectModalLabel_<?php echo $project['project_id']; ?>">Edit Project</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="project_id" value="<?php echo $project['project_id']; ?>">
                                        <div class="mb-3">
                                            <label for="project_name_<?php echo $project['project_id']; ?>" class="form-label">Project Name</label>
                                            <input type="text" class="form-control" id="project_name_<?php echo $project['project_id']; ?>" name="project_name" value="<?php echo htmlspecialchars($project['project_name']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="customer_id_<?php echo $project['project_id']; ?>" class="form-label">Customer</label>
                                            <select class="form-select" id="customer_id_<?php echo $project['project_id']; ?>" name="customer_id" required>
                                                <option value="" disabled>Select Customer</option>
                                                <?php
                                                require_once '../Classes/Customer.php';
                                                $customerObj = new Customer($db->connect());
                                                $customers = $customerObj->getAllCustomers();
                                                foreach ($customers as $cust) {
                                                    $selected = ($cust['id'] == $project['customer_id']) ? 'selected' : '';
                                                    echo '<option value="' . $cust['id'] . '" ' . $selected . '>' . htmlspecialchars($cust['fullname']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="project_cost_<?php echo $project['id']; ?>" class="form-label">Approved Project Cost</label>
                                            <input type="number" step="0.01" class="form-control" id="project_cost_<?php echo $project['id']; ?>" name="project_cost" value="<?php echo htmlspecialchars($project['project_cost']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="downpayment_<?php echo $project['id']; ?>" class="form-label">Downpayment</label>
                                            <input type="number" step="0.01" class="form-control" id="downpayment_<?php echo $project['id']; ?>" name="downpayment" value="<?php echo htmlspecialchars($project['project_downpayment']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="project_file_<?php echo $project['project_id']; ?>" class="form-label">Project File</label>
                                            <input type="file" class="form-control" id="project_file_<?php echo $project['project_id']; ?>" name="project_file">
                                            <?php if (!empty($project['project_file'])): ?>
                                                <small>Current: <a href="../uploads/projects/<?php echo $project['project_file']; ?>" target="_blank"><?php echo htmlspecialchars($project['project_file']); ?></a></small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tdate_<?php echo $project['project_id']; ?>" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="tdate_<?php echo $project['project_id']; ?>" name="tdate" value="<?php echo htmlspecialchars($project['tdate']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status_<?php echo $project['project_id']; ?>" class="form-label">Status</label>
                                            <select class="form-select" id="status_<?php echo $project['project_id']; ?>" name="status" required>
                                                <option value="0" <?php if ($project['status'] == 0) echo 'selected'; ?>>Pending</option>
                                                <option value="1" <?php if ($project['status'] == 1) echo 'selected'; ?>>Ongoing</option>
                                                <option value="2" <?php if ($project['status'] == 2) echo 'selected'; ?>>Completed</option>
                                                <option value="3" <?php if ($project['status'] == 3) echo 'selected'; ?>>Rejected</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="project_description_<?php echo $project['project_id']; ?>" class="form-label">Project Description</label>
                                            <textarea class="form-control" id="project_description_<?php echo $project['project_id']; ?>" name="project_description" rows="3" required><?php echo htmlspecialchars($project['project_description']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Delete Button -->
                        <form action="delete_project.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this project?');">
                            <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="uil uil-trash-alt"></i>
                            </button>
                        </form>
                        <!-- View Details Button -->
                        <button type="button" class="btn btn-sm btn-info" title="View Details" data-bs-toggle="modal" data-bs-target="#viewProjectModal_<?php echo $project['project_id']; ?>">
                            <i class="uil uil-eye"></i>
                        </button>

                        <!-- View Project Modal -->
                        <div class="modal fade" id="viewProjectModal_<?php echo $project['project_id']; ?>" tabindex="-1" aria-labelledby="viewProjectModalLabel_<?php echo $project['project_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewProjectModalLabel_<?php echo $project['project_id']; ?>">Project Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div class="row mb-3">
                                                <div class="col-12 text-center">
                                                    <h4 class="fw-bold mb-2"><?php echo htmlspecialchars($project['project_name']); ?></h4>
                                                    <span class="badge <?php echo $statusClass; ?> mb-2"><?php echo $project['status_text']; ?></span>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12 text-center">
                                                    <?php if (!empty($project['project_file'])): ?>
                                                        <a href="../uploads/projects/<?php echo $project['project_file']; ?>" target="_blank" class="btn btn-outline-primary btn-sm mb-2">
                                                            <i class="uil uil-file"></i> View Project File
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No file uploaded</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <div class="card border-0 shadow-sm mb-2">
                                                        <div class="card-body py-2 px-3">
                                                            <small class="text-body-tertiary">Customer</small>
                                                            <div class="fw-semibold"><?php echo htmlspecialchars($project['fullname']); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="card border-0 shadow-sm mb-2">
                                                        <div class="card-body py-2 px-3">
                                                            <small class="text-body-tertiary">Date</small>
                                                            <div class="fw-semibold"><?php echo htmlspecialchars($project['tdate']); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="card border-0 shadow-sm mb-2">
                                                        <div class="card-body py-2 px-3">
                                                            <small class="text-body-tertiary">Approved Cost</small>
                                                            <div class="fw-semibold">₱ <?php echo number_format($project['project_cost'], 2); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="card border-0 shadow-sm mb-2">
                                                        <div class="card-body py-2 px-3">
                                                            <small class="text-body-tertiary">Downpayment</small>
                                                            <div class="fw-semibold">₱ <?php echo number_format($project['project_downpayment'], 2); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <div class="card border-0 shadow-sm">
                                                        <div class="card-body py-2 px-3">
                                                            <small class="text-body-tertiary">Description</small>
                                                            <div class="fw-normal"><?php echo nl2br(htmlspecialchars($project['project_description'])); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            // Display products for this project
                                            $projectProducts = $projects->getProjectProducts($project['project_id']);
                                            if (!empty($projectProducts)) {
                                                echo '<div class="mt-4">';
                                                echo '<h6 class="fw-bold mb-2">Products</h6>';
                                                echo '<div class="table-responsive">';
                                                echo '<table class="table table-sm table-bordered">';
                                                echo '<thead><tr>
                                                        <th>Name</th>
                                                        <th>Quantity</th>
                                                        <th>Category</th>
                                                        <th>Description</th>
                                                    </tr></thead><tbody>';
                                                foreach ($projectProducts as $prod) {
                                                    echo '<tr>';
                                                    echo '<td>' . htmlspecialchars($prod['product_name']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($prod['quantity_out']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($prod['category_name']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($prod['description']) . '</td>';
                                                    echo '</tr>';
                                                }
                                                echo '</tbody></table></div></div>';
                                            } else {
                                                echo '<div class="mt-4"><span class="text-muted">No products assigned to this project.</span></div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    
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