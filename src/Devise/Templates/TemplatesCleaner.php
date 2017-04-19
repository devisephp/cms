<?php namespace Devise\Templates;

use App;
use DB;
use Devise\Pages\PagesRepository;
use Devise\Pages\Viewvars\DataBuilder;

/**
 * Class TemplatesCleaner handles cleaning of orphan fields
 * when a template (*.blade.php) file has been altered
 */
class TemplatesCleaner
{

    /**
     * Construct a new template manager
     *
     * @param Validator $Validator
     */
	public function __construct(PagesRepository $PagesRepository, DataBuilder $DataBuilder)
    {
        $this->PagesRepository = $PagesRepository;
        $this->DataBuilder = $DataBuilder;
    }

    /**
     * removes all fields and collection from database
     * @param string $templateName
     * @return void
     */
    public function clearTemplateFields($templateName)
    {
        DB::beginTransaction();

        try {
        
            $page = $this->fakeAPageRender($templateName);

            $keys = $this->getActiveKeys();
            
            $allIds = $this->getIdsToDelete($templateName, $keys, $page->version->id);
            
            $this->deleteFields($allIds['fields']);

            $this->deleteCollectionInstances($allIds['collection_instances']);

            $this->deleteCollections($allIds['collections']);

        } catch(\Exception $e) {
            // if anything guest wrong, rollback the database changes.
            DB::rollback();
            
            throw $e;

        }

        DB::commit();

        return true;
    }

    /**
     * takea view name, finds a route that uses the view
     * runds databuilder, and renders the view as if it were being returned in a route
     *
     * @param string $view
     */
    private function fakeAPageRender($view)
    {
        $routeWithoutParams = DB::table('dvs_pages')
                                    ->where('view', $view)
                                    ->where('slug','NOT LIKE','%{%')
                                    ->select('route_name')
                                    ->first();

        $page = $this->PagesRepository->findByRouteName($routeWithoutParams->route_name);
        $this->DataBuilder->setData( ['page'=>$page, 'input'=>[], 'params'=>[]] );

        $pageData = $this->DataBuilder->getData();

        // allow a page version to override the page view
        $view = $page->version->view ?: $page->view;
        view($view, $pageData)->render();

        return $page;
    }

    /**
     * takea view name, finds a route that uses the view
     * runds databuilder, and renders the view as if it were being returned in a route
     *
     * @param string $view
     */
    private function getActiveKeys()
    {
        $dvsPageData = json_decode(str_replace("\'", "'", App::make('dvsPageData')->toJSON()));
        $keys = [];

        $this->keySearch($keys, $dvsPageData);

        return array_unique($keys);
    }

    /**
     * builds an array of ids that need to be deleted
     *
     * @param string $view
     * @param array $keys
     * @param int $liveVersionId
     */
    private function getIdsToDelete($view, $keys, $liveVersionId)
    {
        $liveVersionIds = $this->getAllLivePageVersionIds($view);

        $allIds = DB::table('dvs_fields')
                    ->leftJoin('dvs_collection_instances','dvs_collection_instances.id','=','dvs_fields.collection_instance_id')
                    ->whereIn('dvs_fields.page_version_id',$liveVersionIds)
                    ->whereNotIn('key',$keys)
                    ->select(
                            'dvs_fields.id as dvs_field_id',
                            'dvs_collection_instances.id as dvs_collection_instance_id',
                            'dvs_collection_instances.collection_set_id as dvs_collection_set_id'
                        )
                    ->get();

        $fieldIds = [];
        $collectionInstanceIds = [];
        $collectionIds = [];
        foreach ($allIds as $ids) {
            
            $fieldIds[] = $ids->dvs_field_id;

            if($ids->dvs_collection_instance_id){
                $collectionInstanceIds[] = $ids->dvs_collection_instance_id;
            }

            if($ids->dvs_collection_set_id){
                $collectionIds[] = $ids->dvs_collection_set_id;
            }
        }
        
        return [ 
            'fields' => array_unique($fieldIds),
            'collection_instances' => array_unique($collectionInstanceIds),
            'collections' => array_unique($collectionIds),
        ];
    }

    /**
     * query to get all live page version ids
     *
     * @param string $view
     */
    private function getAllLivePageVersionIds($view)
    {
        return DB::table('dvs_page_versions')
                ->join(\DB::raw('(SELECT MAX(starts_at) as max_starts, page_id FROM dvs_page_versions GROUP BY page_id) newest_version'), function($join){
                    $join->on('newest_version.max_starts','=','dvs_page_versions.starts_at');
                    $join->on('newest_version.page_id','=','dvs_page_versions.page_id');
                })
                ->join('dvs_pages','dvs_pages.id','=','dvs_page_versions.page_id')
                ->where('dvs_pages.view',$view)
                ->pluck('dvs_page_versions.id');
    }

    /**
     * deletes all fields with ids
     *
     * @param array $fieldIds
     */
    private function deleteFields($fieldIds)
    {
        DB::table('dvs_fields')
            ->whereIn('id',$fieldIds)
            ->delete();
    }

    /**
     * deletes all collection_instances with ids
     *
     * @param array $collectionInstanceIds
     */
    private function deleteCollectionInstances($collectionInstanceIds)
    {
        DB::table('dvs_collection_instances')
            ->whereIn('id',$collectionInstanceIds)
            ->delete();
    }

    /**
     * deletes all collections with ids
     *
     * @param array $collectionIds
     */
    private function deleteCollections($collectionIds)
    {
        // deletes by id but only if they dont' have any more related instances
        DB::table('dvs_collection_sets')
            ->join('dvs_collection_instances','dvs_collection_instances.collection_set_id','=','dvs_collection_sets.id')
            ->select('dvs_collection_sets.*',DB::raw('count(dvs_collection_instances.id) as related_count'))
            ->whereIn('dvs_collection_sets.id',$collectionIds)
            ->where('related_count',0);
    }

    /**
     * recursively loops through data to find keys that equal "key" and adds those to the $keys array
     *
     * @param array $keys
     * @param array $data
     */
    private function keySearch(&$keys, $data)
    {
        foreach ($data as $key => $value) {
            if(is_object($value) || is_array($value)){
                $this->keySearch($keys, $value);
            } else if($key === "key"){
                $keys[] = $value;
            }
        }
    }
}