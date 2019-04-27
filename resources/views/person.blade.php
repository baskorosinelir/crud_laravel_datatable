<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet"> -->
          <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
		 <!-- <link rel="stylesheet" href="/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
      <!-- <link rel="stylesheet" href="/datatables.net-bs/css/jquery.dataTables.min.css"> -->
          <link rel="stylesheet" type="text/css" href="/datatable/css/jquery.dataTables.min.css">

		  <link href="/fontawesome/css/all.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
          <h1>Persons Data </h1>
           <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Person</button>
        <button class="btn btn-secondary" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>


          <div class="table col-md-12">
          	<table id="table" class="table-fluid table-bordered">
          		<thead class="bg-primary">
          			<td style="color:#fff;" class="text-center">Num</td>
          			<td style="color:#fff;" class="text-center">Name</td>
          			<td style="color:#fff;" class="text-center">Email</td>
          			<td style="color:#fff;" class="text-center">Adderss</td>
                <td  style="color:#fff;" class="text-center">Action</td>
          		</thead>
          		<tbody>
          			
          		</tbody>
          	</table>
          </div>
        </div>
 
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Person Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                

            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    {{ csrf_field() }}
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group row"> 
                            <label class="control-label col-md-3">Name</label>
                            <div class="col-md-9">
                                <input name="name" placeholder="Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input name="email" placeholder="Email" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                 <!--        <div class="form-group">
                            <label class="control-label col-md-3">Gender</label>
                            <div class="col-md-9">
                                <select name="gender" class="form-control">
                                    <option value="">--Select Gender--</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label class="control-label col-md-3">Address</label>
                            <div class="col-md-9">
                                <textarea name="address" placeholder="Address" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="control-label col-md-3">Date of Birth</label>
                            <div class="col-md-9">
                                <input name="dob" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div> -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<script src="/js/jquery3.4.0.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<!-- <script type="text/javascript" src="/datatables.net/js/jquery.dataTables.min.js"></script> -->
<!-- <script type="text/javascript" src="/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> -->
<script type="text/javascript" src="/datatable/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
var table;
	$(document).ready(function() {

    // set_th(h);
    //datatables


    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": '/person/ajax_list',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            "type": "POST"
        },
     

        //Set column definition initialisation properties.
        "columnDefs": [
            { 
                "targets": [ -1,0 ], //last column
                "orderable": false, //set not orderable
            },
            {
                "defaultContent": "-",
                "targets" : "_all"
            },
            {
                targets:[0,-1],
                class:"text-center"
            }
        ],
          columns:[
            {
                data:"no"
            },
            {
                data:"name"
            },
            {
            	data:"email"
            },
            {
              data:"address"
            },
            {   
                // class:"text-center",
                data: function (a) {
                    var btn;
                    btn='<button class="btn btn-sm btn-primary"  title="Edit" onclick="edit_person('+"'"+a.id+"'"+')"><i class="fas fa-pencil-alt"></i></button>&nbsp;';

                    btn+='<button class="btn btn-sm btn-danger"  title="Hapus" onclick="delete_person('+"'"+a.id+"'"+')"><i class="fas fa-trash"></i></button>';
                    return btn;
                }
            }
        ],

    });

 

     
  
});

  function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('.modal-title').text('Add Person')
    $('#modal_form').modal('show'); // show bootstrap modal
   ; // Set Title to Bootstrap modal title
}



 
function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "/person/ajax_edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id"]').val(data.id);
            $('[name="name"]').val(data.name);
            // $('[name="lastName"]').val(data.lastName);
            // $('[name="gender"]').val(data.gender);
             $('[name="email"]').val(data.email);
            $('[name="address"]').val(data.address);
            // $('[name="dob"]').datepicker('update',data.dob);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
 
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
 
    if(save_method == 'add') {
        url = "/person/ajax_add";
        type="POST";
    } else {
        url = "/person/ajax_update";
        type="PUT"
    }
 
    // ajax adding data to database
    $.ajax({
        url : url,
        type: type,
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
 
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
        }
    });
}
 
function delete_person(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "/person/ajax_delete/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
    }
}

</script>
    </body>
</html>