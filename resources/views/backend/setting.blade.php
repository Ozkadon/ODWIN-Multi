<?php
    $userinfo = Session::get('userinfo');
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'Setting';
	$breadcrumb[1]['url'] = url('backend/setting');
?>

<!-- LAYOUT -->
@extends('backend.layouts.main')

<!-- TITLE -->
@section('title', 'Setting')

<!-- CONTENT -->
@section('content')
	<div class="page-title">
		<div class="title_left" style="width : 100%">
			<h3>Setting</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	@include('backend.elements.breadcrumb',array('breadcrumb' => $breadcrumb))
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
                    @include('backend.elements.notification')
                    {{ Form::open(['url' => 'backend/setting', 'method' => 'POST','class' => 'form-horizontal', 'files' => true]) }}
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab_content1" id="general-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="general-tab">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 col-xs-12">Website Title</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="1" placeholder="Title" autocomplete="off" value="<?=getData('web_title')?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3 col-xs-12">Website Description</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="4" placeholder="Description" autocomplete="off" value="<?=getData('web_description')?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3 col-xs-12">Website Logo <br/><small>Max file size : 1Mb</small></label>
                                    <div class="col-sm-4 col-xs-12">
                                        <input type="file" name="logo" class="dropify" data-default-file="<?=url(getData('logo'))?>"/>
                                        <input type="hidden" name="default_logo" value=<?=url(getData('logo'))?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3 col-xs-12">Email Admin</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <textarea type="text" class="form-control" name="3" rows=5><?=getData('email_admin')?></textarea>
                                        <span class="text-help">
                                                    If there is more than one email, use enter as delimiter<br/>
                                                    Example :<br/>
                                                    email_1<br/>
                                                    email_2
                                        </span>
                                    </div>
                                </div>
                                <!-- MULTILANGUAGE -->
                                <?php
                                    /* 	SUPER ADMIN	 */
                                    $hide = "";
                                    $multi_language = getData('multi_language');
                                    if ($userinfo['user_level_id'] != 1){
                                        $hide = "hide";
                                    }												
                                ?>
                                <div class="<?php echo $hide ?>">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Default Language</label>
                                        <div class="col-sm-2">
                                            <select name="default_language" id="default_language" class="form-control">
                                                <?php
                                                    foreach ($language as $language_detail):
                                                        $selected = "";
                                                        if ($default_language->id == $language_detail->id){
                                                            $selected = "selected";
                                                        }
                                                ?>
                                                    <option <?php echo $selected; ?> value="<?php echo $language_detail->id ?>"><?php echo $language_detail->code ?> - <?php echo $language_detail->name ?></option>
                                                <?php
                                                    endforeach;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <?php
                                                $checked = "";
                                                if ($multi_language == 1){
                                                    $checked = "checked";
                                                }
                                            ?>
                                            <input id="multi_language" name="multi_language" type="checkbox" value=1 <?php echo $checked ?>> Multi Language
                                        </div>
                                    </div>
                                    <?php
                                        $hide = "";
                                        if ($multi_language == 0){
                                            $hide = "hide";
                                        }
                                    ?>
                                    <div class="multi_language_detail <?php echo $hide; ?>">
                                        <div class="form-group">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-3">
                                                <div style="border : 1px solid #abc; padding : 5px 0 5px 10px" id="multiple_checkbox_language">
                                                    <?php
                                                        foreach ($language as $language_detail):
                                                            $checked = "";
                                                            if ($language_detail->active == 1){
                                                                $checked = "checked";
                                                            }
                                                            $disabled = "";
                                                            if ($language_detail->default == 1){
                                                                $disabled = "disabled";
                                                            }
                                                    ?>
                                                        <input name='multi_language_checkbox[]' value="<?php echo $language_detail->id ?>" class="checkbox_language" id="checkbox_language_<?php echo $language_detail->id ?>" <?php echo $checked ?> <?php echo $disabled; ?> type="checkbox" > <?php echo $language_detail->code ?> - <?php echo $language_detail->name ?><br/>
                                                    <?php
                                                        endforeach;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="add_more">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-3">
                                                <button class="btn-add btn btn-block btn-primary">Add More Language...</button>
                                            </div>
                                        </div>
                                        <div class="form-group hide" id="add_more_form">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-2" style="padding-right : 0px;">
                                                <input type="text" class="form-control" id="language_code" placeholder="Language Code">
                                            </div>
                                            <div class="col-sm-2" style="padding-left : 5px;padding-right : 0px;">
                                                <input type="text" class="form-control" id="language_name" placeholder="Language Name">
                                            </div>
                                            <div class="col-sm-1" style="padding-left : 5px;padding-right : 0px;">
                                                <button class="btn-save btn btn-block btn-primary">Save</button>
                                            </div>
                                            <div class="col-sm-1" style="padding-left : 5px;padding-right : 0px;">
                                                <button class="btn-cancel btn btn-block btn-default">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END MULTLANGUAGE -->
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-9 col-sm-offset-3">
                                    <button type="submit" class="btn btn-primary btn-block">Submit </button>
                                </div>
                            </div>
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
    <link href="<?=url('vendors/dropify/css/dropify.min.css');?>" rel="stylesheet">
