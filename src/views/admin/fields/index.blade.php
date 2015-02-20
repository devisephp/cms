@extends('devise::admin.layouts.master')

@section('css')

    <link href="<?= URL::asset('/packages/devisephp/cms/css/spectrum.css') ?>" rel="stylesheet" >
    <link href="<?= URL::asset('/packages/devisephp/cms/css/jquery.datetimepicker.css') ?>" rel="stylesheet" >

    <link href="<?= URL::asset('/packages/devisephp/cms/css/obsidian.min.css') ?>" rel="stylesheet" >
    <script type="text/javascript" src="<?= URL::asset('/packages/devisephp/cms/js/lib/highlight.pack.js') ?>"></script>

    <!-- some weird style that I'm just overriding so I can see the listed attributes -->
    <style>
        /*.dvs-test-block table tr:nth-child(odd) td {
            background-color: transparent;
        }*/
    </style>


@stop

@section('title')
    <div id="dvs-admin-title">
        <h1>Editor Examples</h1>
    </div>
@stop


@section('main')

    <table class="dvs-admin-table dvs-test-blocks">

        <tbody>

        @foreach (['model-creator', 'model', 'model-attribute', 'model-group',
            'audio', 'checkbox-group', 'checkbox', 'color',
            'datetime', 'file', 'html', 'image',
            'link', 'map', 'select', 'text', 'textarea',
            'video', 'wysiwyg', 'groups', 'collections', 'hidden-fields'] as $type)
            <tr>
                <td>
                    @include("devise::admin.fields.types.{$type}")
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    @include('devise::scripts')
    <script>hljs.initHighlightingOnLoad();</script>

@stop