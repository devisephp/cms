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

*Get Paginated List of All Languages*
``` php
$allLanguages = Devise\Languages\LanguagesRepository.languages();
```

*Get Active Languages List*
``` php
$activeLanguages = Devise\Languages\LanguagesRepository.activeLanguageList();
```

*Get Language for Current Request & User*
``` php
$currentLanguage = Devise\Languages\LanguagesRepository.currentLanguage();
```

*Get List of Available Languages for a Page*
``` php
$languagesListForPage = Devise\Languages\LanguagesRepository.languageSelectorOptions($page);
```

*Find Language for by Page Version Id*
``` php
$pageVersionLanguage = Devise\Languages\LanguagesRepository.findLanguageForPageVersion($pageVersionId);
```

### Examples of Usage

*Building Dropdown of Active Languages For a Page*
``` php
// get all active languages
$activeLanguages = Devise\Languages\LanguagesRepository.languageSelectorOptions($page);

Form::select('language_id', $activeLanguages, (!Input::has('language_id')) ? Config::get('devise.languages.primary_language_id') : Input::get('language_id'), array('id' => 'lang-select', 'class' => 'dvs-select dvs-button-solid'))
```

### Notes About Languages

- Make any language active by checking the "active" checkbox on the admin index.
- Standardization is supported by using the two-letter ("ISO 639-1") code for each language.