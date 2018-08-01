<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'Category';
	$breadcrumb[1]['url'] = url('backend/blog-category');	
	$breadcrumb[2]['title'] = 'Add';
	$breadcrumb[2]['url'] = url('backend/blog-category/create');
	if (isset($data)){
		$breadcrumb[2]['title'] = 'Edit';
		$breadcrumb[2]['url'] = url('backend/blog-category/'.$data[0]->id.'/edit');
	}
?>

<!-- LAYOUT -->
@extends('backend.layouts.main')

<!-- TITLE -->
@section('title')
	<?php
		$mode = "Create";
		if (isset($data)){
			$mode = "Edit";
		}
	?>
    Blog - Category - <?=$mode;?>
@endsection

<!-- CONTENT -->
@section('content')
	<?php
		$active = 1;
		$method = "POST";
		$mode = "Create";
		$url = "backend/blog-category/";
		if (isset($data)){
			$active = $data[0]->active;
			$method = "PUT";
			$mode = "Edit";
			$url = "backend/blog-category/".$data[0]->id;
		}
	?>
	<div class="page-title">
		<div class="title_left">
			<h3>Blog - Category - <?=$mode;?></h3>
		</div>
		<div class="title_right">
			<div class="col-md-4 col-sm-4 col-xs-8 form-group pull-right top_search">
                @include('backend.elements.back_button',array('url' => '/backend/blog-category'))
			</div>
        </div>
        <div class="clearfix"></div>
		@include('backend.elements.breadcrumb',array('breadcrumb' => $breadcrumb))
	</div>
	<div class="clearfix"></div>
	<br/><br/>	
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					{{ Form::open(['url' => $url, 'id' => 'submitForm', 'method' => $method,'class' => 'form-horizontal form-label-left', 'files' => true]) }}
						{!! csrf_field() !!}
						<div class="form-group">
                            <label class="control-label col-sm-3 col-xs-12">Status: </label>
                            <div class="col-sm-5 col-xs-12">
                                {{
                                Form::select(
                                    'active',
                                    ['1' => 'Active', '2' => 'Deactive'],
                                    $active,
                                    array(
                                        'class' => 'form-control',
                                    ))
                                }}
                            </div>
                        </div>
                        <br/>
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <?php
                                    $default_language = Session::get('default_language');
                                    $active_language = Session::get('active_language');
                                    foreach ($active_language as $language):
                                        $active = "";
                                        if ($default_language->code == $language->code){
                                            $active = "active";
                                        }
                                ?>
                                    <li role="presentation" class="<?=$active;?>"><a href="#tab-<?=$language->code;?>" id="<?=$language->code;?>" role="tab" data-toggle="tab" aria-expanded="true"><?=$language->name;?></a></li>
                                <?php
                                    endforeach;
                                ?>
                            </ul>
                            <div id="content-language" class="tab-content">
                                <?php
                                    $name = "";
                                    $detail = "";
                                    foreach ($active_language as $language):
                                        $active = "";
                                        if ($default_language->code == $language->code){
                                            $active = "active in";
                                        }
                                        if (isset($data)){
                                            $name = "";
                                            foreach ($data_language as $data_language_single):
                                                if ($data_language_single->language_code == $language->code){
                                                    $name = $data_language_single->name;
                                                }
                                            endforeach;
                                        }
                                ?>
                                <div role="tabpanel" class="tab-pane fade <?=$active;?>" id="tab-<?=$language->code;?>" aria-labelledby="<?=$language->code;?>">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-xs-12">Name <span class="required">*</span></label>
                                        <div class="col-sm-7 col-xs-12">
                                            <input type="text" name="name_<?=$language->code;?>" required="required" class="form-control" value="<?=$name;?>" autofocus>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    endforeach;
                                ?>

                            </div>
                        </div>
						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-sm-6 col-xs-12 col-sm-offset-3">
                                <a href="<?=url('/backend/blog-category')?>" class="btn btn-warning">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit</a>
							</div>
						</div>
					{{ Form::close() }}
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
    <script src="<?=url('vendors/ckeditor/ckeditor.js');?>"></script>
    <script>
        <?php
            foreach ($active_language as $language):
        ?>
        CKEDITOR.replace( 'editor_<?=$language->code;?>', {
            filebrowserBrowseUrl: '<?=url("backend/media-library/popup-media-editor/1");?>',
		    height : 500,
    	});
        <?php
            endforeach;
        ?>
    </script>        
@endsection