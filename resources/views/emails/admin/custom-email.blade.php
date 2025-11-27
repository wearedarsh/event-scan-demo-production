@extends('emails.layouts.main')

@section('content')
    {!! $custom_html_content !!}
    <br>
    {!! $signature_html !!}
@endsection
