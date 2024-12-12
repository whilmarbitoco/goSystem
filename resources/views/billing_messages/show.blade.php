<x-app-layout>
    <x-slot name="header">
    <div class="content-header">
        <div class="container-fluid">
           <div class="row mb-2">
              <div class="col-sm-6">
                 <h1 class="m-0 text-dark"><span class="fa fa-bed"></span> Your Billing</h1>
              </div>
              <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Billings</li>
                 </ol>
              </div>
          </div>
        </div>
    </x-slot>
    <div class="container-fluid">
        <div class="card card-info elevation-2">
           <br>
           <div class="col-md-12 table-responsive">
              <table id="example1" class="table table-bordered table-hover">
                 <thead class="btn-cancel">
		    <tr>
                      <th>Owner Name</th>
                       <th>Billing Name</th>
		       <th>Billing Price</th>
			<th>Billing Message</th>
                        <th>Action</th>
                     </tr>
                 </thead>
                 <tbody>
                    @foreach($messages as $message)
		    <tr>
                        <td>{{$message->sender->name}}</td>
                        <td>{{$message->name}}</td>
		       <td>P{{ number_format($message->price, 2) }}</td>
		       <td>{{$message->content}}</td>	    
               <td class="text-right">     
			       <a href="#" class="btn btn-primary pay-now-btn" data-id="{{$message->id}}" data-name="{{$message->name}}" data-price="{{$message->price}}">Pay Now</a>
                   </td>
                    </tr>
                    <div id="deleteModal{{$message->id}}" class="modal animated rubberBand delete-modal" role="dialog">
                      <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                              <form id="deleteForm{{$message->id}}" action="{{ route('billing_messages.destroy', $message->id) }}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <div class="modal-body text-center">
                                      <img src="{{asset('logo.png')}}" alt="Logo" width="50" height="46">
                                      <h3>Are you sure you want to delete this Operator?</h3>
                                      <div class="m-t-20">
                                          <button type="button" class="btn btn-white" data-dismiss="modal" style="background-color: blue;color:white;border-color:blue;">Close</button>
                                          <button type="submit" class="btn btn-danger">Delete</button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
                 @endforeach
               </tbody>
            </table>                    
          </div>
      </div>
    </div>
    </div>

