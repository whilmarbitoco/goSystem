<x-app-layout>
    <x-slot name="header">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"><span class="fa fa-list-alt"></span> Collectibles</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Collectibles</li>
                        </ol>
                    </div>
                </div>
        </x-slot>
        <div class="container-fluid">
            <div class="card card-info elevation-2">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                         @php
                         $payments = \App\Models\Payment::all();
                         @endphp
                            <thead>
                                <tr>
                                    <th>Tenant Name</th>
                                    <th>Room No.</th>
                                    <th>Bed No.</th>
				    <th>Total Payment</th>
	                        </tr>
                            </thead>
                            <tbody>
                             <tbody>
                                 @if ($payments->isEmpty())
                                 <tr>
                                     <td colspan="6" class="text-center">No data</td>
                                 </tr>
                                @elseif ($payments->first()->status === 'pending') {{-- Check if any payment has a status of pending --}}
                                 <tr>
                                     <td colspan="6" class="text-center" style="color: red">Pending</td>
                                 </tr>
                                 @elseif ($payments->first()->status === 'paid') {{-- Check if payment status is underpaid or paid --}}
                                 @php
                                     // Initialize variables to track merged rows
                                     $mergedPayments = [];
                                 @endphp
                             
                                 @foreach ($payments as $payment)
                                     {{-- Only process payments with status "underpaid" or "paid" --}}
                                     @if ($payment->status === 'paid')
                                         @php
                                             // Generate a unique key based on name, room, and bed
                                             $key = $payment->name . '-' . $payment->room . '-' . $payment->bed;
                             
                                             // Check if this combination already exists in the mergedPayments array
                                             if (isset($mergedPayments[$key])) {
                                                 // If exists, add the total and balance to the existing record
                                                 $mergedPayments[$key]['total'] += $payment->total;
                                                                                              } else {
                                                 // If not, create a new entry
                                                 $mergedPayments[$key] = [
                                                     'name' => $payment->name,
                                                     'room' => $payment->room,
                                                     'bed' => $payment->bed,
                                                     'total' => $payment->total,
                                                                                                      ];
                                             }
                                         @endphp
                                     @endif
                                 @endforeach
                             
                                 {{-- Now loop through the merged payments to display the results --}}
                                 @foreach ($mergedPayments as $merged)
                                     <tr>
                                         <td>{{ $merged['name'] }}</td>
                                         <td>{{ $merged['room'] }}</td>
                                         <td>{{ $merged['bed'] }}</td>
                                         <td>{{ $merged['total'] }}</td>
                                      </tr>
                                 @endforeach
                             
                                 <tr>
                                     <td></td>
                                     <td></td>
                                     <td><b>Total Collectible</b></td>
                                     <td>{{ array_sum(array_column($mergedPayments, 'total')) }}</td> {{-- Sum the total from merged payments --}}
                                 </tr>
                             @endif
                             </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </x-app-layout>
