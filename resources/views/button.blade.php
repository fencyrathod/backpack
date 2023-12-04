<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Button</title>

    <style>

    .btn-success {
        background-color: transparent;
        border: 1px;
        color: #161c2d;
        font-size: 19px;
    }
    .btn-success:hover{
        color: #161c2d !important;
        background-color:#f9fbfd !important;
    }
</style>
</head>
<body>
    <!-- Example split danger button -->


<div class="btn-group">
     <button type="button" class="btn btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="la la-gear nav-icon"></i>
    </button>
     <div class="dropdown-menu">
        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteEntry(this)" data-route="http://127.0.0.1:8000/admin/jobs/{{$entry->getKey()}}">Delete</a>
     
        <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}">Edit</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}">Preview Job</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}#note">Add Note</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{ url('/admin/payment/create?id='.$entry->getKey()) }}">Add Payment</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}#status">Update Status</a>
      <div class="dropdown-divider"></div>
       <a class="dropdown-item" href="{{ url('/admin/jobs/invoice/?id='.$entry->getKey()) }} ">Invoice</a>
       <div class="dropdown-divider"></div>
       <a class="dropdown-item" href="{{ url('/admin/jobs/quotation/?id='.$entry->getKey()) }} ">Quotation</a>
      </div>
  </div>

  <script>

    if (typeof deleteEntry != 'function') {
      $("[data-button-type=delete]").unbind('click');

      function deleteEntry(button) {
        // ask for confirmation before deleting an item
        // e.preventDefault();
        var route = $(button).attr('data-route');

        swal({
          title: "Warning",
          text: "Are you sure you want to delete this item?",
          icon: "warning",
          buttons: ["Cancel", "Delete"],
          dangerMode: true,
        }).then((value) => {
            if (value) {
                $.ajax({
                  url: route,
                  type: 'DELETE',
                  success: function(result) {
                      if (result == 1) {
                          // Redraw the table
                          if (typeof crud != 'undefined' && typeof crud.table != 'undefined') {
                              // Move to previous page in case of deleting the only item in table
                              if(crud.table.rows().count() === 1) {
                                crud.table.page("previous");
                              }

                              crud.table.draw(false);
                          }

                            // Show a success notification bubble
                          new Noty({
                            type: "success",
                            text: "<strong>Item Deleted</strong><br>The item has been deleted successfully."
                          }).show();

                          // Hide the modal, if any
                          $('.modal').modal('hide');
                      } else {
                          // if the result is an array, it means 
                          // we have notification bubbles to show
                            if (result instanceof Object) {
                                // trigger one or more bubble notifications 
                                Object.entries(result).forEach(function(entry, index) {
                                  var type = entry[0];
                                  entry[1].forEach(function(message, i) {
                                    new Noty({
                                    type: type,
                                    text: message
                                  }).show();
                                  });
                                });
                            } else {// Show an error alert
                              swal({
                                  title: "NOT deleted",
                                text: "There's been an error. Your item might not have been deleted.",
                                  icon: "error",
                                  timer: 4000,
                                  buttons: false,
                              });
                            }			          	  
                      }
                  },
                  error: function(result) {
                      // Show an alert with the result
                      swal({
                          title: "NOT deleted",
                        text: "There's been an error. Your item might not have been deleted.",
                          icon: "error",
                          timer: 4000,
                          buttons: false,
                      });
                  }
              });
            }
        });

      }
    }

 
    // make it so that the function above is run after each DataTable draw event
    // crud.addFunctionToDataTablesDrawEventQueue('deleteEntry');
</script>
</body>
</html>