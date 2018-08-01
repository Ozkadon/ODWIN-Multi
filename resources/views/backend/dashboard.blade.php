<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
?>

<!-- LAYOUT -->
@extends('backend.layouts.main')

<!-- TITLE -->
@section('title', 'Dashboard')

<!-- CONTENT -->
@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3>Dashboard</h3>
        </div>
        <div class="title_right">
        </div>
    </div>
    <div class="clearfix"></div>
    @include('backend.elements.breadcrumb',array('breadcrumb' => $breadcrumb))	
    <div class="row">
        <div class="col-xs-12">
            <div class="">
                <div class="row top_tiles">
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-user"></i></div>
                            <div class="count"><?=number_format($data['new_user'],0);?></div>
                            <h3>New Sign ups</h3>
                            <p>Last 7 days</p>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-users"></i></div>
                            <div class="count"><?=number_format($data['total_user'],0);?></div>
                            <h3>Total Users</h3>
                            <p>All time</p>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-file"></i></div>
                            <div class="count"><?=number_format($data['new_blog'],0);?></div>
                            <h3>New Blog</h3>
                            <p>Last 7 days</p>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-file-text"></i></div>
                            <div class="count"><?=number_format($data['total_blog'],0);?></div>
                            <h3>Total Blog</h3>
                            <p>All time</p>
                        </div>
                    </div>                                        
                </div>
            </div>

        </div>
    </div>
@endsection