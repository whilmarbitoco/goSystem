<x-app-layout>
   <x-slot name="header">
       <div class="content-header">
           <div class="container-fluid">
               <div class="row mb-2">
                   <div class="col-sm-6">
                       <h1 class="m-0 text-dark"><span class="fa fa-user"></span>Rental Pendng</h1>
                   </div>
                   <div class="col-sm-6">
                       <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="#">Home</a></li>
                           <li class="breadcrumb-item active">Rental Account</li>
                       </ol>
                   </div>
               </div>
           </div>
   </x-slot>

   <div class="container-fluid">
       <div class="card card-info elevation-2">
           <br>
           <div class="col-md-12 table-responsive">
               @php
               $bookings = \App\Models\Booking::all(); 
                @endphp

<table id="example1" class="table table-bordered table-hover" style="width: 100%; text-align: center;">
    <thead class="btn-cancel">
        <tr>
            <th>Rental  Name</th>
            <th>Rental Email</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($bookings as $key => $booking)

               @if (!empty($booking->name) && 
                 isset($bookings[$key]) && !empty($bookings[$key]->selectbed->bed_no) && 
                 isset($bookings[$key]) && !empty($bookings[$key]->selected->room_no) && 
                 !empty($bookings[$key]->check_in) && 
                 !empty($bookings[$key]->check_out))
                <tr>
                    <td>{{ $booking->name }}</td>
                    <td>{{ $bookings[$key]->selectbed->bed_no }}</td>
                    <td>{{ $bookings[$key]->selected->room_no }}</td>
                    <td>{{ $bookings[$key]->check_out }}</td>
                    <td>{{ $bookings[$key]->check_in }}</td>
