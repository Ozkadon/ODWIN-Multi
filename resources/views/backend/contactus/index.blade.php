<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'Inbox';
	$breadcrumb[1]['url'] = url('backend/contact-inbox');
?>

<!-- LAYOUT -->
@extends('backend.layouts.main')

<!-- TITLE -->
@section('title', 'Inbox')

<!-- CONTENT -->
@section('content')
    {{ Form::open(['method' => 'POST','class' => 'form-horizontal']) }}
	<div class="page-title">
		<div class="title_left">
			<h3>Inbox</h3>
		</div>
		<div class="title_right">
			<div class="col-md-4 col-sm-4 col-xs-8 form-group pull-right top_search">
                <?php
                    $segment =  Request::segment(2);
                    $userinfo = Session::get('userinfo');
                    $access_control = Session::get('access_control');
                    if (!empty($access_control)) :
                        if ($access_control[$userinfo['user_level_id']][$segment] == "a"):
                ?>           
                        <button type="submit" class="btn btn-block btn-danger btn-delete-check"><i class="fa fa-minus"></i>&nbsp; Delete</a>
                <?php
                        endif;
                    endif;
                ?>
    		</div>
		</div>
	</div>
	<div class="clearfix"></div>
	@include('backend.elements.breadcrumb',array('breadcrumb' => $breadcrumb))	
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					@include('backend.elements.notification')
                    <table class="table table-striped table-hover table-bordered dt-responsive nowrap dataTable" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>
									<span class="uni">
									  <input type='checkbox' value='checkall' onclick='checkAll(this)' />
									</span>
								</th>
								<th>ID</th>
								<th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>					
    </div>
    {{ Form::close() }}
@endsection

<!-- CSS -->
@section('css')

@endsection

<!-- JAVASCRIPT -->
@section('script')
	<script>
		$('.dataTable').dataTable({
			processing: true,
			serverSide: true,
            "order": [[ 1, "desc" ]],
			ajax: "<?=url('backend/contact-inbox/datatable');?>",
			columns: [
                {data: 'check', name: 'check', orderable: false, searchable: false},
				{data: 'id', name: 'id'},
				{data: 'name', name: 'name'},
				{data: 'email', render: function ( data, type, row ) {
    				return "<a href='mailto:"+data+"'>"+ data + "</a>";
                }},				
                {data: 'subject', name: 'subject'},
                {data: 'created_at', name: 'created_at'},
				{data: 'read', render: function ( data, type, row ) {
					var text = "";
					var label = "";
					if (data == 1){
						text = "Unread";
						label = "error";
					} else 
					if (data == 2){
						text = "Read";
						label = "success";
					}
					return "<span class='badge badge-" + label + "'>"+ text + "</span>";
                }},				
				{data: 'action', name: 'action', orderable: false, searchable: false}
			],
			responsive: true
		});

        function checkAll(bx) {
            var cbs = document.getElementsByTagName('input');
            for(var i=0; i < cbs.length; i++) {
                if(cbs[i].type == 'checkbox') {
                cbs[i].checked = bx.checked;
                }
            }
        }	

        $('.btn-delete-check').on('click', function(e){
            e.preventDefault();
            if (confirm("Apakah anda yakin mau menghapus data-data ini?")) {
                $(this).parents('form').submit();
            }
        });
	</script>
@endsection