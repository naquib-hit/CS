@extends('layouts.app', ['title' => __('project.title')])

@section('css')
@endsection

@section('content')
<div class="row h-100">
    <div class="col-4">
        <div class="table-reponsive"></div>
    </div>
    <div class="col-8">
        <form class="card">
            <fieldset class="card-header"></fieldset>
            <fieldset class="card-body">
                <div class="input-group input-group-outline">
                    <label class="form-label">{{ __() }}</label>
                    <input type="text" class="form-control" name="notice-name">
                </div>
                <div class="input-group input-group-outline">
                    <label class="form-label"></label>
                    <input type="text" class="form-control" name="notice-content">
                </div>
            </fieldset>
            <fieldset class="card-footer"></fieldset>
        </form>
    </div>
</div>
@endsection

@section('js')
@endsection