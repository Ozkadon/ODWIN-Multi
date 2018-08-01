<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'Language';
	$breadcrumb[1]['url'] = url('backend/language');
?>

<!-- LAYOUT -->
@extends('backend.layouts.main')

<!-- TITLE -->
@section('title', 'Language')

<!-- CONTENT -->
@section('content')
	<div class="page-title">
		<div class="title_left">
			<h3>Language</h3>
		</div>
		<div class="title_right">
			<div class="col-md-4 col-sm-4 col-xs-8 form-group pull-right top_search">
				<a href="<?=url('/backend/language/create');?>" class="btn-index btn btn-primary btn-block" title="Add"><i class="fa fa-plus"></i>&nbsp; Add</a>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	@include('backend.elements.breadcrumb',array('breadcrumb' => $breadcrumb))
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					@include('backend.elements.notification')
					<table class="table table-striped table-hover table-bordered dt-responsive nowrap dataTable" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>Code</th>
                                <th>Name</th>
                                <th>Default</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection

<!-- CSS -->
@section('css')

@endsection

<!-- JAVASCRIPT -->
@section('script')
	<script>
		$('.dataTable').dataTable({
			processing: false,
			serverSide: true,
			ajax: "<?=url('backend/datatable/language');?>",
			columns: [
				{data: 'id', name: 'id'},
				{data: 'code', name: 'code'},
				{data: 'name', name: 'name'},
				{data:  'default', render: function ( data, type, row ) {
					var text = "";
					var label = "";
					if (data == 1){
						text = "Yes";
						label = "success";
					} else 
					if (data == 0){
						text = "No";
						label = "warning";
					}
					return "<span class='badge badge-" + label + "'>"+ text + "</span>";
                }},				
				{data:  'active', render: function ( data, type, row ) {
					var text = "";
					var label = "";
					if (data == 1){
						text = "Active";
						label = "success";
					} else 
					if (data == 0){
						text = "Deactive";
						label = "warning";
					}
					return "<span class='badge badge-" + label + "'>"+ text + "</span>";
                }},				
				{data: 'action', name: 'action', orderable: false, searchable: false}
			],
			responsive: true
		});
	</script>
@endsection