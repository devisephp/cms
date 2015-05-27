@extends('devise::admin.layouts.master')

@section('css')
    @include('devise::assets')
@stop

@section('title')
    <div id="dvs-admin-title">
        <h1>Editor Examples</h1>
    </div>
@stop


@section('main')

    <table class="dvs-admin-table dvs-test-blocks">

        <tbody>

        @foreach (['model-with-page-version', 'model-creator', 'model', 'model-attribute', 'model-group',
            'audio', 'checkbox-group', 'checkbox', 'color',
            'datetime', 'file', 'html', 'image',
            'link', 'map', 'select', 'text', 'textarea',
            'video', 'wysiwyg', 'groups', 'groups-with-categories', 'groups-mixed', 'collections', 'hidden-fields'] as $type)
            <tr>
                <td>
                    @include("devise::admin.fields.types.{$type}")
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <script>hljs.initHighlightingOnLoad();</script>
@stop