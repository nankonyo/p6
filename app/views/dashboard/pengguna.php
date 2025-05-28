      <style>
       @media (max-width: 575.98px) {
            #mainContent {
              margin-top: 8rem;
            }
          }

          @media (min-width: 576px) and (max-width: 767.98px) {
            #mainContent {
              margin-top: 8rem;
            }
          }

          @media (min-width: 768px) and (max-width: 991.98px) {
            #mainContent {
              margin-top: 8rem;
            }
          }

          @media (min-width: 992px) {
            #mainContent {
              margin-top: 5rem;
              max-width:1200px;
            }
          }
      </style>
      <?php component('_components/navSlide-dashboard'); ?>
          
       <div class="d-flex">

        <!-- Sidebar -->
        <?php component('_components/sidebar-dashboard'); ?>    

        <!-- Main Content -->
        <div class="container-fluid" id="mainContent">
          <selection>
            <div class="card bg-body-tertiary p-3 border-primary">
                pengguna
            </div>
          </selection>
        </div>
        
      </div>