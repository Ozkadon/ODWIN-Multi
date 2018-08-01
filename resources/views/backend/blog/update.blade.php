<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'Pages';
	$breadcrumb[1]['url'] = url('backend/blog-content');	
	$breadcrumb[2]['title'] = 'Add';
	$breadcrumb[2]['url'] = url('backend/blog-content/create');
	if (isset($data)){
		$breadcrumb[2]['title'] = 'Edit';
		$breadcrumb[2]['url'] = url('backend/blog-content/'.$data[0]->id.'/edit');
	}
?>

<?php
	$cover_1 = [];
	if (isset($data)){
		$cover_1 = $data[0];
		$cover_1->field = 'featured_image';
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
    Blog - Content - <?=$mode;?>
@endsection

<!-- CONTENT -->
@section('content')
	<?php
        $featured_image = 0;
		$active = 1;
		$method = "POST";
		$mode = "Create";
        $url = "backend/blog-content/";
        $category_id = 0;
		if (isset($data)){
            $featured_image = $data[0]->featured_image;
            $active = $data[0]->active;
            $category_id = $data[0]->category_id;
			$method = "PUT";
			$mode = "Edit";
			$url = "backend/blog-content/".$data[0]->id;
		}
	?>
	<div class="page-title">
		<div class="title_left">
			<h3>Blog - Content - <?=$mode;?></h3>
		</div>
		<div class="title_right">
			<div class="col-md-4 col-sm-4 col-xs-8 form-group pull-right top_search">
                @include('backend.elements.back_button',array('url' => '/backend/blog-content'))
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
							<label class="control-label col-sm-3 col-xs-12">Level</label>
							<div class="col-sm-3 col-xs-12">
								{{
								Form::select(
									'category_id',
									$category,
									$category_id,
									array(
										'class' => 'form-control',
									))
								}}								
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-sm-3 col-xs-12">Image</label>
                            <div class="col-sm-6 col-xs-9">
                                <input type="hidden" name="featured_image" value=<?=$featured_image;?> id="id-cover-image_1">
                                @include('backend.elements.change_cover',array('cover' => $cover_1, 'id_count' => 1))	
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-sm-3 col-xs-12">Status: </label>
                            <div class="col-sm-5 col-xs-12">
                                {{
                                Form::select(
                                    'active',
                                    ['1' => 'Publish', '2' => 'Draft'],
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
                                    $judul = "";
                                    $caption_img = "";
                                    $detail = "";
                                    foreach ($active_language as $language):
                                        $active = "";
                                        if ($default_language->code == $language->code){
                                            $active = "active in";
                                        }
                                        if (isset($data)){
                                            $judul = "";
                                            foreach ($data_language as $data_language_single):
                                                if ($data_language_single->language_code == $language->code){
                                                    $judul = $data_language_single->judul;
                                                    $caption_img = $data_language_single->caption_img;
                                                    $detail = $data_language_single->detail;
                                                }
                                            endforeach;
                                        }
                                ?>
                                <div role="tabpanel" class="tab-pane fade <?=$active;?>" id="tab-<?=$language->code;?>" aria-labelledby="<?=$language->code;?>">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-xs-12">Title <span class="required">*</span></label>
                                        <div class="col-sm-7 col-xs-12">
                                            <input type="text" name="judul_<?=$language->code;?>" required="required" class="form-control" value="<?=$judul;?>" autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-xs-12">Image caption </label>
                                        <div class="col-sm-5 col-xs-12">
                                            <input type="text" name="caption_img_<?=$language->code;?>" class="form-control" value="<?=$caption_img;?>" autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12 col-xs-12">Content</label>
                                        <div class="col-sm-12 col-xs-12">
                                            <textarea name="detail_<?=$language->code;?>" id="editor_<?=$language->code;?>" rows="10" cols="80" class="form-control"><?=$detail;?></textarea>
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
                                <a href="<?=url('/backend/blog-content')?>" class="btn btn-warning">Cancel</a>
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