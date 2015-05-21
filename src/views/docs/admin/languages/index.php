# Languages

### Language-Related Configuration:

The Primary Language Id is set inside the language config:

``` php
config\devise\languages.php

return array(
    'primary_language_id' => 45
);
```

### Common Language Repository Methods:

For our examples, we will need an instance of LanguagesRepository"
``` php
$LanguagesRepository = new Devise\Languages\LanguagesRepository;
```

*Get Paginated List of All Languages*
``` php
$allLanguages = $LanguagesRepository->languages();
```

*Get Active Languages List*
``` php
$activeLanguages = $LanguagesRepository->activeLanguageList();
```

*Get Language for Current Request & User*
``` php
$currentLanguage = $LanguagesRepository->currentLanguage();
```

*Get List of Available Languages for a Page*
``` php
$languagesListForPage = $LanguagesRepository->languageSelectorOptions($page);
```

*Find Language for by Page Version Id*
``` php
$pageVersionLanguage = $LanguagesRepository->findLanguageForPageVersion($pageVersionId);
```

### Examples of Usage

*Building Dropdown of Active Languages For a Page*
``` php
// get all active languages
$activeLanguages = $LanguagesRepository->languageSelectorOptions($page);

Form::select('language_id', $activeLanguages, (!Input::has('language_id')) ? Config::get('devise.languages.primary_language_id') : Input::get('language_id'), array('id' => 'lang-select', 'class' => 'dvs-select dvs-button-solid'))
```

### Notes About Languages

- Make any language active by checking the "active" checkbox on the admin index.
- Standardization is supported by using the two-letter ("ISO 639-1") code for each language.