<x-app-layout>
  
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"  
  integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="  
  crossorigin=""/>  
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"  
  integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="  
  crossorigin=""></script>  
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />  
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>  

      <x-slot name="header">
          <div class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    
                    @if (auth()->user()->user_type === 'tenant')
                    <h1 class="m-0 text-dark">Tenant Dashboard</h1>
                    @elseif (auth()->user()->user_type === 'rental_owner')
                    <h1 class="m-0 text-dark">Rental_Owner Dashboard</h1>
                    @endif

                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                      <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
      </x-slot>

      <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            @if (auth()->user()->user_type === 'tenant')
                        <div class="col-lg-6 col-12">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                    @php
                    $payments = \App\Models\Payment::whereIn('status', ['underpaid', 'paid'])
                        ->where('user_id', auth()->id()) // Filter payments by the authenticated user
                        ->get()
                        ->groupBy(function($date) {
                            return \Carbon\Carbon::parse($date->created_at)->format('F'); // Grouping by month name
                        });
                    @endphp
                  <h3>Php {{ number_format($payments->isNotEmpty() ? $payments->first()->sum('total') : 0, 2) }}<sup style="font-size: 20px"></sup></h3>
                  <p>Payment History</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer" id="more-btn">More info <i class="fas fa-arrow-circle-right"></i></a>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        // Show Payment History Modal
                        document.getElementById('more-btn').addEventListener('click', function (e) {
                            e.preventDefault();
                
                            // Fetch payments from the server
                            @php
                            $payments = \App\Models\Payment::where('user_id', auth()->id())->get();
                            $totalPayments = count($payments);
                            $paymentsPerPage = 5;
                            $totalPages = ceil($totalPayments / $paymentsPerPage);
                            @endphp
                
                            // Initialize pagination variables
                            let currentPage = 1;
                
                            // Function to get CSS class for status
                            function getStatusClass(status) {
                                switch (status) {
                                    case 'pending':
                                        return 'bg-red'; // Red for pending
                                    case 'underpaid':
                                        return 'bg-yellow'; // Yellow for underpaid
                                    case 'paid':
                                        return 'bg-green'; // Green for paid
                                    default:
                                        return ''; // No class if status is unknown
                                }
                            }
                
                            // Function to render the payment history table
                            function renderPayments(page) {
                                const start = (page - 1) * {{ $paymentsPerPage }};
                                const end = start + {{ $paymentsPerPage }};
                                
                                // Update the payments array with a new slice for the current page
                                const paymentsData = @json($payments); // Get payments data in JSON format
                                const paginatedPayments = paymentsData.slice(start, end);
                
                                // Generate table rows
                                let rows = '';
                                paginatedPayments.forEach(payment => {
                                    const statusClass = getStatusClass(payment.status); // Get class for the status
                                    rows += `
                                        <tr>
                                            <td>${payment.name}</td>
                                            <td>${payment.total}</td>
                                            <td>${new Date(payment.created_at).toLocaleString('en-PH', { timeZone: 'Asia/Manila' })}</td>
                                        </tr>
                                    `;
                                });
                
                                // Update the table body
                                document.getElementById('paymentTableBody').innerHTML = rows;
                
                                // Update the pagination buttons visibility
                                document.getElementById('prevBtn').style.display = page === 1 ? 'none' : 'inline-block';
                                document.getElementById('nextBtn').style.display = page === {{ $totalPages }} ? 'none' : 'inline-block';
                            }
                
                            // Show the payment history in a SweetAlert modal
                            Swal.fire({
                                title: 'Payment History',
                                html: `
                                    <div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Billing Amount</th>
                                                    <th>Your Payment/Arrived</th>
                                                </tr>
                                            </thead>
                                            <tbody id="paymentTableBody"> 
                                                <!-- Rows will be inserted here -->
                                            </tbody>
                                        </table>
                                        <div class="pagination">
                                            <button id="prevBtn" style="display: none;">Previous</button>
                                            <button id="nextBtn">Next</button>
                                        </div>
                                    </div>
                                `,
                                showCloseButton: true,
                                showConfirmButton: false,
                                width: '30%', // Adjust the width of the modal
                                customClass: {
                                    popup: 'payment-history-popup' // Optional: Custom class for styling
                                }
                            }).then(() => {
                                // Cleanup after modal is closed
                            });
                
                            // Render the initial set of payments
                            renderPayments(currentPage);
                
                            // Handle Next and Previous button clicks
                            document.getElementById('prevBtn').addEventListener('click', function () {
                                if (currentPage > 1) {
                                    currentPage--;
                                    renderPayments(currentPage);
                                }
                            });
                
                            document.getElementById('nextBtn').addEventListener('click', function () {
                                if (currentPage < {{ $totalPages }}) {
                                    currentPage++;
                                    renderPayments(currentPage);
                                }
                            });
                        });
                    });
                </script>
              </div>
            </div>
            @elseif (auth()->user()->user_type === 'rental_owner')
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>{{$bookings->count()}}</h3>
    
                    <p>Number of Tenants</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="#" class="small-box-footer tenant-info" id="info-link">
                      More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
              </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{$bookings->count()}}<sup style="font-size: 20px"></sup></h3>
                    <p>Number of Rooms</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="#" class="small-box-footer room-info" id="info-link">
                      More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{$bookings->count()}}</h3>
    
                    <p>Number of Beds</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="#" class="small-box-footer bed-info" id="info-link">
                      More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <!-- ./col -->
            </div>
            
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            @php
            // Extract tenant profiles (including address), rooms, and beds
            $tenantProfiles = $tenantprofiles->pluck('name', 'address')->toArray(); // Pluck both name and address
            $rooms = $rooms->pluck('selected.room_no')->toArray();
            $beds = $beds->pluck('selectbed.bed_no')->toArray();
        @endphp
        
        <script>
          document.addEventListener('DOMContentLoaded', function () {
              // Collect tenant profiles from the PHP variable and create table rows
              const tenantProfiles = @json($tenantProfiles); // Convert PHP array to JavaScript array
              const profilesPerPage = 5; // Number of profiles to display per page
              let currentProfilePage = 0; // Current page index
      
              function renderTenantProfiles() {
                  const start = currentProfilePage * profilesPerPage;
                  const end = start + profilesPerPage;
                  const tenantRows = Object.entries(tenantProfiles)
                      .filter(([name, address]) => name && address)  // Filter out null or empty values
                      .slice(start, end) // Slice to get current page data
                      .map(([name, address]) => `<tr>
                        <td style="border: 1px solid #ddd; padding: 8px;">${address}</td>
                          <td style="border: 1px solid #ddd; padding: 8px;">${name}</td>
                      </tr>`)
                      .join('');
      
                  const totalPages = Math.ceil(Object.entries(tenantProfiles).length / profilesPerPage);
      
                  const paginationHTML = `
                      <div style="text-align: center; margin: 10px;">
                          <button id="prevProfile" ${currentProfilePage === 0 ? 'disabled' : ''}>Previous</button>
                          <span> Page ${currentProfilePage + 1} of ${totalPages} </span>
                          <button id="nextProfile" ${currentProfilePage === totalPages - 1 ? 'disabled' : ''}>Next</button>
                      </div>
                  `;
      
                  // Create a table structure with the collected tenant profiles
                  const tenantTableHTML = `
                      <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
                          <thead>
                              <tr>
                                  <th style="border: 1px solid #ddd; padding: 8px;">Tenant Profiles Fname</th>
                                  <th style="border: 1px solid #ddd; padding: 8px;">Address</th>
                              </tr>
                          </thead>
                          <tbody>
                              ${tenantRows || '<tr><td colspan="2" style="border: 1px solid #ddd; padding: 8px;">No tenant profiles yet.</td></tr>'}
                          </tbody>
                      </table>
                      ${paginationHTML}
                  `;
      
                  // Show the table using SweetAlert2
                  Swal.fire({
                      html: tenantTableHTML,
                      icon: 'info',
                      confirmButtonText: 'OK'
                  });
      
                  // Add event listeners for pagination buttons
                  document.getElementById('prevProfile').onclick = function () {
                      if (currentProfilePage > 0) {
                          currentProfilePage--;
                          renderTenantProfiles();
                      }
                  };
                  document.getElementById('nextProfile').onclick = function () {
                      if (currentProfilePage < totalPages - 1) {
                          currentProfilePage++;
                          renderTenantProfiles();
                      }
                  };
              }
      
              // Add click event listener to each tenant-info link
              document.querySelectorAll('.tenant-info').forEach(link => {
                  link.addEventListener('click', function (event) {
                      event.preventDefault(); // Prevent the default link behavior
                      renderTenantProfiles();
                  });
              });
      
              // Collect room numbers from the PHP variable and create table rows
              const rooms = @json($rooms); // Convert PHP array to JavaScript array
              const roomsPerPage = 5; // Number of rooms to display per page
              let currentRoomPage = 0; // Current page index
      
              function renderRooms() {
                  const start = currentRoomPage * roomsPerPage;
                  const end = start + roomsPerPage;
                  const roomRows = rooms
                      .filter(room => room)  // Filter out null or empty values
                      .slice(start, end) // Slice to get current page data
                      .map(room => `<tr><td style="border: 1px solid #ddd; padding: 8px;">${room}</td></tr>`)
                      .join('');
      
                  const totalPages = Math.ceil(rooms.length / roomsPerPage);
      
                  const paginationHTML = `
                      <div style="text-align: center; margin: 10px;">
                          <button id="prevRoom" ${currentRoomPage === 0 ? 'disabled' : ''}>Previous</button>
                          <span> Page ${currentRoomPage + 1} of ${totalPages} </span>
                          <button id="nextRoom" ${currentRoomPage === totalPages - 1 ? 'disabled' : ''}>Next</button>
                      </div>
                  `;
      
                  // Create a table structure with the collected room numbers
                  const roomTableHTML = `
                      <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
                          <thead>
                              <tr>
                                  <th style="border: 1px solid #ddd; padding: 8px;">Room Number Selected</th>
                              </tr>
                          </thead>
                          <tbody>
                              ${roomRows || '<tr><td style="border: 1px solid #ddd; padding: 8px;">No room selected yet.</td></tr>'}
                          </tbody>
                      </table>
                      ${paginationHTML}
                  `;
      
                  // Show the table using SweetAlert2
                  Swal.fire({
                      html: roomTableHTML,
                      icon: 'info',
                      confirmButtonText: 'OK'
                  });
      
                  // Add event listeners for pagination buttons
                  document.getElementById('prevRoom').onclick = function () {
                      if (currentRoomPage > 0) {
                          currentRoomPage--;
                          renderRooms();
                      }
                  };
                  document.getElementById('nextRoom').onclick = function () {
                      if (currentRoomPage < totalPages - 1) {
                          currentRoomPage++;
                          renderRooms();
                      }
                  };
              }
      
              // Add click event listener to each room-info link
              document.querySelectorAll('.room-info').forEach(link => {
                  link.addEventListener('click', function (event) {
                      event.preventDefault(); // Prevent the default link behavior
                      renderRooms();
                  });
              });
      
              // Collect bed numbers from the PHP variable and create table rows
              const beds = @json($beds); // Convert PHP array to JavaScript array
              const bedsPerPage = 5; // Number of beds to display per page
              let currentBedPage = 0; // Current page index
      
              function renderBeds() {
                  const start = currentBedPage * bedsPerPage;
                  const end = start + bedsPerPage;
                  const bedRows = beds
                      .filter(bed => bed)  // Filter out null or empty values
                      .slice(start, end) // Slice to get current page data
                      .map(bed => `<tr><td style="border: 1px solid #ddd; padding: 8px;">${bed}</td></tr>`)
                      .join('');
      
                  const totalPages = Math.ceil(beds.length / bedsPerPage);
      
                  const paginationHTML = `
                      <div style="text-align: center; margin: 10px;">
                          <button id="prevBed" ${currentBedPage === 0 ? 'disabled' : ''}>Previous</button>
                          <span> Page ${currentBedPage + 1} of ${totalPages} </span>
                          <button id="nextBed" ${currentBedPage === totalPages - 1 ? 'disabled' : ''}>Next</button>
                      </div>
                  `;
      
                  // Create a table structure with the collected bed numbers
                  const bedTableHTML = `
                      <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
                          <thead>
                              <tr>
                                  <th style="border: 1px solid #ddd; padding: 8px;">Bed Number Selected</th>
                              </tr>
                          </thead>
                          <tbody>
                              ${bedRows || '<tr><td style="border: 1px solid #ddd; padding: 8px;">No beds selected yet.</td></tr>'}
                          </tbody>
                      </table>
                      ${paginationHTML}
                  `;
      
                  // Show the table using SweetAlert2
                  Swal.fire({
                      html: bedTableHTML,
                      icon: 'info',
                      confirmButtonText: 'OK'
                  });
      
                  // Add event listeners for pagination buttons
                  document.getElementById('prevBed').onclick = function () {
                      if (currentBedPage > 0) {
                          currentBedPage--;
                          renderBeds();
                      }
                  };
                  document.getElementById('nextBed').onclick = function () {
                      if (currentBedPage < totalPages - 1) {
                          currentBedPage++;
                          renderBeds();
                      }
                  };
              }
      
              // Add click event listener to each bed-info link
              document.querySelectorAll('.bed-info').forEach(link => {
                  link.addEventListener('click', function (event) {
                      event.preventDefault(); // Prevent the default link behavior
                      renderBeds();
                  });
              });
          });
      </script>
          <h1 style="text-align: center">Search here the location of the tenant... <i class="fas fa-info-circle" id="infoButton"></i></h1>
          <script>
            document.getElementById('infoButton').addEventListener('click', function() {
    Swal.fire({
        title: 'More Info',
        text: 'Please click the number of the tenant to copy the address and paste it in the search to locate on the map. if the location not found please click the homies messenger to contact the tenant. ',
        icon: 'info',
        confirmButtonText: 'Ok'  // Only the Ok button is displayed
    });
});
        </script>
           @include('page.map')

           @endif
              <!-- ./col -->
          </div>
        </div><!-- /.container-fluid -->
        
  </x-app-layout>
  
