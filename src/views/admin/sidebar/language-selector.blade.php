<div id="dvs-sidebar-language-selector">
    <select class="dvs-select" name="other_languages">
        @foreach ($availableLanguages as $language)
        <option value="<?= $language['url']  ?>"><?= $language['code'] ?></option>
        @endforeach
    </select>
</div>
