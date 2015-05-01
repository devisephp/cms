<?php namespace Devise\Sidebar;

use View;
use Devise\Pages\PagesRepository;
use Devise\Pages\Fields\FieldsRepository;
use Devise\Pages\Fields\FieldManager;

/**
 * Class SidebarManager fetches the partial sidebar view
 * for the given input data
 *
 * @package Devise\Sidebar
 */
class SidebarManager
{
    /**
     * @var SidebarDataTranslator
     */
    private $SidebarDataTranslator;

    /**
     * @var PagesRepository
     */
    private $PagesRepository;

    /**
     * @var FieldsRepository
     */
    private $FieldsRepository;

    /**
     * @var ModelMapper
     */
    private $ModelMapper;

    /**
     * @var $FieldManager
     */
    private $FieldManager;

    /**
     * Create a new sidebar manager
     *
     * @param SidebarDataTranslator $SidebarDataTranslator
     * @param PagesRepository $PagesRepository
     * @param FieldsRepository  [varname] [description]
     */
	public function __construct(SidebarDataTranslator $SidebarDataTranslator, PagesRepository $PagesRepository, FieldsRepository $FieldsRepository, ModelMapper $ModelMapper, FieldManager $FieldManager, $View = null)
	{
		$this->SidebarDataTranslator = $SidebarDataTranslator;
		$this->PagesRepository = $PagesRepository;
        $this->FieldsRepository = $FieldsRepository;
        $this->ModelMapper = $ModelMapper;
        $this->FieldManager = $FieldManager;
        $this->View = $View ?: \View::getFacadeRoot();
	}

    /**
     * Fetches the corresponding html views for this sidebar from the input data
     *
     * @param $inputData
     * @return mixed
     */
	public function fetchPartialView($inputData)
	{
        $type = isset($inputData['type']) ? $inputData['type'] : 'none';

        switch ($type)
        {
            case 'model':            return $this->fetchPartialModelView($inputData);
            case 'attribute':        return $this->fetchPartialModelAttributeView($inputData);
            case 'model_collection': return $this->fetchPartialModelCollectionView($inputData);
            case 'model_creator':    return $this->fetchPartialModelCreatorView($inputData);
            case 'none':
            default:                 return $this->fetchPartialFieldView($inputData);
        }
	}

    /**
     * Fetches the sidebar form for this specific type of element
     *
     * @param  array $inputData
     * @return view
     */
    public function fetchElementView($inputData)
    {
        $fieldId = array_get($inputData, 'field_id');
        $fieldScope = array_get($inputData, 'field_scope', 'page');
        $element = $this->FieldsRepository->findFieldByIdAndScope($fieldId, $fieldScope);
        $pageRoutes = $this->PagesRepository->getRouteList();
        return $this->View->make('devise::admin.sidebar._'.$element->type, compact('element','pageRoutes'))->render();
    }

    /**
     * Fetches the grid of items that lists all the elements we can
     * click on and bring up the edit form for
     *
     * @param  array $inputData
     * @return view
     */
    public function fetchElementGridView($inputData)
    {
        $data = $this->SidebarDataTranslator->translateFromInputArray($inputData);
        return $this->View->make('devise::admin.sidebar._sidebar-elements-grid', compact('data'))->render();
    }

    /**
     * Update the model in this input data
     *
     * @param  array $inputData
     * @return array
     */
    public function updateModel($inputData)
    {
        return $this->ModelMapper->update($inputData['class_name'], $inputData['key'], $inputData['page_version_id'], $inputData['forms']);
    }

    /**
     * Create a new model using this input data
     *
     * @param  array $inputData
     * @return array
     */
    public function createModel($inputData)
    {
       return $this->ModelMapper->create($inputData['class_name'], $inputData['page_version_id'], $inputData['forms']);
    }

