@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-ios-people"></span> Groups</h1>
    </div>
@stop

@section('subnavigation')
    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-groups-create'), 'Create New Group', array('class'=>'dvs-button dvs-button-secondary')) ?>
    </div>
@stop

@section('main')
    @if ($groups->count() == 0)
        <h3>No groups found.</h3>
    @else
        <table class="dvs-admin-table">
            <thead>
                <th class="dvs-tac"><?= Sort::link('id','Id') ?></th>
                <th class="dvs-tac"><?= Sort::link('name','Name') ?></th>
                <th class="dvs-tac"><?= Sort::link('created_at','Created') ?></th>
                <th><?= Sort::clearSortLink('Clear Sort', array('class'=>'dvs-button dvs-button-small dvs-button-outset')) ?></th>
            </thead>

            <tbody>
                @foreach($groups as $group)
                    <tr>
                        <td class="dvs-tac"><?= $group->id ?></td>
                        <td class="dvs-tac"><?= $group->name ?></td>
                        <td class="dvs-tac"><?= date("m/d/Y", strtotime($group->created_at)) ?></td>
                        <td class="dvs-tac dvs-button-group">
                            <a class="dvs-button dvs-button-small" href="<?= route('dvs-groups-edit', $group->id) ?>">Edit</a>
                            <?= Form::delete(route('dvs-groups-destroy', $group->id), 'Delete', null, array('class'=>'dvs-button dvs-button-small dvs-button-danger')) ?>
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="4"><?= $groups->appends(Input::except(['page']))->render() ?></td>
                </tr>
            </tfoot>
        </table>
    @endif
@stop