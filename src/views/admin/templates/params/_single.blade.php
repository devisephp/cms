<!-- Ensures booleans are properly handled -->
@if(is_bool($parameter))
    @php $parameter = ($parameter) ? 'true' : 'false';  @endphp
@endif

@php
    preg_match_all('/{(.*?)}/', $parameter, $matches);
@endphp

@if(isset($matches[1]) && count($matches[1]))
    @php
        $parameterForShow = $matches[1][0];
    @endphp
@endif


<div class="dvs-param-wrapper dvs-inline-block" data-var-type="<?=$varType?>">
    <?= Form::hidden('template[vars]['.$var.'][params][]', $parameter) ?>

    <div class="dvs-badge">
        <?= (isset($parameterForShow)) ? $parameterForShow : $parameter ?>&nbsp;
        <a href="javascript:void(0)" class="dvs-button dvs-button-small dvs-remove-param dvs-pr">X</a>
    </div>
</div>