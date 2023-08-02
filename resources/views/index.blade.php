<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD With Image Upload using jQuery Ajax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-12">
                <h2 class="text-center">CRUD With Image Upload using jQuery Ajax</h2>
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="text-secondary">Manage Employee</h3>
                        <button class="btn btn-secondary"  data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                            <i class="bi bi-plus-circle me-2"></i>Add New Employee</button>
                    </div>
                    <div class="card-body" id="show_all_employees">
                        <h1 class="text-center text-secondary my-5">Loding...</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

  
  <!-- Insert Modal -->
  <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Add New Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="post" id="add_employee_form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg">
                        <label for="fname-add" class="col-form-label">First Name:</label>
                        <input type="text" name="fname" class="form-control" id="fname-add" placeholder="First Name" required>
                    </div>
                    <div class="col-lg">
                        <label for="lname-add" class="col-form-label">Last Name:</label>
                        <input type="text" name="lname" class="form-control" id="lname-add" placeholder="Last Name" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email-add" class="col-form-label">Email:</label>
                    <input type="email" name="email" class="form-control" id="email-add" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <label for="avatar-add" class="col-form-label">Select Avatar:</label>
                    <input type="file" name="avatar" class="form-control" id="avatar-add" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="add_employee_btn">Add Employee</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="post" id="edit_employee_form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="emp_id" id="emp_id">
            <input type="hidden" name="emp_avatar" id="emp_avatar">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg">
                        <label for="fname" class="col-form-label">First Name:</label>
                        <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name" required>
                    </div>
                    <div class="col-lg">
                        <label for="lname" class="col-form-label">Last Name:</label>
                        <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="col-form-label">Email:</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <label for="avatar" class="col-form-label">Select Avatar:</label>
                    <input type="file" name="avatar" class="form-control">
                </div>
                <div class="mt-2" id="avatar"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="edit_employee_btn">Update Employee</button>
            </div>
        </form>
      </div>
    </div>
  </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>{{-- https://datatables.net/--}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function(){
            //add new employee
           $("#add_employee_form").submit(function(e){
                e.preventDefault();
                const fd = new FormData(this);
                $('#add_employee_btn').text('Adding...');

                $.ajax({
                    url: '{{route('store')}}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 200){
                            Swal.fire(
                                'Added!',
                                'Employee Added Successfully!',
                                'success'
                            )
                            fetchAllEmployees();
                        }
                        $("#add_employee_btn").text('Add Employee');
                        $("#add_employee_form")[0].reset();
                        $("#addEmployeeModal").modal('hide');
                    }
                });
           });

            //edit employee
            $(document).on('click', '.editIcon', function(e){
                e.preventDefault(e);
                let id = $(this).attr('id');
                
                $.ajax({
                    url: '{{route('edit')}}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(response){
                        $("#fname").val(response.first_name);
                        $("#lname").val(response.last_name);
                        $("#email").val(response.email);
                        $("#avatar").html(
                            `<img src="storage/images/${response.avatar}" width="80" class="img-fluid img-thumbnail">`);
                        $("#emp_id").val(response.id);
                        $("#emp_avatar").val(response.avatar);
                    }
                });
            });

            //update employee edit-data
            $("#edit_employee_form").submit(function(e){
                e.preventDefault();
                const fd = new FormData(this);
                $("#edit_employee_btn").text('Updating...');

                $.ajax({
                    url: '{{route('update')}}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 200){
                            Swal.fire(
                                'Updated!',
                                'Employee Updated Successfully!',
                                'success'
                            )
                            fetchAllEmployees();
                        }
                        $("#edit_employee_btn").text('Update Employee');
                        $("#edit_employee_form")[0].reset();
                        $("#editEmployeeModal").modal('hide');
                    }
                });
            });

            //delete employee
            $(document).on('click', '.deleteIcon', function(e){
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';

                Swal.fire({
                    title: 'Are you sure',
                    text: "You  won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtoncolor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if(result.isConfirmed){
                        $.ajax({
                            url: '{{route('delete')}}',
                            method: 'delete',
                            data: {
                                id: id,
                                _token: csrf
                            },
                            success: function(response){
                                Swal.fire(
                                    'Delete!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                fetchAllEmployees();
                            }
                        });
                    }
                })
            });
            



            //fetch all employees
            fetchAllEmployees();


            function fetchAllEmployees(){
                $.ajax({
                    url: '{{route('fetchAll')}}',
                    method: 'get',
                    success: function(response){
                        $('#show_all_employees').html(response);
                        //Start For, datatables.net 
                        $("table").DataTable({
                            order: [0, 'asc']
                        });
                        //End For, datatables.net 
                    }
                });
            }
        });
    </script>

</body>
</html>