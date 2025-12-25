<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loan Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- <div class="container mt-4"> -->
        <h1 class="mb-4">Loan Report</h1>
        <!-- Your content goes here -->
        <table class="table table-sm fs-9 mb-0">
                  <thead>
                    <tr>
                      <th class="sort align-middle" scope="col" data-sort="customer">CUSTOMER</th>
                       <th class="sort align-middle" scope="col" data-sort="project">PROJECT</th>
                      <th class="sort align-middle pe-0" scope="col" data-sort="date">DATE</th>
                      <th class="sort align-middle pe-0" scope="col" data-sort="amount">Balance</th>
                    </tr>
                  </thead>
                  <tbody class="list" id="order-table-body">
                    <?php 
                    // Include database and object files  
                    include('../../Classes/Projects.php');
                    include('../../Classes/DB.php');
                    $db = new DB();
                    $projects = new Projects($db->connect());
                    $loanProjects = $projects->getProjectLoanList();
                    foreach ($loanProjects as $loanProject) {
                    ?>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="customer align-middle white-space-nowrap text-body-tertiary"><?php echo $loanProject['fullname']; ?></td>
                         <td class="date align-middle white-space-nowrap text-body-tertiary"><?php echo $loanProject['project_name']; ?></td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary"><?php echo $loanProject['tdate']; ?></td>
                      <td class="amount align-middle white-space-nowrap text-body-tertiary"><?php echo number_format($loanProject['total_balance'], 2); ?></td>
                        
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
    <!-- </div> -->
    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>