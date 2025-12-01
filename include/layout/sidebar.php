<nav class="navbar navbar-vertical navbar-expand-lg">
        <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
          <!-- scrollbar removed-->
          <div class="navbar-vertical-content">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
              <li class="nav-item">
                <div class="nav-item-wrapper"><a class="nav-link label-1" href="dashboard.php" role="button" data-bs-toggle="" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span data-feather="home"></span></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Dashboard</span></span>
                    </div>
                  </a>
                </div>
                <!-- parent pages-->
                <div class="nav-item-wrapper">
                  <a class="nav-link dropdown-indicator label-1" href="#nv-home" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-home">
                    <div class="d-flex align-items-center">
                      <div class="dropdown-indicator-icon-wrapper"><span class="fas fa-caret-right dropdown-indicator-icon"></span></div><span class="nav-link-icon"><span data-feather="pie-chart"></span></span><span class="nav-link-text">Management</span>
                    </div>
                  </a>
                  <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent show" data-bs-parent="#navbarVerticalCollapse" id="nv-home">
                      <li class="collapsed-nav-item-title d-none">Home
                      </li>
                      <li class="nav-item"><a class="nav-link" href="category.php">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Category</span>
                          </div>
                        </a>
                        <!-- more inner pages-->
                      </li>
                      <li class="nav-item"><a class="nav-link" href="product.php">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Products</span>
                          </div>
                        </a>
                        <!-- more inner pages-->
                      </li>
                      <li class="nav-item"><a class="nav-link" href="customer.php">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Customer</span>
                          </div>
                        </a>
                        <!-- more inner pages-->
                      </li>
                      <li class="nav-item"><a class="nav-link" href="supplier.php">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Supplier</span>
                          </div>
                        </a>
                        <!-- more inner pages-->
                      </li>
                      <?php if ($_SESSION['role'] == 1): ?>
                      <li class="nav-item"><a class="nav-link" href="users.php">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Users</span>
                          </div>
                        </a>
                        <!-- more inner pages-->
                      </li>
                      <?php endif; ?>
                    </ul>
                  </div>
                </div>
                <div class="nav-item-wrapper">
                  <a class="nav-link dropdown-indicator label-1" href="#nv-Transaction" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-home">
                    <div class="d-flex align-items-center">
                      <div class="dropdown-indicator-icon-wrapper"><span class="fas fa-caret-right dropdown-indicator-icon"></span></div><span class="nav-link-icon"><span data-feather="package"></span></span><span class="nav-link-text">Transaction</span>
                    </div>
                  </a>
                  <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent show" data-bs-parent="#navbarVerticalCollapse" id="nv-Transaction">
                      <li class="collapsed-nav-item-title d-none">Transaction
                      </li>
                      <li class="nav-item"><a class="nav-link" href="quantity-management.php">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Stock Management</span>
                          </div>
                        </a>
                        <!-- more inner pages-->
                      </li>
                      <li class="nav-item"><a class="nav-link" href="buyproducts.php">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Buy Products</span>
                          </div>
                        </a>
                        <!-- more inner pages-->
                      </li>
                       <li class="nav-item"><a class="nav-link" href="loan-payments.php">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Loan Payments</span>
                          </div>
                        </a>
                      </li>
                       <li class="nav-item"><a class="nav-link" href="orders.php">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Orders</span>
                          </div>
                        </a>
                        <!-- more inner pages-->
                      </li>
                    </ul>
                  </div>
                </div>
                <?php if ($_SESSION['role'] == 1): ?>
                <div class="nav-item-wrapper">
                  <a class="nav-link dropdown-indicator label-1" href="#nv-Reports" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-home">
                    <div class="d-flex align-items-center">
                      <div class="dropdown-indicator-icon-wrapper"><span class="fas fa-caret-right dropdown-indicator-icon"></span></div><span class="nav-link-icon"><span data-feather="file"></span></span><span class="nav-link-text">Reports</span>
                    </div>
                  </a>
                  <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent show" data-bs-parent="#navbarVerticalCollapse" id="nv-Reports">
                      <li class="collapsed-nav-item-title d-none">Reports
                      </li>
                      <li class="nav-item"><a class="nav-link" href="inventory-reports.php">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Inventory Reports</span>
                          </div>
                        </a>
                        <!-- more inner pages-->
                      </li>
                      <li class="nav-item"><a class="nav-link" href="sales-report.php">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Sales Report</span>
                          </div>
                        </a>
                        <!-- more inner pages-->
                      </li>
                      <li class="nav-item"><a class="nav-link" href="re-order-point-report.php">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Re Order Point Report</span>
                          </div>
                        </a>
                        <!-- more inner pages-->
                      </li>
                      <li class="nav-item"><a class="nav-link" href="loan-reports.php">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Loan Reports</span>
                          </div>
                        </a>
                        <!-- more inner pages-->
                      </li>
                    </ul>
                  </div>
                </div>
                <?php endif; ?>
              </li>
            </ul>
          </div>
        </div>
        <div class="navbar-vertical-footer">
          <button class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center"><span class="uil uil-left-arrow-to-left fs-8"></span><span class="uil uil-arrow-from-right fs-8"></span><span class="navbar-vertical-footer-text ms-2">Collapsed View</span></button>
        </div>
      </nav>