    /**
     * Save the groups passed in
     *
     * @param  array $inputData
     * @return array
     */
    public function updateGroup($inputData)
    {
        foreach ($inputData['groups'] as $group)
        {
            if ($group['type'] == 'model' || $group['type'] == 'attribute')
            {
                $this->ModelMapper->update($group['class_name'], $group['key'], $inputData['page_version_id'], $group['forms']);
            }
            else
            {
                $fieldData = reset($group['forms']);
                $fieldId = key($group['forms']);
                $this->FieldManager->updateField($fieldId, $fieldData);
            }
        }
    }

    /**
     * Fetch the field partial view
     *
     * @param  array $inputData
     * @return view
     */
    protected function fetchPartialFieldView($inputData)
    {
        $data = $this->SidebarDataTranslator->translateFromInputArray($inputData);
        $availableLanguages = $this->PagesRepository->availableLanguagesForPage($inputData['page_id']);
        $pageRoutes = $this->PagesRepository->getRouteList();
        $pageVersions = $this->PagesRepository->getPageVersions($inputData['page_id'], $inputData['page_version_id']);

        return $this->View->make('devise::admin.sidebar.main', compact('data', 'pageVersions', 'availableLanguages', 'pageRoutes'))->render();
    }

    /**
     * Fetch the model view partial
     *
     * @param  array $inputData
     * @return view
     */
    protected function fetchPartialModelView($inputData)
    {
        $className = $inputData['elements'][0]['class'];
        $key = $inputData['elements'][0]['key'];
        $humanName = $inputData['elements'][0]['humanName'];
        $fields = $this->getFieldsFromElement($inputData['elements'][0]);

        $data = [
            'page_id' => $inputData['page_id'],
            'page_version_id' => $inputData['page_version_id'],
            'human_name' => $humanName,
            'class_name' => $className,
            'key' => $key,
            'fields' => $fields,
            'availableLanguages' => $this->PagesRepository->availableLanguagesForPage($inputData['page_id']),
            'pageRoutes' => $this->PagesRepository->getRouteList(),
            'pageVersions' => $this->PagesRepository->getPageVersions($inputData['page_id'], $inputData['page_version_id']),
        ];

        return $this->View->make('devise::admin.sidebar.model', $data)->render();
    }

    /**
     * Fetch the model attribute partial view
     *
     * @param  array $inputData
     * @return view
     */
    protected function fetchPartialModelAttributeView($inputData)
    {
        $className = $inputData['elements'][0]['class'];
        $key = $inputData['elements'][0]['key'];
        $humanName = $inputData['elements'][0]['humanName'];
        $attribute = $inputData['elements'][0]['attribute'];
        $fields = $this->getFieldsFromElement($inputData['elements'][0]);

        $data = [
            'page_id' => $inputData['page_id'],
            'page_version_id' => $inputData['page_version_id'],
            'human_name' => $humanName,
            'class_name' => $className,
            'key' => $key,
            'fields' => $fields,
            'attribute' => $attribute,
            'availableLanguages' => $this->PagesRepository->availableLanguagesForPage($inputData['page_id']),
            'pageRoutes' => $this->PagesRepository->getRouteList(),
            'pageVersions' => $this->PagesRepository->getPageVersions($inputData['page_id'], $inputData['page_version_id']),
        ];

        return $this->View->make('devise::admin.sidebar.model-attribute', $data)->render();
    }

    /**
     * Fetch the model collection partial view
     *
     * @param  array $inputData
     * @return view
     */
    protected function fetchPartialModelCollectionView($inputData)
    {
        $groups = [];

        $data = [
            'collection_name' => $inputData['collection'],
            'human_name' => $inputData['collection'],
            'page_id' => $inputData['page_id'],
            'page_version_id' => $inputData['page_version_id'],
            'availableLanguages' => $this->PagesRepository->availableLanguagesForPage($inputData['page_id']),
            'pageRoutes' => $this->PagesRepository->getRouteList(),
            'pageVersions' => $this->PagesRepository->getPageVersions($inputData['page_id'], $inputData['page_version_id']),
        ];

        foreach ($inputData['groups'] as $group)
        {
            foreach ($group as $element)
            {
                $groups[] = $this->getGroupDataFromElement($element, count($groups), $data);
            }
        }

        $data['groups'] = $groups;

        return $this->View->make('devise::admin.sidebar.model-collection', $data)->render();
    }

