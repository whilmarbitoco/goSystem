<x-app-layout>

    <x-slot name="header">
        <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h1 class="m-0 text-dark"><span class="fa fa-chart-bar"></span> Income Reports</h1>
                  </div>
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Reports</li>
                     </ol>
                  </div>
               </div>
    </x-slot>
    <div class="container-fluid">
        <div class="card card-info elevation-2">
           <br>
           <div class="col-md-12 table-responsive">
             <div class="row">
               <div class="col-md-5">
               <div class="form-group">
                 <label>From</label>
                 <input type="month" name="number" class="form-control" placeholder="ex. 6000.00">
               </div></div>
               <div class="col-md-5">
                 <div class="form-group">
                   <label>To</label>
                   <input type="month" name="number" class="form-control" placeholder="ex. 6000.00">
                 </div></div>
                 <div class="col-md-2" style="margin-top: 30px;">
                   <div class="form-group">
                     <button class="btn btn-info">Search</button>
                   </div></div>
                 </div>
              <table id="example1" class="table table-bordered table-hover">
                 <thead class="btn-cancel">
                    <tr>
                       <th>Month</th>
                       <th>Income</th>
                    </tr>
                 </thead>
                 <tbody>
                @php
    // Get all payments with status 'paid' or 'pending' and group by month
    $payments = \App\Models\Payment::whereIn('status', ['paid', 'pending'])->get()
        ->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('F'); // grouping by month name
        });
@endphp

@if($payments->isEmpty())
    <tr>
        <td colspan="2" class="text-center">No data</td>
    </tr>
@elseif ($payments->flatten()->first()->status === 'pending')
    <tr>
        <td colspan="6" class="text-center" style="color: red">Pending</td>
    </tr>
@else
    @foreach ($payments as $month => $monthPayments)
        <tr>
            <td>{{ $month }}</td> <!-- Display the month name -->
            <td>{{ number_format($monthPayments->sum(function($payment) {
                return is_numeric($payment->total) ? (float) $payment->total : 0;
            }), 2) }}
            </td> <!-- Sum amounts and format -->
        </tr>
    @endforeach
    <tr>
        <td><b>Total Income</b></td>
        <td><b>Php {{ number_format($payments->flatten()->sum(function($payment) {
            return is_numeric($payment->total) ? (float) $payment->total : 0;
        }), 2) }}</b></td> <!-- Total income for all months -->
    </tr>
    @endif                
        </tbody>
              </table>
           </div>
        </div>
     </div>
  </section>
</div>
</div>
<div id="delete" class="modal animated rubberBand delete-modal" role="dialog">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
     <div class="modal-body text-center">
        <img src="../assets/img/sent.png" alt="" width="50" height="46">
        <h3>Are you sure want to delete this Operator?</h3>
        <div class="m-t-20">
           <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
           <button type="submit" class="btn btn-danger">Delete</button>
        </div>
     </div>
  </div>
</div>
</div>
    </x-app-layout>
