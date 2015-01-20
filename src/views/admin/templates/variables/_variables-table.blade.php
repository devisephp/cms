<div class="dvs-admin-items-wpr">
    <h4>Variables <div class="dvs-pr dvs-fr"><a class="dvs-add-button" href="{{ URL::route('dvs-templates-var-create', $params['templatePath']) }}">Add New Variable</a></div></h4>

    <table class="dvs-admin-items">
        @if(count($template['vars']))
            @foreach($template['vars'] as $var => $varDataArr)

            @php
                if(is_array($varDataArr)) {
                    $pathAndMethod = explode('.', key($varDataArr));
                } else {
                    $pathAndMethod = explode('.', $varDataArr);
                }

                $classPath = array_shift($pathAndMethod);
                $methodName = is_array($pathAndMethod) ? array_shift($pathAndMethod) : '';
                $fullPath = $classPath . '.' . $methodName;
            @endphp


            <tr id="dvs-var-{{$var}}" class="dvs-var-item" data-var-type="vars">
                <td class="dvs-form-group">
                    <a href="javascript:void(0)" class="dvs-button dvs-button-small dvs-remove-row dvs-pl">X</a>

                    {{ Form::text('template[vars]['.$var.'][varName]', $var) }}
                    {{ Form::text('template[vars]['.$var.'][classPath]', $classPath) }}
                    {{ Form::text('template[vars]['.$var.'][methodName]', $methodName) }}

                    @if(is_array($varDataArr))

                        @foreach($varDataArr[$fullPath] as $key => $parameter)

                            @include('devise::admin.templates.params._single', ['varType' => 'vars'])

                        @endforeach

                    @else

                        <div class="dvs-param-wrapper dvs-inline-block">&nbsp;</div>

                    @endif

                    <a href="{{ URL::route('dvs-templates-param-create') }}?varName={{$var}}" class="dvs-button dvs-button-small dvs-add-button">+</a>
                </td>
            </tr>
            @endforeach

        @else

            <tr id="no-variables">
                <td class="dvs-form-group">No variables have been set for template.</td>
            </tr>

        @endif
    </table>


    @include('devise::admin.templates.variables._new-variables-table')
</div>