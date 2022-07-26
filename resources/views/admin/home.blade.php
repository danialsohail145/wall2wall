@extends('admin.layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-12 text-right mb-5">
            <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Add Item</a>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered data-table" id="item_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>SIGNED BY</th>
                        <th>CERT NO</th>
                        <th>AMOUNT</th>
                        <th>SOLD</th>
                        <th>USER ID</th>
                        <th>CREATED</th>
                        <th>UPDATED</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>

            <div class="modal-body">



                <form id="productForm" name="productForm" class="form-horizontal">
                    <div class="alert alert-danger error">The cert no has already been taken.</div>
                    <input type="hidden" name="item_id" id="item_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="signed_by" class="col-sm-2 control-label">Signed By</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="signed_by" name="signed_by" placeholder="Enter Signed By" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cert_no" class="col-sm-2 control-label">Certificate Number</label>
                        <div class="col-sm-12">
                            <input type="number" min="0" class="form-control" id="cert_no" name="cert_no" placeholder="Enter Certificate Number" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="amount" class="col-sm-2 control-label">Amount</label>
                        <div class="col-sm-12">
                            <input type="number" min="0" class="form-control" id="amount" name="amount" placeholder="Enter Amount" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sold" class="col-sm-2 control-label">Sold</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="sold" name="sold" placeholder="Enter Sold" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


@endsection



@push('page_scripts')
    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var table = $('.data-table').DataTable({

                processing: true,

                serverSide: true,

                ajax: "{{ route('item.index') }}",

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'name', name: 'name' },
                    { data: 'signed_by', name: 'signed_by' },
                    { data: 'cert_no', name: 'cert_no' },
                    { data: 'amount', name: 'amount' },
                    { data: 'sold', name: 'sold' },
                    { data: 'user_id', name: 'user_id' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });

         

            $('#createNewProduct').click(function () {
                $('.error').hide();
                $('#saveBtn').val("create-product");
                $('#item_id').val('');
                $('#productForm').trigger("reset");
                $('#modelHeading').html("Create New Product");
                $('#ajaxModel').modal('show');
            });



            $('body').on('click', '.editProduct', function () {
                $('.error').hide();

                var product_id = $(this).data('id');

                $.get("{{ route('item.index') }}" +'/' + product_id +'/edit', function (data) {
                    $('#modelHeading').html("Edit Product");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#item_id').val(data.id);
                    $('#name').val(data.name);
                    $('#name').val(data.name);
                    $('#signed_by').val(data.signed_by);
                    $('#cert_no').val(data.cert_no);
                    $('#amount').val(data.amount);
                    $('#sold').val(data.sold);
                })
            });



            $('#productForm').submit(function (e) {
                e.preventDefault();
                $('#saveBtn').html('Sending..');
                $.ajax({
                    data: $('#productForm').serialize(),
                    url: "{{ route('item.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        if (data.success) {
                            $('#productForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            $('#saveBtn').html('Save Changes');
                            table.draw();
                        }

                        if (data.fail) {
                            $('.error').show();
                            $('#saveBtn').html('Save Changes');
                        }
                    },
                    error: function (data) {
                        $('#saveBtn').html('Save Changes');
                    }

                });

            });


            $('body').on('click', '.deleteProduct', function (){
                var product_id = $(this).data("id");
                var result = confirm("Are You sure want to delete !");
                if(result){
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('item.store') }}"+'/'+product_id,
                        success: function (data) {
                            table.draw();
                        },
                        error: function (data) {
                        }
                    });
                }else{
                    return false;
                }
            });
        })
    </script>
@endpush