<script>
  document.querySelectorAll('.pay-now-btn').forEach(button => {
    button.addEventListener('click', function () {
      const messageId = this.getAttribute('data-id');
      const messageName = this.getAttribute('data-name');
      const messageAmount = parseFloat(this.getAttribute('data-price')); // Get message price

      // Show payment options after clicking "Pay Now"
      Swal.fire({
        title: `Proceed with payment for ${messageName}`,
        text: 'Choose your payment method',
        showCancelButton: true,
        confirmButtonText: 'Gcash',
        cancelButtonText: 'Cash on Hand',
        icon: 'question'
      }).then((result) => {
        if (result.isConfirmed) {
          // Gcash was selected - Show Gcash form
          Swal.fire({
            title: 'Gcash Payment',
            html: `
             <form id="gcashPaymentForm" action="{{ route('payment_messages.store') }}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8 offset-md-2">
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" readonly>
                      </div>
                    </div>
                    <div class="col-md-8 offset-md-2">
                      <div class="form-group">
                        <label>Payment Method</label>
                        <input type="text" name="paymentmethod" class="form-control" value="Gcash" readonly>
                      </div>
                    </div>

                    <div class="col-md-8 offset-md-2" id="owner-details">
                      <div class="form-group">
                        <label>Owner Name</label>
                        <input type="text" name="ownername" class="form-control" value="{{ $message->sender->name }}" readonly>
                      </div>
                      <div class="form-group">
                        <label>Owner Gcash Number</label>
                        <input type="text" name="number" class="form-control" value="{{ $message->sender->number }}" readonly>
                      </div>
                    </div>

                    <div class="col-md-8 offset-md-2">
                      <div class="form-group">
                        <label>Billing Name</label>
                        <input type="text" id="billingname" name="billingname" class="form-control" value="${messageName}" readonly>
                      </div>
                    </div>

                    <div class="col-md-8 offset-md-2">
                      <div class="form-group">
                        <label>Price</label>
                        <input type="text" id="price" name="price" class="form-control" value="${messageAmount}" readonly>
                      </div>
                    </div>

                    <div class="col-md-8 offset-md-2">
                      <div class="form-group">
                        <label>Total Billing</label>
                        <input type="text" id="total" name="total" class="form-control" readonly>
                      </div>
                    </div>

                    <!-- Hidden fee input field -->
                    <div class="form-group" style="display:none;">
                      <label>Your Fee</label>
                      <input type="text" name="fee" id="fee" class="form-control" readonly>
                    </div>
                    
               
                    <div class="col-md-8 offset-md-2">
                      <div class="form-group">
                        <label>Select Receiver</label>
			<select name="receiver_id" id="receiver_id" class="form-control" required>
			@foreach($users as $user)
                            <option value="{{$user->id }}" selected>{{$user->name }}</option>
			    @endforeach
			    </select>
                      </div>
                    </div>

                    <!-- Hidden status input field -->
                    <div class="col-md-8 offset-md-2" style="display:none">
                      <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status">
                          <option value="pending" style="color:red">Pending</option>
                          <option value="underpaid" style="color:yellow">Receive/Underpaid</option>
                          <option value="received" style="color:green">Receive/Paid</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Pay with Gcash</button>
              </form>
            `,
            showConfirmButton: false,
          });

          // Access necessary DOM elements
          const feeInput = document.getElementById('fee');
          const totalInput = document.getElementById('total');

          let fee = 0;
          if (messageAmount >= 1 && messageAmount <= 500) {
            fee = 5;
          } else {
            // Every 500 increment adds 10 to the fee
            fee = 5 + (Math.floor((messageAmount - 501) / 500) + 1) * 5;
          }
          feeInput.value = fee;

          // Calculate total (message amount + fee)
          let total = messageAmount + fee;
          totalInput.value = total;  // Set total value

        } else if (result.dismiss === Swal.DismissReason.cancel) {
          // Cash on Hand was selected - Show Cash on Hand form
          Swal.fire({
            title: 'Cash on Hand Payment',
            html: `
              <form id="cashPaymentForm" action="{{ route('payment_messages.store') }}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8 offset-md-2" style="display:none;">
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" readonly>
                      </div>
                    </div>
             
                    <div class="col-md-8 offset-md-2" id="owner-details">
                      <div class="form-group">
                        <label>Owner Name</label>
                        <input type="text" name="ownername" class="form-control" value="{{ $message->sender->name }}" readonly>
                      </div>
                    </div>
               
                    <div class="col-md-8 offset-md-2">
                      <div class="form-group">
                        <label>Payment Method</label>
                        <input type="text" name="paymentmethod" class="form-control" value="Cash on Hand" readonly>
                      </div>
		      </div>

                   <div class="col-md-8 offset-md-2">
                      <div class="form-group">
                        <label>Billing Name</label>
                        <input type="text" id="billingname" name="billingname" class="form-control" value="${messageName}" readonly>
                      </div>
                    </div>

                    <div class="col-md-8 offset-md-2">
                      <div class="form-group">
                        <label>Price</label>
                        <input type="text" id="price" name="price" class="form-control" value="${messageAmount}" readonly>
                      </div>
                    </div>

                   <div class="col-md-8 offset-md-2">
                      <div class="form-group">
                        <label>Select Receiver</label>
			<select name="receiver_id" id="receiver_id" class="form-control" required>
			@foreach($users as $user)
                            <option value="{{$user->id }}" selected>{{$user->name }}</option>
			    @endforeach
			    </select>
                      </div>
                    </div>

                    <div class="col-md-8 offset-md-2" style="display:none">
                      <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status">
                          <option value="pending" style="color:red">Pending</option>
                          <option value="underpaid" style="color:yellow">Receive/Underpaid</option>
                          <option value="received" style="color:green">Receive/Paid</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Pay with Cash</button>
              </form>
            `,
            showConfirmButton: false,
          });

          // Access necessary DOM elements for Cash on Hand
          const cashMessageInput = document.querySelector('input[name="message"]');
          const cashBalanceInput = document.getElementById('balance'); // Access the balance input
          const totalInputForCash = document.querySelector('input[name="total"]'); // Access the total input

          // Set message input value for Cash on Hand
          cashMessageInput.value = `${messageName} - ${messageAmount}`;
          totalInputForCash.value = `${messageAmount}`; // Ensure total is set correctly

          // Event listener for the amount input for Cash on Hand
          const cashAmountInput = document.querySelector('input[name="balance"]');
          cashAmountInput.addEventListener('input', function () {
            const inputAmount = parseFloat(this.value) || 0; // Parse the input amount as a float
            const messageAmount = parseFloat(totalInputForCash.value) || 0; // Get the message amount from the total input
            const halfMessageAmount = messageAmount / 2; // Calculate half of the message amount

            // Ensure input does not exceed the message amount
            if (inputAmount > messageAmount) {
              this.value = messageAmount; // Set to maximum message amount
            }

            // Calculate balance (message amount - input amount) only if there's input
            const cashBalance = inputAmount ? messageAmount - inputAmount : ''; // Show empty if input is empty
            cashBalanceInput.value = cashBalance >= 0 ? cashBalance : 0; // Update balance
          });
        }
      });
    });
  });
</script>  


 </x-app-layout>

