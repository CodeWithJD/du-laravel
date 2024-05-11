@extends('admin.layouts.master')
@section('title')
    @lang('Users List')
@endsection
@section('content')
    @component('admin.components.breadcrumb')
        @slot('li_1')
            Dashboards
        @endslot
        @slot('title')
            Edit User
        @endslot
    @endcomponent

    @dump($user)

@endsection
@section('script')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
