<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'Blog';
	$breadcrumb[1]['url'] = url('backend/blog-content');
?>

<!-- LAYOUT -->
@extends('backend.layouts.main')

<!-- TITLE -->
@section('title', 'Blog | Content')

<!-- CONTENT -->
@section('content')
	<div class="page-title">
		<div class="title_left">
			<h3>Blog - Content</h3>
		</div>
		<div class="title_right">
			<div class="col-md-4 col-sm-4 col-xs-8 form-group pull-right top_search">
				@include('backend.elements.create_button',array('url' => '/backend/blog-content/create'))
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
								<th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
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
			processing: true,
			serverSide: true,
            "order": [[ 0, "desc" ]],
			ajax: "<?=url('backend/blog-content/datatable');?>",
			columns: [
				{data: 'id', name: 'id'},
				{data: 'judul', name: 'judul'},
                {data: 'name', name: 'name'},
				{data:  'active', render: function ( data, type, row ) {
					var text = "";
					var label = "";
					if (data == 1){
						text = "Publish";
						label = "success";
					} else 
					if (data == 2){
						text = "Draft";
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