    /**
     * Fetch the model creator partial sidebar view
     *
     * @param  array $inputData
     * @return view
     */
    protected function fetchPartialModelCreatorView($inputData)
    {
        $element = $inputData['elements'][0];

        $fields = $this->getFieldsFromElement($element);

        $data = [
            'page_id' => $inputData['page_id'],
            'page_version_id' => $inputData['page_version_id'],
            'human_name' => $element['human_name'],
            'class_name' => $element['model_name'],
            'fields' => $fields,
            'availableLanguages' => $this->PagesRepository->availableLanguagesForPage($inputData['page_id']),
            'pageRoutes' => $this->PagesRepository->getRouteList(),
            'pageVersions' => $this->PagesRepository->getPageVersions($inputData['page_id'], $inputData['page_version_id']),
        ];

        return $this->View->make('devise::admin.sidebar.model-creator', $data)->render();
    }

    /**
     * Constructs a list of groups from the element
     *
     * @param  array $element
     * @param  string $cid
     * @param  string $view
     * @param  array $fields
     * @return StdClass
     */
    protected function getGroupDataFromElement($element, $index, $masterData)
    {
        $key = '';
        $type = $element['type'];
        $fields = $this->getFieldsFromElement($element);

        switch ($type)
        {
            case 'model':
                $key = $fields[0]->dvs_model_field->model_id;
                $className = $fields[0]->dvs_model_field->model_type;
            break;

            case 'attribute':
                $key = $fields[0]->dvs_model_field->id;
                $className = $fields[0]->dvs_model_field->model_type;
            break;

            default:
                $key = $fields[0]->id;
                $className = "";
            break;
        }

        $viewData = array_merge($masterData, [
            'fields' => $fields,
            'element' => $fields[0]
        ]);

        $group = new \StdClass;
        $group->index = $index;
        $group->key = $key;
        $group->type = $type;
        $group->cid = 'group' . $index;
        $group->class_name = $className;
        $group->human_name = $element['humanName'];
        $group->view = $this->View->make('devise::admin.sidebar._' . $type, $viewData)->render();
        $group->fields = $fields;
        $group->display = $index == 0 ? 'block' : 'none';
        $group->active = $index == 0 ? 'dvs-active' : '';

        return $group;
    }

    /**
     * Assistance function that will allow us to fetch
     * fields for a given element (it uses it's type to
     * determine how to do the fetching). Right now there
     * are 3 types, model, attribute, and field
     *
     * @param  array $element
     * @return array
     */
    protected function getFieldsFromElement($element)
    {
        $type = $element['type'];

        if ($type === 'model')
        {
            $lookup = $this->ModelMapper->lookupWithKey($element['class'], $element['key']);
            return $lookup->fields;
        }

        if ($type === 'attribute')
        {
            $lookup = $this->ModelMapper->lookupWithKey($element['class'], $element['key']);
            return [ $this->getFieldByModelAttribute($lookup->fields, $element['attribute'], $element['class']) ];
        }

        if ($type === 'model_creator')
        {
            $lookup = $this->ModelMapper->lookupWithoutKey($element['model_name']);
            return $lookup->fields;
        }

        //
        // should we account for other field types here later?
        // that might be neat but not sure how it would work
        // we can think about that later I suppose ... for now
        // we only accept models and attributes in this group
        //

        return [];
    }

    /**
     * Picks out the attribute field from this array of fields for
     * a given model
     *
     * @param  array  $fields
     * @param  string $attribute
     * @param  string $className
     * @return \StdClass
     */
    protected function getFieldByModelAttribute($fields, $attribute, $className)
    {
        foreach ($fields as $field)
        {
            if (array_key_exists($attribute, $field->picks))
            {
                return $field;
            }
        }

        throw new \Exception('Could not find the attribute "' . $attribute . '"for this model "' . $className . '"');
    }

}