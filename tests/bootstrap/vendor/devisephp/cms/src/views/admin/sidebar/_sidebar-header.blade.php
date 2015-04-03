    <div id="dvs-sidebar-title">
        <h1><?= $title ?></h1>

        <a class="dvs-sidebar-close dvs-button dvs-button-danger dvs-button-solid dvs-button-tiny"><span class="ion-android-close"></span></a>

        @if(isset($availableLanguages) && count($availableLanguages) > 1)
        <div id="dvs-sidebar-language-selector">
            <select class="dvs-select dvs-select-small" name="other_languages">
                @foreach ($availableLanguages as $language)
                <option value="<?= $language['url']  ?>"><?= $language['code'] ?></option>
                @endforeach
            </select>
        </div>
        @endif
    </div>