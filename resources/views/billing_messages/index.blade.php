<x-app-layout>
    <x-slot name="header">
    <div class="content-header">
        <div class="container-fluid">
           <div class="row mb-2">
              <div class="col-sm-6">
                 <h1 class="m-0 text-dark"><span class="fa fa-bed"></span> Billing</h1>
              </div>
              <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Billings</li>
                 </ol>
              </div>
              <a class="btn btn-sm elevation-2" id="showFormModal" style="margin-top: 20px;margin-left: 10px;background-color: #05445E;color: #ddd;">
                <i class="fa fa-user-plus"></i> Add New
              </a>
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
                       <th>Billing Name</th>
		       <th>Billing Price</th>
			<th>Billing Message</th>
                        <th>Action</th>
                     </tr>
                 </thead>
                 <tbody>
                    @foreach($messages as $message)
                    <tr>
                        <td>{{$message->name}}</td>
		       <td>P{{ number_format($message->price, 2) }}</td>
		       <td>{{$message->content}}</td>
		    
<td class="text-right">     
                        <a class="btn btn-sm btn-success editBillingBtn" data-id="{{ $message->id }}" data-name="{{ $message->name }}" data-message="{{ $message->price}}" href="#">
                            <i class="fa fa-edit"></i>
                        </a>                     
                          <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{$message->id}}" href="#"><i
                                class="fa fa-trash-alt"></i></a>
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



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


            <script>
    document.getElementById('showFormModal').addEventListener('click', function (e) {
        e.preventDefault();  // Prevent default link behavior

        Swal.fire({
            title: 'Add New Billing Message',
            html: `
                <form id="billingMessageForm" action="{{ route('billing_messages.store') }}" method="POST">
                    @csrf

                    <!-- Recipient selection -->
                    <div style="margin-bottom: 15px;">
                        <label for="receiver_id" style="font-size: 14px; margin-bottom: 5px; color: #333;">Select Recipient:</label>
                        <select name="receiver_id" id="receiver_id" style="padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box;" required>
                            <option value="" disabled selected>Select a user</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Message content -->
                    <div style="margin-bottom: 15px;">
                        <label for="content" style="font-size: 14px; margin-bottom: 5px; color: #333;">Message Content:</label>
                        <textarea name="content" id="content" style="padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box;" required></textarea>
                    </div>

                    <!-- Message name (e.g., service name) -->
                    <div style="margin-bottom: 15px;">
                        <label for="name" style="font-size: 14px; margin-bottom: 5px; color: #333;">Name:</label>
                        <input type="text" name="name" id="name" style="padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box;" required>
                    </div>

                    <!-- Price -->
                    <div style="margin-bottom: 15px;">
                        <label for="price" style="font-size: 14px; margin-bottom: 5px; color: #333;">Price:</label>
                        <input type="number" name="price" id="price" step="0.01" min="0" style="padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box;" required>
                    </div>
                </form>
            `,
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Submit',
            focusConfirm: false,
            preConfirm: () => {
                // Here you can submit the form
                document.getElementById('billingMessageForm').submit();
            }
        });
    });
</script>







   </script>


    </x-app-layout>













