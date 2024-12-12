<x-app-layout>
    <style>
       .profile-image {
    border-radius: 50%;
    width: 120px;  /* Default size */
    height: 120px; /* Default size */
    object-fit: cover;
    margin-bottom: 20px; /* Space below the image */
    margin-left: auto; /* Centers image horizontally */
    margin-right: auto; /* Centers image horizontally */
    display: block; /* Ensures margin auto works for centering */
}

/* Media Query for Smaller Screens */
@media (max-width: 768px) {
    .profile-image {
        width: 100px; /* Adjust for smaller screens */
        height: 100px; /* Adjust for smaller screens */
    }
}

/* Media Query for Very Small Screens (e.g., phones) */
@media (max-width: 480px) {
    .profile-image {
        width: 80px; /* Further reduce size for very small screens */
        height: 80px; /* Further reduce size for very small screens */
    }
} 
       .card-body {
          text-align: center; /* Center-align all card content */
       }
 
       .card-body h5 {
          font-size: 1.5rem; /* Increased font size */
          margin-bottom: 20px; /* Add space below the name */
       }
 
       .card-body p {
          font-size: 1.2rem; /* Increased font size */
          margin-bottom: 10px; /* Add space between information rows */
          text-align: left; /* Align text to the left */
       }
 
       .container-fluid h1 {
          font-size: 2.5rem; /* Increased header size */
       }
 
       .breadcrumb-item a {
          font-size: 1.2rem; /* Increased breadcrumb size */
       }
 
       .breadcrumb-item.active {
          font-size: 1.2rem; /* Increased breadcrumb size */
       }
 
       .modal-body h3 {
          font-size: 1.8rem; /* Increased modal text size */
       }
 
       .modal-body button {
          font-size: 1.2rem; /* Increased modal button size */
          padding: 10px 20px; /* Increased modal button padding */
       }
    </style>
 <style>
 /* General Styles */
 body {
     font-family: Arial, sans-serif;
     margin: 0;
 }
 
 * {
     box-sizing: border-box;
 }
 
 img {
     vertical-align: middle;
 }
 
 /* Image Container */
 .container {
     position: relative;
     max-width: 100%;
     margin: auto;
 }
 
 /* Slideshow Container */
 .slideshow-container {
     position: relative;
     max-width: 100%;
     margin: auto;
 }
 
 /* Hide the images by default */
 .mySlides {
     display: none;
     position: relative;
 }
 
 /* Slideshow Image */
 .mySlides img {
     width: 100%;
     height: 300px; /* Set a fixed height */
     object-fit: cover; /* Maintain aspect ratio and fill the container */
 }
 
 /* Cursor for clickable elements */
 .cursor {
     cursor: pointer;
 }
 
 /* Next & Previous Buttons */
 .prev,
 .next {
     cursor: pointer;
     position: absolute;
     top:42%;
     width: auto;
     padding: 16px;
     color: white;
     font-weight: bold;
     font-size: 20px;
     border-radius: 0 3px 3px 0;
     user-select: none;
     background-color: rgba(0, 0, 0, 0.5); /* Slightly transparent background */
 }
 
 .next {
     right: 0;
     border-radius: 3px 0 0 3px;
 }
 
 .prev {
     left: 0;
     border-radius: 3px 0 0 3px;
 }
 
 /* On hover, add a black background color with a little bit see-through */
 .prev:hover,
 .next:hover {
     background-color: rgba(0, 0, 0, 0.8);
 }
 
 /* Number Text (1/3 etc) */
 .numbertext {
     color: #f2f2f2;
     font-size: 12px;
     padding: 8px 12px;
     position: absolute;
     top: 0;
 }
 
 /* Container for Image Text */
 .caption-container {
     text-align: center;
     background-color: #222;
     padding: 2px 16px;
     color: white;
 }
 
 /* Row Clearfix */
 .row:after {
     content: "";
     display: table;
     clear: both;
 }
 
 /* Column Layout */
 .column {
     float: left;
     width: 16.66%;
 }
 
 /* Transparency for Thumbnail Images */
 .demo {
     opacity: 0.6;
 }
 
 .active,
 .demo:hover {
     opacity: 1;
 }
 
 /* Responsive Styles */
 @media only screen and (max-width: 768px) {
     .prev, .next {
         font-size: 18px;
         padding: 12px;
     }
 
     .caption-container {
         padding: 2px 10px;
     }
 
     .numbertext {
         font-size: 10px;
     }
 
     .column {
         width: 33.33%; /* Three columns on tablets */
     }
 }
 
 @media only screen and (max-width: 480px) {
     .prev, .next {
         font-size: 16px;
         padding: 10px;
     }
 
     .caption-container {
         padding: 2px 8px;
     }
 
     .numbertext {
         font-size: 8px;
     }
 
     .column {
         width: 50%; /* Two columns on small screens */
     }
 }
    </style>
 <script>
  let slideIndex = 1;
 
 function showSlides(n) {
     let i;
     let slides = document.getElementsByClassName("mySlides");
     let caption = document.getElementById("caption-text");
 
     if (n > slides.length) { slideIndex = 1 }
     if (n < 1) { slideIndex = slides.length }
     for (i = 0; i < slides.length; i++) {
         slides[i].style.display = "none";
     }
     slides[slideIndex - 1].style.display = "block";
     caption.innerText = slides[slideIndex - 1].getAttribute('data-caption');
 }
 
 function plusSlides(n) {
     showSlides(slideIndex += n);
 }
 
 // Initialize slideshow
 document.addEventListener("DOMContentLoaded", function() {
     showSlides(slideIndex);
 });
 </script>
 
    
 <x-slot name="header">
    <div class="content-header">
        <div class="container-fluid">
           <div class="row mb-2">
              <div class="col-sm-6">
               <h1 class="m-0 text-dark"><span class="fa fa-book"></span> Booking Profile</h1>
              </div>
              <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">booking Profile</li>
                 </ol> 
              </div>
           </div>
        </div>
    </x-slot>
 
          <div class="row">
             <div class="col-lg-4">
                                                             
			
                         <div class="container">
                            <div class="row justify-content-center mb-2">
                                          
                                </div>
                            <div class="row justify-content-center">
                                              
                            </div>
                        </div>
                                
                @foreach($bookings as $booking)
                <div class="container" style="margin-top:-15px;">
                    <h3 class="m-0 text-dark">
                        <span class="fa fa-home"></span> Room Picture :
                        <p id="caption-text" style="margin-top: -33px;margin-left:230px;"></p></h3>
                    <div class="card-body" style="margin-top:-30px;" data-id="{{ $booking->selected->id }}">
                        @php
                            $profiles = [
                                ['profile' => 'profile1', 'caption' => 'caption1'],
                                ['profile' => 'profile2', 'caption' => 'caption2'],
                                ['profile' => 'profile3', 'caption' => 'caption3'],
                                ['profile' => 'profile4', 'caption' => 'caption4'],
                                ['profile' => 'profile5', 'caption' => 'caption5'],
                                ['profile' => 'profile6', 'caption' => 'caption6'],
                            ];
                        @endphp
                        <div class="slideshow-container">
                            @foreach ($profiles as $profile)
                                @php
                                    $profilePath = $booking->selected->{$profile['profile']};
                                    $captionText = $booking->selected->{$profile['caption']};
                                    $imagePath = storage_path('app/public/' . $profilePath);
                                    $isImageExists = file_exists($imagePath);
                                @endphp
                                @if ($profilePath)
                                    <div class="mySlides" data-caption="{{ $captionText }}">
                                        <img src="{{ $isImageExists ? asset('storage/' . $profilePath) : asset($profilePath) }}" alt="{{ $captionText }}">
                                    </div>
                                @endif
                            @endforeach
                            <!-- Next/previous controls -->
                            <a class="prev" onclick="plusSlides(-1)">❮</a>
                            <a class="next" onclick="plusSlides(1)">❯</a>
                        </div>
                    </div>
                </div><br>
         
             </div>
 
             <div class="col-lg-8">
                <div class="card mb-4" style="margin-top: -20px;">
                                         <div class="row">
                           </div>
                                                  <div class="row">
                                                    </div>
			
                     
                   </div>
                                
                <div class="row" style="margin-top:-15px;">
                   <div class="col-md-6">
                   <h3 class="m-0 text-dark"><span class="fa fa-home"></span>Room</h3>
                      <div class="card mb-4 mb-md-0" style="margin-top:5px;">
                         <div class="card-body">
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Room No</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $booking->selected->room_no}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Room Description</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $booking->selected->description}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Check In</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $booking->check_in}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Check Out</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $booking->check_out}}</p>
                               </div>
                            </div>
                       </div>
                       
                      </div>
                      
                   </div>
		 <div class="col-md-6">

                  <h3 class="m-0 text-dark"><span class="fa fa-bed"></span> Bed </h3>
                      <div class="card mb-4 mb-md-0" style="margin-top:5px;">
                         <div class="card-body">
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Bed No</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $booking->selectbed->bed_no}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Bed Description</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $booking->selectbed->description}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0"> Bed Status</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">
                                     @if ($booking->selectbed->bed_status == 'occupied')
                                     <span class="badge bg-warning">{{ $booking->selectbed->bed_status }}</span>
                                 @elseif ($booking->selectbed->bed_status == 'available')
                                     <span class="badge bg-success">{{ $booking->selectbed->bed_status }}</span>
                                 @endif
                               </p>
                               </div>
                             </div>
                         </div>
                      </div>
                   </div>
                </div>
                @endforeach
             </div>    
          </div><br>
       </div>

     </x-app-layout>

