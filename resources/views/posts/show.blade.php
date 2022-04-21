<?php

use Carbon\Carbon;

$date = Carbon::parse("{$post['created_at']}", 'UTC');
$formatedDate = $date->format('l jS \\of F Y h:i:s A');
?>
@extends('layouts.app')

@section('title') View post @endsection

@section('content')
<div class="card my-5">
    <div class="card-header"> Post info </div>
    <div class="card-body">
        <h5 class="card-title">Title : {{$post['title']}} </h5>
        <h5 class="card-title">Description : {{$post['description']}}</h5>

    </div>
</div>

<div class="card">
    <div class="card-header"> Post creator info </div>
    <div class="card-body">
        <h5 class="card-title">Name : {{$post->user ? $post->user->name : 'Not Found'}}</h5>
        <h5 class="card-title">Email : {{$post->user ? $post->user->email : 'Not Found'}}</h5>
        <h5 class="card-title">CreatedAt : {{$post->user ? $formatedDate : 'Not determined'}}</h5>

    </div>
</div>
@endsection