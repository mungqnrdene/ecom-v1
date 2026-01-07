@extends('layouts.user')
@section('title', 'Dashboard')

@section('page')
    @php
        $currentSection = $section ?? 'dashboard';
    @endphp
    @includeIf("users.dashboard.sections.{$currentSection}", $data ?? [])
@endsection