@endsection

<!-- JAVASCRIPT -->
@section('script')
    <script src="<?=url('vendors/dropify/js/dropify.js');?>"></script>
    <script>
        $('.dropify').dropify();
    </script>
    <script>
		$(".btn-add").on("click",function(e){
			e.preventDefault();
			$("#add_more").addClass("hide");
			$("#add_more_form").removeClass("hide");
		});
		
		$(".btn-cancel").on("click",function(e){
			e.preventDefault();
			$("#add_more").removeClass("hide");
			$("#add_more_form").addClass("hide");
			$("#language_code").val("");
			$("#language_name").val("");
		});

		$(".btn-save").on("click",function(e){
			e.preventDefault();
			var code_form = $("#language_code").val();
			var name_form = $("#language_name").val();
			
			if (code_form == "" || name_form == ""){
				alert("Invalid data. Languange Code or Language Name required");
				return false;
			} else {
				$.post( "<?=url('/backend/setting/check-language');?>", { code: code_form, name: name_form, '_token' : '{{ csrf_token() }}' },function(data){
					if (data == 1){
						alert("Invalid data. Duplicate language code");
						return false;
					} else{
						$("#add_more").removeClass("hide");
						$("#add_more_form").addClass("hide");
						$.post( "<?=url('/backend/setting/insert-language');?>", { code: code_form, name: name_form, '_token' : '{{ csrf_token() }}' },function(data){
							$("#language_code").val("");
							$("#language_name").val("");
							
							var o = new Option(name_form, data);
							/// jquerify the DOM object 'o' so we can use the html method
							$(o).html(code_form.toUpperCase() + " - " + name_form);
							$("#default_language").append(o);
			
							$("#multiple_checkbox_language").append("<input name='multi_language_checkbox[]' value='"+data+"' class='checkbox_language' id='checkbox_language_"+data+"' checked type='checkbox'> "+code_form.toUpperCase()+" - "+name_form+" <br/>");
						});
					}
				});
			}
		});

		$("#multi_language").on("change",function(){
            if($(this).prop("checked") == true){
				$(".multi_language_detail").removeClass("hide");
            }
            else if($(this).prop("checked") == false){
                $(".multi_language_detail").addClass("hide");
            }			
		});
		
		$("#default_language").on("change", function(){
			var id = $(this).val();
			$(".checkbox_language").removeAttr("disabled");
			$("#checkbox_language_"+id).prop("checked", true);
			$("#checkbox_language_"+id).attr("disabled", "disabled");
		});

    </script>    
@endsection